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
        $queryType = $request->query("Type");

        $queryId = $request->query("Id");
        $queryParams = $request->query();
        // mencegah user mengakses id lain jika bukan ranahnya
        if ($user->level == "kabkota" && $queryType == "Kabkota") {
            if ($user->code != $queryId) {
                $queryParams["Id"] = $user->code;
                $newUrl = $request->url()."?".http_build_query($queryParams);
                return redirect($newUrl);
            }
        }
        return $next($request);
    }
}
