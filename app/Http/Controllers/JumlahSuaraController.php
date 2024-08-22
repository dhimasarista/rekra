<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class JumlahSuaraController extends Controller
{
    public function index(Request $request){
        try {
            $data = null;
            $view = "layouts.form";
            //
                $formId1 = Uuid::uuid7();
                $formId2 = Uuid::uuid7();
                $formId3 = Uuid::uuid7();
            //
            $config = [
                "name" => "TPS 001 Sadai, Bengkong, Kota Batam",
                "submit" => [
                    "id" => Uuid::uuid7(),
                    "type" => "input", // redirect, input
                    "route" => null,
                    "method" => "post",
                    "redirect" =>  null,
                ],
                "form_data" => [
                    [
                        "id" => $formId1,
                        "name" => "Nama Calon",
                        "type" => "string"
                    ],
                ],
                "form" => [
                    0 => [
                        "id" => $formId1,
                        "type" => "text",
                        "name" => "No. 1 - Anto & Ujang",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => 1000 ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    1 => [
                        "id" => $formId1,
                        "type" => "text",
                        "name" => "No. 2 - Yusuf & Alex",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => 1000 ?? null,
                            "placeholder" => "Wajib Diisi",
                        ],
                    ],
                    2 => [
                        "id" => $formId3,
                        "type" => "textarea",
                        "name" => "Catatan (Tidak Wajib)",
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => "Contoh: Terjadi kecurangan...",
                        ],
                    ]
                ],
            ];

            return view($view, [
                "data" => $data,
                "config" => $config,
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
}
