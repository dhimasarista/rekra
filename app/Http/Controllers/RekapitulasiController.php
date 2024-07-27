<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /**
         * jika query param ber-value provinsi || kabkota
         * maka controller akan mengambil dan merespon data json
         */
        $user = User::find($request->session()->get('user_id'));
        $jenis = $request->query("Jenis");
        if ($jenis == "provinsi") {
            $jenis = Provinsi::all();
            return response()->json(["data" => $jenis], 200);
        }
        if ($jenis == "kabkota") {
            if ($user->level === "master") {
                $jenis = KabKota::all();
            } else if ($user->level === "kabkota") {
                $code = 2171;
                $jenis = KabKota::where("id", $code)->get();
            }
            return response()->json(["data" => $jenis], 200);
        }
        // jika tidak render halaman
        return view('rekapitulasi.index');
    }
    public function list(Request $request){
        $userRole = "kabkota";
        $idQuery = $request->query("Id");
        $checkQuery = !$idQuery || $idQuery == "null" || $idQuery == "Pilih";
        if ($checkQuery) {
            return redirect("/rekapitulasi");
        }
        $data = Calon::where("code", $request->query("Id"))->get();

        return view("rekapitulasi.list", [
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
