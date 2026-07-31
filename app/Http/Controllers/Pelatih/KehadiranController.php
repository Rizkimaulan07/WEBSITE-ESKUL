<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KehadiranController extends Controller
{
    public function index()
    {
        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;
        
        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di ekskul manapun!');
        }
        
        $anggota = $ekskul->users()->where('role', 'anggota')->get();
        
        $kehadiranHariIni = Kehadiran::where('ekskul_id', $ekskul->id)
                                      ->where('pelatih_id', $pelatih->id)
                                      ->whereDate('tanggal', today())
                                      ->get()
                                      ->keyBy('anggota_id');
        
        $statistik = [
            'total' => Kehadiran::where('ekskul_id', $ekskul->id)
                               ->whereMonth('tanggal', now()->month)
                               ->count(),
            'hadir' => Kehadiran::where('ekskul_id', $ekskul->id)
                               ->where('status', 'hadir')
                               ->whereMonth('tanggal', now()->month)
                               ->count(),
        ];
        
        return view('pelatih.kehadiran.index', compact('anggota', 'kehadiranHariIni', 'ekskul', 'statistik'));
    }

    public function store(Request $request)
    {
        // ... store logic
    }

    public function rekap()
    {
        // ... rekap logic
    }
}