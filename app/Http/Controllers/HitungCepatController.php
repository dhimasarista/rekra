<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use Exception;
use Illuminate\Http\Request;

class HitungCepatController extends Controller
{
    public function byAdmin(Request $request)
    {
        try {

            return view("hitung_cepat.admin");
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
}
