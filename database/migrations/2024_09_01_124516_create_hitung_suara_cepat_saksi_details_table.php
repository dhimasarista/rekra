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
        Schema::create('hitung_suara_cepat_saksi_detail', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->unsignedInteger("amount")->default(0);
            $table->uuid("calon_id");
            $table->foreign("calon_id")->references("id")->on("calon");
            $table->uuid("hs_cepat_saksi_id");
            $table->foreign("hs_cepat_saksi_id")->references("id")->on("hitung_suara_cepat_saksi");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitung_suara_cepat_saksi_detail');
    }
};
