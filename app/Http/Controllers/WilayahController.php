<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Tps;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;


class WilayahController extends Controller
{
    public function index(Request $request){
        try {
            $data = null;
            $tableName = "Daftar Wilayah";
            $view = "wilayah.index";
            $typeQuery = $request->query("Type");
            $idQuery = $request->query("Id");
            if ($typeQuery == "Kecamatan" || $typeQuery == "kecamatan") {
                $kecamatan = Kecamatan::with("kabkota")->where("kabkota_id", $idQuery)->get();
                $tableName = $kecamatan->first()->kabkota->name ?? "Kocong🥺";
                foreach ($kecamatan as $k) {
                    $data[] = [
                        "id" => $k->id,
                        "name" => $k->name,
                        "total" => 1000,
                        "detail" => route("wilayah.index", [
                            "Type" => "Kelurahan",
                            "Id" =>  $k->id,
                        ]),
                        "edit" => route("wilayah.form", [
                            "Type" => "Kecamatan",
                            "Id" =>  $k->id,
                        ]),
                        "delete" => "#"
                    ];
                }
            } else if (!$typeQuery || $typeQuery == "Kabkota" || $typeQuery == "kabkota") {
                $kabkota = KabKota::all();
                foreach ($kabkota as $k) {
                    $data[] = [
                        "id" => $k->id,
                        "name" => $k->name,
                        "total" => 1000,
                        "detail" => route("wilayah.index", [
                            "Type" => "Kecamatan",
                            "Id" =>  $k->id,
                        ]),
                        "edit" => route("wilayah.form", [
                            "Type" => "Kabkota",
                            "Id" =>  $k->id,
                        ]),
                        "delete" => "#"
                    ];
                }
            } else if (!$typeQuery || $typeQuery == "Kelurahan" || $typeQuery == "kelurahan") {
                $kelurahan = Kelurahan::with("kecamatan")->where("kecamatan_id", $idQuery)->get();
                $tableName = $kelurahan->first()->kecamatan->name ?? "Kocong🥺";
                foreach ($kelurahan as $k) {
                    $data[] = [
                        "id" => $k->id,
                        "name" => $k->name,
                        "total" => 1000,
                        "detail" => route("wilayah.index", [
                            "Type" => "TPS",
                            "Id" =>  $k->id,
                        ]),
                        "edit" => route("wilayah.form", [
                            "Type" => "Kelurahan",
                            "Id" =>  $k->id,
                        ]),
                        "delete" => "#"
                    ];
                }
            }
            return view($view, [
                "tableName" => $tableName,
                "data"=> $data,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => "Line: ".$e->getLine(),
            ]);

            return redirect("/error$val");
        }
    }
    public function findAllByType(Request $request)
    {
        try {
            $typeQuery = $request->query("Type");
            $data = null;
            if ($typeQuery) {
                if($typeQuery == "Provinsi" || $typeQuery == "provinsi"){
                    $data = Provinsi::all();
                }
                else if ($typeQuery == "Kabkota" || $typeQuery == "kabkota"){
                    $user = User::find($request->session()->get('user_id'));
                    $data = match ($user->level) {
                        "kabkota" => KabKota::where("id", $user->code)->first(),
                        "master" => KabKota::all(),
                        default => null,
                    };
                }
            }
            return response()->json([
                "data"=> $data
            ], 200);
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }
    public function form(Request $request){
        try {
            $typeQuery = $request->query("Type");
            $view = "layouts.form";
            $idQuery = $request->query("Id");
            //
                $formId1 = Uuid::uuid7();
                $formId2 = Uuid::uuid7();
                $formId3 = Uuid::uuid7();
            //
            $config = [
                "name" => null,
                "submit" => [
                    "type" => "input",
                    "id" => Uuid::uuid7(),
                    "route" => null,
                    "method" => "post",
                    "redirect" => route("wilayah.index")
                ],
                "form_data" => [],
                "form" => [],
            ];
            if($typeQuery == "Kabkota"|| $typeQuery == "kabkota"){
                $provinsi = Provinsi::all();
                $kabkota = KabKota::find($idQuery);
                $optProvinsi[] = [
                    "id" => null,
                    "is_selected" => true,
                    "name" => "Pilih"
                ];
                foreach ($provinsi as $p) {
                    $optProvinsi[] = [
                        "id"=> $p->id,
                        "is_selected" => false,
                        "name" => $p->name,
                    ];
                }
                $config["name"] = "Create Kab/Kota";
                $config["submit"]["route"] = route("wilayah.post", ["Type" => "Kabkota", "Id" => $idQuery]);
                $config["submit"]["form_data"] = [
                    [
                        "id" => $formId1,
                        "name" => "id",
                    ],
                    [
                        "id" => $formId2,
                        "name" => "name",
                    ],
                    [
                        "id" => $formId3,
                        "name" => "provinsi_id",
                    ],
                ];
                $config["form"] = [
                    0 => [
                        "id" => $formId1,
                        "type" => "text",
                        "name" => "ID",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $kabkota->id ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    1 => [
                        "id" => $formId2,
                        "type" => "text",
                        "name" => "Nama Kabupaten/Kota",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => $kabkota->name ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    2 => [
                        "id" => $formId3,
                        "type" => "select",
                        "name" => "Nama Provinsi",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => $optProvinsi,
                    ],
                    3 => [
                        "id" => null,
                        "type" => "notification",
                        "name" => "ID: silahkan browsing di internet untuk melihat kode setiap daerah. Contoh 21 Kepri, 2171 Kota Batam.",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                    ],
                ];
                if($kabkota){
                    $config["name"] = "Update: $kabkota->name";
                    $config["form"][2]["data"]["value"] = 21;
                }
            } else if($typeQuery == "Kecamatan"|| $typeQuery == "kecamatan") {
                $provinsi = Provinsi::all();
                $kecamatan = Kecamatan::find($idQuery);
                $options[] = [
                    "id" => null,
                    "is_selected" => true,
                    "name" => "Pilih"
                ];
                foreach ($provinsi as $p) {
                    $options[] = [
                        "id"=> $p->id,
                        "is_selected" => false,
                        "name" => $p->name,
                    ];
                }
                $containerIdForm2 = Uuid::uuid7();
                $config["submit"]["route"] = route("wilayah.post", ["Type" => "Kecamatan", "Id" => $idQuery]);
                $config["submit"]["form_data"] = [
                    0 => [
                        "id" => $formId2,
                        "name" => "kabkota_id",
                    ],
                    1 => [
                        "id" => $containerIdForm2,
                        "name" => "names",
                        "type" => "array",
                    ],
                ];
                $config["form"] = [
                    0 => [
                        "id" => $formId1,
                        "type" => "select",
                        "name" => "Nama Provinsi",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => true,
                            "route" => route("wilayah.find", [
                                "Type" => "Kabkota",
                                "Id" => ""
                            ]),
                            "sibling_form_id" => $formId2,
                            "response" => "data",
                        ],
                        "options" => $options,
                    ],
                    1 => [
                        "id" => $formId2,
                        "type" => "select",
                        "data" => [
                            "value" => $kecamatan->kabkota_id ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                        "name" => "Nama Kab/Kota",
                        "is_disabled" => true,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => [
                            [
                                "id" => null,
                                "is_selected" => true,
                                "name" => ""
                            ],
                        ],
                    ],
                    // Form Dynamic Input
                    2 => [
                        "id" => $formId3,
                        "type" => "dynamic-input",
                        "button" => [
                            "id" => Uuid::uuid7(),
                            "name" => "+Tambah Kolom",
                            "show" => true,
                        ],
                        "container" => [
                            "id" => $containerIdForm2,
                        ],
                        "data" => [
                            "value" => $kecamatan->name ?? null,
                            "placeholder" => null
                        ],
                        "name" => "Nama Kecamatan",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                    ],
                ];
                if($kecamatan){
                    $config["name"] = "Update: $kecamatan->name";
                    $config["form"][0]["data"]["value"] = 21; // hardcode
                    $config["form"][2]["button"]["show"] = false;
                } else {
                    $config["name"] = "Create Kecamatan";
                }
            } else if($typeQuery == "Kelurahan"|| $typeQuery == "kelurahan") {
                $formId4 = Uuid::uuid7();
                $provinsi = Provinsi::all();

                $optProvinsi[] = [
                    "id" => null,
                    "is_selected" => true,
                    "name" => "Pilih"
                ];
                foreach ($provinsi as $p) {
                    $optProvinsi[] = [
                        "id"=> $p->id,
                        "is_selected" => false,
                        "name" => $p->name,
                    ];
                }
                $kelurahan = Kelurahan::find($idQuery);
                $kecamatan = Kecamatan::find($kelurahan->kecamatan_id);
                $kabkota = Kabkota::find($kecamatan->kabkota_id);
                $provinsi = Provinsi::find($kabkota->provinsi_id);
                $containerIdForm4 = Uuid::uuid7();
                $config["submit"]["route"] = route("wilayah.post", ["Type" => "Kelurahan", "Id" => $idQuery]);
                $config["submit"]["form_data"] = [
                    [
                        "id" => $formId3,
                        "name" => "kecamatan_id",
                    ],
                    [
                        "id" => $containerIdForm4,
                        "name" => "names",
                        "type" => "array",
                    ],
                ];
                $config["form"] = [
                    0 => [
                        "id" => $formId1,
                        "type" => "select",
                        "name" => "Nama Provinsi",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => true,
                            "route" => route("wilayah.find", [
                                "Type" => "Kabkota",
                                "Id" => ""
                            ]),
                            "sibling_form_id" => $formId2,
                            "response" => "data",
                        ],
                        "options" => $optProvinsi,
                        "data" => [
                            "value" => $provinsi->id ?? null,
                            "placeholder" => null
                        ],
                    ],
                    1 => [
                        "id" => $formId2,
                        "type" => "select",
                        "name" => "Nama Kab/Kota",
                        "is_disabled" => true,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => true,
                            "route" => route("wilayah.find", [
                                "Type" => "Kecamatan",
                                "Id" => ""
                            ]),
                            "sibling_form_id" => $formId3,
                            "response" => "data",
                        ],
                        "options" => [
                            [
                                "id" => null,
                                "is_selected" => true,
                                "name" => ""
                            ],
                        ],
                        "data" => [
                            "value" => $kabkota->id,
                            "placeholder" => null
                        ],
                    ],
                    2 => [
                        "id" => $formId3,
                        "type" => "select",
                        "name" => "Nama Kecamatan",
                        "is_disabled" => true,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => [
                            [
                                "id" => null,
                                "is_selected" => true,
                                "name" => ""
                            ],
                        ],
                        "data" => [
                            "value" => $kecamatan->id ?? null,
                            "placeholder" => null
                        ],
                    ],
                    // Form Dynamic Input
                    3 => [
                        "id" => $formId4,
                        "type" => "dynamic-input",
                        "button" => [
                            "id" => Uuid::uuid7(),
                            "name" => "+ Tambah",
                            "show" => true,
                        ],
                        "container" => [
                            "id" => $containerIdForm4,
                        ],
                        "data" => [
                            "value" => $kelurahan->name,
                            "placeholder" => null
                        ],
                        "name" => "Nama Kelurahan",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],

                    ],
                ];
                // Todo: update form jika data edit, ganti dynamic/multiple input jadi input biasa
                if($kelurahan){
                    $config["name"] = "Update: $kelurahan->name";
                    $config["form"][3]["button"]["show"] = false;

                } else {
                    $config["name"] = "Create Kelurahan";
                }
            } else if($typeQuery == "TPS" || $typeQuery == "tps"){
                $formQuery = $request->query("Form");

                $formId4 = Uuid::uuid7();
                $provinsi = Provinsi::all();

                $optProvinsi[] = [
                    "id" => null,
                    "is_selected" => true,
                    "name" => "Pilih"
                ];
                foreach ($provinsi as $p) {
                    $optProvinsi[] = [
                        "id"=> $p->id,
                        "is_selected" => false,
                        "name" => $p->name,
                    ];
                }
                $kelurahan = Kelurahan::find($idQuery);
                $kecamatan = Kecamatan::find($kelurahan->kecamatan_id);
                $kabkota = Kabkota::find($kecamatan->kabkota_id);
                $provinsi = Provinsi::find($kabkota->provinsi_id);
                $containerIdForm4 = Uuid::uuid7();
                $config["submit"]["route"] = route("wilayah.post", ["Type" => "Kelurahan", "Id" => $idQuery]);
                $config["submit"]["form_data"] = [
                    [
                        "id" => $formId3,
                        "name" => "kecamatan_id",
                    ],
                    [
                        "id" => $containerIdForm4,
                        "name" => "names",
                        "type" => "array",
                    ],
                ];
                $config["form"] = [
                    0 => [
                        "id" => $formId1,
                        "type" => "select",
                        "name" => "Nama Provinsi",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => true,
                            "route" => route("wilayah.find", [
                                "Type" => "Kabkota",
                                "Id" => ""
                            ]),
                            "sibling_form_id" => $formId2,
                            "response" => "data",
                        ],
                        "options" => $optProvinsi,
                        "data" => [
                            "value" => $provinsi->id ?? null,
                            "placeholder" => null
                        ],
                    ],
                    1 => [
                        "id" => $formId2,
                        "type" => "select",
                        "name" => "Nama Kab/Kota",
                        "is_disabled" => true,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => true,
                            "route" => route("wilayah.find", [
                                "Type" => "Kecamatan",
                                "Id" => ""
                            ]),
                            "sibling_form_id" => $formId3,
                            "response" => "data",
                        ],
                        "options" => [
                            [
                                "id" => null,
                                "is_selected" => true,
                                "name" => ""
                            ],
                        ],
                        "data" => [
                            "value" => $kabkota->id,
                            "placeholder" => null
                        ],
                    ],
                    2 => [
                        "id" => $formId3,
                        "type" => "select",
                        "name" => "Nama Kecamatan",
                        "is_disabled" => true,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => [
                            [
                                "id" => null,
                                "is_selected" => true,
                                "name" => ""
                            ],
                        ],
                        "data" => [
                            "value" => $kecamatan->id ?? null,
                            "placeholder" => null
                        ],
                    ],
                    // Form Dynamic Input
                    3 => [
                        "id" => $formId4,
                        "type" => "dynamic-input",
                        "button" => [
                            "id" => Uuid::uuid7(),
                            "name" => "+ Tambah",
                            "show" => true,
                        ],
                        "container" => [
                            "id" => $containerIdForm4,
                        ],
                        "data" => [
                            "value" => $kelurahan->name,
                            "placeholder" => null
                        ],
                        "name" => "Nama Kelurahan",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],

                    ],
                ];
                // Todo: update form jika data edit, ganti dynamic/multiple input jadi input biasa
                if($kelurahan){
                    $config["name"] = "Update: $kelurahan->name";
                    $config["form"][3]["button"]["show"] = false;

                } else {
                    $config["name"] = "Create TPS";
                }
            }
            // dd($config);
            return view($view, [
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
    public function store(Request $request) {
        $message = null;
        $responseCode = 200;
        try {
            $queryType = $request->query("Type");
            $queryId = $request->query("Id");
            if ($queryType == "Kabkota" || $queryType == "kabkota") {
                $validator = Validator::make($request->all(), [
                    "id" => "required|integer",
                    "name" => "required|string|max:255",
                    "provinsi_id" => "required|integer"
                ]);
                if ($validator->fails()) {
                    $message = $validator->errors()->all();
                    $responseCode = 500;
                } else {
                    $data = KabKota::withTrashed()->find($queryId);
                    if ($data) {
                        // $data->update($request->all());
                        $data->name = $request->name;
                        $data->provinsi_id = (int)$request->provinsi_id;
                        $data->save();
                        $message = "Data berhasil diperbarui";
                    } else {
                        KabKota::create([
                            "id" => $request->id,
                            "name" => $request->name,
                            "provinsi_id" => $request->provinsi_id
                        ]);
                        $message = "Saat ini belum bisa menambahkan data, hubungi developer";
                        $responseCode = 500;
                    }
                }
            } else if ($queryType == "Kecamatan" || $queryType == "kecamatan"){
                $validator = Validator::make($request->all(), [
                    "names" => "required|array|min:1",
                    "kabkota_id" => "required|integer"
                ]);
                if ($validator->fails()) {
                    $message = $validator->errors()->all();
                    $responseCode = 500;
                } else {
                    $data = Kecamatan::withTrashed()->find($queryId);
                    if ($data) {
                        $data->name = $request->names[0];
                        $data->save();
                        $message = "Data berhasil diperbarui";
                    } else {
                        $data = [];
                        foreach ($request->names as $value) {
                            if ($value) {
                                array_push($data, [
                                    "id" => Uuid::uuid7(),
                                    "name" => $value,
                                    "kabkota_id" => $request->kabkota_id,
                                ]);
                            }
                        }
                        Kecamatan::insert($data);
                        $message = "Data baru ditambahkan";
                    }
                }
            } else if ($queryType == "Kelurahan" || $queryType == "kelurahan") {
                $validator = Validator::make($request->all(), [
                    "name" => "required|string|array|min:1",
                    "kecamatan_id" => "required|string"
                ]);
                if ($validator->fails()) {
                    $message = $validator->errors()->all();
                    $responseCode = 500;
                } else {
                    $data = Kelurahan::withTrashed()->find($queryId);
                    if ($data) {
                        $data->update($request->all());
                    } else {
                        $data = [];
                        foreach ($request->names as $value) {
                            if ($value) {
                                array_push($data, [
                                    "id" => Uuid::uuid7(),
                                    "name" => $value,
                                    "kecamatan_id" => $request->kecamatan_id,
                                ]);
                            }
                        }
                        if ($data) {
                            Kelurahan::insert($data);
                            $message = "Data baru ditambahkan";
                        } else {
                            $responseCode = 500;
                        }
                    }
                }
            } else if ($queryType == "TPS" || $queryType == "tps") {
                $validator = Validator::make($request->all(), [
                    "name" => "required|string|max:255",
                    "kelurahan_id" => "required|string"
                ]);
                if ($validator->fails()) {
                    $message = $validator->errors()->all();
                    $responseCode = 500;
                } else {
                    $data = Tps::withTrashed()->find($queryId);
                    if ($data) {
                        $data->update($request->all());
                    } else {
                        $data = $request->all();
                        if (!$request->id) {
                            $data["id"] = Uuid::uuid7();
                        }
                        Tps::create($data);
                    }
                }
            }

            return response()->json([
                "message" => $message,
                "data" => $request->all()
            ], $responseCode);
        } catch (QueryException $e) {
            $responseCode = 500;
            $message = match ($e->errorInfo[1]) {
                1062 => "Data sudah ada",
                default => $e->errorInfo[2],
            };
            return response()->json(["message" => $message, "data" => $request->all()], $responseCode);
        }
    }

    /**
     * Display the specified resource.
     */
    public function find(Request $request)
    {
        try {
            $data = null;
            $typeQuery = $request->query("Type");
            $idQuery = $request->query("Id");
            if ($typeQuery == "Provinsi" || $typeQuery == "provinsi") {
                $data = Provinsi::where("id", $idQuery)->get();
            } else if ($typeQuery == "Kabkota" || $typeQuery == "kabkota"){
                $data = KabKota::where("provinsi_id", $idQuery)->get();
            } else if ($typeQuery == "Kecamatan" || $typeQuery == "kecamatan"){
                $data = Kecamatan::where("kabkota_id", $idQuery)->get();
            } else if ($typeQuery == "Kelurahan" || $typeQuery == "kelurahan"){
                $data = Kelurahan::where("kecamatan_id", $idQuery)->get();
            } else if ($typeQuery == "TPS" || $typeQuery == "tps"){
                $data = TPS::where("kelurahan_id", $idQuery)->get();
            }

            return response()->json([
                "data" => $data,
            ], 200);
        } catch (QueryException $e) {
            $message = match($e->errorInfo[1]){
                1062 => "Duplikasi Data",
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
