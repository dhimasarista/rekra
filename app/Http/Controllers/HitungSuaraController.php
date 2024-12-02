<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\JumlahSuara;
use App\Models\JumlahSuaraDetail;
use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

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
            $calon = null;
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
            foreach ($jumlahSuaraDetail as $value) {
                if ($value->calon_id == $calon[0]->id) {
                    $jumlahSuaraId = $value->jumlah_suara_id;
                }
            }
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
                "type" => $typeQuery,
            ];
            return view("hitung_suara.form", [
                "data" => $data,
                "jumlahSuara" => $jumlahSuara,
            ]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction(); // Memulai transaksi
            $message = null;

            $tpsQuery = $request->query("Tps");
            $jumlahSuaraId = Uuid::uuid7();
            $dataJumlahSuaraDetail = [];
            $dataJumlahSuara = [
                "id" => $jumlahSuaraId,
                "note" => $request->note,
                "dpt" => $request->dpt,
                "dptb" => $request->dptb,
                "dptk" => $request->dptk,
                "surat_suara_diterima" => $request->surat_suara_diterima,
                "surat_suara_digunakan" => $request->surat_suara_digunakan,
                "surat_suara_tidak_digunakan" => $request->surat_suara_tidak_digunakan,
                "surat_suara_rusak" => $request->surat_suara_rusak,
                "total_suara_sah" => $request->total_suara_sah,
                "total_suara_tidak_sah" => $request->total_suara_tidak_sah,
                "total_sah_tidak_sah" => $request->total_sah_tidak_sah,
                "c_hasil" => $request->c_hasil,
            ];

            foreach ($request->calon as $calon) {
                $jumlahSuaraDetail = $this->jumlahSuaraDetail
                    ->where("tps_id", $tpsQuery)
                    ->where("calon_id", $calon["id"])
                    ->first();
                if ($jumlahSuaraDetail) {
                    $jumlahSuaraId = $jumlahSuaraDetail->jumlah_suara_id;
                    $jumlahSuaraDetail->amount = $calon["value"];
                    $jumlahSuaraDetail->save();
                } else {
                    $dataJumlahSuaraDetail[] = [
                        "id" => Uuid::uuid7(),
                        "jumlah_suara_id" => $jumlahSuaraId,
                        "calon_id" => $calon["id"],
                        "amount" => $calon["value"],
                        "tps_id" => $tpsQuery,
                    ];
                }
            }
            // Jika tidak ada data, buat baru di tabel jumlah_suara
            if (empty($dataJumlahSuaraDetail)) {
                $jumlahSuara = $this->jumlahSuara->find($jumlahSuaraId);
                if ($jumlahSuara) {
                    $jumlahSuara->dpt = $dataJumlahSuara["dpt"];
                    $jumlahSuara->dptb = $dataJumlahSuara["dptb"];
                    $jumlahSuara->dptk = $dataJumlahSuara["dptk"];
                    $jumlahSuara->surat_suara_diterima = $dataJumlahSuara["surat_suara_diterima"];
                    $jumlahSuara->surat_suara_digunakan = $dataJumlahSuara["surat_suara_digunakan"];
                    $jumlahSuara->surat_suara_tidak_digunakan = $dataJumlahSuara["surat_suara_tidak_digunakan"];
                    $jumlahSuara->surat_suara_rusak = $dataJumlahSuara["surat_suara_rusak"];
                    $jumlahSuara->total_suara_sah = $dataJumlahSuara["total_suara_sah"];
                    $jumlahSuara->total_suara_tidak_sah = $dataJumlahSuara["total_suara_tidak_sah"];
                    $jumlahSuara->total_sah_tidak_sah = $dataJumlahSuara["total_sah_tidak_sah"];
                    $jumlahSuara->note = $dataJumlahSuara["note"];
                    if ($dataJumlahSuara["c_hasil"]) {
                        $jumlahSuara->c_hasil = $dataJumlahSuara["c_hasil"];
                    }
                    $jumlahSuara->save();
                } else {
                    return abort(500, "Data Tidak Ditemukan. (Internal Server Error)");
                }
            } else {
                $this->jumlahSuara->insert($dataJumlahSuara);
                $this->jumlahSuaraDetail->insert($dataJumlahSuaraDetail);
            }

            DB::commit();
            return response()->json([
                "message" => "Berhasil Menambahkan Data",
            ], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
                1062 => "Data sudah ada",
                1264 => "Jumlah Melebih Batas",
                1048 => "Data tidak boleh kosong, isi 0 jika kosong.",
                default => $e->getMessage(),
            };

            return response()->json(["message" => $message], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function indexRekap(Request $request)
    {
        try {
            return view("hitung_suara.rekap", [
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

    public function selectTingkat(Request $request)
    {
        $provinsi = Provinsi::all();
        return view("hitung_suara.select_tingkat", [
            "data" => $provinsi,
            "jenisWilayah" => $request->query("Select")
        ]);
    }

    public function uploadChasil(Request $request)
    {
        try {
            $tps = Tps::find($request->query("Tps"));
            $kelurahan = Kelurahan::find($tps->kelurahan_id);
            $kecamatan = Kecamatan::find($kelurahan->kecamatan_id);
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:2048', // hanya image dan pdf dengan ukuran maksimal 2MB
            ]);
            // Ambil file dari request
            $file = $request->file('file');
            // Nama Baru
            $filename = $tps->name.".".$file->getClientOriginalExtension();
            $filePath = $file->storeAs("public/chasil/$kecamatan->name/$kelurahan->name/".$request->query("Type")."/", $filename);
            $publicPath = str_replace("public/", "storage/", $filePath);

            return response()->json([
                // 'file_name' => $filename
                'file_url' => $publicPath,
                // "file_path" => $filePath,
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function listRekap(Request $request)
    {
        try {
            $typeQuery = $request->query("Type");
            $tingkatQuery = $request->query("Tingkat");
            $idQuery = $request->query("Id");
            $wilayah = null;
            $data = null;

            if ($tingkatQuery == $idQuery) {
                $wilayah = Kabkota::where("provinsi_id", $idQuery)->get();
                $data = Calon::select(
                    "calon.id",
                    "calon.calon_name",
                    "calon.wakil_name",
                    DB::raw("COALESCE(SUM(jumlah_suara_details.amount), 0) as total"),
                    DB::raw('SUM(jumlah_suara.dpt) as total_dpt'),
                    DB::raw('SUM(jumlah_suara.dptb) as total_dptb'),
                    DB::raw('SUM(jumlah_suara.dptk) as total_dptk'),
                    DB::raw('SUM(jumlah_suara.surat_suara_diterima) as total_surat_suara_diterima'),
                    DB::raw('SUM(jumlah_suara.surat_suara_digunakan) as total_surat_suara_digunakan'),
                    DB::raw('SUM(jumlah_suara.surat_suara_tidak_digunakan) as total_surat_suara_tidak_digunakan'),
                    DB::raw('SUM(jumlah_suara.surat_suara_rusak) as total_surat_suara_rusak'),
                    DB::raw('SUM(jumlah_suara.total_suara_sah) as total_total_suara_sah'),
                    DB::raw('SUM(jumlah_suara.total_suara_tidak_sah) as total_total_suara_tidak_sah'),
                    DB::raw('SUM(jumlah_suara.total_sah_tidak_sah) as total_sah_tidak_sah')
                )
                ->leftJoin("jumlah_suara_details", "calon.id", "=", "jumlah_suara_details.calon_id")
                ->leftJoin("jumlah_suara", "jumlah_suara_details.jumlah_suara_id", "=", "jumlah_suara.id")
                    ->leftJoin("tps", "jumlah_suara_details.tps_id", "=", "tps.id")
                    ->leftJoin("kelurahan", "tps.kelurahan_id", "=", "kelurahan.id")
                    ->leftJoin("kecamatan", "kelurahan.kecamatan_id", "=", "kecamatan.id")
                    ->leftJoin("kabkota", "kecamatan.kabkota_id", "=", "kabkota.id")
                    ->leftJoin("provinsi", "kabkota.provinsi_id", "=", "provinsi.id")
                    ->where("provinsi.id", $idQuery)
                    ->groupBy("calon.id", "calon.calon_name", "calon.wakil_name")
                    ->get();
            } else {
                if ($tingkatQuery == "Provinsi") {
                    if ($typeQuery == "") {
                        # code...
                    }

                } else if ($tingkatQuery == "Kabkota") {

                }
            }
            return view("hitung_suara.rekap_table", [
                "data" => $data,
                "wilayah" => $wilayah
            ]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
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

}
