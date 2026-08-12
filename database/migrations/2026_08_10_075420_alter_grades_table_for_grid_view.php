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
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['jenis_nilai', 'nilai']);
            $table->decimal('nilai_presensi', 5, 2)->nullable();
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_uh', 5, 2)->nullable();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('nilai_huruf', 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->string('jenis_nilai')->nullable();
            $table->integer('nilai')->nullable();
            $table->dropColumn([
                'nilai_presensi',
                'nilai_tugas',
                'nilai_uh',
                'nilai_uts',
                'nilai_uas',
                'nilai_akhir',
                'nilai_huruf',
            ]);
        });
    }
};
