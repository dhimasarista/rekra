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
    public function index(){
        try {
            $data = KabKota::all();
            return view("wilayah.index", [
                "data"=> $data,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => "Internal Server Error",
                "message" => $e->getMessage(),
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
                $formId4 = Uuid::uuid7();
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
                        "options" => $options,
                    ],
                ];
                if($kabkota){
                    $config["name"] = "Update: $kabkota->name";
                    $config["form"][2]["data"]["value"] = $kabkota->provinsi_id;
                }
            }
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
    public function form2(Request $request)
    {
        try {
            $typeQuery = $request->query("Type");
            $view = "wilayah.index";
            $data = null;
            $dataWilayah = null;
            $idQuery = $request->query("Id");
                if($typeQuery == "Kabkota"|| $typeQuery == "kabkota"){
                    $view = "wilayah.forms.kabkota";
                    $dataWilayah = Provinsi::all();
                    if ($idQuery) {
                        $data = KabKota::find($idQuery);
                    }
                } else if($typeQuery == "Kecamatan"|| $typeQuery == "kecamatan"){

                } else if($typeQuery == "Kelurahan"|| $typeQuery == "kelurahan"){

                } else if($typeQuery == "TPS"|| $typeQuery == "tps"){

                }

            return view($view, [
                "data" => $data,
                "dataWilayah" => $dataWilayah,
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
                        // KabKota::create($request->all());
                        $message = "Saat ini belum bisa menambahkan data, hubungi developer";
                        $responseCode = 500;
                    }
                }
            } else if ($queryType == "Kecamatan" || $queryType == "kecamatan"){
                $validator = Validator::make($request->all(), [
                    "name" => "required|string|max:255",
                    "kabkota_id" => "required|integer"
                ]);
                if ($validator->fails()) {
                    $message = $validator->errors()->all();
                    $responseCode = 500;
                } else {
                    $data = Kecamatan::withTrashed()->find($queryId);
                    if ($data) {
                        $data->update($request->all());
                    } else {
                        $data = $request->all();
                        if (!$request->id) {
                            $data["id"] = Uuid::uuid7();
                        }
                        Kecamatan::create($data);
                    }
                }
            } else if ($queryType == "Kelurahan" || $queryType == "kelurahan") {
                $validator = Validator::make($request->all(), [
                    "name" => "required|string|max:255",
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
                        $data = $request->all();
                        if (!$request->id) {
                            $data["id"] = Uuid::uuid7();
                        }
                        Kelurahan::create($data);
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
    public function show(string $id)
    {
        //
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
