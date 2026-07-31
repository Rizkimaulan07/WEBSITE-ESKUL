<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TemplateSuratController;
use App\Http\Controllers\Pelatih\NilaiController;
use App\Http\Controllers\Pelatih\DokumentasiController;
use App\Http\Controllers\Pelatih\KehadiranController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

// ===== DASHBOARD =====
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// === ROUTE PROFILE ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === ROUTE ADMIN ===
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::resource('ekskul', EkskulController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('template-surat', TemplateSuratController::class);
    Route::get('template-surat/{templateSurat}/download', [TemplateSuratController::class, 'download'])->name('template-surat.download');
});

// === ROUTE PELATIH ===
Route::middleware(['auth'])->prefix('pelatih')->name('pelatih.')->group(function () {
    // Dashboard Pelatih
    Route::get('/dashboard', [DashboardController::class, 'pelatih'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('pelatih.dashboard');
    });
    
    // Kehadiran
    Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran');
    Route::post('/kehadiran', [KehadiranController::class, 'store'])->name('kehadiran.store');
    Route::get('/kehadiran/rekap', [KehadiranController::class, 'rekap'])->name('kehadiran.rekap');
    
    // Nilai
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::get('/nilai/export', [NilaiController::class, 'export'])->name('nilai.export');
    
    // Dokumentasi
    Route::get('/dokumentasi', [DokumentasiController::class, 'index'])->name('dokumentasi');
    Route::get('/dokumentasi/create', [DokumentasiController::class, 'create'])->name('dokumentasi.create');
    Route::post('/dokumentasi', [DokumentasiController::class, 'store'])->name('dokumentasi.store');
    Route::delete('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy');
});

// === ROUTE ANGGOTA ===
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'anggota'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('anggota.dashboard');
    });
});

require __DIR__.'/auth.php';