<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->foreignId('parent_id')->nullable()->constrained('navigation_menus')->nullOnDelete();
            $table->string('target')->default('_self');
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->boolean('is_external')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_menus');
    }
};
