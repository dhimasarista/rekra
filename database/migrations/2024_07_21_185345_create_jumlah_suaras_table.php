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
        Schema::create('jumlah_suara', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->text("note")->default("");
            $table->integer("total_suara_sah")->nullable();
            $table->integer("total_suara_tidak_sah")->nullable();
            $table->integer("total_sah_tidak_sah")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_suara');
    }
};
