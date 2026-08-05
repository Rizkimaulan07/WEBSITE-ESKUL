<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Dokumentasi;
use App\Models\NilaiAnggota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Dashboard utama (redirect berdasarkan role)
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'pelatih') {
            return redirect()->route('pelatih.dashboard');
        } elseif ($user->role == 'anggota') {
            return redirect()->route('anggota.dashboard');
        }
        
        return view('dashboard');
    }

    // ===== DASHBOARD ADMIN =====
    public function admin()
    {
        $user = Auth::user();
        
        $data = [
            'total_ekskul' => Ekstrakurikuler::count(),
            'total_pelatih' => User::where('role', 'pelatih')->count(),
            'total_anggota' => User::where('role', 'anggota')->count(),
            'total_kehadiran_hari_ini' => Kehadiran::whereDate('tanggal', today())->count(),
            'ekskul_terbaru' => Ekstrakurikuler::orderBy('created_at', 'desc')->limit(5)->get(),
        ];
        
        return view('admin.dashboard', compact('data', 'user'));
    }

    // ===== DASHBOARD PELATIH =====
    public function pelatih()
    {
        $user = Auth::user();
        $ekskulId = $user->ekskul_id;
        
        // Jika pelatih tidak memiliki ekskul
        if (!$ekskulId) {
            $data = [
                'total_anggota' => 0,
                'total_kehadiran' => 0,
                'kehadiran_hari_ini' => 0,
                'total_dokumentasi' => 0,
                'dokumentasi_terbaru' => collect([]),
                'anggota_terbaru' => collect([]),
                'ekskul' => null,
            ];
            return view('pelatih.dashboard', compact('data', 'user'))
                   ->with('error', 'Anda belum memiliki ekskul! Silakan hubungi admin.');
        }
        
        // Ambil data dokumentasi
        $dokumentasiTerbaru = Dokumentasi::where('ekskul_id', $ekskulId)
                                         ->orderBy('created_at', 'desc')
                                         ->limit(4)
                                         ->get();
        
        // Ambil data anggota
        $anggotaTerbaru = User::where('ekskul_id', $ekskulId)
                              ->where('role', 'anggota')
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();
        
        // Hitung statistik
        $totalAnggota = User::where('ekskul_id', $ekskulId)->where('role', 'anggota')->count();
        
        $totalKehadiran = Kehadiran::whereHas('anggota', function($query) use ($ekskulId) {
            $query->where('ekskul_id', $ekskulId);
        })->count();
        
        $kehadiranHariIni = Kehadiran::whereHas('anggota', function($query) use ($ekskulId) {
            $query->where('ekskul_id', $ekskulId);
        })->whereDate('tanggal', today())->count();
        
        $totalDokumentasi = Dokumentasi::where('ekskul_id', $ekskulId)->count();
        
        $data = [
            'total_anggota' => $totalAnggota,
            'total_kehadiran' => $totalKehadiran,
            'kehadiran_hari_ini' => $kehadiranHariIni,
            'total_dokumentasi' => $totalDokumentasi,
            'dokumentasi_terbaru' => $dokumentasiTerbaru,
            'anggota_terbaru' => $anggotaTerbaru,
            'ekskul' => Ekstrakurikuler::find($ekskulId),
        ];
        
        return view('pelatih.dashboard', compact('data', 'user'));
    }

    // ===== DASHBOARD ANGGOTA =====
    public function anggota()
    {
        $user = Auth::user();
        
        $totalKehadiran = Kehadiran::where('anggota_id', $user->id)->count();
        $hadir = Kehadiran::where('anggota_id', $user->id)->where('status', 'hadir')->count();
        $izin = Kehadiran::where('anggota_id', $user->id)->where('status', 'izin')->count();
        $sakit = Kehadiran::where('anggota_id', $user->id)->where('status', 'sakit')->count();
        $alpa = Kehadiran::where('anggota_id', $user->id)->where('status', 'alpa')->count();
        
        $riwayatTerbaru = Kehadiran::where('anggota_id', $user->id)
                                   ->orderBy('tanggal', 'desc')
                                   ->limit(5)
                                   ->get();
        
        $data = [
            'total_kehadiran' => $totalKehadiran,
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => $alpa,
            'persentase_hadir' => $totalKehadiran > 0 ? round(($hadir / $totalKehadiran) * 100) : 0,
            'riwayat_terbaru' => $riwayatTerbaru,
            'ekskul' => $user->ekskul,
        ];
        
        return view('anggota.dashboard', compact('data', 'user'));
    }
}