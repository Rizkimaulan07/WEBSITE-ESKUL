<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Ekstrakurikuler;
use App\Models\NilaiAnggota;
use App\Exports\KehadiranAnggotaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class KehadiranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ekskulId = $user->ekskul_id;

        // Jika tidak ada ekskul
        if (!$ekskulId) {
            return redirect()->route('pelatih.dashboard')
                             ->with('error', 'Anda belum memiliki ekskul! Silakan hubungi admin.');
        }

        // Ambil semua anggota yang mengikuti ekskul ini (multi-ekskul via pivot)
        $anggota = User::where('role', 'anggota')
                       ->whereHas('ekskuls', function ($query) use ($ekskulId) {
                           $query->where('ekstrakurikulers.id', $ekskulId);
                       })
                       ->orderBy('name')
                       ->get();

        // Ambil kehadiran hari ini untuk anggota ekskul ini
        $kehadiranHariIni = Kehadiran::where('ekskul_id', $ekskulId)
                                     ->whereDate('tanggal', today())
                                     ->get()
                                     ->keyBy('anggota_id');

        // Statistik kehadiran bulan ini
        $statistik = [
            'total' => Kehadiran::where('ekskul_id', $ekskulId)->whereMonth('tanggal', date('m'))->count(),
            'hadir' => Kehadiran::where('ekskul_id', $ekskulId)->whereMonth('tanggal', date('m'))->where('status', 'hadir')->count(),
            'izin' => Kehadiran::where('ekskul_id', $ekskulId)->whereMonth('tanggal', date('m'))->where('status', 'izin')->count(),
            'sakit' => Kehadiran::where('ekskul_id', $ekskulId)->whereMonth('tanggal', date('m'))->where('status', 'sakit')->count(),
            'alpa' => Kehadiran::where('ekskul_id', $ekskulId)->whereMonth('tanggal', date('m'))->where('status', 'alpa')->count(),
        ];

        $ekskul = $user->ekskul;

        return view('pelatih.kehadiran.index', compact('anggota', 'kehadiranHariIni', 'statistik', 'ekskul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_ids' => 'required|array',
            'anggota_ids.*' => 'exists:users,id',
            'status' => 'nullable|array',
            'keterangan' => 'nullable|array',
        ]);

        $user = Auth::user();
        $ekskulId = $user->ekskul_id;

        if (!$ekskulId) {
            return redirect()->back()->with('error', 'Anda belum memiliki ekskul!');
        }

        $anggotaIds = $request->input('anggota_ids', []);

        if (empty($anggotaIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu anggota untuk mencatat kehadiran.');
        }

        foreach ($anggotaIds as $anggotaId) {
            $anggota = User::where('id', $anggotaId)
                ->where('role', 'anggota')
                ->whereHas('ekskuls', function ($query) use ($ekskulId) {
                    $query->where('ekstrakurikulers.id', $ekskulId);
                })
                ->first();

            if (!$anggota) {
                continue;
            }

            $status = 'hadir';
            if ($request->has("status.$anggotaId") && $request->input("status.$anggotaId") !== 'hadir') {
                $status = $request->input("status.$anggotaId");
            }

            $keterangan = $request->input("keterangan.$anggotaId");

            $existing = Kehadiran::where('anggota_id', $anggotaId)
                ->whereDate('tanggal', today())
                ->first();

            if ($existing) {
                $existing->update([
                    'status' => $status,
                    'keterangan' => $keterangan,
                    'pelatih_id' => $user->id,
                    'ekskul_id' => $ekskulId,
                ]);
            } else {
                Kehadiran::create([
                    'anggota_id' => $anggotaId,
                    'pelatih_id' => $user->id,
                    'ekskul_id' => $ekskulId,
                    'tanggal' => today(),
                    'status' => $status,
                    'keterangan' => $keterangan,
                ]);
            }
        }

        return redirect()->route('pelatih.kehadiran')->with('success', '✅ Kehadiran berhasil disimpan!');
    }

    public function rekap(Request $request)
    {
        $user = Auth::user();
        $ekskulId = $user->ekskul_id;

        if (!$ekskulId) {
            return redirect()->route('pelatih.dashboard')
                             ->with('error', 'Anda belum memiliki ekskul!');
        }

        // Tipe rekap: monthly | semester | yearly
        $type = $request->get('type', 'monthly');
        $year = (int) $request->get('year', now()->year);
        $month = $request->get('month', 'all');
        $semester = $request->get('semester', self::semesterOf(now()->month));

        $ekskul = $user->ekskul;
        $availableYears = $this->availableYears($ekskulId);

        // Query jembatan query per anggota -> status counts
        $buildRekap = function (?array $monthRange) use ($ekskulId, $year) {
            $anggota = User::where('role', 'anggota')
                           ->whereHas('ekskuls', function ($query) use ($ekskulId) {
                               $query->where('ekstrakurikulers.id', $ekskulId);
                           })
                           ->orderBy('name')
                           ->get();

            return $anggota->map(function ($a) use ($monthRange, $year, $ekskulId) {
                $query = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                  ->whereYear('tanggal', $year);

                if ($monthRange) {
                    $query->whereIn(\DB::raw('MONTH(tanggal)'), $monthRange);
                }

                $hadir = (clone $query)->where('status', 'hadir')->count();
                $izin = (clone $query)->where('status', 'izin')->count();
                $sakit = (clone $query)->where('status', 'sakit')->count();
                $alpa = (clone $query)->where('status', 'alpa')->count();
                $total = $hadir + $izin + $sakit + $alpa;

                return (object) [
                    'anggota' => $a,
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $total,
                    'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 1) : 0,
                ];
            });
        };

        $monthRange = null; // null = seluruh tahun
        $periodLabel = 'Tahunan';

        if ($type === 'monthly') {
            if ($month !== 'all') {
                $monthNum = (int) $month;
                $monthRange = [$monthNum];
                $periodLabel = self::SELF_MONTH_NAMES[$monthNum] ?? ('Bulan ' . $month);
            } else {
                $periodLabel = 'Semua Bulan';
            }
        } elseif ($type === 'semester') {
            $monthRange = $semester === 'genap' ? range(1, 6) : range(7, 12);
            $periodLabel = $semester === 'genap' ? 'Semester Genap' : 'Semester Ganjil';
        }

        $rekap = $buildRekap($monthRange)->filter(function ($r) {
            return $r->total > 0;
        })->values();

        $statistik = [
            'total' => $rekap->sum('total'),
            'hadir' => $rekap->sum('hadir'),
            'izin' => $rekap->sum('izin'),
            'sakit' => $rekap->sum('sakit'),
            'alpa' => $rekap->sum('alpa'),
        ];

        // Ringkasan per bulan (ditampilkan saat tahunan / semua bulan)
        $monthlySummary = $this->monthlySummary($ekskulId, $year);

        $rekapLabel = $type === 'monthly' && $month === 'all' ? 'Semua Bulan' : ($type === 'monthly' ? 'Bulanan' : ($type === 'semester' ? $periodLabel : 'Tahunan'));

        return view('pelatih.kehadiran.rekap', compact(
            'rekap', 'ekskul', 'statistik', 'type', 'year', 'month', 'semester',
            'availableYears', 'periodLabel', 'monthlySummary', 'rekapLabel'
        ));
    }

    public function rekapExport(Request $request)
    {
        $user = Auth::user();
        $ekskulId = $user->ekskul_id;

        if (!$ekskulId) {
            abort(403, 'Anda belum memiliki ekskul!');
        }

        $type = $request->get('type', 'monthly');
        $year = (int) $request->get('year', now()->year);
        $month = $request->get('month', 'all');
        $semester = $request->get('semester', self::semesterOf(now()->month));

        $ekskul = $user->ekskul;
        $buildRekap = function (?array $monthRange) use ($ekskulId, $year, $ekskul) {
            $anggota = User::where('role', 'anggota')
                           ->whereHas('ekskuls', function ($query) use ($ekskulId) {
                               $query->where('ekstrakurikulers.id', $ekskulId);
                           })
                           ->orderBy('name')
                           ->get();

            return $anggota->map(function ($a) use ($monthRange, $year, $ekskulId, $ekskul) {
                $query = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                  ->whereYear('tanggal', $year);

                if ($monthRange) {
                    $query->whereIn(\DB::raw('MONTH(tanggal)'), $monthRange);
                }

                $hadir = (clone $query)->where('status', 'hadir')->count();
                $izin = (clone $query)->where('status', 'izin')->count();
                $sakit = (clone $query)->where('status', 'sakit')->count();
                $alpa = (clone $query)->where('status', 'alpa')->count();
                $total = $hadir + $izin + $sakit + $alpa;

                return [
                    'anggota' => $a,
                    'ekskul' => $ekskul,
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $total,
                    'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 1) : 0,
                ];
            })->filter(function ($r) {
                return $r['total'] > 0;
            })->values();
        };

        $monthRange = null;
        if ($type === 'monthly') {
            if ($month !== 'all') {
                $monthRange = [(int) $month];
            }
        } elseif ($type === 'semester') {
            $monthRange = $semester === 'genap' ? range(1, 6) : range(7, 12);
        }

        $rekap = $buildRekap($monthRange);

        $suffix = $type === 'yearly' ? 'tahunan_' . $year : ($type === 'semester' ? 'semester_' . $semester . '_' . $year : ($month === 'all' ? 'semua_bulan_' . $year : sprintf('%04d-%02d', $year, (int) $month)));

        $filename = 'kehadiran_anggota_' . str_replace(' ', '_', $ekskul->nama_ekskul ?? 'ekskul') . '_' . $suffix . '.xlsx';

        return Excel::download(new KehadiranAnggotaExport($rekap), $filename);
    }

    private const SELF_MONTH_NAMES = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public static function semesterOf(int $month): string
    {
        return in_array($month, range(7, 12), true) ? 'ganjil' : 'genap';
    }

    private function availableYears(?int $ekskulId = null): array
    {
        $years = Kehadiran::when($ekskulId, function ($query) use ($ekskulId) {
                $query->where('ekskul_id', $ekskulId);
            })
            ->selectRaw('YEAR(tanggal) as year')
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

    private function semesterSummaryAll(?int $ekskulId, int $year): array
    {
        $monthly = $this->monthlySummary($ekskulId, $year);

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

    private function monthlySummary(?int $ekskulId, int $year): array
    {
        $rows = Kehadiran::when($ekskulId, function ($query) use ($ekskulId) {
                $query->where('ekskul_id', $ekskulId);
            })
            ->whereYear('tanggal', $year)
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

        return $rows;
    }

    public function adminIndex(Request $request)
    {
        $type = $request->get('type', 'monthly');
        $year = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);
        $semester = in_array($request->get('semester', 'ganjil'), ['ganjil', 'genap'], true) ? $request->get('semester') : 'ganjil';
        $ekskulFilter = $request->get('eskul_id');

        $query = Kehadiran::with(['anggota', 'pelatih', 'ekskul'])
            ->when($ekskulFilter, function ($q) use ($ekskulFilter) {
                $q->where('ekskul_id', $ekskulFilter);
            });

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

        $rekapBulanan = $kehadiran->groupBy('anggota_id')->map(function ($items) {
            $count = $items->count();
            $first = $items->first();

            return [
                'anggota' => $first->anggota ?? null,
                'ekskul' => $first->ekskul ?? null,
                'hadir' => $items->where('status', 'hadir')->count(),
                'izin' => $items->where('status', 'izin')->count(),
                'sakit' => $items->where('status', 'sakit')->count(),
                'alpa' => $items->where('status', 'alpa')->count(),
                'total' => $count,
                'persentase_hadir' => $count > 0 ? round(($items->where('status', 'hadir')->count() / $count) * 100, 1) : 0,
            ];
        })->values()->sortByDesc('hadir')->values();

        $statistikBulanan = [
            'total' => $kehadiran->count(),
            'hadir' => $kehadiran->where('status', 'hadir')->count(),
            'izin' => $kehadiran->where('status', 'izin')->count(),
            'sakit' => $kehadiran->where('status', 'sakit')->count(),
            'alpa' => $kehadiran->where('status', 'alpa')->count(),
        ];

        $allEkskuls = Ekstrakurikuler::orderBy('nama_ekskul')->get();
        $monthlySummary = $this->monthlySummary($ekskulFilter ? (int) $ekskulFilter : null, $year);
        $semesterSummary = $this->semesterSummaryAll($ekskulFilter ? (int) $ekskulFilter : null, $year);
        $availableYears = $this->availableYears($ekskulFilter ? (int) $ekskulFilter : null);

        return view('admin.kehadiran_anggota', compact(
            'kehadiran', 'rekapBulanan', 'statistikBulanan', 'allEkskuls',
            'type', 'year', 'month', 'semester', 'ekskulFilter', 'periodLabel',
            'monthlySummary', 'semesterSummary', 'availableYears'
        ));
    }

    public function adminExport(Request $request)
    {
        $type = $request->get('type', 'monthly');
        $year = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);
        $semester = in_array($request->get('semester', 'ganjil'), ['ganjil', 'genap'], true) ? $request->get('semester') : 'ganjil';
        $ekskulFilter = $request->get('eskul_id');

        $query = Kehadiran::with(['anggota', 'ekskul'])
            ->when($ekskulFilter, function ($q) use ($ekskulFilter) {
                $q->where('ekskul_id', $ekskulFilter);
            });

        if ($type === 'semester') {
            $months = $semester === 'genap' ? range(1, 6) : range(7, 12);
            $query->whereYear('tanggal', $year)->whereIn(\DB::raw('MONTH(tanggal)'), $months);
        } elseif ($type === 'yearly') {
            $query->whereYear('tanggal', $year);
        } else {
            $query->whereYear('tanggal', $year)->whereMonth('tanggal', $month);
        }

        $kehadiran = $query->get();

        $rekap = $kehadiran->groupBy('anggota_id')->map(function ($items) {
            $count = $items->count();
            $first = $items->first();

            return [
                'anggota' => $first->anggota ?? null,
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

        $filename = 'kehadiran_anggota_' . $suffix . '.xlsx';

        return Excel::download(new KehadiranAnggotaExport($rekap), $filename);
    }

    public function show(int $id)
    {
        $user = Auth::user();
        $ekskulId = $user->ekskul_id;

        // Cek apakah kehadiran ini milik ekskul pelatih
        $kehadiran = Kehadiran::where('id', $id)
                              ->where('ekskul_id', $ekskulId)
                              ->with(['anggota', 'pelatih'])
                              ->firstOrFail();

        return view('pelatih.kehadiran.show', compact('kehadiran'));
    }
}