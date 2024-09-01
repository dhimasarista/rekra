<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hitung_suara_cepat_admin_detail', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->integer("amount");
            $table->uuid("calon_id");
            $table->foreign("calon_id")->references("id")->on("calon");
            $table->uuid("tps_id");
            $table->foreign("tps_id")->references("id")->on("tps");
            $table->uuid("hs_cepat_admin_id");
            $table->foreign("hs_cepat_admin_id")->references("id")->on("hitung_suara_cepat_admin");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitung_suara_cepat_admin_detail');
    }
};
