
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri_album', function (Blueprint $table) {
            $table->increments('id');
            $table->string('judul');
            $table->string('deskripsi');
            $table->string('cover');
            $table->enum('status', ['draft', 'published', 'archived'])
                ->default('draft');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri_album');
    }
};
