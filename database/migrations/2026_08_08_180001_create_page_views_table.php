<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url', 1000);
            $table->string('title')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('referer', 1000)->nullable();
            $table->string('device_type')->nullable();  // desktop, mobile, tablet
            $table->date('tanggal');
            $table->timestamps();

            $table->index('tanggal');
            // Note: url column (1000 chars) is too long for a MySQL index by default;
            // use a full-text search or prefix index if needed.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
