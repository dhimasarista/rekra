<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Provinsi;
use App\Utilities\Formatting;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jenis = $request->query("Jenis");
        if ($jenis == "provinsi") {
            $jenis = Provinsi::all();
            return response()->json(["data" => $jenis], 200);
        }
        if ($jenis == "kabkota") {
            $jenis = KabKota::all();
            return response()->json(["data" => $jenis], 200);
        }
        return view('rekapitulasi.index');
    }
    public function list(Request $request){
        if (!$request->query("Id")) {
            return redirect("/rekapitulasi");
        }
        $data = [
            [
                "name" => "Dhimas - Ibna",
                "total" => 2390,
            ],
            [
                "name" => "Anto - Udin",
                "total" => 0,
            ]
        ];
        return view("rekapitulasi.list", [
            "name" => "provinsi",
            "data" => $data
        ]);
    }
    public function selectType($Jenis){
        $value = null;
        if ($Jenis == "provinsi") {
            $value = Provinsi::all();
        }

        return response()->json([
            "value" => $value,
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
