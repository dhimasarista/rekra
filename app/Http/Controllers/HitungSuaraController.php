<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\JumlahSuara;
use App\Models\JumlahSuaraDetail;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Http\Request;

class HitungSuaraController extends Controller
{
    protected $jumlahSuara;
    protected $jumlahSuaraDetail;
    protected $tps;
    public function __construct(JumlahSuara $jumlahSuara, Tps $tps, JumlahSuaraDetail $jumlahSuaraDetail)
    {
        $this->jumlahSuara = $jumlahSuara;
        $this->jumlahSuaraDetail = $jumlahSuaraDetail;
        $this->tps = $tps;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $provinsi = Provinsi::all();
            return view("hitung_suara.index", [
                "urlSubmit" => route("hitung_suara.list", ['Id' => 'ID_PLACEHOLDER']),
                "provinsi" => $provinsi,
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

    /**
     * Show the form for creating a new resource.
     */
    public function list(Request $request)
    {
        try {
            $idQuery = $request->query("Id");
            $tps = $this->tps->tpsWithDetail()
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
            return view("hitung_suara.table", [
                "data" => $data,
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
