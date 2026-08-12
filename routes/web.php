<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Pure Bahasa Indonesia)
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'beranda'])->name('beranda');
Route::get('/profil', [PublicController::class, 'profil'])->name('profil');

Route::get('/berita', [PublicController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [PublicController::class, 'beritaShow'])->name('berita.show');

Route::get('/pengumuman', [PublicController::class, 'pengumumanIndex'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [PublicController::class, 'pengumumanShow'])->name('pengumuman.show');

Route::get('/agenda', [PublicController::class, 'agendaIndex'])->name('agenda.index');
Route::get('/agenda/{slug}', [PublicController::class, 'agendaShow'])->name('agenda.show');

Route::get('/galeri', [PublicController::class, 'galeriIndex'])->name('galeri.index');
Route::get('/galeri/{slug}', [PublicController::class, 'galeriShow'])->name('galeri.show');

Route::get('/guru-staf', [PublicController::class, 'guruStaf'])->name('guru-staf');

Route::get('/fasilitas', [PublicController::class, 'fasilitasIndex'])->name('fasilitas.index');
Route::get('/fasilitas/{slug}', [PublicController::class, 'fasilitasShow'])->name('fasilitas.show');

Route::get('/prestasi', [PublicController::class, 'prestasiIndex'])->name('prestasi.index');
Route::get('/prestasi/{slug}', [PublicController::class, 'prestasiShow'])->name('prestasi.show');

Route::get('/dokumen', [PublicController::class, 'dokumenIndex'])->name('dokumen.index');

Route::get('/kontak', [PublicController::class, 'kontakIndex'])->name('kontak.index');
Route::post('/kontak', [PublicController::class, 'kontakStore'])->name('kontak.store');

Route::get('/halaman/{slug}', [PublicController::class, 'halamanShow'])->name('halaman.show');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Phase 3 Routes
Route::get('/ppdb', [PublicController::class, 'ppdbIndex'])->name('ppdb.index');
Route::get('/pencarian', [PublicController::class, 'pencarianIndex'])->name('pencarian.index');
Route::post('/newsletter/daftar', [PublicController::class, 'newsletterDaftar'])->name('newsletter.daftar');

Route::get('/portal/report-cards/{id}/pdf', [\App\Http\Controllers\ReportCardController::class, 'downloadPdf'])->middleware('auth')->name('report-cards.pdf');