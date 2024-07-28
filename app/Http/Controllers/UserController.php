<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot("level", "master")->get();
        $provinsi = Provinsi::all();
        $kabkota = KabKota::all();
        return view("user.index", [
            "users" => $users,
            "provinsi" => $provinsi,
            "kabkota" => $kabkota,
        ]);
    }
    public function form(Request $request)
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
    public function store(Request $request) // everything's work here
    {
        try {
            // default message & response code
            $message = null;
            $responseCode = 200;
            // make the validation
            $validator = Validator::make($request->all(), [
                "username" => "required|string",
                "password" => "string|nullable|min:6",
                "code" => "required|integer",

            ]);
            // input user validation
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                $responseCode = 500;
            } else {
                // regex: checking username pattern from user input
                if (preg_match('/^[a-zA-Z0-9]+$/', $request->username)) {
                    $user = User::find($request->query("Id"));
                    if ($user) { // if user finded, update user data
                        $userPassword = $request->password;
                        // password not updating, if password from body response null
                        if (!$userPassword)
                            $userPassword = $user->password;
                        $user->username = $request->username;
                        $user->password = $userPassword;
                        $user->code = $request->code;
                        $user->save(); // save user
                        // set new message and response code
                        $message = "User diperbarui";
                    } else {
                        // creating new user
                        User::create([
                            "name" => $request->name,
                            "username" => $request->username,
                            "password" => $request->password,
                            "code" => $request->code,
                        ]);
                        $message = "😊User baru dibuat";
                    }
                } else { // else of regexp of username
                    $message = "username yang dibuat tidak diperbolehkan";
                    $responseCode = 400;
                }
            }
            return response()->json([
                "message" => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                1062 => "Duplikasi Data",
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $message = null;
            $responseCode = 200;
            $user = User::find($id);
            if ($user) {
                $user->delete();
                $message = "User berhasil dihapus";
            }
            return response()->json([
                "message" => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }
    public function activeDeactive(Request $request)
    {
        try {
            $user = User::find($request->query("Id"));
            if ($user) {
                $user->is_active = !$user->is_active;
                $user->save();
                return response()->json(["message" => "status user diperbarui"], 200);
            } else {
                return response()->json(["message" => "user tidak ditemukan"], 404);
            }
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }
}
