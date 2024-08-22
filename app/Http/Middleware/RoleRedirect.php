<?php

namespace App\Http\Middleware;

use App\Models\KabKota;
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
        $username = $request->session()->get('username');
        $user = User::where("username", $username)->first();
        $userLevel = $user->level == "provinsi" || $user->level == "kabkota";

        $queryType = $request->query("Type");
        if ($userLevel && $queryType == "Provinsi") {
            $kabkota = KabKota::find($user->code);
            return redirect()->route("rekap.list", [
                "Type" => "Provinsi",
                "Id" => $kabkota->provinsi_id,
            ]);
        } else if ($userLevel && $queryType == "Kabkota") {
            return redirect()->route("rekap.list", [
                "Type" => "Kabkota",
                "Id" => $user->code,
            ]);
        }
        return $next($request);
    }
}
