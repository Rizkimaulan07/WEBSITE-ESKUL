<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPelatih;
use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehadiranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ekskul = $user->ekskul;

        // Jika tidak ada ekskul, tampilkan halaman dengan data kosong
        if (!$ekskul) {
            $kehadiranHariIni = null;
            $statistik = [
                'total' => 0,
                'hadir' => 0,
                'izin' => 0,
                'sakit' => 0,
                'alpa' => 0,
            ];
            $riwayat = collect([]);
            return view('pelatih.kehadiran', compact('kehadiranHariIni', 'statistik', 'riwayat', 'ekskul'))
                   ->with('error', 'Anda belum memiliki ekskul! Silakan hubungi admin.');
        }

        // Cek kehadiran pelatih hari ini
        $kehadiranHariIni = KehadiranPelatih::where('pelatih_id', $user->id)
                                            ->whereDate('tanggal', today())
                                            ->first();

        // Statistik kehadiran bulan ini
        $statistik = [
            'total' => KehadiranPelatih::where('pelatih_id', $user->id)
                                       ->whereMonth('tanggal', now()->month)
                                       ->count(),
            'hadir' => KehadiranPelatih::where('pelatih_id', $user->id)
                                       ->whereMonth('tanggal', now()->month)
                                       ->where('status', 'hadir')
                                       ->count(),
            'izin' => KehadiranPelatih::where('pelatih_id', $user->id)
                                      ->whereMonth('tanggal', now()->month)
                                      ->where('status', 'izin')
                                      ->count(),
            'sakit' => KehadiranPelatih::where('pelatih_id', $user->id)
                                       ->whereMonth('tanggal', now()->month)
                                       ->where('status', 'sakit')
                                       ->count(),
            'alpa' => KehadiranPelatih::where('pelatih_id', $user->id)
                                       ->whereMonth('tanggal', now()->month)
                                       ->where('status', 'alpa')
                                       ->count(),
        ];

        // Riwayat kehadiran
        $riwayat = KehadiranPelatih::where('pelatih_id', $user->id)
                                   ->orderBy('tanggal', 'desc')
                                   ->paginate(10);

        return view('pelatih.kehadiran', compact('kehadiranHariIni', 'statistik', 'riwayat', 'ekskul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'tanggal' => 'required|date'
        ]);

        $user = Auth::user();
        $ekskul = $user->ekskul;

        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum memiliki ekskul!');
        }

        // Cek apakah sudah ada kehadiran untuk tanggal ini
        $existing = KehadiranPelatih::where('pelatih_id', $user->id)
                                    ->whereDate('tanggal', $request->tanggal)
                                    ->first();

        if ($existing) {
            $existing->update([
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]);
            $message = '✅ Kehadiran berhasil diupdate!';
        } else {
            KehadiranPelatih::create([
                'pelatih_id' => $user->id,
                'ekskul_id' => $ekskul->id,
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]);
            $message = '✅ Kehadiran berhasil dicatat!';
        }

        return redirect()->route('pelatih.kehadiran')
                         ->with('success', $message);
    }

    public function rekap(Request $request)
    {
        $user = Auth::user();
        
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $riwayat = KehadiranPelatih::where('pelatih_id', $user->id)
                                   ->whereMonth('tanggal', $bulan)
                                   ->whereYear('tanggal', $tahun)
                                   ->orderBy('tanggal', 'desc')
                                   ->paginate(10);

        return view('pelatih.kehadiran_rekap', compact('riwayat', 'bulan', 'tahun'));
    }

    // ===== DETAIL KEHADIRAN =====
    public function show($id)
    {
        $user = Auth::user();
        
        // Ambil data kehadiran dengan relasi pelatih dan ekskul
        $kehadiran = KehadiranPelatih::with(['pelatih', 'ekskul'])
                                     ->where('pelatih_id', $user->id)
                                     ->findOrFail($id);
        
        return view('pelatih.kehadiran_detail', compact('kehadiran'));
    }
}