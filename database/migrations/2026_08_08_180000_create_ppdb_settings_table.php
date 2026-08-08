<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran');                     // e.g. "2027/2028"
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('gelombang')->nullable();            // "Gelombang 1", "Gelombang 2"
            $table->longText('persyaratan')->nullable();        // rich text
            $table->longText('jadwal')->nullable();             // rich text
            $table->longText('biaya')->nullable();              // rich text
            $table->string('link_pendaftaran')->nullable();     // external URL
            $table->string('whatsapp_pendaftaran')->nullable();
            $table->string('email_pendaftaran')->nullable();
            $table->longText('keterangan')->nullable();         // rich text
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_settings');
    }
};
