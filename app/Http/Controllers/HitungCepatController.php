<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Http\Request;

class HitungCepatController extends Controller
{
    protected $tps;
    public function __construct(Tps $tps)
    {
        $this->tps = $tps;
    }
    public function byAdmin(Request $request)
    {
        try {
            $provinsi = Provinsi::all();
            return view("hitung_cepat.admin", [
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
    public function listByAdmin(Request $request)
    {
        try {
            $idQuery = $request->query("Id");
            $typeQuery = $request->query("Type");
            $calon = null;
            $data = $this->tps->tpsWithDetail()
            ->where('kelurahan_id', $idQuery)
            ->get();
            if ($typeQuery === "Provinsi" || $typeQuery === "provinsi") {
                $calonCode = $data == null ? null : $data->first()->provinsi_id;
                $calon = Calon::where("code", $calonCode)->get();
            } else if ($typeQuery === "Kabkota" || $typeQuery === "kabkota") {
                $calonCode = $data == null ? null : $data->first()->kabkota_id;
                $calon = Calon::where("code", $calonCode)->get();
            }
            return view("hitung_cepat.table", [
                "table" => $data == null ? "Kosong" : $data->first()->kelurahan->name,
                "data" => $data,
                "calon" => $calon,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);

            return response()->json([
                "message" => $val,
            ]);
        }
    }
}
