<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\JumlahSuara;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class JumlahSuaraController extends Controller
{
    protected $jumlahSuara;
    protected $tps;
    public function __construct(JumlahSuara $jumlahSuara, Tps $tps){
        $this->jumlahSuara = $jumlahSuara;
        $this->tps = $tps;
    }
    public function list(Request $request){
        try {
            $idQuery = $request->query("Id");
            $tps =  $this->tps->tpsWithDetail()
            ->where('kelurahan_id', $idQuery)
            ->get();
            $data = [];
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
    public function index(Request $request){
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
                    "button_list" => []
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
                            "sibling_form_id" => $formId2 // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => $options
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
                            "sibling_form_id" => $formId3 // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => []
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
                            "sibling_form_id" => $formId4 // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => []
                    ],
                    4 => [
                        "id" => $formId4, // ID untuk elemen form
                        "type" => "select", // Tipe elemen: select, text, number, notification, dynamic-input
                        "name" => "Nama Kelurahan", // Label untuk elemen form
                        "is_disabled" => true, // Jika true, elemen akan disabled
                        "for_submit" => true, // Jika true, elemen ini digunakan untuk submit
                        "fetch_data" => [
                            "is_fetching" => false, // Jika true, data akan diambil melalui AJAX
                            "route" => null, // Rute untuk AJAX fetch
                            "response" => null, // Key dalam respons untuk data yang diambil
                            "sibling_form_id" => null // ID elemen lain yang akan diupdate berdasarkan fetch
                        ],
                        "options" => []
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
    public function form(Request $request){
        try {
            $view = "layouts.form";
            $tpsQuery = $request->query("Tps");
            $typeQuery = $request->query("Type");
            // $idQuery = $request->query("Id");
            // Ambil data TPS dengan detail
            $tps = $this->tps->tpsWithDetail()
            ->where('tps.id', $tpsQuery)
            ->first(); // Menggunakan first() jika hanya membutuhkan satu hasil
            if (!$tps) {
                // Tangani kasus jika TPS tidak ditemukan
                abort(404, 'TPS not found');
            }

            // Ambil data calon berdasarkan kabkota_id dari TPS
            $calon = Calon::where("code", $tps->kabkota_id)->get(['id', 'calon_name', 'wakil_name']); // Ambil hanya kolom yang diperlukan

            // Ambil jumlah suara berdasarkan tps_id
            $jumlahSuara = $this->jumlahSuara
            ->select("calon_id", "tps_id", "amount")
            ->where("tps_id", $tps->id)
            ->get();

            // Buat lookup untuk jumlah suara berdasarkan calon_id
            $jumlahSuaraLookup = $jumlahSuara->keyBy('calon_id');
            // Format data calon dengan jumlah suara
            $newCalon = $calon->map(function($c) use ($jumlahSuaraLookup) {
                $jumlahSuara = $jumlahSuaraLookup->get($c->id, (object) ['amount' => 0])->amount;
                return [
                    "id" => $c->id,
                    "calon_name" => $c->calon_name,
                    "wakil_name" => $c->wakil_name,
                    "jumlah_suara" => $jumlahSuara,
                ];
            })->toArray();
            $calonForm = [];
            foreach ($newCalon as $c) {
                $calonForm[] =  [
                    "id" => $c["id"],
                    "type" => "text",
                    "name" => $c["calon_name"]." - ".$c["wakil_name"],
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
                $formId13 = Uuid::uuid7();
                $formId14 = Uuid::uuid7();
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
                    ]
                ],
                "submit" => [
                    "id" => Uuid::uuid7(),
                    "type" => "input", // redirect, input
                    "route" => null,
                    "method" => "post",
                    "redirect" =>  null,
                ],
                "form_data" => [
                    [
                        "id" => $formId1,
                        "name" => "Nama Calon",
                        "type" => "string"
                    ],
                ],
                "form" => [
                    ...$calonForm,
                    2 => [
                        "id" => $formId3,
                        "type" => "number",
                        "name" => "Pengguna Hak Pilih DPT",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    3 => [
                        "id" => $formId4,
                        "type" => "number",
                        "name" => "Pengguna Hak Pilih DPTB",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    4 => [
                        "id" => $formId5,
                        "type" => "number",
                        "name" => "Pengguna Hak Pilih DPTK",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    5 => [
                        "id" => $formId6,
                        "type" => "number",
                        "name" => "Surat Suara Diterima",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    6 => [
                        "id" => $formId7,
                        "type" => "number",
                        "name" => "Surat Suara Digunakan",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    7 => [
                        "id" => $formId8,
                        "type" => "number",
                        "name" => "Surat Suara Tidak Digunakan Digunakan",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    8 => [
                        "id" => $formId9,
                        "type" => "number",
                        "name" => "Surat Suara Rusak",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    9 => [
                        "id" => $formId10,
                        "type" => "number",
                        "name" => "Total Suara Sah",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    10 => [
                        "id" => $formId11,
                        "type" => "number",
                        "name" => "Total Suara Tidak Sah",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    11 => [
                        "id" => $formId12,
                        "type" => "number",
                        "name" => "Total Suara Sah & Tidak Sah",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    12 => [
                        "id" => $formId13,
                        "type" => "select",
                        "name" => "C Keberatan",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => [
                            [
                                "id"=> 0,
                                "is_selected" => true,
                                "name" => "Tidak Ada",
                            ],
                            [
                                "id"=> 1,
                                "is_selected" => false,
                                "name" => "Ada",
                            ],
                        ],
                    ],
                    13 => [
                        "id" => $formId14,
                        "type" => "textarea",
                        "name" => "Catatan (Tidak Wajib)",
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
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
