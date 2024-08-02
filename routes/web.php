<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
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
        Route::get("", [RekapitulasiController::class, "index"])->name("rekap.index");
        Route::get("/list", [RekapitulasiController::class, "list"])->name("rekap.list");
        Route::get("wilayah/kabkota", [RekapitulasiController::class, "kabkota"]);
    });
    Route::get("/logout", [AuthController::class, "destroy"]);
    Route::middleware(["userRole"])->group(function (){
        // Calon
        Route::get("/calon/form", [CalonController::class, "form"])->name("calon.form");
        Route::resource("calon", CalonController::class);
        // User
        Route::get("/user/form", [UserController::class, "form"])->name("user.form");
        Route::get("/user/status", [UserController::class, "activeDeactive"])->name("user.active");
        Route::resource('user', UserController::class);
        // Wilayah
        Route::get("/wilayah-pemilihan", [WilayahController::class,"index"])->name("wilayah.index");
        Route::post("/wilayah-pemilihan", [WilayahController::class,"store"])->name("wilayah.post");
        Route::get("/wilayah-pemilihan/list", [WilayahController::class,"findAllByType"])->name("wilayah.list");
        Route::get("/wilayah-pemilihan/form", [WilayahController::class,"form"])->name("wilayah.form");
    });
});
