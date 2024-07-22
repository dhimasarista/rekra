<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calon = Calon::all();
        return view("calon.index", [
            "calon" => $calon,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $calon = null;
        $idQuery = $request->query("Id");
        if ($idQuery) {
            $calon = Calon::find($idQuery);
        }
        return view("calon.form", [
            "calon" => $calon,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "code" => "required",
            "calon_name" => "required|string",
            "wakil_name" => "required|string",
            "level" => "required|string"
        ]);
        if($validator->fails()){
            return response()->json(["message" => $validator->errors()],500);
        }
        $idQuery = $request->query("Id");
        $calon = Calon::find($idQuery);
        if ($calon) {
            $calon = $calon->update($request->all());
        } else {
            $calon = Calon::create($request->all());
        }
        return response()->json(["message" => $calon], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
