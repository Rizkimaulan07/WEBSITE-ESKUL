<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPelatih;use App\Exports\KehadiranPelatihExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $type = $request->get('type', 'monthly');
        $year = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);
        $semester = in_array($request->get('semester', 'ganjil'), ['ganjil', 'genap'], true) ? $request->get('semester') : 'ganjil';

        // Bangun filter berdasarkan tipe rekap
        $query = KehadiranPelatih::with(['pelatih', 'ekskul']);

        if ($type === 'semester') {
            $months = $semester === 'genap' ? range(1, 6) : range(7, 12);
            $query->whereYear('tanggal', $year)->whereIn(\DB::raw('MONTH(tanggal)'), $months);
            $periodLabel = $semester === 'genap' ? 'Semester Genap (Jan-Jun)' : 'Semester Ganjil (Jul-Des)';
        } elseif ($type === 'yearly') {
            $query->whereYear('tanggal', $year);
            $periodLabel = 'Tahunan ' . $year;
        } else {
            $query->whereYear('tanggal', $year)->whereMonth('tanggal', $month);
            $periodLabel = \Carbon\Carbon::create()->month($month)->translatedFormat('F') . ' ' . $year;
        }

        $kehadiran = $query->orderBy('tanggal', 'desc')->get();

        // Rekap per pelatih
        $rekapBulanan = $kehadiran->groupBy('pelatih_id')
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

        // Statistik
        $statistikBulanan = [
            'total' => $kehadiran->count(),
            'hadir' => $kehadiran->where('status', 'hadir')->count(),
            'izin' => $kehadiran->where('status', 'izin')->count(),
            'sakit' => $kehadiran->where('status', 'sakit')->count(),
            'alpa' => $kehadiran->where('status', 'alpa')->count(),
        ];

        // Ringkasan per bulan (populer untuk tipe tahunan)
        $monthlySummary = $this->monthlySummary($year);

        // Ringkasan per semester (tahunan)
        $semesterSummary = $this->semesterSummary($year);

        $availableYears = $this->availableYears();

        return view('admin.kehadiran_pelatih', compact(
            'kehadiran',
            'rekapBulanan',
            'statistikBulanan',
            'type',
            'year',
            'month',
            'semester',
            'periodLabel',
            'monthlySummary',
            'semesterSummary',
            'availableYears'
        ));
    }

    private function availableYears(): array
    {
        $years = KehadiranPelatih::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->map(fn ($y) => (int) $y)
            ->toArray();

        if (empty($years)) {
            $years = range(now()->year - 4, now()->year);
        }

        return array_values(array_unique(array_merge($years, [now()->year])));
    }

    private function monthlySummary(int $year): array
    {
        return KehadiranPelatih::whereYear('tanggal', $year)
            ->selectRaw('MONTH(tanggal) as bulan')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir")
            ->selectRaw("SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin")
            ->selectRaw("SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit")
            ->selectRaw("SUM(CASE WHEN status = 'alpa' THEN 1 ELSE 0 END) as alpa")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan')
            ->toArray();
    }

    private function semesterSummary(int $year): array
    {
        $monthly = $this->monthlySummary($year);

        $build = function (array $range) use ($monthly) {
            $hadir = $izin = $sakit = $alpa = 0;
            foreach ($monthly as $bulanNum => $m) {
                if (in_array((int) $bulanNum, $range, true)) {
                    $hadir += (int) $m['hadir'];
                    $izin += (int) $m['izin'];
                    $sakit += (int) $m['sakit'];
                    $alpa += (int) $m['alpa'];
                }
            }
            $total = $hadir + $izin + $sakit + $alpa;
            return compact('hadir', 'izin', 'sakit', 'alpa', 'total');
        };

        return [
            'ganjil' => $build(range(7, 12)),
            'genap' => $build(range(1, 6)),
        ];
    }

    public function adminExport(Request $request)
    {
        $type = $request->get('type', 'monthly');
        $year = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);
        $semester = in_array($request->get('semester', 'ganjil'), ['ganjil', 'genap'], true) ? $request->get('semester') : 'ganjil';

        $query = KehadiranPelatih::with(['pelatih', 'ekskul']);

        if ($type === 'semester') {
            $months = $semester === 'genap' ? range(1, 6) : range(7, 12);
            $query->whereYear('tanggal', $year)->whereIn(\DB::raw('MONTH(tanggal)'), $months);
        } elseif ($type === 'yearly') {
            $query->whereYear('tanggal', $year);
        } else {
            $query->whereYear('tanggal', $year)->whereMonth('tanggal', $month);
        }

        $kehadiran = $query->get();

        $rekap = $kehadiran->groupBy('pelatih_id')->map(function ($items) {
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
        })->values();

        $suffix = $type === 'yearly' ? 'tahunan_' . $year : ($type === 'semester' ? 'semester_' . $semester . '_' . $year : sprintf('%04d-%02d', $year, $month));

        $filename = 'kehadiran_pelatih_' . $suffix . '.xlsx';

        return Excel::download(new KehadiranPelatihExport($rekap), $filename);
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