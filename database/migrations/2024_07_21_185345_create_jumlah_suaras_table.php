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
            $table->integer("amount");
            $table->text("note");
            $table->uuid("tps_id");
            $table->foreign("tps_id")->references("id")->on("tps");
            $table->uuid("calon_id");
            $table->foreign("calon_id")->references("id")->on("calon");
            $table->string("updated_by")->nullable();
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
