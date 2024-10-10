<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\HitungSuaraCepatAdmin;
use App\Models\HitungSuaraCepatAdminDetail;
use App\Models\HitungSuaraCepatSaksi;
use App\Models\HitungSuaraCepatSaksiDetail;
use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class HitungCepatController extends Controller
{
    protected $tps;
    protected $hitungCepatAdmin;
    protected $hitungCepatAdminDetail;
    public function __construct(
        Tps $tps,
        HitungSuaraCepatAdmin $hitungCepatAdmin,
        HitungSuaraCepatAdminDetail $hitungCepatAdminDetail
    ) {
        $this->tps = $tps;
        $this->hitungCepatAdmin = $hitungCepatAdmin;
        $this->hitungCepatAdminDetail = $hitungCepatAdminDetail;
    }
    // Hitung Cepat By Admin
    public function byAdmin(Request $request)
    {
        try {
            $provinsi = Provinsi::all();
            $urlSubmit = route('hitung_cepat.admin.list', ['Type' => 'TYPE_PLACEHOLDER', 'Id' => 'ID_PLACEHOLDER']);
            return view("hitung_cepat.admin", [
                "urlSubmit" => $urlSubmit,
                "provinsi" => $provinsi,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
    public function listByAdmin(Request $request)
    {
        try {
            $idQuery = $request->query('Id');
            $typeQuery = strtolower($request->query('Type'));

            // Ambil data TPS berdasarkan kelurahan_id
            $tpsData = $this->tps->tpsWithDetail()
                ->where('kelurahan_id', $idQuery)
                ->get();

            if ($tpsData->isEmpty()) {
                return view('hitung_cepat.admin_table', [
                    'table' => 'Kosong',
                    'data' => [],
                    'calon' => [],
                ]);
            }

            // Ambil data Calon berdasarkan typeQuery
            $calonCode = match ($typeQuery) {
                'provinsi' => $tpsData->first()->provinsi_id,
                'kabkota' => $tpsData->first()->kabkota_id,
                default => null,
            };

            $calon = $calonCode ? Calon::where('code', $calonCode)->get() : collect();

            // Ambil data hitung suara cepat admin detail
            $hscadData = DB::table('hitung_suara_cepat_admin_detail as hscad')
                ->select('tps.name as tps_name', 'calon.calon_name as calon_name', 'hscad.amount', 'hsca.updated_by')
                ->join('tps', 'hscad.tps_id', '=', 'tps.id')
                ->join('calon', 'hscad.calon_id', '=', 'calon.id')
                ->leftJoin('hitung_suara_cepat_admin as hsca', 'hscad.hs_cepat_admin_id', '=', 'hsca.id')
                ->whereIn('tps.id', $tpsData->pluck('id'))
                ->whereIn('calon.id', $calon->pluck('id'))
                ->get();

            // Buat data final untuk ditampilkan
            $results = $tpsData->map(function ($tps) use ($hscadData, $calon) {

                // Looping untuk setiap calon pada TPS tertentu
                $calonData = $calon->map(function ($c) use ($hscadData, $tps) {

                    // Mencari data HSCAD yang cocok dengan calon dan TPS
                    $hscadEntry = $hscadData->first(function ($entry) use ($c, $tps) {
                        // Membandingkan nama calon dan nama TPS untuk menemukan entry yang sesuai
                        return $entry->calon_name === $c->calon_name && $entry->tps_name === $tps->name;
                    });

                    // Mengembalikan data calon dengan jumlah suara, jika tidak ada data hscadEntry maka jumlahnya 0
                    return [
                        "id" => $c->id, // ID calon
                        'calon_name' => $c->calon_name, // Nama calon
                        'amount' => $hscadEntry ? $hscadEntry->amount : 0, // Jumlah suara, 0 jika tidak ada data
                    ];
                });

                // Mencari siapa yang terakhir mengupdate data TPS, default 'Belum ada' jika tidak ditemukan
                $updatedBy = $hscadData->where('tps_name', $tps->name)->first()->updated_by ?? 'Belum ada';

                // Mengembalikan data TPS dengan informasi calon, jumlah suara, dan siapa yang terakhir mengupdate
                return [
                    "id" => $tps->id, // ID TPS
                    'tps_name' => $tps->name, // Nama TPS
                    'calon_data' => $calonData, // Data calon di TPS ini
                    'updated_by' => $updatedBy, // Siapa yang terakhir kali mengupdate
                ];
            });

            return view('hitung_cepat.admin_table', [
                'table' => $tpsData->first()->kelurahan->name,
                'data' => $results,
                'calon' => $calon,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function storeByAdmin(Request $request)
    {
        DB::beginTransaction(); // Memulai transaksi
        try {
            $message = "Data Berhasil Disimpan";
            $responseCode = 200;
            $body = $request->all();
            $tpsId = $request->query("Tps");
            $hitungCepatId = Uuid::uuid7();
            $dataHSCD = []; // HSCD: hitung_suara_cepat_details
            $dataHSC = [
                "id" => $hitungCepatId,
                "updated_by" => $request->session()->get("name"),
            ];

            foreach ($body as $key => $value) {
                if ($key !== "Tps") {
                    $hitungCepatDetail = $this->hitungCepatAdminDetail
                        ->where("tps_id", $tpsId)
                        ->where("calon_id", $key)
                        ->first();

                    if ($hitungCepatDetail) {
                        $hitungCepatId = $hitungCepatDetail->hs_cepat_admin_id;
                        $hitungCepatDetail->amount = $value;
                        $hitungCepatDetail->save();
                    } else {
                        $dataHSCD[] = [
                            "id" => Uuid::uuid7(),
                            "hs_cepat_admin_id" => $hitungCepatId,
                            "calon_id" => $key,
                            "amount" => $value,
                            "tps_id" => $tpsId,
                        ];
                    }
                }
            }
            if (empty($dataHSCD)) {
                $HC = $this->hitungCepatAdmin->find($hitungCepatId);
                if ($HC) {
                    $HC->updated_by = $dataHSC["updated_by"];
                    $HC->save();
                } else {
                    $responseCode = 500;
                    throw new Exception("Data Tidak Ditemukan!", 1);
                    
                }
            } else {
                $this->hitungCepatAdmin->insert($dataHSC);
                $this->hitungCepatAdminDetail->insert($dataHSCD);
            }
            DB::commit(); // Menyimpan perubahan jika tidak ada error
            return response()->json([
                "message" => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
            // 1062 => "Data sudah ada",
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message, "data" => $tpsId], 500);
        }
    }
    public function rekapHitungCepat(Request $request)
    {
        try {
            $view = "hitung_cepat.rekap";
            return view($view, [

            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
    public function chart(Request $request)
    {
        $responseCode = 200;
        try {
            $idQuery = $request->query("Id");
            $tingkatQuery = $request->query("Tingkat");
            $typeQuery = $request->query("Type");
            if ($idQuery == null) {
                $responseCode = 404;
                throw new Exception("Tidak Ada Data!", 1);
            }
            if ($request->session()->get("level") === "kabkota" && $tingkatQuery !== "Kabkota") {
                $responseCode = 400;
                throw new Exception("Not Allowed", 1);
            } else {
                if (!$idQuery || $idQuery == "null" || $idQuery == "Pilih" || !$tingkatQuery || $tingkatQuery  == "null" || $tingkatQuery == "Pilih") {
                    $responseCode = 400;
                    throw new Exception("Pilihan Salah!", 1);
                }
                if ($typeQuery == "null") {
                    $responseCode = 404;
                    throw new Exception("Pilih Jenis Rekap Terlebih Dahulu!!!", 1);
                } else if ($typeQuery == "admin") {
                    $wilayah = match ($tingkatQuery) {
                        "Kabkota" => Kabkota::with("kecamatan")->find($idQuery),
                        "Provinsi" => Provinsi::with("kabkota")->find($idQuery),
                        default => null,
                    };

                    if (!$wilayah) {
                        $responseCode = 404;
                        throw new Exception("Data Tidak Ditemukan!", 1);
                    }
    
                    $dataPerwilayah = $this->getDataAdminPerWilayah($wilayah, $idQuery, $tingkatQuery);
                    $calonTotal = $this->getCalonTotal($idQuery, "admin");
    
                    $data = [
                        "calon_total" => $calonTotal,
                        "data_perwilayah" => $dataPerwilayah,
                    ];
                }
                else if( $typeQuery == "saksi") {
                    $wilayah = match ($tingkatQuery) {
                        "Kabkota" => Kabkota::with("kecamatan")->find($idQuery),
                        "Provinsi" => Provinsi::with("kabkota")->find($idQuery),
                        default => null,
                    };

                    if (!$wilayah) {
                        $responseCode = 404;
                        throw new Exception("Data Tidak Ditemukan!", 1);
                    }
    
                    $dataPerwilayah = $this->getDataSaksiPerwilayah($wilayah, $idQuery, $tingkatQuery);
                    $calonTotal = $this->getCalonTotal($idQuery, "saksi");
    
                    $data = [
                        "calon_total" => $calonTotal,
                        "data_perwilayah" => $dataPerwilayah,
                    ];
                } else {
                    $responseCode = 500;
                    throw new Exception("Internal Server Error!", 1);
                }
            }
            return response()->json([
                "data" => $data,
                "wilayah" => $wilayah,
            ], $responseCode);
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], $responseCode);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $responseCode);
        }
    }
    public function selectTingkatPemilihan(Request $request)
    {
        $typeQuery = $request->query("Type");
        $provinsi = Provinsi::all();

        return view("hitung_cepat.select_tingkat", [
            "provinsi" => $provinsi,
            "type" => $typeQuery,
        ]);
    }
    public function selectRekapHitungCepat(Request $request)
    {
        try {
            $view = "layouts.form";
            //
            $formId1 = Uuid::uuid7();
            $formId2 = Uuid::uuid7();
            $formId3 = Uuid::uuid7();
            $formId4 = Uuid::uuid7();
            //
            $provinsi = Provinsi::all();
            $options[] = [
                "id" => null,
                "is_selected" => true,
                "name" => "Pilih",
            ];
            foreach ($provinsi as $p) {
                $options[] = [
                    "id" => $p->id,
                    "is_selected" => false,
                    "name" => Formatting::capitalize($p->name),
                ];
            }
            $config = [
                "name" => "Pilih Rekap & Tingkatan Hitung Cepat", // Nama form atau judul halaman
                "button_helper" => [
                    "enable" => false, // menampilkan button jika true
                    "button_list" => [
                        [
                            "name" => "Kembali",
                            "icon" => "fa fa-arrow-left",
                            "route" => null, // route yang diarahkan ketika event klik
                        ],
                    ],
                ],
                "submit" => [
                    "id" => Uuid::uuid7(), // ID unik untuk tombol submit
                    "name" => "Submit", // Penamaan nama button
                    "type" => "redirect", // Tipe submit, bisa 'input' atau 'redirect'
                    "route" => "#", // Rute yang akan diakses saat submit
                    "method" => "GET", // Metode HTTP yang digunakan untuk submit
                    "redirect" => "/success-page", // Halaman redirect setelah submit sukses (jika ada)
                    "form_data" => [ // Data yang akan dikirim pada saat submit
                        [
                            "id" => "inputText", // ID dari elemen input
                            "name" => "nama", // Nama field yang dikirim
                            "type" => "string", // Tipe data yang dikirim (string, array)
                        ],
                        [
                            "id" => "dynamicContainer", // ID dari container elemen dynamic input
                            "name" => "skills", // Nama field untuk array dynamic input
                            "type" => "array", // Tipe data array karena ada banyak input
                        ],
                    ],
                ],
                "form" => [
                    [
                        "id" => $formId1, // ID untuk elemen form
                        "type" => "select", // Tipe elemen: select, text, number, notification, dynamic-input
                        "name" => "Jenis Hitung Cepat", // Label untuk elemen form
                        "is_disabled" => false, // Jika true, elemen akan disabled
                        "for_submit" => true, // Jika true, elemen ini digunakan untuk submit
                        "fetch_data" => [
                            "is_fetching" => false, // Jika true, data akan diambil melalui AJAX
                            "route" => "#", // Rute untuk AJAX fetch
                            "response" => null, // Key dalam respons untuk data yang diambil
                            "sibling_form_id" => $formId2, // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => [
                            [
                                "id" => "null",
                                "is_selected" => true,
                                "name" => "Pilih",
                            ],
                            [
                                "id" => "saksi",
                                "is_selected" => false,
                                "name" => "Hitung Cepat Saksi",
                            ],
                            [
                                "id" => "admin",
                                "is_selected" => false,
                                "name" => "Hitung Cepat Admin",
                            ],
                        ],
                    ],
                    [
                        "id" => $formId2, // ID untuk elemen form
                        "type" => "select", // Tipe elemen: select, text, number, notification, dynamic-input
                        "name" => "Tingkatan Pemilihan", // Label untuk elemen form
                        "is_disabled" => false, // Jika true, elemen akan disabled
                        "for_submit" => true, // Jika true, elemen ini digunakan untuk submit
                        "fetch_data" => [
                            "is_fetching" => false, // Jika true, data akan diambil melalui AJAX
                            "route" => "#",
                            "response" => "data", // Key dalam respons untuk data yang diambil
                            "sibling_form_id" => $formId3, // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => [
                            [
                                "id" => "null",
                                "is_selected" => true,
                                "name" => "Pilih",
                            ],
                            [
                                "id" => "provinsi",
                                "is_selected" => false,
                                "name" => "Provinsi",
                            ],
                            [
                                "id" => "kabkota",
                                "is_selected" => false,
                                "name" => "Kabkota",
                            ],
                        ],
                    ],
                    [
                        "id" => $formId3,
                        "type" => "select",
                        "name" => "Nama Provinsi",
                        "is_disabled" => false,
                        "for_submit" => true,
                        "fetch_data" => [
                            "is_fetching" => true, // Jika true, data akan diambil melalui AJAX
                            "route" => route("wilayah.find", [
                                "Type" => "Kabkota",
                                "Id" => "",
                            ]), // Rute untuk AJAX fetch
                            "response" => "data", // Key dalam respons untuk data yang diambil
                            "sibling_form_id" => $formId4, // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => $options,
                    ],
                    [
                        "id" => $formId4,
                        "type" => "select",
                        "name" => "Nama Kabkota",
                        "is_disabled" => true,
                        "for_submit" => true,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => [
                            [
                                "id" => null,
                                "is_selected" => true,
                                "name" => "Pilih",
                            ],
                        ],
                    ],
                ],
            ];
            return view($view, [
                "config" => $config,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
    private function getDataAdminPerWilayah($wilayah, $idQuery, $typeQuery)
    {
        $dataPerwilayah = [];
        $calonTotal = $this->getCalonTotal($idQuery, "admin");

        foreach ($wilayah->{($typeQuery === "Provinsi" || $typeQuery === "provinsi") ? 'kabkota' : 'kecamatan'} as $region) {
            $totalSuara = $this->getTotalSuaraPerWilayahAdmin($region->id, $idQuery, $typeQuery);

            $totalSuaraArray = $totalSuara->isEmpty() ? $calonTotal->map(fn($calon) => (object) [
                'id' => $calon->id,
                'calon_name' => $calon->calon_name,
                'wakil_name' => $calon->wakil_name,
                'total' => 0,
            ]) : $totalSuara;

            $dataPerwilayah[] = [
                "id" => $region->id,
                "name" => $region->name,
                "total_suara" => $totalSuaraArray,
            ];
        }

        return $dataPerwilayah;
    }

    private function getDataSaksiPerwilayah($wilayah, $idQuery, $typeQuery){
        $dataPerwilayah = [];
        $calonTotal = $this->getCalonTotal($idQuery, "saksi");

        foreach ($wilayah->{($typeQuery === "Provinsi" || $typeQuery === "provinsi") ? 'kabkota' : 'kecamatan'} as $region) {
            $totalSuara = $this->getTotalSuaraPerWilayahSaksi($region->id, $idQuery, $typeQuery);

            $totalSuaraArray = $totalSuara->isEmpty() ? $calonTotal->map(fn($calon) => (object) [
                'id' => $calon->id,
                'calon_name' => $calon->calon_name,
                'wakil_name' => $calon->wakil_name,
                'total' => 0,
            ]) : $totalSuara;

            $dataPerwilayah[] = [
                "id" => $region->id,
                "name" => $region->name,
                "total_suara" => $totalSuaraArray,
            ];
        }

        return $dataPerwilayah;
    }

    /**
     * Get Total Suara per Wilayah (Kecamatan/Kabkota)
     */
    private function getTotalSuaraPerWilayahAdmin($regionId, $idQuery, $typeQuery)
    {
        return Calon::select(
            "calon.id",
            "calon.calon_name",
            "calon.wakil_name",
            DB::raw("COALESCE(SUM(hitung_suara_cepat_admin_detail.amount), 0) as total")
        )
            ->leftJoin("hitung_suara_cepat_admin_detail", "calon.id", "=", "hitung_suara_cepat_admin_detail.calon_id")
            ->leftJoin("tps", "hitung_suara_cepat_admin_detail.tps_id", "=", "tps.id")
            ->leftJoin("kelurahan", "tps.kelurahan_id", "=", "kelurahan.id")
            ->leftJoin("kecamatan", "kelurahan.kecamatan_id", "=", "kecamatan.id")
            ->leftJoin("kabkota", "kecamatan.kabkota_id", "=", "kabkota.id")
            ->where(($typeQuery === "Provinsi") ? "kabkota.id" : "kecamatan.id", $regionId)
            ->where("calon.code", $idQuery)
            ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
            ->get();
    }
    private function getTotalSuaraPerWilayahSaksi($regionId, $idQuery, $typeQuery)
    {
        return Calon::select(
            "calon.id",
            "calon.calon_name",
            "calon.wakil_name",
            DB::raw("COALESCE(SUM(hitung_suara_cepat_saksi_detail.amount), 0) as total")
            )
            ->leftJoin("hitung_suara_cepat_saksi_detail", "calon.id", "=", "hitung_suara_cepat_saksi_detail.calon_id")
            ->leftJoin("hitung_suara_cepat_saksi", "hitung_suara_cepat_saksi.id", "=", "hitung_suara_cepat_saksi_detail.hs_cepat_saksi_id")
            ->leftJoin("tps", "hitung_suara_cepat_saksi.tps_id", "=", "tps.id")
            ->leftJoin("kelurahan", "tps.kelurahan_id", "=", "kelurahan.id")
            ->leftJoin("kecamatan", "kelurahan.kecamatan_id", "=", "kecamatan.id")
            ->leftJoin("kabkota", "kecamatan.kabkota_id", "=", "kabkota.id")
            ->where(($typeQuery === "Provinsi") ? "kabkota.id" : "kecamatan.id", $regionId)
            ->where("calon.code", $idQuery)
            ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
            ->get();
    }

    /**
     * Get Calon Total
     */
    private function getCalonTotal($idQuery, $table)
    {
        return Calon::select(
            "calon.id",
            "calon.calon_name",
            "calon.wakil_name",
            DB::raw("COALESCE(SUM(hitung_suara_cepat_".$table."_detail.amount), 0) as total")
        )
            ->leftJoin("hitung_suara_cepat_".$table."_detail", "calon.id", "=", "hitung_suara_cepat_".$table."_detail.calon_id")
            ->where("calon.code", $idQuery)
            ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
            ->get();
    }

    // Hitung Cepat By Saksi
    public function bySaksi(Request $request)
    {
        try {
            $provinsi = Provinsi::all();
            $urlSubmit = route('hitung_cepat.saksi.list', ['Type' => 'TYPE_PLACEHOLDER', 'Id' => 'ID_PLACEHOLDER']);
            return view("hitung_cepat.saksi", [
                "urlSubmit" => $urlSubmit,
                "provinsi" => $provinsi,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);
            return redirect("/error$val");
        }
    }
    public function listBySaksi(Request $request)
    {
        try {
            $table = "Test Saksi";
            $idQuery = $request->query("Id");
            $tpsData = $this->tps->tpsWithDetail()
                ->where("kelurahan_id", $idQuery)
                ->get();

            if ($tpsData->isEmpty()) {
                return view('hitung_cepat.saksi_table', [
                    'table' => 'Kosong',
                    'data' => [],
                    'calon' => [],
                ]);
            }

            $results = $tpsData->map(function ($tps) {
                $hsca = HitungSuaraCepatSaksi::where("tps_id", $tps->id)->first();
                return [
                    "id" => $tps->id,
                    'tps_name' => $tps->name,
                    'nik' => $hsca ? $hsca->nik : 0,
                    "input_status" => $hsca ? $hsca->input_status : false,
                ];
            });

            return view("hitung_cepat.saksi_table", [
                "table" => $table,
                "data" => $results,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function searchSaksiTps(Request $request){
        $responseCode = 200;
        try {
            $nikQuery = $request->query('NIK');
            $hc = HitungSuaraCepatSaksi::where('nik', $nikQuery)->first();
            $tps = null;
            $data = null;
            if ($hc) {
                if ($hc->input_status) {
                    $responseCode = 400;
                    throw new Exception("Saksi Hanya Bisa 1 Kali Input, Terimakasih.", 1);
                    
                }
                $data = HitungSuaraCepatSaksiDetail::where('hs_cepat_saksi_id', $hc->id)->get();
                $tps = $this->tps->tpsWithDetail()
                ->where("tps.id", $hc->tps_id)
                ->first();
            } else {
                $responseCode = 404;
                throw new Exception("Saksi Tidak Ditemukan", 404);
            }

            return view("hitung_cepat.saksi_form", [
                "data" => $data,
                "tps" => $tps,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $responseCode);
        }
    }

    public function editHitungCepatSaksi(Request $request)
    {
        $responseCode = 200;
        try {
            $idQuery = $request->query("Id");
            $tps = $this->tps->tpsWithDetail()
                ->where("tps.id", $idQuery)
                ->first();
            $data = null;
            $hitungCepat = HitungSuaraCepatSaksi::where("tps_id", $idQuery)->first();
            if ($hitungCepat) {
                $data = HitungSuaraCepatSaksiDetail::with("calon")
                    ->where("hitung_suara_cepat_saksi_detail.hs_cepat_saksi_id", $hitungCepat->id)
                    ->get();
            } else {
                $responseCode = 404;
                throw new Exception("Data Belum Ada", 1);
                
            }
            return view("hitung_cepat/edit_saksi", [
                "tps" => $tps,
                "data" => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $responseCode);
        }
    }

    public function storeNIK(Request $request)
    {
        $responseCode = 200;
        try {
            DB::beginTransaction();
            $responseCode = 200;
            $message = null;
            $validator = Validator::make($request->all(), [
                "nik" => "required|string|min:16",
                "tps_id" => "required|string|uuid",
            ], [
                "nik.min" => "NIK harus 16 karakter!",
            ]);
            if ($validator->fails()) {
                $responseCode = 500;
                throw new Exception($validator->errors()->first(), 1);
            } else {
                $hscs = HitungSuaraCepatSaksi::where("tps_id", $request->tps_id)->first();
                if ($hscs) {
                    $hscs->nik = $request->nik;
                    $hscs->save();
                    $message = "Berhasil Memperbarui NIK";
                } else {
                    $tps = $this->tps->tpsWithDetail()
                        ->where("tps.id", $request->tps_id)
                        ->first();
                    $calon = Calon::whereIn('code', [$tps->kabkota_id, $tps->provinsi_id])->get();
                    $uuid = Uuid::uuid7();
                    HitungSuaraCepatSaksi::create([
                        "id" => $uuid,
                        "nik" => $request->nik,
                        "tps_id" => $request->tps_id,
                    ]);
                    foreach ($calon as $c) {
                        HitungSuaraCepatSaksiDetail::create([
                            "amount" => "0",
                            "calon_id" => $c->id,
                            "hs_cepat_saksi_id" => $uuid,
                        ]);
                    }
                    $message = "Saksi Baru Sukses";
                }
            }
            DB::commit();
            return response()->json([
                "message" => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
                1062 => "Data sudah ada",
                1264 => "Jumlah Melebih Batas",
                1048 => "Data tidak boleh kosong, isi 0 jika kosong.",
                1406 => "NIK Lebih dari 16 Karakter",
                default => $e->getMessage(),
            };

            return response()->json(["message" => $message], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function inputStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $tpsQuery = $request->query("Tps");
            $message = null;
            $responseCode = 200;
            $data = HitungSuaraCepatSaksi::where("tps_id", $tpsQuery)->first();
            if ($data) {
                $data->input_status = !$data->input_status;
                $data->save();
                $message = "Berhasil Memperbarui Status";
            } else {
                $responseCode = 500;
                throw new Exception("Data Belum Ada!", 1);
            }
            DB::commit();
            return response()->json([
                "message" => $message,
                "data" => $data,
            ], $responseCode);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function submitEditHitungCepatSaksi(Request $request)
    {
        try {
            DB::beginTransaction();
            $responseStatus = 500;
            $message = null;

            $tpsQuery = $request->query("Tps");
            $body = $request->data;
            $hcs = HitungSuaraCepatSaksi::where("tps_id", $tpsQuery)->first();
            if ($hcs) {
                $data = HitungSuaraCepatSaksiDetail::where("hs_cepat_saksi_id", $hcs->id)->get();
                foreach ($data as $d) {
                    foreach ($body as $b) {
                        if ($b["id"] == $d->calon_id) {
                            // $d->amount = $b["value"];
                            // $d->save();
                            DB::update('UPDATE hitung_suara_cepat_saksi_detail SET amount = ? WHERE id = ?', [(int) $b["value"], $d->id]);
                            $message = "Berhasil Memperbarui Data!";
                            $responseStatus = 200;
                        }
                    }
                }
            } else {
                $responseStatus = 404;
                throw new Exception("Data Tidak Ditemukan!", 1);
                
            }
            DB::commit();
            return response()->json([
                "message" => $message,
            ], $responseStatus);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function submitHitungCepatSaksiBySaksi(Request $request){
        try {
            DB::beginTransaction();
            $responseStatus = 200;
            $message = null;

            $nikQuery = $request->query("NIK");
            $body = $request->data;
            $hc  = HitungSuaraCepatSaksi::where("nik", $nikQuery)->first();
            if ($hc) {
                $data = HitungSuaraCepatSaksiDetail::where("hs_cepat_saksi_id", $hc->id)->get();
                foreach ($data as $d) {
                    foreach ($body as $b) {
                        if ($b["id"] == $d->calon_id) {
                            DB::update('UPDATE hitung_suara_cepat_saksi_detail SET amount = ? WHERE id = ?', [(int) $b["value"], $d->id]);
                            $message = "Berhasil Memperbarui Data!";
                            $responseStatus = 200;
                        }
                    }
                }
                $hc->input_status = true;
                $hc->save();
            } else {
                $responseStatus = 404;
                throw new Exception("Data Tidak Ditemukan!", 1);
                
            }
            DB::commit();
            return response()->json([
                "message" => $message,
            ], $responseStatus);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function inputHitungCepatSaksi()
    {
        try {
            return view("hitung_cepat.saksi_input", []);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
}
