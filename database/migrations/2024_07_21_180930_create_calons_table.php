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
        Schema::create('calon', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->integer("code");
            $table->string("calon_name")->unique();
            $table->string("wakil_name")->unique();
            $table->enum("level", ["provinsi", "kabkota"]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon');
    }
};
