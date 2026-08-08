<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('subjek');
            $table->longText('konten');
            $table->enum('status', ['draft', 'terjadwal', 'terkirim'])->default('draft');
            $table->timestamp('dijadwalkan_pada')->nullable();
            $table->timestamp('dikirim_pada')->nullable();
            $table->integer('jumlah_penerima')->default(0);
            $table->integer('jumlah_terkirim')->default(0);
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_campaigns');
    }
};
