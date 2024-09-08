<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DataRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // todo: middleware mencegah user mengakses data yang tidak diizinkan
        $username = $request->session()->get('username');
        $user = User::where("username", $username)->first();
        return $next($request);
    }
}
