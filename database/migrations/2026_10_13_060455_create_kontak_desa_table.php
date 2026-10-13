<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak_desa', function (Blueprint $table) {
            $table->tinyInteger('id')->primary();
            $table->string('alamat');
            $table->string('telepon');
            $table->text('jam_pelayanan');
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->integer('radius_meter');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak_desa');
    }
};