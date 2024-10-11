<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("jumlah_suara", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("note")->nullable();
            $table->unsignedInteger("dpt")->nullable();
            $table->unsignedInteger("dptb")->nullable();
            $table->unsignedInteger("dptk")->nullable();
            $table->unsignedInteger("surat_suara_diterima")->nullable();
            $table->unsignedInteger("surat_suara_digunakan")->nullable();
            $table->unsignedInteger("surat_suara_tidak_digunakan")->nullable();
            $table->unsignedInteger("surat_suara_suara_rusak")->nullable();
            $table->unsignedInteger("total_suara_sah")->nullable();
            $table->unsignedInteger("total_suara_tidak_sah")->nullable();
            $table->unsignedInteger("total_sah_tidak_sah")->nullable();
            $table->boolean("c_keberatan")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("jumlah_suara");
    }
};
