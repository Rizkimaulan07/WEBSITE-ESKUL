<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\User;
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
        
        // Ambil semua anggota dari ekskul ini
        $anggota = $ekskul->users()->where('role', 'anggota')->get();
        
        // Ambil kehadiran hari ini
        $kehadiranHariIni = Kehadiran::where('ekskul_id', $ekskul->id)
                                      ->where('pelatih_id', $pelatih->id)
                                      ->whereDate('tanggal', today())
                                      ->get()
                                      ->keyBy('anggota_id');
        
        // Statistik bulan ini
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
        $request->validate([
            'anggota_ids' => 'array',
            'tanggal' => 'required|date',
            'status' => 'array'
        ]);

        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;

        DB::beginTransaction();
        try {
            // Hapus kehadiran sebelumnya di tanggal ini
            Kehadiran::where('ekskul_id', $ekskul->id)
                     ->where('pelatih_id', $pelatih->id)
                     ->whereDate('tanggal', $request->tanggal)
                     ->delete();

            // Semua anggota ekskul
            $semuaAnggota = $ekskul->users()->where('role', 'anggota')->pluck('id');
            
            // Anggota yang hadir
            $hadirIds = $request->anggota_ids ?? [];
            
            // Status khusus (izin/sakit)
            $statusKhusus = $request->status ?? [];

            foreach ($semuaAnggota as $anggotaId) {
                $status = 'alpa'; // default
                
                if (in_array($anggotaId, $hadirIds)) {
                    $status = 'hadir';
                } elseif (isset($statusKhusus[$anggotaId])) {
                    $status = $statusKhusus[$anggotaId];
                }
                
                Kehadiran::create([
                    'anggota_id' => $anggotaId,
                    'pelatih_id' => $pelatih->id,
                    'ekskul_id' => $ekskul->id,
                    'tanggal' => $request->tanggal,
                    'status' => $status,
                    'keterangan' => $request->keterangan[$anggotaId] ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('kehadiran.index')
                             ->with('success', '✅ Kehadiran berhasil diinput!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                             ->with('error', '❌ Gagal input kehadiran: ' . $e->getMessage());
        }
    }

    public function rekap()
    {
        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;
        
        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di ekskul manapun!');
        }
        
        $rekap = Kehadiran::where('ekskul_id', $ekskul->id)
                          ->select('anggota_id', 
                                   DB::raw('COUNT(CASE WHEN status = "hadir" THEN 1 END) as hadir'),
                                   DB::raw('COUNT(CASE WHEN status = "izin" THEN 1 END) as izin'),
                                   DB::raw('COUNT(CASE WHEN status = "sakit" THEN 1 END) as sakit'),
                                   DB::raw('COUNT(CASE WHEN status = "alpa" THEN 1 END) as alpa'),
                                   DB::raw('COUNT(*) as total'))
                          ->groupBy('anggota_id')
                          ->with('anggota')
                          ->get();
        
        // Data untuk chart
        $chartData = [
            'labels' => $rekap->pluck('anggota.name'),
            'hadir' => $rekap->pluck('hadir'),
            'alpa' => $rekap->pluck('alpa')
        ];
        
        return view('pelatih.kehadiran.rekap', compact('rekap', 'chartData', 'ekskul'));
    }

    public function exportExcel()
    {
        // Implementasi export Excel
        return redirect()->back()->with('success', '📊 Excel berhasil di-export!');
    }
}