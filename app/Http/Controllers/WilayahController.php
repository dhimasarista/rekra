<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Provinsi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index(Request $request){
        try {
            $typeQuery = $request->query("Type");
            $data = null;
            if ($typeQuery) {
                if($typeQuery == "Provinsi" || $typeQuery == "provinsi"){
                    $data = Provinsi::all();
                } else if ($typeQuery == "Kabkota" || $typeQuery == "kabkota"){
                    $data = KabKota::all();
                }

                return response()->json([
                    "data"=> $data
                ], 200);
            }
            return view("wilayah.index", [
                "data"=> $data,
            ]);
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
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
