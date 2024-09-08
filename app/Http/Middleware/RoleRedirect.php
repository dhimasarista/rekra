<?php

namespace App\Http\Middleware;

use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userSession = $request->session()->get('username');
        // $user = User::where("username", $userSession)->first();
        // Query Parameters
        $typeQuery = $request->query("Type");
        $idQuery = $request->query("Id");
        $queryParams = $request->query();

        // user role
        $userRole = $request->session()->get("level") == "kabkota" || $request->session()->get("level") == "provinsi";
        // mencegah user mengakses id lain jika bukan ranahnya
        if ($userRole && $typeQuery == "Kabkota") {
            if ($request->session()->get("code") != $idQuery) {
                $queryParams["Id"] = $request->session()->get("code");
                $newUrl = $request->url()."?".http_build_query($queryParams);
                return redirect($newUrl);
            }
        } else if ($userRole && $typeQuery == "Provinsi") {
            $kabkota = Kabkota::where("id", $request->session()->get("code"))->first();
            if ($kabkota->provinsi_id != $idQuery) {
                $queryParams["Id"] = $kabkota->provinsi_id;
                $newUrl = $request->url()."?".http_build_query($queryParams);
                return redirect($newUrl);
            }
        }
        return $next($request);
    }
}
