<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Dokumentasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->role == 'admin') {
            // Statistik Admin
            $data['total_ekskul'] = Ekstrakurikuler::count();
            $data['total_pelatih'] = User::where('role', 'pelatih')->count();
            $data['total_anggota'] = User::where('role', 'anggota')->count();
            $data['total_kehadiran_hari_ini'] = Kehadiran::whereDate('tanggal', today())->count();
            
            // Data untuk chart
            $data['chart_labels'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $data['chart_data'] = [];
            
            // Ekskul terbaru
            $data['ekskul_terbaru'] = Ekstrakurikuler::orderBy('created_at', 'desc')->limit(5)->get();
            
            // Kehadiran per ekskul
            $data['kehadiran_per_ekskul'] = Kehadiran::select('ekskul_id', DB::raw('count(*) as total'))
                ->whereMonth('tanggal', now()->month)
                ->groupBy('ekskul_id')
                ->with('ekskul')
                ->get();
                
        } elseif ($user->role == 'pelatih') {
            // Statistik Pelatih
            $ekskul = $user->ekskul;
            $data['ekskul'] = $ekskul;
            $data['jumlah_anggota'] = $ekskul ? $ekskul->users()->where('role', 'anggota')->count() : 0;
            $data['kehadiran_bulan_ini'] = Kehadiran::where('pelatih_id', $user->id)
                                                    ->whereMonth('tanggal', now()->month)
                                                    ->count();
            
            // Detail kehadiran per status
            $data['hadir'] = Kehadiran::where('pelatih_id', $user->id)
                                      ->where('status', 'hadir')
                                      ->whereMonth('tanggal', now()->month)
                                      ->count();
            $data['izin'] = Kehadiran::where('pelatih_id', $user->id)
                                     ->where('status', 'izin')
                                     ->whereMonth('tanggal', now()->month)
                                     ->count();
            $data['sakit'] = Kehadiran::where('pelatih_id', $user->id)
                                      ->where('status', 'sakit')
                                      ->whereMonth('tanggal', now()->month)
                                      ->count();
            $data['alpa'] = Kehadiran::where('pelatih_id', $user->id)
                                     ->where('status', 'alpa')
                                     ->whereMonth('tanggal', now()->month)
                                     ->count();
            
            // Dokumentasi terbaru
            $data['dokumentasi_terbaru'] = Dokumentasi::where('ekskul_id', $ekskul ? $ekskul->id : 0)
                                                      ->orderBy('created_at', 'desc')
                                                      ->limit(4)
                                                      ->get();
            
            // Kehadiran per hari (untuk chart)
            $data['kehadiran_harian'] = Kehadiran::where('pelatih_id', $user->id)
                                                ->whereMonth('tanggal', now()->month)
                                                ->select(DB::raw('DATE(tanggal) as date'), DB::raw('count(*) as total'))
                                                ->groupBy('date')
                                                ->get();
                                                
        } elseif ($user->role == 'anggota') {
            // Statistik Anggota
            $data['total_kehadiran'] = Kehadiran::where('anggota_id', $user->id)->count();
            $data['hadir'] = Kehadiran::where('anggota_id', $user->id)->where('status', 'hadir')->count();
            $data['izin'] = Kehadiran::where('anggota_id', $user->id)->where('status', 'izin')->count();
            $data['sakit'] = Kehadiran::where('anggota_id', $user->id)->where('status', 'sakit')->count();
            $data['alpa'] = Kehadiran::where('anggota_id', $user->id)->where('status', 'alpa')->count();
            
            // Persentase kehadiran
            $total = $data['total_kehadiran'];
            $data['persentase_hadir'] = $total > 0 ? round(($data['hadir'] / $total) * 100) : 0;
            
            // Riwayat terbaru
            $data['riwayat_terbaru'] = Kehadiran::where('anggota_id', $user->id)
                                                ->orderBy('tanggal', 'desc')
                                                ->limit(5)
                                                ->get();
        }

        return view('dashboard', compact('data', 'user'));
    }

    public function anggota()
    {
        $user = Auth::user();
        $kehadirans = Kehadiran::where('anggota_id', $user->id)
                               ->orderBy('tanggal', 'desc')
                               ->paginate(10);
        
        // Statistik
        $statistik = [
            'total' => Kehadiran::where('anggota_id', $user->id)->count(),
            'hadir' => Kehadiran::where('anggota_id', $user->id)->where('status', 'hadir')->count(),
            'izin' => Kehadiran::where('anggota_id', $user->id)->where('status', 'izin')->count(),
            'sakit' => Kehadiran::where('anggota_id', $user->id)->where('status', 'sakit')->count(),
            'alpa' => Kehadiran::where('anggota_id', $user->id)->where('status', 'alpa')->count(),
        ];
        
        $persentase = $statistik['total'] > 0 ? round(($statistik['hadir'] / $statistik['total']) * 100) : 0;
        
        return view('anggota.dashboard', compact('kehadirans', 'statistik', 'persentase', 'user'));
    }
}