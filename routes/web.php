<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\HitungCepatController;
use App\Http\Controllers\JumlahSuaraController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use App\Models\Calon;
use App\Models\Tps;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// Route::get("/chart", [ErrorController::class, "test"]);
Route::get("/login", [AuthController::class, "index"])->name("login");
Route::post('/login', [AuthController::class, 'post']);
Route::get("/error", [ErrorController::class, "index"]);
Route::get("/404", function () {
    return redirect("/error?code=404&title=Page+Not+Found&message=It+looks+like+you+found+a+glitch+in+the+matrix...");
});
Route::get('/test', function (Request $request) {
    try {
        $data = Tps::all();
        return response()->json([
            'data' => $data,
        ]);
    } catch (Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
});

Route::middleware("auth")->middleware("checkingSession")->group(function () {
    Route::get('/', function () {
        $calon = Calon::all();
        return view("index", [
            "calon" => $calon,
        ]);
        // return redirect(route("rekap.index"));
    })->name("index");
    Route::prefix("rekapitulasi")->group(function () {
        Route::get("", action: [RekapitulasiController::class, "index"])->name("rekap.index")->middleware("pageRedirect");
        Route::get("/list", [RekapitulasiController::class, "list"])->name("rekap.list")->middleware("roleRedirect")->middleware("dataRestriction");
        Route::get("/detail", [RekapitulasiController::class, "detail"])->name("rekap.detail")->middleware("dataRestriction");
    });
    Route::get("/logout", [AuthController::class, "destroy"]);
    Route::middleware(["userRole"])->group(function () {
        // Calon
        Route::get("/calon/form", [CalonController::class, "form"])->name("calon.form");
        Route::get("/calon/test", [CalonController::class, "index2"])->name("calon.test");
        Route::get("/calon/all", [CalonController::class, "all"])->name("calon.all");
        Route::resource("calon", CalonController::class);
        // User
        Route::get("/user/form", [UserController::class, "form"])->name("user.form");
        Route::get("/user/status", [UserController::class, "activeDeactive"])->name("user.active");
        Route::get("/user/login", [UserController::class, "loginHistories"])->name("user.login");
        Route::resource('user', UserController::class);
        // Wilayah
        Route::get("/wilayah-pemilihan", [WilayahController::class, "index"])->name("wilayah.index");
        Route::post("/wilayah-pemilihan", [WilayahController::class, "store"])->name("wilayah.post");
        Route::get("/wilayah-pemilihan/find", [WilayahController::class, "find"])->name("wilayah.find")->withoutMiddleware("userRole");
        Route::get("/wilayah-pemilihan/list", [WilayahController::class, "findAllByType"])->name("wilayah.list");
        Route::get("/wilayah-pemilihan/form", [WilayahController::class, "form"])->name("wilayah.form");
        Route::delete("/wilayah-pemilihan", [WilayahController::class, "destroy"])->name("wilayah.delete");
    });

    Route::prefix("input")->group(function () {
        Route::get("", [JumlahSuaraController::class, "index"])->name("input.index");
        Route::post("", [JumlahSuaraController::class, "store"])->name("input.store");
        Route::get("/list", [JumlahSuaraController::class, "list"])->name("input.list");
        Route::get("/form", [JumlahSuaraController::class, "form"])->name("input.form")->middleware("dataRestriction");
    });
    Route::prefix("hitung-cepat")->group(function () {
        Route::get("admin", [HitungCepatController::class, "byAdmin"])->name("hitung_cepat.admin");
        Route::post("admin", [HitungCepatController::class, "storeByAdmin"])->name("hitung_cepat.admin.post");
        Route::get("admin/list", [HitungCepatController::class, "listByAdmin"])->name("hitung_cepat.admin.list")->middleware("dataRestriction");
        Route::get("saksi", [HitungCepatController::class, "bySaksi"])->name("hitung_cepat.saksi");
        Route::get("saksi/list", [HitungCepatController::class, "listBySaksi"])->name("hitung_cepat.saksi.list")->middleware("dataRestriction");
        Route::get("saksi/edit", [HitungCepatController::class, "editHitungCepatSaksi"])->name("hitung_cepat.saksi.edit.list");
        Route::post("saksi/edit", [HitungCepatController::class, "submitEditHitungCepatSaksi"])->name("hitung_cepat.saksi.edit.post");
        Route::get("saksi/status", [HitungCepatController::class, "inputStatus"])->name("hitung_cepat.saksi.status");
        Route::post("saksi/nik", [HitungCepatController::class, "storeNIK"])->name("hitung_cepat.saksi.nik");
        // Route::get("rekap", [HitungCepatController::class, "rekapHitungCepatAdmin"])->name("rekap.hitung-cepat.admin");
        Route::get("rekap", [HitungCepatController::class, "rekapHitungCepat"])->name("hitung_cepat.rekap");
        Route::get("chart", [HitungCepatController::class, "chart"])->name("hitung_cepat.chart")->middleware("dataRestriction");
        Route::get("pilih-tingkat", [HitungCepatController::class, "selectTingkatPemilihan"])->name("hitung_cepat.select_tingkat");
    });
});
