<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('kategori_id');

            $table->string('judul');
            $table->string('file');
            $table->string('tipe_file');
            $table->integer('jumlah_unduh')->default(0);

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
