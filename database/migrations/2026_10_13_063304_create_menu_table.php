<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('label');
            $table->string('url');
            $table->smallInteger('urutan');
            $table->boolean('is_active');

            $table->foreign('parent_id')
                ->references('id')
                ->on('menu')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};