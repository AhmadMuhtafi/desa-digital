<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->tinyInteger('id')->primary();
            $table->string('nama_desa');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->text('visi');
            $table->text('misi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_desa');
    }
};
