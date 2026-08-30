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

        // Tipe rekap: monthly atau yearly
        $type = $request->get('type', 'monthly');

        $ekskul = $user->ekskul;

        $anggota = User::where('role', 'anggota')
                       ->whereHas('ekskuls', function ($query) use ($ekskulId) {
                           $query->where('ekstrakurikulers.id', $ekskulId);
                       })
                       ->orderBy('name')
                       ->get();

        if ($type === 'yearly') {
            $selectedYear = (int) $request->get('year', now()->year);

            $rekap = $anggota->map(function ($a) use ($selectedYear, $ekskulId) {
                $hadir = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                  ->whereYear('tanggal', $selectedYear)
                                  ->where('status', 'hadir')
                                  ->count();

                $izin = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                 ->whereYear('tanggal', $selectedYear)
                                 ->where('status', 'izin')
                                 ->count();

                $sakit = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                  ->whereYear('tanggal', $selectedYear)
                                  ->where('status', 'sakit')
                                  ->count();

                $alpa = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                 ->whereYear('tanggal', $selectedYear)
                                 ->where('status', 'alpa')
                                 ->count();

                $total = $hadir + $izin + $sakit + $alpa;

                // Predikat nilai anggota terakhir untuk periode ini
                $nilaiTerakhir = NilaiAnggota::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                            ->whereYear('created_at', $selectedYear)
                            ->orderBy('created_at', 'desc')
                            ->first();

                $nilaiAvg = $nilaiTerakhir ? $nilaiTerakhir->predikat . ' (' . $nilaiTerakhir->predikat_label . ')' : null;

                return (object) [
                    'anggota' => $a,
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $total,
                    'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 1) : 0,
                    'nilai_avg' => $nilaiAvg,
                ];
            });

            $statistik = [
                'total' => $rekap->sum('total'),
                'hadir' => $rekap->sum('hadir'),
                'izin' => $rekap->sum('izin'),
                'sakit' => $rekap->sum('sakit'),
                'alpa' => $rekap->sum('alpa'),
            ];

            $selectedMonth = null;

        } else {
            $selectedMonth = $request->get('month', now()->format('Y-m'));
            [$year, $month] = array_pad(explode('-', $selectedMonth), 2, now()->month);

            $rekap = $anggota->map(function ($a) use ($month, $year, $ekskulId) {
                $hadir = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                  ->whereMonth('tanggal', $month)
                                  ->whereYear('tanggal', $year)
                                  ->where('status', 'hadir')
                                  ->count();

                $izin = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                 ->whereMonth('tanggal', $month)
                                 ->whereYear('tanggal', $year)
                                 ->where('status', 'izin')
                                 ->count();

                $sakit = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                  ->whereMonth('tanggal', $month)
                                  ->whereYear('tanggal', $year)
                                  ->where('status', 'sakit')
                                  ->count();

                $alpa = Kehadiran::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                                 ->whereMonth('tanggal', $month)
                                 ->whereYear('tanggal', $year)
                                 ->where('status', 'alpa')
                                 ->count();

                $total = $hadir + $izin + $sakit + $alpa;

                // Predikat nilai anggota terakhir untuk periode ini
                $nilaiTerakhir = NilaiAnggota::where('anggota_id', $a->id)->where('ekskul_id', $ekskulId)
                            ->whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->orderBy('created_at', 'desc')
                            ->first();

                $nilaiAvg = $nilaiTerakhir ? $nilaiTerakhir->predikat . ' (' . $nilaiTerakhir->predikat_label . ')' : null;

                return (object) [
                    'anggota' => $a,
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $total,
                    'persentase_hadir' => $total > 0 ? round(($hadir / $total) * 100, 1) : 0,
                    'nilai_avg' => $nilaiAvg,
                ];
            });

            $statistik = [
                'total' => $rekap->sum('total'),
                'hadir' => $rekap->sum('hadir'),
                'izin' => $rekap->sum('izin'),
                'sakit' => $rekap->sum('sakit'),
                'alpa' => $rekap->sum('alpa'),
            ];

            $selectedYear = (int) ($year ?? now()->year);
        }

        return view('pelatih.kehadiran.rekap', compact('rekap', 'ekskul', 'selectedMonth', 'statistik', 'type', 'selectedYear'));
    }

    public function adminIndex(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        [$year, $month] = array_pad(explode('-', $selectedMonth), 2, now()->month);

        $ekskulFilter = $request->get('eskul_id');

        $kehadiran = Kehadiran::with(['anggota', 'pelatih', 'ekskul'])
            ->when($ekskulFilter, function ($query) use ($ekskulFilter) {
                $query->where('ekskul_id', $ekskulFilter);
            })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'desc')
            ->get();

        $rekapBulanan = $kehadiran->groupBy('anggota_id')->map(function ($items) {
            $count = $items->count();
            $hadir = $items->where('status', 'hadir')->count();
            $izin = $items->where('status', 'izin')->count();
            $sakit = $items->where('status', 'sakit')->count();
            $alpa = $items->where('status', 'alpa')->count();

            return [
                'anggota' => $items->first()->anggota,
                'ekskul' => $items->first()->ekskul,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'total' => $count,
                'persentase_hadir' => $count > 0 ? round(($hadir / $count) * 100, 1) : 0,
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

        return view('admin.kehadiran_anggota', compact('kehadiran', 'rekapBulanan', 'statistikBulanan', 'selectedMonth', 'allEkskuls'));
    }

    public function adminExport(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        [$year, $month] = array_pad(explode('-', $selectedMonth), 2, now()->month);

        $ekskulFilter = $request->get('eskul_id');

        $kehadiran = Kehadiran::with(['anggota', 'ekskul'])
            ->when($ekskulFilter, function ($query) use ($ekskulFilter) {
                $query->where('ekskul_id', $ekskulFilter);
            })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $rekap = $kehadiran->groupBy('anggota_id')->map(function ($items) {
            $count = $items->count();
            return [
                'anggota' => $items->first()->anggota,
                'ekskul' => $items->first()->ekskul,
                'hadir' => $items->where('status', 'hadir')->count(),
                'izin' => $items->where('status', 'izin')->count(),
                'sakit' => $items->where('status', 'sakit')->count(),
                'alpa' => $items->where('status', 'alpa')->count(),
                'total' => $count,
                'persentase_hadir' => $count > 0 ? round(($items->where('status', 'hadir')->count() / $count) * 100, 1) : 0,
            ];
        })->values();

        $filename = 'kehadiran_anggota_' . $selectedMonth . '.xlsx';

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