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
        $user = session()->get('level');
        $queryParams = $request->query();
        // $user = User::where("username", $user)->first();
        if ($user == "kabkota" && $queryParams["Type"] == "Provinsi") {
            $queryParams["Type"] = "Kabkota";
            $newUrl = $request->url()."?".http_build_query($queryParams);
            return redirect($newUrl);
        }
        return $next($request);
    }
}
