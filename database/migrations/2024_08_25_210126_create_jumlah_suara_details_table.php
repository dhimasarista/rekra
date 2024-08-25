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
        Schema::create('jumlah_suara_details', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->text("note");
            $table->integer("total_suara_sah");
            $table->integer("total_suara_tidak_sah");
            $table->integer("total_sah_tidak_sah");
            $table->uuid("jumlah_suara_id");
            $table->foreign("jumlah_suara_id")->references("id")->on("jumlah_suara");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_suara_details');
    }
};
