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
    // public function index(Request $request)
    // {
    //     /**
    //      * jika query param ber-value provinsi || kabkota
    //      * maka controller akan mengambil dan merespon data json
    //      */
    //     $user = User::find($request->session()->get('user_id'));
    //     $jenis = $request->query("Jenis");
    //     if ($jenis == "provinsi") {
    //         $jenis = Provinsi::all();
    //         return response()->json(["data" => $jenis], 200);
    //     }
    //     if ($jenis == "kabkota") {
    //         if ($user->level === "master") {
    //             $jenis = KabKota::all();
    //         } else if ($user->level === "kabkota") {
    //             $code = $user->code;
    //             $jenis = KabKota::where("id", $code)->get();
    //         }
    //         return response()->json(["data" => $jenis], 200);
    //     }
    //     // jika tidak render halaman
    //     return view('rekapitulasi.index');
    // }
    public function index(Request $request){
        $view = "rekapitulasi.index";
        $provinsi = null;
        $kabkota = null;
        $user = User::find($request->session()->get('user_id'));
        $typeQuery = $request->query("Type");
        if ($typeQuery == "Provinsi" || $typeQuery == "provinsi") {
            $view = "rekapitulasi.provinsi";
        }
        switch ($user->level) {
            case 'kabkota':
            $kabkota = KabKota::where("id", $user->code)->first();
            $provinsi = Provinsi::where("id", $kabkota->provinsi_id)->get();
            break;
            default:
            $provinsi = Provinsi::all();
            break;
        }
        if ($typeQuery == "Kabkota" || $typeQuery == "kabkota"){
            switch ($user->level) {
                case 'kabkota':
                    $kabkota = KabKota::where("id", $user->code)->first();
                    break;
                default:
                    $kabkota = KabKota::all();
                    break;
            }
            $view = "rekapitulasi.kabkota";
        }
        return view($view, [
            "provinsi" => $provinsi,
            "kabkota" => $kabkota,
        ]);
    }
    public function kabkota(Request $request)
    {
        $kabkota = null;
        $user = User::find($request->session()->get('user_id'));
        $provinsi = $request->query("Provinsi");
        if ($user->level == "kabkota") {
            $kabkota = KabKota::where("id", $user->code)->get();
        } else {
            $kabkota = KabKota::where("provinsi_id", $provinsi)->get();
        }
        return response()->json([
            "kabkota" => $kabkota,
        ], 200);
    }
    public function list(Request $request){
        $view = "rekapitulasi.list"; // soon: change list to table
        $idQuery = $request->query("Id");
        // $typeQuery = $request->query("Type");
        $chartQuery = $request->query("Chart");
        $checkQuery = !$idQuery || $idQuery == "null" || $idQuery == "Pilih";
        if ($checkQuery) {
            return redirect("/rekapitulasi");
        }
        $data = Calon::where("code", $request->query("Id"))->get();
        if ($chartQuery) {
            $view = "rekapitulasi.chart";
        }
        return view($view, [
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
