<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect("/login");
});
Route::get("/login", [AuthController::class, "index"]);
Route::get("/logout", [AuthController::class, "destroy"]);
Route::post('/login', [AuthController::class, 'post']);

Route::prefix("/rekapitulasi")->group(function(){
    Route::get("", [RekapitulasiController::class, "index"]);
    Route::get("/list", [RekapitulasiController::class, "list"]);
});

Route::resource("calon", CalonController::class);
Route::resource('user', UserController::class);
Route::get("/error", [ErrorController::class, "index"]);
Route::get("/404", function(){
    return redirect("/error?code=404&title=Page+Not+Found&message=It+looks+like+you+found+a+glitch+in+the+matrix...");
});
