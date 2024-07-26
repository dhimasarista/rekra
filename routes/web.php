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
Route::post('/login', [AuthController::class, 'post']);
Route::get("/error", [ErrorController::class, "index"]);
Route::get("/404", function(){
    return redirect("/error?code=404&title=Page+Not+Found&message=It+looks+like+you+found+a+glitch+in+the+matrix...");
});

Route::middleware("auth")->group(function (){
    Route::prefix("rekapitulasi")->group(function(){
        Route::get("", [RekapitulasiController::class, "index"])->name("rekap-index");
        Route::get("/list", [RekapitulasiController::class, "list"]);
    });
    Route::get("/logout", [AuthController::class, "destroy"]);
    Route::middleware(["userRole"])->group(function (){
        Route::resource("calon", CalonController::class);
        Route::resource('user', UserController::class);
    });
});
