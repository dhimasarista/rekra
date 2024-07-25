<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\KabKota;
use App\Models\Provinsi;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Throw_;

class CalonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calon = Calon::all();
        $provinsi = Provinsi::all();
        $kabkota = KabKota::all();
        return view("calon.index", [
            "calon" => $calon,
            "provinsi" => $provinsi,
            "kabkota" => $kabkota,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $calon = null;
        $idQuery = $request->query("Id");
        // dd($idQuery);
        if ($idQuery) {
            $calon = Calon::find($idQuery);
        }
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
                return response()->json(["message" => $$message = $validator->errors()->all()], 500);
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
            $message = null;
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $message = "Duplikasi Data";
            }
            return response()->json(["message" => $message], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $calon = Calon::find($id);
        if (!$calon) {
            return response()->json(['message' => "not found"], 404);
        }
        return response()->json(["data" => $calon], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $calon = Calon::find($id);
            if (!$calon) {
                return response()->json(['message' => "not found"], 404);
            }
            $calon->delete();
            return response()->json(["message" => "berhasil dihapus"], 200);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception], 500);
        }
    }
}
