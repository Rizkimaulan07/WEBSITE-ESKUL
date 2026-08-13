<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TemplateSuratController;
use App\Http\Controllers\Pelatih\NilaiController;
use App\Http\Controllers\Pelatih\DokumentasiController;
use App\Http\Controllers\Pelatih\KehadiranController;
use App\Http\Controllers\Pelatih\KehadiranPelatihController;
use App\Http\Controllers\Anggota\KehadiranController as AnggotaKehadiranController;
use App\Http\Controllers\Anggota\NilaiController as AnggotaNilaiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // Jika sudah login, arahkan ke dashboard sesuai role
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    // Jika belum login, arahkan ke halaman login (bukan welcome Laravel)
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
    Route::get('/kehadiran-pelatih', [KehadiranPelatihController::class, 'adminIndex'])->name('kehadiran_pelatih');
    Route::get('/kehadiran-anggota', [KehadiranController::class, 'adminIndex'])->name('kehadiran_anggota');
    
    // ===== ROUTE DOKUMENTASI ADMIN =====
    Route::get('/dokumentasi', [DokumentasiController::class, 'adminIndex'])->name('dokumentasi.index');
    Route::get('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'adminShow'])->name('dokumentasi.show');
    Route::delete('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'adminDestroy'])->name('dokumentasi.destroy');
});

// === ROUTE PELATIH ===
Route::middleware(['auth', 'role:pelatih'])->prefix('pelatih')->name('pelatih.')->group(function () {
    // Dashboard Pelatih
    Route::get('/dashboard', [DashboardController::class, 'pelatih'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('pelatih.dashboard');
    });
    
    // Kehadiran Pelatih (untuk pelatih sendiri)
    Route::get('/kehadiran-pelatih', [KehadiranPelatihController::class, 'index'])->name('kehadiran_pelatih');
    Route::post('/kehadiran-pelatih', [KehadiranPelatihController::class, 'store'])->name('kehadiran_pelatih.store');
    
    // Kehadiran Anggota
    Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran');
    Route::post('/kehadiran', [KehadiranController::class, 'store'])->name('kehadiran.store');
    Route::get('/kehadiran/rekap', [KehadiranController::class, 'rekap'])->name('kehadiran.rekap');
    Route::get('/kehadiran/{kehadiran}', [KehadiranController::class, 'show'])->name('kehadiran.show');

    // Anggota (pelatih)
    Route::get('/anggota/create', [AnggotaController::class, 'createPelatih'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'storePelatih'])->name('anggota.store');
    
    // Nilai
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::post('/nilai/kehadiran', [NilaiController::class, 'storeKehadiran'])->name('nilai.kehadiran');
    Route::get('/nilai/export', [NilaiController::class, 'export'])->name('nilai.export');
    
    // Dokumentasi
    Route::get('/dokumentasi', [DokumentasiController::class, 'index'])->name('dokumentasi');
    Route::get('/dokumentasi/create', [DokumentasiController::class, 'create'])->name('dokumentasi.create');
    Route::post('/dokumentasi', [DokumentasiController::class, 'store'])->name('dokumentasi.store');
    Route::get('/dokumentasi/{dokumentasi}/edit', [DokumentasiController::class, 'edit'])->name('dokumentasi.edit');
    Route::put('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'update'])->name('dokumentasi.update');
    Route::get('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'show'])->name('dokumentasi.show');
    Route::delete('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy');
});

// === ROUTE ANGGOTA ===
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    // Dashboard Anggota
    Route::get('/dashboard', [DashboardController::class, 'anggota'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('anggota.dashboard');
    });
    
    // Kehadiran Anggota
    Route::get('/kehadiran', [AnggotaKehadiranController::class, 'index'])->name('kehadiran');
    Route::get('/kehadiran/detail/{id}', [AnggotaKehadiranController::class, 'detail'])->name('kehadiran.detail');
    
    // Nilai Anggota
    Route::get('/nilai', [AnggotaNilaiController::class, 'index'])->name('nilai');
    Route::get('/nilai/detail/{id}', [AnggotaNilaiController::class, 'detail'])->name('nilai.detail');
});

require __DIR__.'/auth.php';