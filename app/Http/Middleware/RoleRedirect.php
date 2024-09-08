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
        $userRole = $userSession->level == "kabkota" || $userSession->level == "provinsi";
        // mencegah user mengakses id lain jika bukan ranahnya
        if ($userRole && $typeQuery == "Kabkota") {
            if ($userSession->code != $idQuery) {
                $queryParams["Id"] = $userSession->code;
                $newUrl = $request->url()."?".http_build_query($queryParams);
                return redirect($newUrl);
            }
        } else if ($userRole && $typeQuery == "Provinsi") {
            $kabkota = Kabkota::where("id", $userSession->code)->first();
            if ($kabkota->provinsi_id != $idQuery) {
                $queryParams["Id"] = $kabkota->provinsi_id;
                $newUrl = $request->url()."?".http_build_query($queryParams);
                return redirect($newUrl);
            }
        }
        return $next($request);
    }
}
