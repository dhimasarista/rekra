<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\Calon;
use App\Models\KabKota;
use App\Models\Provinsi;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $calon = Calon::all();
    //     $provinsi = Provinsi::all();
    //     $kabkota = KabKota::all();
    //     return view("calon.index", [
    //         "calon" => $calon,
    //         "provinsi" => $provinsi,
    //         "kabkota" => $kabkota,
    //     ]);
    // }
    public function index()
    {
        return view("calon.index2", []);
    }
    public function all(Request $request) {
        try {
            // Ambil parameter dari request
            $limit = $request->input('length', 10); // default 10
            $start = $request->input('start', 0); // default 0
            $search = $request->input('search.value', '');
    
            // Query untuk mengambil data dengan pagination dan pencarian
            $query = Calon::query()
                ->whereNull('calon.deleted_at')
                ->join('kabkota', 'calon.code', '=', 'kabkota.id')
                ->select('calon.*', 'kabkota.name as kabkota_name'); // Ambil semua kolom dari calon dan nama kabkota
    
            // Filter berdasarkan pencarian
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('calon.calon_name', 'LIKE', "%$search%")
                      ->orWhere('calon.wakil_name', 'LIKE', "%$search%")
                      ->orWhere('kabkota.name', 'LIKE', "%$search%"); // Pencarian untuk nama kabkota
                });
            }
    
            // Hitung total data
            $totalData = $query->count();
    
            // Ambil data dengan limit dan offset
            $data = $query->limit($limit)->offset($start)->get();
    
            return response()->json([
                "draw" => intval($request->input('draw')), // Pastikan draw diubah menjadi integer
                "recordsTotal" => $totalData,
                "recordsFiltered" => $totalData,
                "data" => $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "code" => 500,
                "title" => "Error",
                "message" => $e->getMessage(),
            ], 500);
        }
    }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function form(Request $request)
    {
        $calon = null;
        $idQuery = $request->query("Id");
        if ($idQuery)
            $calon = Calon::find($idQuery);
        return view("calon.form", [
            "calon" => $calon,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "code" => "required",
                "calon_name" => "required|string",
                "wakil_name" => "required|string",
                "level" => "required|string"
            ]);
            if ($validator->fails()) {
                return response()->json(["message" => $message = $validator->errors()->all()], 500);
            }
            $idQuery = $request->query("Id");
            $message = "";

            if ($idQuery) {
                $calon = Calon::find($idQuery);
                if ($calon) {
                    $calon->update($request->all());
                    $message = "Data diperbarui";
                } else {
                    return response()->json(["message" => "Not Found"], 404);
                }

            } else {
                Calon::create($request->all());
                $message = "Data baru dibuat";
            }
            return response()->json(["message" => $message], 200);
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                1062 => "Duplikasi Data",
                1366 => "Periksa Kembali Data",
                1452 => "Data Referensi Tidak Ditemukan", // Example of another error code
                2002 => "Koneksi Database Gagal",
                default => $e->getMessage()
            };
            return response()->json(["message" => $message], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $calon = Calon::find($id);
        if (!$calon)
            return response()->json(['message' => "not found"], 404);
        return response()->json(["data" => $calon], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $calon = Calon::find($id);
            if (!$calon)
                return response()->json(['message' => "not found"], 404);
            $calon->delete();
            return response()->json(["message" => "berhasil dihapus"], 200);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception], 500);
        }
    }
}
