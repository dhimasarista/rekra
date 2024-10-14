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
        Schema::create('data_pemilih', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->char("nik", 16)->index()->unique();
            $table->string("name");
            $table->string("phone");
            $table->string("alamat");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pemilih');
    }
};
