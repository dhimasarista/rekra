<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\JumlahSuara;
use App\Models\JumlahSuaraDetail;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class JumlahSuaraController extends Controller
{
    protected $jumlahSuara;
    protected $jumlahSuaraDetail;
    protected $tps;
    public function __construct(JumlahSuara $jumlahSuara, Tps $tps, JumlahSuaraDetail $jumlahSuaraDetail)
    {
        $this->jumlahSuara = $jumlahSuara;
        $this->jumlahSuaraDetail = $jumlahSuaraDetail;
        $this->tps = $tps;
    }
    public function list(Request $request)
    {
        try {
            $idQuery = $request->query("Id");
            $tps = $this->tps->tpsWithDetail()
                ->where('kelurahan_id', $idQuery)
                ->get();
            $data = [];
            // dd($tps);
            // $JSD = $this->jumlahSuaraDetail->select(
            //     "jumlah_suara_details.*",
            //     "jumlah_suara.*",
            //     "tps.*",
            //     "kelurahan.*"
            // )
            // ->join("tps", "tps.id", "=", "jumlah_suara_details.tps_id")
            // ->join("kelurahan", "kelurahan.id", "=", "tps.kelurahan_id")
            // ->join("jumlah_suara", "jumlah_suara.id", "=", "jumlah_suara_details.jumlah_suara_id")
            // ->where("kelurahan.id", $tps[0]->kelurahan_id)
            // ->get();
            // dd($JSD);
            foreach ($tps as $t) {
                $data[] = [
                    "id" => $t->id,
                    "name" => $t->name,
                    "wilayah" => "$t->kelurahan_name, $t->kecamatan_name, $t->kabkota_name",
                    "provinsi" => route("input.form", [
                        "Type" => "Provinsi",
                        "Id" => "",
                        "Tps" => $t->id,
                    ]),
                    "kabkota" => route("input.form", [
                        "Type" => "Kabkota",
                        "Id" => "",
                        "Tps" => $t->id,
                    ]),
                ];
            }
            return view("input.table", [
                "data" => $data,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getLine(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
    public function index(Request $request)
    {
        try {
            $data = null;
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
                    "name" => $p->name,
                ];
            }
            $config = [
                "name" => 'Pilih Wilayah',
                "button_helper" => [
                    "enable" => false,
                    "button_list" => [],
                ],
                "submit" => [
                    "id" => Uuid::uuid7(),
                    "name" => "submit",
                    "type" => "redirect",
                    "route" => route("input.list", [
                        "Type" => "General",
                    ]),
                    "method" => null,
                    "redirect" => null,
                ],
                "form_data" => null,
                "form" => [
                    1 => [
                        "id" => $formId1, // ID untuk elemen form
                        "type" => "select", // Tipe elemen: select, text, number, notification, dynamic-input
                        "name" => "Nama Provinsi", // Label untuk elemen form
                        "is_disabled" => false, // Jika true, elemen akan disabled
                        "for_submit" => false, // Jika true, elemen ini digunakan untuk submit
                        "fetch_data" => [
                            "is_fetching" => true, // Jika true, data akan diambil melalui AJAX
                            "route" => route("wilayah.find", [
                                "Type" => "Kabkota",
                                "Id" => "",
                            ]), // Rute untuk AJAX fetch
                            "response" => "data", // Key dalam respons untuk data yang diambil
                            "sibling_form_id" => $formId2, // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => $options,
                    ],
                    2 => [
                        "id" => $formId2, // ID untuk elemen form
                        "type" => "select", // Tipe elemen: select, text, number, notification, dynamic-input
                        "name" => "Nama Kabupaten/Kota", // Label untuk elemen form
                        "is_disabled" => true, // Jika true, elemen akan disabled
                        "for_submit" => false, // Jika true, elemen ini digunakan untuk submit
                        "fetch_data" => [
                            "is_fetching" => true, // Jika true, data akan diambil melalui AJAX
                            "route" => route("wilayah.find", [
                                "Type" => "Kecamatan",
                                "Id" => "",
                            ]), // Rute untuk AJAX fetch
                            "response" => "data", // Key dalam respons untuk data yang diambil
                            "sibling_form_id" => $formId3, // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => [],
                    ],
                    3 => [
                        "id" => $formId3, // ID untuk elemen form
                        "type" => "select", // Tipe elemen: select, text, number, notification, dynamic-input
                        "name" => "Nama Kecamatan", // Label untuk elemen form
                        "is_disabled" => true, // Jika true, elemen akan disabled
                        "for_submit" => false, // Jika true, elemen ini digunakan untuk submit
                        "fetch_data" => [
                            "is_fetching" => true, // Jika true, data akan diambil melalui AJAX
                            "route" => route("wilayah.find", [
                                "Type" => "Kelurahan",
                                "Id" => "",
                            ]), // Rute untuk AJAX fetch
                            "response" => "data", // Key dalam respons untuk data yang diambil
                            "sibling_form_id" => $formId4, // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => [],
                    ],
                    4 => [
                        "id" => $formId4, // ID untuk elemen form
                        "type" => "select", // Tipe elemen: select, text, number, notification, dynamic-input
                        "name" => "Nama Kelurahan/Desa", // Label untuk elemen form
                        "is_disabled" => true, // Jika true, elemen akan disabled
                        "for_submit" => true, // Jika true, elemen ini digunakan untuk submit
                        "fetch_data" => [
                            "is_fetching" => false, // Jika true, data akan diambil melalui AJAX
                            "route" => null, // Rute untuk AJAX fetch
                            "response" => null, // Key dalam respons untuk data yang diambil
                            "sibling_form_id" => null, // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => [],
                    ],
                ],
            ];
            return view($view, [
                "config" => $config,
                "data" => $data,
            ]);

        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getLine(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
    public function store(Request $request)
    {
        DB::beginTransaction(); // Memulai transaksi

        try {
            $message = "Data Berhasil Disimpan";
            $responseCode = 200;
            $body = $request->except([
                "note",
                "dpt",
                "dptb",
                "dptk",
                "surat_suara_diterima",
                "surat_suara_digunakan",
                "surat_suara_tidak_digunakan",
                "surat_suara_rusak",
                "total_suara_sah",
                "total_sah_tidak_sah",
                "total_suara_tidak_sah",
                "c_keberatan"
            ]);
            $tpsId = $request->query("Tps");
            $jumlahSuaraId = Uuid::uuid7();
            $dataJSD = []; // JSD: jumlah_suara_details
            $dataJS = [
                "id" => $jumlahSuaraId,
                "note" => $request->note,
                "dpt" => $request->dpt,
                "dptb" => $request->dptb,
                "dptk" => $request->dptk,
                "surat_suara_diterima" => $request->surat_suara_diterima,
                "surat_suara_digunakan" => $request->surat_suara_digunakan,
                "surat_suara_tidak_digunakan" => $request->surat_suara_tidak_digunakan,
                "surat_suara_rusak" => $request->surat_suara_rusak,
                "total_suara_sah" => $request->total_suara_sah,
                "total_suara_tidak_sah" => $request->total_suara_tidak_sah,
                "total_sah_tidak_sah" => $request->total_sah_tidak_sah,
                "c_keberatan" => $request->c_keberatan,
            ]; // JS: jumlah_suara

            foreach ($body as $key => $value) {
                if ($key !== "Tps") {
                    $jumlahSuaraDetail = $this->jumlahSuaraDetail
                        ->where("tps_id", $tpsId)
                        ->where("calon_id", $key)
                        ->first();

                    if ($jumlahSuaraDetail) {
                        $jumlahSuaraId = $jumlahSuaraDetail->jumlah_suara_id;
                        $jumlahSuaraDetail->amount = $value;
                        $jumlahSuaraDetail->save();
                    } else {
                        $dataJSD[] = [
                            "id" => Uuid::uuid7(),
                            "jumlah_suara_id" => $jumlahSuaraId,
                            "calon_id" => $key,
                            "amount" => $value,
                            "tps_id" => $tpsId,
                        ];
                    }
                }
            }
            // Jika tidak ada data, buat baru di tabel jumlah_suara
            if (empty($dataJSD)) {
                $JS = $this->jumlahSuara->find($jumlahSuaraId);
                if ($JS) {
                    $JS->dpt = $dataJS["dpt"];
                    $JS->dptb = $dataJS["dptb"];
                    $JS->dptk = $dataJS["dptk"];
                    $JS->surat_suara_diterima = $dataJS["surat_suara_diterima"];
                    $JS->surat_suara_digunakan = $dataJS["surat_suara_digunakan"];
                    $JS->surat_suara_tidak_digunakan = $dataJS["surat_suara_tidak_digunakan"];
                    $JS->surat_suara_rusak = $dataJS["surat_suara_rusak"];
                    $JS->total_suara_sah = $dataJS["total_suara_sah"];
                    $JS->total_suara_tidak_sah = $dataJS["total_suara_tidak_sah"];
                    $JS->total_sah_tidak_sah = $dataJS["total_sah_tidak_sah"];
                    $JS->note = $dataJS["note"];
                    $JS->c_keberatan = $dataJS["c_keberatan"];
                    $JS->save();
                } else {
                    $message = "Data Tidak Ditemukan. (Internal Server Error)";
                    $responseCode = 500;
                }
            } else {
                $this->jumlahSuara->insert($dataJS);
                $this->jumlahSuaraDetail->insert($dataJSD);
            }

            DB::commit(); // Menyimpan perubahan jika tidak ada error

            return response()->json([
                "message" => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
                1062 => "Data sudah ada",
                1264 => "Jumlah Melebih Batas",
                1048 => "Data tidak boleh kosong, isi 0 jika kosong.",
                default => $e->getMessage(),
            };

            return response()->json(["message" => $message], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
    // todo: anomali
    public function form(Request $request)
    {
        try {
            $view = "layouts.form";
            $tpsQuery = $request->query("Tps");
            $typeQuery = $request->query("Type");
            // Ambil data TPS dengan detail
            $tps = $this->tps->tpsWithDetail()
                ->where('tps.id', $tpsQuery)
                ->first(); // Menggunakan first() jika hanya membutuhkan satu hasil
            if (!$tps) {
                // Tangani kasus jika TPS tidak ditemukan
                abort(404, 'TPS not found');
            }

            if ($typeQuery === "Kabkota" || $typeQuery === "kabkota") {
                // Ambil data calon berdasarkan kabkota_id dari TPS
                $calon = Calon::where("code", $tps->kabkota_id)->get(['id', 'calon_name', 'wakil_name']); // Ambil hanya kolom yang diperlukan
            } else if ($typeQuery === "Provinsi" || $typeQuery === "provinsi") {
                $calon = Calon::where("code", $tps->provinsi_id)->get(['id', 'calon_name', 'wakil_name']); // Ambil hanya kolom yang diperlukan
            }
            // Ambil jumlah suara detail berdasarkan tps_id
            $jumlahSuaraDetail = $this->jumlahSuaraDetail
                ->select("calon_id", "tps_id", "amount", "jumlah_suara_id")
                ->where("tps_id", $tps->id)
                ->get();
            $jumlahSuaraId = null;
            foreach ($jumlahSuaraDetail as $value) {
                if ($value->calon_id == $calon[0]->id) {
                    $jumlahSuaraId = $value->jumlah_suara_id;
                }
            }
            $jumlahSuara = $this->jumlahSuara::find($jumlahSuaraId);

            // Buat lookup untuk jumlah suara berdasarkan calon_id
            $jumlahSuaraLookup = $jumlahSuaraDetail->keyBy('calon_id');
            // Format data calon dengan jumlah suara
            $newCalon = $calon->map(function ($c) use ($jumlahSuaraLookup) {
                $jumlahSuaraDetail = $jumlahSuaraLookup->get($c->id, (object) ['amount' => 0])->amount;
                return [
                    "id" => $c->id,
                    "calon_name" => $c->calon_name,
                    "wakil_name" => $c->wakil_name,
                    "jumlah_suara" => $jumlahSuaraDetail,
                ];
            })->toArray();
            $calonForm = [];
            $calonFormData = [];
            foreach ($newCalon as $c) {
                $calonFormData[] = [
                    "id" => $c["id"],
                    "name" => $c["id"],
                    "type" => "string",
                ];
                $calonForm[] = [
                    "id" => $c["id"],
                    "type" => "text",
                    "name" => sprintf("%s - %s", Formatting::capitalize($c["calon_name"]), Formatting::capitalize($c["wakil_name"])),
                    "is_disabled" => false,
                    "for_submit" => false,
                    "fetch_data" => [
                        "is_fetching" => false,
                    ],
                    "data" => [
                        "value" => $c["jumlah_suara"],
                        "placeholder" => "Wajib Diisi",
                    ],
                ];
            }

            // Format data untuk respons
            $data = [
                "tps_id" => $tps->id,
                "tps_name" => sprintf(
                    "%s - %s, %s, %s, %s",
                    $typeQuery,
                    $tps->name,
                    Formatting::capitalize($tps->kelurahan_name),
                    Formatting::capitalize($tps->kecamatan_name),
                    Formatting::capitalize($tps->kabkota_name)
                ),
                "calon" => $newCalon,
            ];
            //
            $formId1 = Uuid::uuid7();
            $formId2 = Uuid::uuid7();
            $formId3 = Uuid::uuid7();
            $formId4 = Uuid::uuid7();
            $formId5 = Uuid::uuid7();
            $formId6 = Uuid::uuid7();
            $formId7 = Uuid::uuid7();
            $formId8 = Uuid::uuid7();
            $formId9 = Uuid::uuid7();
            $formId10 = Uuid::uuid7();
            $formId11 = Uuid::uuid7();
            $formId12 = Uuid::uuid7();
            //
            $config = [
                "name" => $data["tps_name"],
                "button_helper" => [
                    "enable" => true,
                    "button_list" => [
                        [
                            "name" => "Kembali",
                            "icon" => "fa fa-arrow-left",
                            "route" => url()->previous(),
                        ],
                    ],
                ],
                "submit" => [
                    "id" => Uuid::uuid7(),
                    "type" => "input", // redirect, input
                    "route" => route("input.store", [
                        "Tps" => $tpsQuery,
                    ]),
                    "method" => "post",
                    "redirect" => url()->previous(),
                    "form_data" => [
                        ...$calonFormData,
                        [
                            "id" => $formId1,
                            "name" => "dpt",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId2,
                            "name" => "dptb",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId3,
                            "name" => "dptk",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId4,
                            "name" => "surat_suara_diterima",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId5,
                            "name" => "surat_suara_digunakan",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId6,
                            "name" => "surat_suara_tidak_digunakan",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId7,
                            "name" => "surat_suara_rusak",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId12,
                            "name" => "note",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId8,
                            "name" => "total_suara_sah",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId9,
                            "name" => "total_suara_tidak_sah",
                            "type" => "string",
                        ],
                        [
                            "id" => $formId10,
                            "name" => "total_sah_tidak_sah",
                            "type" => "string",
                        ],
                        // [
                        //     "id" => $formId11,
                        //     "name" => "c_keberatan",
                        //     "type" => "string",
                        // ],
                    ],
                ],
                "form" => [
                    ...$calonForm,
                    [
                        "id" => $formId1,
                        "type" => "number",
                        "name" => "Pengguna Hak Pilih DPT",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->dpt ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId2,
                        "type" => "number",
                        "name" => "Pengguna Hak Pilih DPTB",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->dptb ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId3,
                        "type" => "number",
                        "name" => "Pengguna Hak Pilih DPTK",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->dptk ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId4,
                        "type" => "number",
                        "name" => "Surat Suara Diterima",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->surat_suara_diterima ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId5,
                        "type" => "number",
                        "name" => "Surat Suara Digunakan",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->surat_suara_digunakan ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId6,
                        "type" => "number",
                        "name" => "Surat Suara Tidak Digunakan",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->surat_suara_tidak_digunakan ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId7,
                        "type" => "number",
                        "name" => "Surat Suara Rusak",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->surat_suara_rusak ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId8,
                        "type" => "number",
                        "name" => "Total Suara Sah",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->total_suara_sah ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId9,
                        "type" => "number",
                        "name" => "Total Suara Tidak Sah",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->total_suara_tidak_sah ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId10,
                        "type" => "number",
                        "name" => "Total Suara Sah & Tidak Sah",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->total_sah_tidak_sah ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    [
                        "id" => $formId11,
                        "type" => "select",
                        "name" => "C Keberatan",
                        "is_disabled" => true,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => [
                            [
                                "id" => 0,
                                "is_selected" => true,
                                "name" => "Tidak Ada",
                            ],
                            [
                                "id" => 1,
                                "is_selected" => false,
                                "name" => "Ada",
                            ],
                        ],
                    ],
                    [
                        "id" => $formId12,
                        "type" => "textarea",
                        "name" => "Catatan (Tidak Wajib)",
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $jumlahSuara->note ?? "",
                            "placeholder" => "Contoh: Terjadi kecurangan...",
                        ],
                    ],
                ],
            ];

            return view($view, [
                "data" => $data,
                "config" => $config,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getLine(),
            ]);

            return redirect("/error$val");
        }
    }
}
