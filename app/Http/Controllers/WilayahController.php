<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\KabKota;
use App\Models\Provinsi;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

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
                "title" => $e->getMessage(),
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
    public function store(Request $request)
    {
        //
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
