<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPelatih;
use App\Models\Kehadiran;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KehadiranPelatihController extends Controller
{
    /**
     * Tampilkan kehadiran pelatih untuk pelatih sendiri
     */
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

    /**
     * Tampilkan kehadiran pelatih untuk admin
     * Method ini digunakan untuk route admin.kehadiran_pelatih
     */
    public function adminIndex(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        [$year, $month] = array_pad(explode('-', $selectedMonth), 2, now()->month);

        // Query kehadiran pelatih dengan relasi pelatih dan ekskul
        $kehadiranQuery = KehadiranPelatih::with(['pelatih', 'ekskul'])
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'desc');

        $kehadiran = $kehadiranQuery->get();

        // Rekap per pelatih
        $rekapBulanan = KehadiranPelatih::with(['pelatih', 'ekskul'])
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get()
            ->groupBy('pelatih_id')
            ->map(function ($items) {
                $count = $items->count();
                $first = $items->first();
                
                return [
                    'pelatih' => $first->pelatih ?? null,
                    'ekskul' => $first->ekskul ?? null,
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

        // Statistik bulanan
        $statistikBulanan = [
            'total' => $kehadiran->count(),
            'hadir' => $kehadiran->where('status', 'hadir')->count(),
            'izin' => $kehadiran->where('status', 'izin')->count(),
            'sakit' => $kehadiran->where('status', 'sakit')->count(),
            'alpa' => $kehadiran->where('status', 'alpa')->count(),
        ];

        return view('admin.kehadiran_pelatih', compact(
            'kehadiran', 
            'rekapBulanan', 
            'statistikBulanan', 
            'selectedMonth'
        ));
    }

    /**
     * Rekap kehadiran anggota untuk pelatih
     * Gabungan rekap bulanan dan tahunan
     */
    public function rekap(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', 'all');
        
        // Get user dan ekskul
        $user = Auth::user();
        $ekskul = $user->ekskul;
        
        if (!$ekskul) {
            return redirect()->route('pelatih.dashboard')
                             ->with('error', 'Anda belum memiliki ekskul!');
        }
        
        // Get available years from data
        $availableYears = Kehadiran::where('ekskul_id', $ekskul->id)
            ->selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        if ($availableYears->isEmpty()) {
            $availableYears = collect(range(now()->year - 4, now()->year));
        }
        
        // Build query untuk rekap per anggota
        $query = Kehadiran::where('ekskul_id', $ekskul->id)
            ->whereYear('tanggal', $year);
        
        // Jika tidak memilih "Semua Bulan"
        if ($month != 'all') {
            $query->whereMonth('tanggal', $month);
        }
        
        // Get rekap data per anggota
        $rekap = $query->select(
                'anggota_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as hadir'),
                DB::raw('SUM(CASE WHEN status = "izin" THEN 1 ELSE 0 END) as izin'),
                DB::raw('SUM(CASE WHEN status = "sakit" THEN 1 ELSE 0 END) as sakit'),
                DB::raw('SUM(CASE WHEN status = "alpa" THEN 1 ELSE 0 END) as alpa'),
                DB::raw('AVG(nilai) as nilai_avg')
            )
            ->with('anggota')
            ->groupBy('anggota_id')
            ->get()
            ->map(function($item) {
                $item->persentase_hadir = $item->total > 0 
                    ? round(($item->hadir / $item->total) * 100, 2) 
                    : 0;
                return $item;
            });
        
        // Statistik
        $statistik = [
            'total' => $rekap->sum('total'),
            'hadir' => $rekap->sum('hadir'),
            'izin' => $rekap->sum('izin'),
            'sakit' => $rekap->sum('sakit'),
            'alpa' => $rekap->sum('alpa'),
        ];
        
        // Monthly summary (jika memilih semua bulan)
        $monthlySummary = null;
        if ($month == 'all') {
            $monthlySummary = Kehadiran::where('ekskul_id', $ekskul->id)
                ->whereYear('tanggal', $year)
                ->select(
                    DB::raw('MONTH(tanggal) as bulan'),
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as hadir'),
                    DB::raw('SUM(CASE WHEN status = "izin" THEN 1 ELSE 0 END) as izin'),
                    DB::raw('SUM(CASE WHEN status = "sakit" THEN 1 ELSE 0 END) as sakit'),
                    DB::raw('SUM(CASE WHEN status = "alpa" THEN 1 ELSE 0 END) as alpa')
                )
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();
        }
        
        return view('pelatih.kehadiran.rekap', compact(
            'year', 
            'month', 
            'rekap', 
            'statistik', 
            'availableYears', 
            'ekskul',
            'monthlySummary'
        ));
    }

    /**
     * Simpan kehadiran pelatih
     */
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