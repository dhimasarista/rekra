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
        Route::get("", [RekapitulasiController::class, "index"])->name("rekap-index");
        Route::get("/list", [RekapitulasiController::class, "list"]);
        Route::get("wilayah/kabkota", [RekapitulasiController::class, "kabkota"]);
    });
    Route::get("/logout", [AuthController::class, "destroy"]);
    Route::middleware(["userRole"])->group(function (){
        // Calon
        Route::name("calon.form")->get("/calon/form", [CalonController::class, "form"]);
        Route::resource("calon", CalonController::class);
        // User
        Route::name("user.form")->get("/user/form", [UserController::class, "form"]);
        Route::name("user.active")->get("/user/status", [UserController::class, "activeDeactive"]);
        Route::resource('user', UserController::class);
        // Wilayah
        Route::get("/wilayah-pemilihan", [WilayahController::class,"index"])->name("wilayah.index");
        Route::post("/wilayah-pemilihan", [WilayahController::class,"store"])->name("wilayah.post");
        Route::get("/wilayah-pemilihan/list", [WilayahController::class,"findAllByType"])->name("wilayah.list");
        Route::get("/wilayah-pemilihan/form", [WilayahController::class,"form"])->name("wilayah.form");
    });
});
