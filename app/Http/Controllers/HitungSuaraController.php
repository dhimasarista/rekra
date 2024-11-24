<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
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

    public function form(Request $request)
    {
        try {
            $tpsQuery = $request->query("Tps");
            $typeQuery = $request->query("Type");
            // Ambil data TPS dengan detail
            $tps = $this->tps->tpsWithDetail()
                ->where('tps.id', $tpsQuery)
                ->first(); // Menggunakan first() jika hanya membutuhkan satu hasil
            if (!$tps) {
                // Tangani kasus jika TPS tidak ditemukan
                abort(404, 'TPS not found');
            }
            if ($typeQuery === "Kabkota" || $typeQuery === "kabkota") {
                // Ambil data calon berdasarkan kabkota_id dari TPS
                $calon = Calon::where("code", $tps->kabkota_id)->get(['id', 'calon_name', 'wakil_name']); // Ambil hanya kolom yang diperlukan
            } else if ($typeQuery === "Provinsi" || $typeQuery === "provinsi") {
                $calon = Calon::where("code", $tps->provinsi_id)->get(['id', 'calon_name', 'wakil_name']); // Ambil hanya kolom yang diperlukan
            }
            // Ambil jumlah suara detail berdasarkan tps_id
            $jumlahSuaraDetail = $this->jumlahSuaraDetail
                ->select("calon_id", "tps_id", "amount", "jumlah_suara_id")
                ->where("tps_id", $tps->id)
                ->get();
            $jumlahSuaraId = null;
            $jumlahSuara = $this->jumlahSuara::find($jumlahSuaraId);

            // Buat lookup untuk jumlah suara berdasarkan calon_id
            $jumlahSuaraLookup = $jumlahSuaraDetail->keyBy('calon_id');
            // Format data calon dengan jumlah suara
            $newCalon = $calon->map(function ($c) use ($jumlahSuaraLookup) {
                $jumlahSuaraDetail = $jumlahSuaraLookup->get($c->id, (object) ['amount' => 0])->amount;
                return [
                    "id" => $c->id,
                    "calon_name" => $c->calon_name,
                    "wakil_name" => $c->wakil_name,
                    "jumlah_suara" => $jumlahSuaraDetail,
                ];
            })->toArray();

            // Format data untuk respons
            $data = [
                "tps_id" => $tps->id,
                "tps_name" => sprintf(
                    "%s - %s, %s, %s, %s",
                    $typeQuery,
                    $tps->name,
                    Formatting::capitalize($tps->kelurahan_name),
                    Formatting::capitalize($tps->kecamatan_name),
                    Formatting::capitalize($tps->kabkota_name)
                ),
                "calon" => $newCalon,
            ];
            return view("hitung_suara.form", [
                "data" => $data,
            ]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
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
