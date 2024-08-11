<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class RekapitulasiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $config = null;
            $data = null;
            $view = "layouts.form";
            $typeQuery = $request->query("Type");
            if ($typeQuery) {
                if ($typeQuery == "Provinsi" || $typeQuery == "provinsi") {
                    $data = Provinsi::all();
                    $formId1 = Uuid::uuid7();
                    $formId2 = Uuid::uuid7();
                    $options[] = [
                        "id" => null,
                        "is_selected" => true,
                        "name" => "Pilih"
                    ];
                    foreach ($data as $provinsi) {
                        $options[] = [
                            "id"=> $provinsi->id,
                            "is_selected" => false,
                            "name" => $provinsi->name,
                        ];
                    }
                    $config = [
                        "name" => "Pilih Provinsi",
                        "submit" => [
                            "type" => "redirect", // or "input"
                            "id" => Uuid::uuid7(),
                            "route" => route('rekap.list', ['Type' => 'Provinsi'])
                        ],
                        "form" => [
                            0 => [
                                "id" => $formId1,
                                "type" => "select",
                                "name" => "Nama Negara",
                                "is_disabled" => true,
                                "for_submit" => false,
                                "fetch_data" => [
                                    "is_fetching" => false
                                ],
                                "options" => [
                                    [
                                        "id" => null,
                                        "is_selected" => true,
                                        "name" => "indonesia",
                                    ],
                                ]
                            ],
                            1 => [
                                "id" => $formId2,
                                "type" => "select",
                                "name" => "Nama Provinsi",
                                "is_disabled" => false,
                                "for_submit" => true,
                                "fetch_data" => [
                                    "is_fetching" => false,
                                ],
                                "options" => $options,
                            ],
                        ]

                    ];
                } else if ($typeQuery == "Kabkota" || $typeQuery == "kabkota") {
                    $data = Provinsi::all();
                    $options[] = [
                        "id" => null,
                        "is_selected" => true,
                        "name" => "Pilih"
                    ];
                    foreach ($data as $p) {
                        $options[] = [
                            "id" => $p->id,
                            "is_selected" => false,
                            "name" => $p->name
                        ];
                    }
                    $formId1 = Uuid::uuid7();
                    $formId2 = Uuid::uuid7();
                    // $formId3 = Uuid::uuid7();
                    $config = [
                        "name" => "Pilih Kabupaten/Kota",
                        "submit" => [
                            "type" => "redirect", // or "input"
                            "id" => Uuid::uuid7(),
                            "route" => route('rekap.list', ['Type' => 'Kabkota'])
                        ],
                        "form" => [
                            0 => [
                                "id" => $formId1,
                                "type" => "select",
                                "name" => "Nama Provinsi",
                                "is_disabled" => false,
                                "for_submit" => false,
                                "fetch_data" => [
                                    "is_fetching" => true,
                                    "route" => "/rekapitulasi/wilayah/kabkota?Provinsi=",
                                    "sibling_form_id" => $formId2,
                                    "response" => "kabkota",
                                ],
                                "options" => $options,
                            ],
                            1 => [
                                "id" => $formId2,
                                "type" => "select",
                                "name" => "Nama Kab/Kota",
                                "is_disabled" => true,
                                "for_submit" => true,
                                "fetch_data" => [
                                    "is_fetching" => false
                                ],
                                "options" => [
                                    [
                                        "id" => null,
                                        "is_selected" => true,
                                        "name" => ""
                                    ],
                                ]
                            ],
                        ],
                    ];
                }
            } else {
                $view = "rekapitulasi.index";
            }
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
    public function list(Request $request)
    {
        $data = null;
        $view = "rekapitulasi.list"; // soon: change list to table
        $idQuery = $request->query("Id");
        $typeQuery = $request->query("Type");
        $chartQuery = $request->query("Chart");
        $checkQuery = !$idQuery || $idQuery == "null" || $idQuery == "Pilih";
        if ($checkQuery) {
            return redirect("/rekapitulasi");
        }
        $wilayah = null;
        if ($typeQuery == "Kabkota" || $typeQuery == "kabkota"){
            $wilayah = Kabkota::with("kecamatan")->find($idQuery);
        } else {
            $wilayah = Provinsi::with("kabkota")->find($idQuery);
        }
        $data = Calon::where("code", $request->query("Id"))->get();
        if ($chartQuery) {
            $data = [
                "calon" => $data,
                "wilayah" => $wilayah,
            ];
            $view = "layouts.chart";
        }
        return view($view, [
            "data" => $data
        ]);
    }
    public function selectType($Jenis)
    {
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
