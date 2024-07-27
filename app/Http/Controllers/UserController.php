<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Helpers\RegexValidation;
use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\User;
use Dotenv\Util\Regex;
use Exception;
use Illuminate\Database\QueryException;
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
    public function store(Request $request) // everything's work here
    {
        try {
            $message = null;
            $responseCode = 200;
            $validator = Validator::make($request->all(), [
                "username" => "required|string",
                "password" => "string|nullable",
                "code" => "required|integer",

            ]);
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                $responseCode = 500;
            }
            if (preg_match('/^[a-zA-Z0-9]+$/', $request->username)) {
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
                        $user->code = $request->code;
                        $user->save();
                        $message = "User diperbarui";
                    }
                } else {
                    User::create([
                        "name" => $request->name,
                        "username" => $request->username,
                        "password" => $request->password,
                        "code" => $request->code,
                    ]);
                    $message = "User baru dibuat";
                }
            } else {
                $message = "nama pengguna yang dibuat tidak diperbolehkan";
                $responseCode = 400;
            }
            return response()->json([
                "message" => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            $message = match($e->errorInfo[1]){
                1062 => "Duplikasi Data",
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
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
