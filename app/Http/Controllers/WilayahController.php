<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Rfc4122\UuidV1;
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
                    $data = KabKota::all();
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
    public function form(Request $request)
    {
        try {
            $typeQuery = $request->query("Type");
            $view = "wilayah.index";
            $data = null;
            $dataWilayah = null;
            if ($typeQuery) {
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
            }
            if (!$data) {
                return response()->redirectToRoute("wilayah.index", ["message"=> "Fuck You"]);
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
                    "provinsi_id" => "required|int"
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
                        KabKota::create($request->all());
                        $message = "Data berhasil dibuat";
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
