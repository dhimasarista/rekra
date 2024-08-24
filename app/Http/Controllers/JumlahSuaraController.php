<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Provinsi;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class JumlahSuaraController extends Controller
{
    public function index(Request $request){
        try {
            $data = null;
            $view = "layouts.form";
            //
                $formId1 = Uuid::uuid7();
                $formId2 = Uuid::uuid7();
                $formId3 = Uuid::uuid7();
                $formId4 = Uuid::uuid7();
                $formId5 = Uuid::uuid7();
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
                "name" => null,
                "button_helper" => [
                    "enable" => false,
                    "button_list" => []
                ],
                "submit" => [
                    "id" => Uuid::uuid7(),
                    "name" => "submit",
                    "type" => "redirect",
                    "route" => "#",
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
            $queryType = $request->query("Type");
            if ($queryType == "Provinsi" || $queryType == "provinsi") {
                $config["name"] = "Gubernur - Wakil Gubernur";
                $config["submit"]["route"] = route("input.list", [
                    "Type" => "Provinsi",
                ]);
            } else if ($queryType == "Kabkota" || $queryType == "kabkota") {
                $config["name"] = "Kabupaten - Kota";
                $config["submit"]["route"] = route("input.list", [
                    "Type" => "Kabkota",
                ]);
            }

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
            $data = null;
            $view = "layouts.form";
            //
                $formId1 = Uuid::uuid7();
                $formId2 = Uuid::uuid7();
                $formId3 = Uuid::uuid7();
            //
            $config = [
                "name" => "TPS 001 Sadai, Bengkong, Kota Batam",
                "button_helper" => [
                    "enable" => true,
                    "button_list" => [
                        [
                            "name" => "Kembali",
                            "icon" => "fa fa-arrow-left",
                            "route" => "#",
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
                    0 => [
                        "id" => $formId1,
                        "type" => "text",
                        "name" => "No. 1 - Anto & Ujang",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => 1000 ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    1 => [
                        "id" => $formId1,
                        "type" => "text",
                        "name" => "No. 2 - Yusuf & Alex",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => 1000 ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    2 => [
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => $formId1,
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
                        "id" => 1,
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
                    99 => [
                        "id" => $formId3,
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
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
}
