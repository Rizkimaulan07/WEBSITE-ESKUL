<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\TemplateSuratController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// === ROUTE PROFILE ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show'); // TAMBAHKAN INI!
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === ROUTE ADMIN (GABUNGAN SEMUA) ===
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // ===== EKSKUL =====
    Route::get('ekskul', [EkskulController::class, 'index'])->name('ekskul.index');
    Route::get('ekskul/create', [EkskulController::class, 'create'])->name('ekskul.create');
    Route::post('ekskul', [EkskulController::class, 'store'])->name('ekskul.store');
    Route::get('ekskul/{ekskul}/edit', [EkskulController::class, 'edit'])->name('ekskul.edit');
    Route::put('ekskul/{ekskul}', [EkskulController::class, 'update'])->name('ekskul.update');
    Route::delete('ekskul/{ekskul}', [EkskulController::class, 'destroy'])->name('ekskul.destroy');
    Route::get('ekskul/{ekskul}', [EkskulController::class, 'show'])->name('ekskul.show');
    
    // ===== TEMPLATE SURAT =====
    Route::get('template-surat', [TemplateSuratController::class, 'index'])->name('template-surat.index');
    Route::get('template-surat/create', [TemplateSuratController::class, 'create'])->name('template-surat.create');
    Route::post('template-surat', [TemplateSuratController::class, 'store'])->name('template-surat.store');
    Route::get('template-surat/{templateSurat}/edit', [TemplateSuratController::class, 'edit'])->name('template-surat.edit');
    Route::put('template-surat/{templateSurat}', [TemplateSuratController::class, 'update'])->name('template-surat.update');
    Route::delete('template-surat/{templateSurat}', [TemplateSuratController::class, 'destroy'])->name('template-surat.destroy');
    Route::get('template-surat/{templateSurat}/download', [TemplateSuratController::class, 'download'])->name('template-surat.download');
    
    // ===== ANGGOTA =====
    Route::get('anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
});

// === ROUTE PELATIH ===
Route::middleware(['auth', 'role:pelatih'])->prefix('pelatih')->group(function () {
    Route::get('kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');
    Route::post('kehadiran', [KehadiranController::class, 'store'])->name('kehadiran.store');
    Route::get('kehadiran/rekap', [KehadiranController::class, 'rekap'])->name('kehadiran.rekap');
    Route::get('kehadiran/export-excel', [KehadiranController::class, 'exportExcel'])->name('kehadiran.export-excel');
    
    Route::resource('dokumentasi', DokumentasiController::class)->except(['show']);
    
    Route::get('surat/create', [SuratController::class, 'create'])->name('surat.create');
    Route::post('surat/export', [SuratController::class, 'export'])->name('surat.export');
    Route::post('surat/export-pdf', [SuratController::class, 'exportPdf'])->name('surat.export-pdf');
    Route::get('surat/history', [SuratController::class, 'history'])->name('surat.history');
    Route::get('surat/{surat}/download', [SuratController::class, 'downloadSurat'])->name('surat.download');
});

// === ROUTE ANGGOTA & PUBLIK ===
Route::middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('anggota/dashboard', [DashboardController::class, 'anggota'])->name('anggota.dashboard');
});

Route::get('galeri', [DokumentasiController::class, 'publik'])->name('dokumentasi.publik');

require __DIR__.'/auth.php';