<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\NilaiAnggota;
use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index()
    {
        // Cek login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $pelatih = Auth::user();
        
        // Cek role
        if ($pelatih->role !== 'pelatih') {
            return redirect()->route('dashboard');
        }
        
        $ekskul = $pelatih->ekskul;
        
        if (!$ekskul) {
            // Jika tidak ada ekskul, redirect ke halaman dokumentasi dengan pesan error
            return redirect()->route('pelatih.dokumentasi')
                             ->with('error', 'Anda belum terdaftar di ekskul manapun!');
        }
        
        // Ambil semua anggota
        $anggotas = User::where('role', 'anggota')
                        ->whereHas('ekskuls', function($query) use ($ekskul) {
                            $query->where('ekskul_id', $ekskul->id);
                        })
                        ->with(['nilaiAnggota' => function($query) use ($pelatih) {
                            $query->where('pelatih_id', $pelatih->id)
                                  ->where('semester', $this->getSemester())
                                  ->where('tahun_ajaran', date('Y'));
                        }])
                        ->get();
        
        // Statistik
        $statistik = [
            'total' => NilaiAnggota::where('ekskul_id', $ekskul->id)
                                   ->where('pelatih_id', $pelatih->id)
                                   ->where('semester', $this->getSemester())
                                   ->where('tahun_ajaran', date('Y'))
                                   ->count(),
            'rata_rata' => NilaiAnggota::where('ekskul_id', $ekskul->id)
                                       ->where('pelatih_id', $pelatih->id)
                                       ->where('semester', $this->getSemester())
                                       ->where('tahun_ajaran', date('Y'))
                                       ->avg('nilai_total') ?? 0,
            'tertinggi' => NilaiAnggota::where('ekskul_id', $ekskul->id)
                                       ->where('pelatih_id', $pelatih->id)
                                       ->where('semester', $this->getSemester())
                                       ->where('tahun_ajaran', date('Y'))
                                       ->max('nilai_total') ?? 0,
            'terendah' => NilaiAnggota::where('ekskul_id', $ekskul->id)
                                       ->where('pelatih_id', $pelatih->id)
                                       ->where('semester', $this->getSemester())
                                       ->where('tahun_ajaran', date('Y'))
                                       ->min('nilai_total') ?? 0,
        ];
        
        $semester = $this->getSemester();
        $tahunAjaran = date('Y');
        
        return view('pelatih.nilai.index', compact('anggotas', 'ekskul', 'statistik', 'semester', 'tahunAjaran'));
    }

    public function getSemester()
    {
        $bulan = date('n');
        if ($bulan >= 1 && $bulan <= 6) {
            return 'Genap';
        } else {
            return 'Ganjil';
        }
    }

    public function store(Request $request)
    {
        // ... store logic
        return redirect()->route('pelatih.nilai')
                         ->with('success', '✅ Nilai berhasil disimpan!');
    }

    public function export()
    {
        // ... export logic
    }
}