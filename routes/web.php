<?php

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
