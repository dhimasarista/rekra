<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RekapitulasiController extends Controller
{
    protected $tps;
    public function __construct(Tps $tps)
    {
        $this->tps = $tps;
    }
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
                        "name" => "Pilih",
                    ];
                    foreach ($data as $provinsi) {
                        $options[] = [
                            "id" => $provinsi->id,
                            "is_selected" => false,
                            "name" => $provinsi->name,
                        ];
                    }
                    $config = [
                        "name" => "Pilih Provinsi",
                        "submit" => [
                            "type" => "redirect", // or "input"
                            "id" => Uuid::uuid7(),
                            "route" => route('rekap.list', ['Type' => 'Provinsi']),
                        ],
                        "form" => [
                            0 => [
                                "id" => $formId1,
                                "type" => "select",
                                "name" => "Nama Negara",
                                "is_disabled" => true,
                                "for_submit" => false,
                                "fetch_data" => [
                                    "is_fetching" => false,
                                ],
                                "options" => [
                                    [
                                        "id" => null,
                                        "is_selected" => true,
                                        "name" => "indonesia",
                                    ],
                                ],
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
                        ],

                    ];
                } else if ($typeQuery == "Kabkota" || $typeQuery == "kabkota") {
                    $data = Provinsi::all();
                    $options[] = [
                        "id" => null,
                        "is_selected" => true,
                        "name" => "Pilih",
                    ];
                    foreach ($data as $p) {
                        $options[] = [
                            "id" => $p->id,
                            "is_selected" => false,
                            "name" => $p->name,
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
                            "route" => route('rekap.list', ['Type' => 'Kabkota']),
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
                                    "is_fetching" => false,
                                ],
                                "options" => [
                                    [
                                        "id" => null,
                                        "is_selected" => true,
                                        "name" => "",
                                    ],
                                ],
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
        $view = $request->query("Chart") ? "layouts.chart" : "rekapitulasi.list"; // Use chart view if needed
        $cacheKey = 'calon_data_' . $request->query('Id'); // Caching

        $idQuery = $request->query("Id");
        $typeQuery = strtolower($request->query("Type"));

        // Check id query
        if (!$idQuery || $idQuery == "null" || $idQuery == "Pilih") {
            return redirect("/rekapitulasi");
        }

        // Get Wilayah and Cache it
        // $wilayah = Cache::remember("wilayah_{$typeQuery}_{$idQuery}", 60, function () use ($typeQuery, $idQuery) {
        //     return match ($typeQuery) {
        //         "kabkota" => Kabkota::with("kecamatan")->find($idQuery),
        //         "provinsi" => Provinsi::with("kabkota")->find($idQuery),
        //         default => null,
        //     };
        // });
        $wilayah = match ($typeQuery) {
            "kabkota" => Kabkota::with("kecamatan")->find($idQuery),
            "provinsi" => Provinsi::with("kabkota")->find($idQuery),
            default => null,
        };

        if ($request->query("Chart")) {
            $dataPerwilayah = $this->getDataPerWilayah($wilayah, $idQuery, $typeQuery);
            $calonTotal = $this->getCalonTotal($idQuery);

            $data = [
                "calon_total" => $calonTotal,
                "data_perwilayah" => $dataPerwilayah,
            ];
        } else {
            $data = $this->getCalonTotal($idQuery);
            // $data = Cache::remember($cacheKey, 60, function () use ($idQuery) {
            //     return $this->getCalonTotal($idQuery);
            // });
        }

        return view($view, [
            "data" => $data,
            "wilayah" => $wilayah,
        ]);
    }

    /**
     * Get Total Suara Per Wilayah
     */
    private function getDataPerWilayah($wilayah, $idQuery, $typeQuery)
    {
        $dataPerwilayah = [];
        $calonTotal = $this->getCalonTotal($idQuery);

        foreach ($wilayah->{($typeQuery === "Provinsi" || $typeQuery === "provinsi") ? 'kabkota' : 'kecamatan'} as $region) {
            $totalSuara = $this->getTotalSuaraPerWilayah($region->id, $idQuery, $typeQuery);

            $totalSuaraArray = $totalSuara->isEmpty() ? $calonTotal->map(fn($calon) => (object) [
                'id' => $calon->id,
                'calon_name' => $calon->calon_name,
                'wakil_name' => $calon->wakil_name,
                'total' => 0,
            ]) : $totalSuara;

            $dataPerwilayah[] = [
                "id" => $region->id,
                "name" => $region->name,
                "total_suara" => $totalSuaraArray,
            ];
        }

        return $dataPerwilayah;
    }

    /**
     * Get Total Suara per Wilayah (Kecamatan/Kabkota)
     */
    private function getTotalSuaraPerWilayah($regionId, $idQuery, $typeQuery)
    {
        return Calon::select(
            "calon.id",
            "calon.calon_name",
            "calon.wakil_name",
            DB::raw("COALESCE(SUM(jumlah_suara_details.amount), 0) as total")
        )
            ->leftJoin("jumlah_suara_details", "calon.id", "=", "jumlah_suara_details.calon_id")
            ->leftJoin("tps", "jumlah_suara_details.tps_id", "=", "tps.id")
            ->leftJoin("kelurahan", "tps.kelurahan_id", "=", "kelurahan.id")
            ->leftJoin("kecamatan", "kelurahan.kecamatan_id", "=", "kecamatan.id")
            ->leftJoin("kabkota", "kecamatan.kabkota_id", "=", "kabkota.id")
            ->where(($typeQuery === "provinsi") ? "kabkota.id" : "kecamatan.id", $regionId)
            ->where("calon.code", $idQuery)
            ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
            ->get();
    }

    /**
     * Get Calon Total
     */
    private function getCalonTotal($idQuery)
    {
        return Calon::select(
            "calon.id",
            "calon.calon_name",
            "calon.wakil_name",
            DB::raw("COALESCE(SUM(jumlah_suara_details.amount), 0) as total")
        )
            ->leftJoin("jumlah_suara_details", "calon.id", "=", "jumlah_suara_details.calon_id")
            ->where("calon.code", $idQuery)
            ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
            ->get();
    }
    public function detail(Request $request)
    {
        try {
            $data = null;
            $wilayah = null;
            $isProvinsi = false;
            $view = "rekapitulasi.detail";
            $typeQuery = $request->query("Type");
            $codeQuery = $request->query("Code");
            $idCalon = $request->query("Id");
            $calon = Calon::find($idCalon);
            if ($typeQuery == "Provinsi") {
                $isProvinsi = true;
                $wilayah = "Kabkota";
                $data = Kabkota::select(
                    "kabkota.id",
                    "kabkota.name",
                    DB::raw('COALESCE(SUM(jumlah_suara_details.amount), 0) as total')
                )
                    ->leftJoin('kecamatan', 'kecamatan.kabkota_id', '=', 'kabkota.id')
                    ->leftJoin('kelurahan', 'kelurahan.kecamatan_id', '=', 'kecamatan.id')
                    ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
                    ->leftJoin('jumlah_suara_details', function ($join) use ($idCalon) {
                        $join->on('jumlah_suara_details.tps_id', '=', 'tps.id')
                            ->where('jumlah_suara_details.calon_id', '=', $idCalon);
                    })
                    ->where('kabkota.provinsi_id', $codeQuery)
                    ->groupBy('kabkota.id', 'kabkota.name')
                    ->get();
            } else if ($typeQuery == "Kabkota") {
                $wilayah = "Kecamatan";
                $data = Kecamatan::select(
                    'kecamatan.id',
                    'kecamatan.name',
                    DB::raw('COALESCE(SUM(jumlah_suara_details.amount), 0) as total')
                )
                    ->leftJoin('kelurahan', 'kelurahan.kecamatan_id', '=', 'kecamatan.id')
                    ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
                    ->leftJoin('jumlah_suara_details', function ($join) use ($idCalon) {
                        $join->on('jumlah_suara_details.tps_id', '=', 'tps.id')
                            ->where('jumlah_suara_details.calon_id', '=', $idCalon);
                    })
                    ->where('kecamatan.kabkota_id', $codeQuery)
                    ->groupBy('kecamatan.id', 'kecamatan.name')
                    ->get();
            } else if ($typeQuery == "Kecamatan") {
                $wilayah = "Kelurahan";
                $data = Kelurahan::select(
                    'kelurahan.id',
                    'kelurahan.name',
                    DB::raw('COALESCE(SUM(jumlah_suara_details.amount), 0) as total')
                )
                    ->leftJoin('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
                    ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
                    ->leftJoin('jumlah_suara_details', function ($join) use ($idCalon) {
                        $join->on('jumlah_suara_details.tps_id', '=', 'tps.id')
                            ->where('jumlah_suara_details.calon_id', '=', $idCalon);
                    })
                    ->where('kelurahan.kecamatan_id', $codeQuery)
                    ->groupBy('kelurahan.id', 'kelurahan.name')
                    ->get();
            } else if ($typeQuery == "Kelurahan") {
                $wilayah = "TPS";
                $data = Tps::select(
                    'tps.id',
                    DB::raw("CONCAT(tps.name, ' ', kelurahan.name) as name"),
                    DB::raw('COALESCE(SUM(jumlah_suara_details.amount), 0) as total')
                )
                    ->leftJoin('kelurahan', 'kelurahan.id', '=', 'tps.kelurahan_id')
                    ->leftJoin('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
                    ->leftJoin('jumlah_suara_details', function ($join) use ($idCalon) {
                        $join->on('jumlah_suara_details.tps_id', '=', 'tps.id')
                            ->where('jumlah_suara_details.calon_id', '=', $idCalon);
                    })
                    ->where('tps.kelurahan_id', $codeQuery)
                    ->groupBy('tps.id', 'name')
                    ->get();
            }
            // else if ($typeQuery == "TPS" || $typeQuery == "Tps" || $typeQuery == "tps") {
            //     $data = Tps::select(
            //         'tps.id',
            //         'tps.name',
            //         DB::raw('COALESCE(SUM(jumlah_suara_details.amount), 0) as total')
            //     )
            //         ->leftJoin('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
            //         ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
            //         ->leftJoin('jumlah_suara_details', 'jumlah_suara_details.tps_id', '=', 'tps.id')
            //         ->where('kecamatan.kabkota_id', $codeQuery)
            //         ->where('jumlah_suara_details.calon_id', $idCalon)
            //         ->groupBy('tps.id', 'tps.name')
            //         ->get();
            // }

            // dd($data);

            return view($view, [
                "data" => $data,
                "wilayah" => $wilayah,
                "calon" => $calon,
                "code" => $codeQuery,
                "isProvinsi" => $isProvinsi,
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
