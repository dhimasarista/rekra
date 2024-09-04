<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\Provinsi;
use App\Models\Tps;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

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
            $idQuery = $request->query('Id');
            $typeQuery = strtolower($request->query('Type'));

            // Ambil data TPS berdasarkan kelurahan_id
            $tpsData = $this->tps->tpsWithDetail()
                ->where('kelurahan_id', $idQuery)
                ->get();

            if ($tpsData->isEmpty()) {
                return view('hitung_cepat.table', [
                    'table' => 'Kosong',
                    'data' => [],
                    'calon' => [],
                ]);
            }

            // Ambil data Calon berdasarkan typeQuery
            $calonCode = match ($typeQuery) {
                'provinsi' => $tpsData->first()->provinsi_id,
                'kabkota' => $tpsData->first()->kabkota_id,
                default => null,
            };

            $calon = $calonCode ? Calon::where('code', $calonCode)->get() : collect();

            // Ambil data hitung suara cepat admin detail
            $hscadData = DB::table('hitung_suara_cepat_admin_detail as hscad')
                ->select('tps.name as tps_name', 'calon.calon_name as calon_name', 'hscad.amount', 'hsca.note')
                ->join('tps', 'hscad.tps_id', '=', 'tps.id')
                ->join('calon', 'hscad.calon_id', '=', 'calon.id')
                ->leftJoin('hitung_suara_cepat_admin as hsca', 'hscad.hs_cepat_admin_id', '=', 'hsca.id')
                ->whereIn('tps.id', $tpsData->pluck('id'))
                ->get();

            // Buat data final untuk ditampilkan
            $results = $tpsData->map(function ($tps) use ($hscadData, $calon) {
                $calonData = $calon->map(function ($c) use ($hscadData, $tps) {
                    $hscadEntry = $hscadData->firstWhere('calon_name', $c->name);
                    return [
                        'calon_name' => $c->calon_name,
                        'amount' => $hscadEntry ? $hscadEntry->amount : 0,
                    ];
                });

                $updatedBy = $hscadData->where('tps_name', $tps->name)->first()->note ?? 'Belum ada';

                return [
                    'tps_name' => $tps->name,
                    'calon_data' => $calonData,
                    'updated_by' => $updatedBy,
                ];
            });

            return view('hitung_cepat.table', [
                'table' => $tpsData->first()->kelurahan->name,
                'data' => $results,
                'calon' => $calon,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function storeByAdmin(Request $request){
        DB::beginTransaction(); // Memulai transaksi
        try {
            $message = "Data Berhasil Disimpan";
            $responseCode = 200;
            $body = $request->all();
            $hitungCepatId = Uuid::uuid7();
            $dataHSCD = []; // HSCD: hitung_suara_cepat_details
            $dataHSC = [
                "id" => $hitungCepatId,
                ""
            ];
            DB::commit(); // Menyimpan perubahan jika tidak ada error
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
                1062 => "Data sudah ada",
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }
}
