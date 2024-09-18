<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Models\LoginHistory;
use App\Services\UserServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userService = $userServiceInterface;
    }
    public function index()
    {
        if (Auth::check()) {
            return redirect('/rekapitulasi');
        }
        // Jika tidak, tampilkan halaman login
        return view("login");
    }
    public function post(Request $request)
    {
        // $emotes = ["😁", "😊", "😇", "🫡", "😻"];
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
                if ($this->userService->login($credentials)) {
                    $user = $this->userService->findUseAuth();
                    if ($user->deleted_at != null) {
                        $message = "Akun anda tidak ditemukan";
                        $responseCode = 400;
                    } else {
                        if (!$user->is_active) {
                            $message = "Akun anda tidak aktif";
                            $responseCode = 400;
                        } else {
                            // $request->session()->put('avatar', $emotes[array_rand($emotes)]);
                            $request->session()->put('username', $user->username);
                            $request->session()->put('user_id', $user->id);
                            $request->session()->put('name', Formatting::capitalize($user->name));
                            $request->session()->put('level', $user->level);
                            $request->session()->put('code', $user->code);
                            $request->session()->put("is_admin", $user->is_admin);
                            $message = "Autentikasi Berhasil";

                            LoginHistory::create([
                                "user_id" => $user->id,
                                "username" => $user->username,
                                "login_at" => now(),
                                "ip_address" => $request->server->get('HTTP_X_FORWARDED_FOR') ?? $request->server->get('HTTP_X_REAL_IP') ?? $request->server->get('REMOTE_ADDR'),
                            ]);
                        }
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
            $message = match ($e->errorInfo[1]) {
                1062 => "Duplikasi Data",
                default => $e->getMessage(),
            };
            return response()->json(['message' => $message], 500);
        }
    }

    public function destroy()
    {
        $this->userService->logout();
        return redirect('/login');
    }
}
