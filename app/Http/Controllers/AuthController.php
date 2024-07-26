<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        if (Auth::check()) {
            return redirect('/rekapitulasi');
        }
        // Jika tidak, tampilkan halaman login
        return view("login");
    }
    public function post(Request $request)
    {
        try {
            // Menerima username dan password dari request body
            $credentials = $request->only('username', 'password');
            $validator = Validator::make($request->all(), [
                "username" => "required|string",
                "password" => "required|string",
            ]);
            $message = null;
            $responseCode = 200;
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                $responseCode = 401;
            } else {
                // Mencoba memeriksa kredensial
                if (Auth::attempt($credentials)) {
                    $user = Auth::user();

                    // Memeriksa apakah akun user aktif
                    if ($user->deleted_at != null) {
                        // Jika tidak aktif, response dengan status 400
                        $message = "Akun anda tidak aktif";
                        $responseCode = 400;
                    } else {
                        $request->session()->put('username', $user->username);
                        $request->session()->put('user_id', $user->id);
                        $request->session()->put('name', $user->name);
                        $message = "Autentikasi Berhasil";
                    }
                } else { // Jika tidak cocok
                    $message = "Periksa Kembali Username dan Password";
                    $responseCode = 401;
                }
            }
            return response()->json([
                'message' => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            // Tangani exception jika terjadi
            return response()->json(['message' => $e->errorInfo], 500);
        }
    }

    public function destroy()
    {
        // $request->session()->forget('username');
        Auth::logout(); // Logout user dari Auth
        return redirect('/login');
    }
}
