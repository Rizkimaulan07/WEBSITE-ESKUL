<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkskulController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PelatihController; 
use App\Http\Controllers\TemplateSuratController;
use App\Http\Controllers\Pelatih\NilaiController;
use App\Http\Controllers\Pelatih\DokumentasiController;
use App\Http\Controllers\Pelatih\KehadiranController;
use App\Http\Controllers\Pelatih\KehadiranPelatihController;
use App\Http\Controllers\Anggota\KehadiranController as AnggotaKehadiranController;
use App\Http\Controllers\Anggota\NilaiController as AnggotaNilaiController;
use App\Http\Controllers\Admin\NilaiController as AdminNilaiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// ===== DASHBOARD =====
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// === ROUTE PROFILE ===
Route::middleware('auth')->group(function () {
    Route::get('/profile/me', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =================================================================
// === ROUTE ADMIN ===
// =================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    
    Route::resource('ekskul', EkskulController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('pelatih', PelatihController::class);
    Route::resource('template-surat', TemplateSuratController::class);
    Route::get('template-surat/{templateSurat}/download', [TemplateSuratController::class, 'download'])->name('template-surat.download');
    Route::get('/kehadiran-pelatih', [KehadiranPelatihController::class, 'adminIndex'])->name('kehadiran_pelatih');
    Route::get('/kehadiran-pelatih/export', [KehadiranPelatihController::class, 'adminExport'])->name('kehadiran_pelatih.export');
    Route::get('/kehadiran-anggota', [KehadiranController::class, 'adminIndex'])->name('kehadiran_anggota');
    Route::get('/kehadiran-anggota/export', [KehadiranController::class, 'adminExport'])->name('kehadiran_anggota.export');
    Route::get('/nilai-anggota', [AdminNilaiController::class, 'index'])->name('nilai.index');
    Route::get('/nilai-anggota/export', [AdminNilaiController::class, 'export'])->name('nilai.export');
    
    // ===== ROUTE DOKUMENTASI ADMIN =====
    Route::get('/dokumentasi', [DokumentasiController::class, 'adminIndex'])->name('dokumentasi.index');
    Route::get('/dokumentasi/eskul/{eskul}', [DokumentasiController::class, 'indexByEskul'])->name('dokumentasi.eskul')->whereNumber('eskul');
    Route::get('/dokumentasi/create/{eskul}', [DokumentasiController::class, 'adminCreate'])->name('dokumentasi.create')->whereNumber('eskul');
    Route::post('/dokumentasi/store/{eskul}', [DokumentasiController::class, 'adminStore'])->name('dokumentasi.store')->whereNumber('eskul');
    Route::get('/dokumentasi/edit/{dokumentasi}', [DokumentasiController::class, 'adminEdit'])->name('dokumentasi.edit')->whereNumber('dokumentasi');
    Route::put('/dokumentasi/update/{dokumentasi}', [DokumentasiController::class, 'adminUpdate'])->name('dokumentasi.update')->whereNumber('dokumentasi');
    Route::get('/dokumentasi/show/{dokumentasi}', [DokumentasiController::class, 'adminShow'])->name('dokumentasi.show')->whereNumber('dokumentasi');
    Route::delete('/dokumentasi/destroy/{dokumentasi}', [DokumentasiController::class, 'adminDestroy'])->name('dokumentasi.destroy')->whereNumber('dokumentasi');

    // ===== ROUTE DOWNLOAD APK =====
    Route::get('/downloads', function () {
        return view('admin.download.index');
    })->name('downloads.index');

    Route::post('/downloads/upload', function (Request $request) {
        $request->validate([
            'apk' => 'required|file|mimes:apk|max:102400'
        ]);

        $file = $request->file('apk');
        $filename = 'SIMSKUL_' . date('Ymd_His') . '.apk';
        $file->move(public_path('downloads'), $filename);

        return back()->with('success', 'APK berhasil diupload!');
    })->name('downloads.upload');

    Route::delete('/downloads/{filename}', function ($filename) {
        $path = public_path('downloads/' . $filename);
        if (file_exists($path)) {
            unlink($path);
            return back()->with('success', 'File berhasil dihapus!');
        }
        return back()->with('error', 'File tidak ditemukan!');
    })->name('downloads.delete');
});
// =================================================================

// =================================================================
// === ROUTE PELATIH ===
// =================================================================
Route::middleware(['auth', 'role:pelatih'])->prefix('pelatih')->name('pelatih.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pelatih'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('pelatih.dashboard');
    });
    
    Route::get('/kehadiran-pelatih', [KehadiranPelatihController::class, 'index'])->name('kehadiran_pelatih');
    Route::post('/kehadiran-pelatih', [KehadiranPelatihController::class, 'store'])->name('kehadiran_pelatih.store');
    
    Route::get('/kehadiran/rekap', [KehadiranController::class, 'rekap'])->name('kehadiran.rekap');
    Route::get('/kehadiran/rekap/export', [KehadiranController::class, 'rekapExport'])->name('kehadiran.rekap.export');
    Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran');
    Route::post('/kehadiran', [KehadiranController::class, 'store'])->name('kehadiran.store');
    Route::get('/kehadiran/{kehadiran}', [KehadiranController::class, 'show'])
        ->name('kehadiran.show')
        ->whereNumber('kehadiran');

    Route::get('/anggota/create', [AnggotaController::class, 'createPelatih'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'storePelatih'])->name('anggota.store');
    
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::post('/nilai/kehadiran', [NilaiController::class, 'storeKehadiran'])->name('nilai.kehadiran');
    Route::get('/nilai/export', [NilaiController::class, 'export'])->name('nilai.export');
    
    // ===== DOKUMENTASI PELATIH =====
    Route::get('/dokumentasi', [DokumentasiController::class, 'indexPelatih'])->name('dokumentasi');
    Route::get('/dokumentasi/create', [DokumentasiController::class, 'createPelatih'])->name('dokumentasi.create');
    Route::post('/dokumentasi', [DokumentasiController::class, 'storePelatih'])->name('dokumentasi.store');
    Route::get('/dokumentasi/edit/{dokumentasi}', [DokumentasiController::class, 'edit'])->name('dokumentasi.edit')->whereNumber('dokumentasi');
    Route::put('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'update'])->name('dokumentasi.update')->whereNumber('dokumentasi');
    Route::delete('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy')->whereNumber('dokumentasi');
});
// =================================================================

// === ROUTE ANGGOTA ===
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'anggota'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('anggota.dashboard');
    });
    
    Route::get('/kehadiran', [AnggotaKehadiranController::class, 'index'])->name('kehadiran');
    Route::get('/kehadiran/detail/{id}', [AnggotaKehadiranController::class, 'detail'])->name('kehadiran.detail');
    
    Route::get('/nilai', [AnggotaNilaiController::class, 'index'])->name('nilai');
    Route::get('/nilai/detail/{id}', [AnggotaNilaiController::class, 'detail'])->name('nilai.detail');
});

require __DIR__.'/auth.php';