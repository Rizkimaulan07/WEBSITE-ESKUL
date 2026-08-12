<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPelatih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehadiranPelatihController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ekskul = $user->ekskul;

        // Jika tidak ada ekskul
        if (!$ekskul) {
            return redirect()->route('pelatih.dashboard')
                             ->with('error', 'Anda belum memiliki ekskul!');
        }

        // Cek kehadiran pelatih hari ini
        $kehadiranHariIni = KehadiranPelatih::where('pelatih_id', $user->id)
                                            ->whereDate('tanggal', today())
                                            ->first();

        // Statistik kehadiran pelatih
        $statistik = [
            'total' => KehadiranPelatih::where('pelatih_id', $user->id)->count(),
            'hadir' => KehadiranPelatih::where('pelatih_id', $user->id)->where('status', 'hadir')->count(),
            'izin' => KehadiranPelatih::where('pelatih_id', $user->id)->where('status', 'izin')->count(),
            'sakit' => KehadiranPelatih::where('pelatih_id', $user->id)->where('status', 'sakit')->count(),
            'alpa' => KehadiranPelatih::where('pelatih_id', $user->id)->where('status', 'alpa')->count(),
        ];

        // Riwayat kehadiran
        $riwayat = KehadiranPelatih::where('pelatih_id', $user->id)
                                   ->orderBy('tanggal', 'desc')
                                   ->paginate(10);

        return view('pelatih.kehadiran_pelatih', compact('kehadiranHariIni', 'statistik', 'riwayat', 'ekskul'));
    }

    public function adminIndex(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        [$year, $month] = array_pad(explode('-', $selectedMonth), 2, now()->month);

        $kehadiranQuery = KehadiranPelatih::with(['pelatih', 'ekskul'])
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'desc');

        $kehadiran = $kehadiranQuery->get();

        $rekapBulanan = KehadiranPelatih::with(['pelatih', 'ekskul'])
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get()
            ->groupBy('pelatih_id')
            ->map(function ($items) {
                $count = $items->count();

                return [
                    'pelatih' => $items->first()->pelatih,
                    'ekskul' => $items->first()->ekskul,
                    'hadir' => $items->where('status', 'hadir')->count(),
                    'izin' => $items->where('status', 'izin')->count(),
                    'sakit' => $items->where('status', 'sakit')->count(),
                    'alpa' => $items->where('status', 'alpa')->count(),
                    'total' => $count,
                    'persentase_hadir' => $count > 0 ? round(($items->where('status', 'hadir')->count() / $count) * 100, 1) : 0,
                ];
            })
            ->values()
            ->sortByDesc('hadir')
            ->values();

        $statistikBulanan = [
            'total' => $kehadiran->count(),
            'hadir' => $kehadiran->where('status', 'hadir')->count(),
            'izin' => $kehadiran->where('status', 'izin')->count(),
            'sakit' => $kehadiran->where('status', 'sakit')->count(),
            'alpa' => $kehadiran->where('status', 'alpa')->count(),
        ];

        return view('admin.kehadiran_pelatih', compact('kehadiran', 'rekapBulanan', 'statistikBulanan', 'selectedMonth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string|max:255'
        ]);

        $user = Auth::user();
        $ekskul = $user->ekskul;

        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum memiliki ekskul!');
        }

        // Cek apakah sudah ada kehadiran hari ini
        $existing = KehadiranPelatih::where('pelatih_id', $user->id)
                                    ->whereDate('tanggal', today())
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
                'tanggal' => today(),
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]);
            $message = '✅ Kehadiran berhasil dicatat!';
        }

        return redirect()->route('pelatih.kehadiran_pelatih')
                         ->with('success', $message);
    }
}