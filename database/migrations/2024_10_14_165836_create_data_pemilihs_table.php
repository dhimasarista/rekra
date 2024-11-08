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
            $table->char("nik", 16)->index()->unique()->default(null)->nullable();
            $table->string("name");
            $table->string("phone")->nullable()->default(null);
            $table->string("address");
            $table->enum("gender", ["L", "P"]);
            $table->unsignedInteger("age");
            $table->char("tps", 3);
            $table->char("rt", 3);
            $table->char("rw", 3);
            $table->string("kelurahan_desa");
            $table->string("kecamatan");
            $table->string("kabkota");
            $table->string("provinsi");
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
