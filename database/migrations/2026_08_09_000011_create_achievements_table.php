<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('winner_name')->nullable();
            $table->enum('level', ['kabupaten', 'provinsi', 'nasional', 'internasional'])->default('kabupaten');
            $table->string('year')->nullable();
            $table->enum('rank', ['juara_1', 'juara_2', 'juara_3', 'harapan_1', 'lainnya'])->default('juara_1');
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
