<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->increments('id');

            // Foreign key ke tabel users
            $table->unsignedInteger('penulis_id');

            // Foreign key ke tabel kategori
            $table->unsignedInteger('kategori_id');

            $table->string('judul');
            $table->string('slug');
            $table->mediumText('isi');
            $table->string('gambar')->nullable();

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->dateTime('published_at')->nullable();

            $table->foreign('penulis_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
