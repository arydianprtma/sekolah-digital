<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->text('catatan_wali_kelas')->nullable();
            $table->enum('nilai_sikap', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])->default('Baik');
            $table->enum('nilai_spiritual', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])->default('Baik');
            $table->enum('status_kenaikan', ['Naik Kelas', 'Tinggal Kelas', 'Lulus', ''])->nullable();
            $table->timestamps();
            
            // Ensures a student only has one report card per academic year
            $table->unique(['student_id', 'academic_year_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_cards');
    }
};
