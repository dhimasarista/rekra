<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->session()->get('username');
        $user = User::where("username", $username)->first();
        if ($user->level != "master") {
            return redirect("/404");
        }
        // $username = session('username'); // atau Session::get('username');
        // $userRole = session('userRole'); // atau Session::get('userRole');
        return $next($request);
    }
}
