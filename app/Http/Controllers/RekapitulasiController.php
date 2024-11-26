<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\JumlahSuaraDetail;
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
                    $formId1 = "X" . bin2hex(random_bytes(8));
                    $formId2 = "X" . bin2hex(random_bytes(8));
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
                            "id" => "X" . bin2hex(random_bytes(8)),
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
                    $formId1 = "X" . bin2hex(random_bytes(8));
                    $formId2 = "X" . bin2hex(random_bytes(8));
                    $config = [
                        "name" => "Pilih Kabupaten/Kota",
                        "submit" => [
                            "type" => "redirect", // or "input"
                            "id" => "X" . bin2hex(random_bytes(8)),
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
            DB::raw("COALESCE(SUM(jumlah_suara_details.amount), 0) as total"),
            DB::raw("COALESCE(SUM(jumlah_suara.dpt), 0) as total_dpt"),
            DB::raw("COALESCE(SUM(jumlah_suara.dptb), 0) as total_dptb"),
            DB::raw("COALESCE(SUM(jumlah_suara.dptk), 0) as total_dptk"),
            DB::raw("COALESCE(SUM(jumlah_suara.surat_suara_diterima), 0) as surat_suara_diterima"),
            DB::raw("COALESCE(SUM(jumlah_suara.surat_suara_digunakan), 0) as surat_suara_digunakan"),
            DB::raw("COALESCE(SUM(jumlah_suara.surat_suara_tidak_digunakan), 0) as surat_suara_tidak_digunakan"),
            DB::raw("COALESCE(SUM(jumlah_suara.surat_suara_rusak), 0) as surat_suara_rusak"),
            DB::raw("COALESCE(SUM(jumlah_suara.total_suara_sah), 0) as total_suara_sah"),
            DB::raw("COALESCE(SUM(jumlah_suara.total_suara_tidak_sah), 0) as total_suara_tidak_sah"),
            DB::raw("COALESCE(SUM(jumlah_suara.total_sah_tidak_sah), 0) as total_sah_tidak_sah")
        )
            ->leftJoin("jumlah_suara_details", "calon.id", "=", "jumlah_suara_details.calon_id")
            ->leftJoin("jumlah_suara", "jumlah_suara.id", "=", "jumlah_suara_details.jumlah_suara_id")
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
            $levelQuery = $request->query("Level");
            $idCalon = $request->query("Id");
            $calon = Calon::find($idCalon);

            if ($typeQuery == "Provinsi") {
                return redirect(route("index"));
                // $wilayah = "Kabkota";

                // // Ambil semua calon dari tabel Calon
                // $allCalon = Calon::select('id', 'code', 'calon_name')->where("code")->get();

                // // Ambil data calon dengan total suara
                // $calonData = Calon::select(
                //     'calon.id as calon_id',
                //     'calon.code',
                //     'calon.calon_name',
                //     DB::raw('SUM(jumlah_suara_details.amount) as total_suara')
                // )
                //     ->leftJoin('jumlah_suara_details', 'jumlah_suara_details.calon_id', '=', 'calon.id')
                //     ->leftJoin('tps', 'tps.id', '=', 'jumlah_suara_details.tps_id')
                //     ->leftJoin('kelurahan', 'kelurahan.id', '=', 'tps.kelurahan_id')
                //     ->leftJoin('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
                //     ->leftJoin('kabkota', 'kabkota.id', '=', 'kecamatan.kabkota_id')
                //     ->where('kabkota.provinsi_id', $codeQuery) // Sesuaikan dengan provinsi_id
                //     ->groupBy('calon.id', 'calon.calon_name', 'calon.code')
                //     ->get();

                // // Ambil data kabkota dengan agregasi suara
                // $kabkotaData = Kabkota::select(
                //     'kabkota.id',
                //     'kabkota.name',
                //     DB::raw('SUM(jumlah_suara.dpt) as total_dpt'),
                //     DB::raw('SUM(jumlah_suara.dptb) as total_dptb'),
                //     DB::raw('SUM(jumlah_suara.dptk) as total_dptk'),
                //     DB::raw('SUM(jumlah_suara.surat_suara_diterima) as total_surat_suara_diterima'),
                //     DB::raw('SUM(jumlah_suara.surat_suara_digunakan) as total_surat_suara_digunakan'),
                //     DB::raw('SUM(jumlah_suara.surat_suara_tidak_digunakan) as total_surat_suara_tidak_digunakan'),
                //     DB::raw('SUM(jumlah_suara.surat_suara_rusak) as total_surat_suara_rusak'),
                //     DB::raw('SUM(jumlah_suara.total_suara_sah) as total_suara_sah'),
                //     DB::raw('SUM(jumlah_suara.total_suara_tidak_sah) as total_suara_tidak_sah'),
                //     DB::raw('SUM(jumlah_suara.total_sah_tidak_sah) as total_sah_tidak_sah')
                // )
                //     ->leftJoin('kecamatan', 'kecamatan.kabkota_id', '=', 'kabkota.id')
                //     ->leftJoin('kelurahan', 'kelurahan.kecamatan_id', '=', 'kecamatan.id')
                //     ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
                //     ->leftJoin('jumlah_suara_details', 'jumlah_suara_details.tps_id', '=', 'tps.id')
                //     ->leftJoin('jumlah_suara', 'jumlah_suara.id', '=', 'jumlah_suara_details.jumlah_suara_id')
                //     ->where('kabkota.provinsi_id', $codeQuery)
                //     ->groupBy('kabkota.id', 'kabkota.name')
                //     ->get();

                // // Proses data kabkota dan calon untuk mendapatkan hasil akhir
                // $data = $kabkotaData->map(function ($kabkota) use ($calonData, $allCalon) {
                //     // Ambil data calon yang berhubungan dengan kabkota
                //     $calonList = $allCalon->map(function ($calon) use ($calonData, $kabkota) {
                //         $calonDetail = $calonData->firstWhere('calon_id', $calon->id);

                //         return [
                //             'id' => $calon->id,
                //             'calon_name' => $calon->calon_name,
                //             'code' => $calon->code,
                //             'total_suara' => $calonDetail ? $calonDetail->total_suara : 0,
                //         ];
                //     });

                //     return [
                //         'id' => $kabkota->id,
                //         'name' => $kabkota->name,
                //         'calon' => $calonList,
                //         'jumlah_suara' => [
                //             'dpt' => $kabkota->total_dpt / 2,
                //             'dptb' => $kabkota->total_dptb / 2,
                //             'dptk' => $kabkota->total_dptk / 2,
                //             'surat_suara_diterima' => $kabkota->total_surat_suara_diterima / 2,
                //             'surat_suara_digunakan' => $kabkota->total_surat_suara_digunakan / 2,
                //             'surat_suara_tidak_digunakan' => $kabkota->total_surat_suara_tidak_digunakan / 2,
                //             'surat_suara_rusak' => $kabkota->total_surat_suara_rusak / 2,
                //             'total_suara_sah' => $kabkota->total_suara_sah / 2,
                //             'total_suara_tidak_sah' => $kabkota->total_suara_tidak_sah / 2,
                //             'total_sah_tidak_sah' => $kabkota->total_sah_tidak_sah / 2,
                //         ],
                //     ];
                // });
            }
             else {
                if ($typeQuery == "Kabkota") {
                    $wilayah = "Kecamatan";

                    $kecamatan = Kecamatan::select(
                        'kecamatan.id as kecamatan_id',
                        'kecamatan.name as kecamatan_name',
                        DB::raw('SUM(jumlah_suara.dpt) as total_dpt'),
                        DB::raw('SUM(jumlah_suara.dptb) as total_dptb'),
                        DB::raw('SUM(jumlah_suara.dptk) as total_dptk'),
                        DB::raw('SUM(jumlah_suara.surat_suara_diterima) as total_surat_suara_diterima'),
                        DB::raw('SUM(jumlah_suara.surat_suara_digunakan) as total_surat_suara_digunakan'),
                        DB::raw('SUM(jumlah_suara.surat_suara_tidak_digunakan) as total_surat_suara_tidak_digunakan'),
                        DB::raw('SUM(jumlah_suara.surat_suara_rusak) as total_surat_suara_rusak'),
                        DB::raw('SUM(jumlah_suara.total_suara_sah) as total_suara_sah'),
                        DB::raw('SUM(jumlah_suara.total_suara_tidak_sah) as total_suara_tidak_sah'),
                        DB::raw('SUM(jumlah_suara.total_sah_tidak_sah) as total_sah_tidak_sah')
                    )
                        ->leftJoin('kelurahan', 'kelurahan.kecamatan_id', '=', 'kecamatan.id')
                        ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
                        ->leftJoin('jumlah_suara_details', 'jumlah_suara_details.tps_id', '=', 'tps.id')
                        ->leftJoin('jumlah_suara', 'jumlah_suara.id', '=', 'jumlah_suara_details.jumlah_suara_id')
                        ->where('kecamatan.kabkota_id', $codeQuery)
                        ->whereNull('kecamatan.deleted_at')
                        ->groupBy('kecamatan.id', 'kecamatan.name')
                        ->get();

                    // Ambil data calon beserta total suara per kecamatan
                    $calonData = Kecamatan::select(
                        'kecamatan.id as kecamatan_id',
                        'calon.id as calon_id',
                        'calon.calon_name as calon_name',
                        DB::raw('SUM(jumlah_suara_details.amount) as total_suara')
                    )
                        ->leftJoin('kelurahan', 'kelurahan.kecamatan_id', '=', 'kecamatan.id')
                        ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
                        ->join('jumlah_suara_details', 'jumlah_suara_details.tps_id', '=', 'tps.id') // INNER JOIN
                        ->join('calon', function ($join) use ($typeQuery) {
                            $join->on('calon.id', '=', 'jumlah_suara_details.calon_id')
                                ->whereNotNull('calon.id')
                                ->whereNotNull('calon.calon_name')
                                ->where('calon.level', '=', strtolower($typeQuery)); // Filter calon kabkota
                        })
                        ->where('kecamatan.kabkota_id', $codeQuery)
                        ->groupBy('kecamatan.id', 'calon.id', 'calon.calon_name')
                        ->get();
                    // Proses data untuk menghasilkan format yang diminta
                    $data = $kecamatan->map(function ($kecamatan) use ($calonData) {
                        $calonList = $calonData->filter(function ($calon) use ($kecamatan) {
                            return $calon->kecamatan_id === $kecamatan->kecamatan_id;
                        })->map(function ($calon) {
                            return [
                                'id' => $calon->calon_id,
                                'calon_name' => $calon->calon_name,
                                'total_suara' => $calon->total_suara,
                            ];
                        });

                        return [
                            'id' => $kecamatan->kecamatan_id,
                            'name' => $kecamatan->kecamatan_name,
                            'calon' => $calonList->values(),
                            'jumlah_suara' => [
                                'dpt' => $kecamatan->total_dpt / 2,
                                'dptb' => $kecamatan->total_dptb / 2,
                                'dptk' => $kecamatan->total_dptk / 2,
                                'surat_suara_diterima' => $kecamatan->total_surat_suara_diterima / 2,
                                'surat_suara_digunakan' => $kecamatan->total_surat_suara_digunakan / 2,
                                'surat_suara_tidak_digunakan' => $kecamatan->total_surat_suara_tidak_digunakan / 2,
                                'surat_suara_rusak' => $kecamatan->total_surat_suara_rusak / 2,
                                'total_suara_sah' => $kecamatan->total_suara_sah / 2,
                                'total_suara_tidak_sah' => $kecamatan->total_suara_tidak_sah / 2,
                                'total_sah_tidak_sah' => $kecamatan->total_sah_tidak_sah / 2,
                            ],
                        ];
                    });
                }else if ($typeQuery == "Kecamatan") {
                    $wilayah = "Kelurahan";

                    // Ambil data kelurahan beserta total suara
                    $kelurahan = Kelurahan::select(
                        'kelurahan.id as kelurahan_id',
                        'kelurahan.name as kelurahan_name',
                        DB::raw('SUM(jumlah_suara.dpt) as total_dpt'),
                        DB::raw('SUM(jumlah_suara.dptb) as total_dptb'),
                        DB::raw('SUM(jumlah_suara.dptk) as total_dptk'),
                        DB::raw('SUM(jumlah_suara.surat_suara_diterima) as total_surat_suara_diterima'),
                        DB::raw('SUM(jumlah_suara.surat_suara_digunakan) as total_surat_suara_digunakan'),
                        DB::raw('SUM(jumlah_suara.surat_suara_tidak_digunakan) as total_surat_suara_tidak_digunakan'),
                        DB::raw('SUM(jumlah_suara.surat_suara_rusak) as total_surat_suara_rusak'),
                        DB::raw('SUM(jumlah_suara.total_suara_sah) as total_suara_sah'),
                        DB::raw('SUM(jumlah_suara.total_suara_tidak_sah) as total_suara_tidak_sah'),
                        DB::raw('SUM(jumlah_suara.total_sah_tidak_sah) as total_sah_tidak_sah')
                    )
                        ->leftJoin('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
                        ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
                        ->leftJoin('jumlah_suara_details', 'jumlah_suara_details.tps_id', '=', 'tps.id')
                        ->leftJoin('jumlah_suara', 'jumlah_suara.id', '=', 'jumlah_suara_details.jumlah_suara_id')
                        ->where('kelurahan.kecamatan_id', $codeQuery)
                        ->whereNull('kelurahan.deleted_at')
                        ->groupBy('kelurahan.id', 'kelurahan.name')
                        ->get();

                    // Ambil data calon beserta total suara per kelurahan
                    $calonData = Kelurahan::select(
                        'kelurahan.id as kelurahan_id',
                        'calon.id as calon_id',
                        'calon.calon_name as calon_name',
                        DB::raw('SUM(jumlah_suara_details.amount) as total_suara')
                    )
                        ->leftJoin('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
                        ->leftJoin('tps', 'tps.kelurahan_id', '=', 'kelurahan.id')
                        ->join('jumlah_suara_details', 'jumlah_suara_details.tps_id', '=', 'tps.id') // INNER JOIN
                        ->join('calon', function ($join) use ($typeQuery) {
                            $join->on('calon.id', '=', 'jumlah_suara_details.calon_id')
                                ->whereNotNull('calon.id')
                                ->whereNotNull('calon.calon_name')
                                ->where('calon.level', '=', strtolower($typeQuery)); // Filter calon kecamatan
                        })
                        ->where('kelurahan.kecamatan_id', $codeQuery)
                        ->groupBy('kelurahan.id', 'calon.id', 'calon.calon_name')
                        ->get();

                    // Proses data untuk menghasilkan format yang diminta
                    $data = $kelurahan->map(function ($kelurahan) use ($calonData) {
                        $calonList = $calonData->filter(function ($calon) use ($kelurahan) {
                            return $calon->kelurahan_id === $kelurahan->kelurahan_id;
                        })->map(function ($calon) {
                            return [
                                'id' => $calon->calon_id,
                                'calon_name' => $calon->calon_name,
                                'total_suara' => $calon->total_suara,
                            ];
                        });

                        return [
                            'id' => $kelurahan->kelurahan_id,
                            'name' => $kelurahan->kelurahan_name,
                            'calon' => $calonList->values(),
                            'jumlah_suara' => [
                                'dpt' => $kelurahan->total_dpt / 2,
                                'dptb' => $kelurahan->total_dptb / 2,
                                'dptk' => $kelurahan->total_dptk / 2,
                                'surat_suara_diterima' => $kelurahan->total_surat_suara_diterima / 2,
                                'surat_suara_digunakan' => $kelurahan->total_surat_suara_digunakan / 2,
                                'surat_suara_tidak_digunakan' => $kelurahan->total_surat_suara_tidak_digunakan / 2,
                                'surat_suara_rusak' => $kelurahan->total_surat_suara_rusak / 2,
                                'total_suara_sah' => $kelurahan->total_suara_sah / 2,
                                'total_suara_tidak_sah' => $kelurahan->total_suara_tidak_sah / 2,
                                'total_sah_tidak_sah' => $kelurahan->total_sah_tidak_sah / 2,
                            ],
                        ];
                    });
                }
                 else if ($typeQuery == "Kelurahan") {
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
            }

            return view($view, [
                "data" => $data->toArray(),
                "wilayah" => $wilayah,
                "calon" => $calon,
                "code" => $codeQuery,
                "level" => $levelQuery,
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


