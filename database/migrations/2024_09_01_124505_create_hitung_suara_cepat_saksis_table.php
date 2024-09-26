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
        Schema::create('hitung_suara_cepat_saksi', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->char("nik", 16)->unique();
            $table->boolean("input_status")->default(false);
            $table->uuid("tps_id");
            $table->foreign("tps_id")->references("id")->on("tps");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitung_suara_cepat_saksi');
    }
};
