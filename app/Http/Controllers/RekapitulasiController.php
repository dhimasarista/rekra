<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\JumlahSuara;
use App\Models\JumlahSuaraDetail;
use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
                                    "route" => route("wilayah.find", [
                                        "Type" => "Kabkota",
                                        "Id" => "",
                                    ]),
                                    "sibling_form_id" => $formId2,
                                    "response" => "data",
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
    public function list(Request $request)
    {
        $data = null;
        $wilayah = null;
        $view = "rekapitulasi.list"; // soon: change list to table
        $cacheKey = 'calon_data_' . $request->query('Id'); // caching

        $idQuery = $request->query("Id");
        $typeQuery = $request->query("Type");
        $chartQuery = $request->query("Chart");

        // Check id query
        $checkQuery = !$idQuery || $idQuery == "null" || $idQuery == "Pilih";
        if ($checkQuery) {
            return redirect("/rekapitulasi");
        }

        if ($typeQuery == "Kabkota" || $typeQuery == "kabkota") {
            $wilayah = Kabkota::with("kecamatan")->find($idQuery);
        } else $wilayah = Provinsi::with("kabkota")->find($idQuery);
        // dd($wilayah);

        if ($chartQuery) {
            $view = "layouts.chart";
            $dataPerwilayah = [];
            $calonTotal = Calon::select(
                "calon.id",
                "calon.calon_name",
                "calon.wakil_name",
                DB::raw("COALESCE(SUM(jumlah_suara_details.amount), 0) as total")
            )
            ->leftJoin("jumlah_suara_details", "calon.id", "=", "jumlah_suara_details.calon_id")
            ->where("calon.code", $idQuery)
            ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
            ->get();
            if ($typeQuery == "Provinsi" || $typeQuery == "Provinsi") {
                // todo like Kabkota but kecamatan change with kabkota
            } else if ($typeQuery == "Kabkota" || $typeQuery == "kabkota") {
                foreach ($wilayah->kecamatan as $kecamatan) {
                    $totalSuaraPerKecamatan = Calon::select(
                        "calon.id",
                        "calon.calon_name",
                        "calon.wakil_name",
                        DB::raw("COALESCE(SUM(jumlah_suara_details.amount), 0) as total")
                    )
                    ->leftJoin("jumlah_suara_details", "calon.id", "=", "jumlah_suara_details.calon_id")
                    ->leftJoin("tps", "jumlah_suara_details.tps_id", "=", "tps.id")
                    ->leftJoin("kelurahan", "tps.kelurahan_id", "=", "kelurahan.id")
                    ->leftJoin("kecamatan", "kelurahan.kecamatan_id", "=", "kecamatan.id")
                    ->where("kecamatan.id", $kecamatan->id)  // Menghubungkan TPS dengan kecamatan
                    ->where("calon.code", $idQuery)
                    ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
                    ->get();
                    if ($totalSuaraPerKecamatan->isEmpty()) {
                        // Jika tidak ada data suara per kecamatan, set total untuk setiap calon menjadi 0
                        $totalSuaraArray = $calonTotal->map(function ($calon) {
                            return (object) [
                                'id' => $calon->id,
                                'calon_name' => $calon->calon_name,
                                'wakil_name' => $calon->wakil_name,
                                'total' => 0 // Set total menjadi 0
                            ];
                        });
                    } else {
                        $totalSuaraArray = $totalSuaraPerKecamatan;
                    }
                    $dataPerwilayah[] = [
                        "id" => $kecamatan->id,
                        "name" => $kecamatan->name,
                        "total_suara" => $totalSuaraArray
                    ];
                }
            }
            $data = [
                "calon_total" => $calonTotal,
                "data_perwilayah" => $dataPerwilayah
            ];
            // dd($data);
        } else {
            // $data = Calon::where("code", $request->query("Id"))->with('jumlahSuara')->get();
            $data = Cache::remember($cacheKey, 1, function() use ($request){
                $idQuery = $request->query("Id");
                return Calon::select("calon.id", "calon.calon_name", "calon.wakil_name", DB::raw("COALESCE(SUM(jumlah_suara_details.amount), 0) as total"))
                ->leftJoin("jumlah_suara_details", "calon.id", "=", "jumlah_suara_details.calon_id")
                ->where("calon.code", $idQuery)
                ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
                ->get();
            });
        }
        // dd($data);
        return view($view, [
            "data" => $data,
            "wilayah" => $wilayah,
        ]);
    }
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
