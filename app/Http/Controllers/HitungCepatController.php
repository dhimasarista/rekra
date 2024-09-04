<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Provinsi;
use Exception;
use Illuminate\Http\Request;

class HitungCepatController extends Controller
{
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

            return view("hitung_cepat.table");
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
