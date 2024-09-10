<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\HitungSuaraCepatAdmin;
use App\Models\HitungSuaraCepatAdminDetail;
use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        )
    {
        $this->tps = $tps;
        $this->hitungCepatAdmin = $hitungCepatAdmin;
        $this->hitungCepatAdminDetail = $hitungCepatAdminDetail;
    }
    public function byAdmin(Request $request)
    {
        try {
            $provinsi = Provinsi::all();
            return view("hitung_cepat.admin", [
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
                return view('hitung_cepat.table', [
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
                $calonData = $calon->map(function ($c) use ($hscadData, $tps) {
                    $hscadEntry = $hscadData->first(function ($entry) use ($c, $tps) {
                        return $entry->calon_name === $c->calon_name && $entry->tps_name === $tps->name;
                    });
                    return [
                        "id" => $c->id,
                        'calon_name' => $c->calon_name,
                        'amount' => $hscadEntry ? $hscadEntry->amount : 0,
                    ];
                });

                $updatedBy = $hscadData->where('tps_name', $tps->name)->first()->updated_by ?? 'Belum ada';

                return [
                    "id" => $tps->id,
                    'tps_name' => $tps->name,
                    'calon_data' => $calonData,
                    'updated_by' => $updatedBy,
                ];
            });

            return view('hitung_cepat.table', [
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

    public function storeByAdmin(Request $request){
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
                    $message = "Data Tidak Ditemukan. (Internal Server Error)";
                    $responseCode = 500;
                }
            } else {
                $this->hitungCepatAdmin->insert($dataHSC);
                $this->hitungCepatAdminDetail->insert($dataHSCD);
            }
            DB::commit(); // Menyimpan perubahan jika tidak ada error
            return response()->json([
                "message" => $message,
                "data" => $request->all()
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

    public function selectRekapHitungCepat(Request $request){
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
                    "name" => Formatting::capitalize($p->name)
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
                        ]
                    ]
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
                            "type" => "string" // Tipe data yang dikirim (string, array)
                        ],
                        [
                            "id" => "dynamicContainer", // ID dari container elemen dynamic input
                            "name" => "skills", // Nama field untuk array dynamic input
                            "type" => "array" // Tipe data array karena ada banyak input
                        ],
                    ]
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
                            "sibling_form_id" => $formId2 // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => [
                            [
                                "id" => "null",
                                "is_selected" => true,
                                "name" => "Pilih Cok"
                            ],
                            [
                                "id" => "saksi",
                                "is_selected" => false,
                                "name" => "Hitung Cepat Saksi"
                            ],
                            [
                                "id" => "admin",
                                "is_selected" => false,
                                "name" => "Hitung Cepat Admin"
                            ],
                        ]
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
                            "sibling_form_id" => $formId3 // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => [
                            [
                                "id" => "null",
                                "is_selected" => true,
                                "name" => "Pilih Tingkatan"
                            ],
                            [
                                "id" => "provinsi",
                                "is_selected" => false,
                                "name" => "Provinsi"
                            ],
                            [
                                "id" => "kabkota",
                                "is_selected" => false,
                                "name" => "Kabkota"
                            ],
                        ]
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
                            "sibling_form_id" => $formId4 // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => $options
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
                                "name" => "",
                            ],
                        ],
                    ],
                ]
            ];
            return view($view, [
                "config" => $config
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
    private function getDataPerWilayah($wilayah, $idQuery, $typeQuery)
    {
        $dataPerwilayah = [];
        $calonTotal = $this->getCalonTotal($idQuery);

        foreach ($wilayah->{($typeQuery === "Provinsi" || $typeQuery === "provinsi") ? 'kabkota' : 'kecamatan'} as $region) {
            $totalSuara = $this->getTotalSuaraPerWilayah($region->id, $idQuery, $typeQuery);

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
    private function getTotalSuaraPerWilayah($regionId, $idQuery, $typeQuery)
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

    /**
     * Get Calon Total
     */
    private function getCalonTotal($idQuery)
    {
        return Calon::select(
            "calon.id",
            "calon.calon_name",
            "calon.wakil_name",
            DB::raw("COALESCE(SUM(hitung_suara_cepat_admin_detail.amount), 0) as total")
        )
            ->leftJoin("hitung_suara_cepat_admin_detail", "calon.id", "=", "hitung_suara_cepat_admin_detail.calon_id")
            ->where("calon.code", $idQuery)
            ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
            ->get();
    }

    public function rekapHitungCepatAdmin(Request $request){
        $view = "hitung_cepat.chart";
        $idQuery = $request->query("Id");
        $typeQuery = $request->query("Type");
        if (!$idQuery || $idQuery == "null" || $idQuery == "Pilih") {
            return redirect("/");
        }
        $wilayah = match ($typeQuery) {
            "Kabkota" => Kabkota::with("kecamatan")->find($idQuery),
            "Provinsi" => Provinsi::with("kabkota")->find($idQuery),
            default => null,
        };

        $dataPerwilayah = $this->getDataPerWilayah($wilayah, $idQuery, $typeQuery);
        $calonTotal = $this->getCalonTotal($idQuery);

        $data = [
            "calon_total" => $calonTotal,
            "data_perwilayah" => $dataPerwilayah,
        ];
        return view($view, [
            "data" => $data,
            "wilayah" => $wilayah,
        ]);
    }
}
