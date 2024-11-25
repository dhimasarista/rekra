<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\JumlahSuara;
use App\Models\JumlahSuaraDetail;
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
            ];
            return view("hitung_suara.form", [
                "data" => $data,
                "jumlahSuara" => $jumlahSuara,
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
