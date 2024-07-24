<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $provinsi = Provinsi::all();
        $kabkota = KabKota::all();
        return view("user.index", [
            "users" => $users,
            "provinsi" => $provinsi,
            "kabkota" => $kabkota,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $user = User::find($request->query("Id"));
            $kabkota = KabKota::all();
            return view("user.form", [
                "user" => $user,
                "kabkota" => $kabkota,
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = null;
        $responseCode = 200;
        $validator = Validator::make($request->all(), [
            "username" => "required|string",
            "password" => "string|null",
            "code" => "required|integer",
            "is_admin" => "required|boolean",
            "is_active" => "required|boolean",
            "level" => "required|string"

        ]);
        if ($validator->fails()) {
            $message = $validator->errors();
            $responseCode = 500;
        }
        $idQuery = $request->query("Id");
        if ($idQuery) {
            $user = User::find($idQuery);
            if ($user) {
                $userPassword = $request->password;
                if (!$userPassword) {
                    $userPassword = $user->password;
                }
                $user->username = $request->username;
                $user->password = $userPassword;
                $user->is_admin = $request->is_admin;
                $user->is_active = $request->is_active;
                $user->code = $request->code;
                $user->level = $request->level;
                $user->save();
                $message = "User diperbarui";
            } else {
                $user->create($request->all());
                $message = "User baru dibuat";
            }
        }

        return response()->json([
            "message" => $message,
        ], $responseCode);
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
