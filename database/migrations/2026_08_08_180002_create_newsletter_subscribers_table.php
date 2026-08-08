<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('email')->unique();
            $table->string('token_verifikasi', 100)->nullable();
            $table->timestamp('terverifikasi_pada')->nullable();
            $table->enum('status', ['pending', 'aktif', 'berhenti'])->default('aktif');
            $table->string('sumber')->nullable();   // homepage, footer, artikel
            $table->timestamp('berhenti_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
};
