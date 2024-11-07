<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\DataPemilih;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataPemilihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view("data_pemilih.index");
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }

    public function all(Request $request){
        try {
            // Ambil parameter dari request
            $limit = $request->input('length', 10); // default 10
            $start = $request->input('start', 0); // default 0
            $search = $request->input('search.value', '');

            // Query untuk mengambil data dengan pagination dan pencarian
            $query = DataPemilih::query()
                ->whereNull('deleted_at');

            // Filter berdasarkan pencarian
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%")
                      ->orWhere('nik', 'LIKE', "%$search%")
                      ->orWhere('phone', 'LIKE', "%$search%")
                      ->orWhere('address', 'LIKE', "%$search%");
                });
            }

            // Hitung total data
            $totalData = $query->count();

            // Jika length adalah -1, ambil semua data
            if ($limit == -1) {
                $data = $query->get();
            } else {
                // Ambil data dengan limit dan offset
                $data = $query->limit($limit)->offset($start)->get();
            }

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
    public function create(Request $request)
    {
        $responseCode = 200;
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                "nik" => "required|string|size:16",
                "name" => "required|string",
                "address" => "required|string",
                "phone" => "required|string",
            ]);
            if ($validator->fails()) {
                $responseCode = 500;
                throw new Exception($validator->errors()->first(), 1);
            } else {
                $data = DataPemilih::where("nik", $request->nik)->first();
                if ($data) {
                    $responseCode = 400;
                    throw new Exception("NIK Sudah Dipakai",1);
                } else {
                    DataPemilih::create([
                        "nik" => $request->nik,
                        "phone" => $request->phone,
                        "name" => $request->name,
                        "address" => $request->address
                    ]);
                    $message = "Berhasil Menambahkan Data";
                }
            }
            DB::commit();
            return response()->json([
                "message" => $message,
                "data" => $request->all(),
            ], $responseCode);
        } catch (QueryException $e) {
            DB::rollBack();
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json([
                "message" => $message,
                "data" => $request->all(),
            ], $responseCode);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => $e->getMessage(),
                "data" => $request->all(),
            ], $responseCode);
        }
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
