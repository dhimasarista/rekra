<?php

use App\Http\Controllers\ErrorController;
use App\Http\Controllers\RekapitulasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect("/login");
});
Route::get('/login', function () {
    return view('login');
});
Route::prefix("/rekapitulasi")->group(function(){
    Route::get("", [RekapitulasiController::class, "index"]);
    Route::get("/list", [RekapitulasiController::class, "list"]);
});

Route::get("/error", [ErrorController::class, "index"]);
Route::get("/404", function(){
    return redirect("/error?code=404&title=Page+Not+Found&message=It+looks+like+you+found+a+glitch+in+the+matrix...");
});
