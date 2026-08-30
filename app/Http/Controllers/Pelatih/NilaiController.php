<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\NilaiAnggota;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Ekstrakurikuler;
use App\Exports\NilaiPelatihExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class NilaiController extends Controller
{
    public function index()
    {
        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;

        if (!$ekskul) {
            $anggotas = collect([]);
            $statistik = [
                'total' => 0,
                's' => 0,
                'a' => 0,
                'b' => 0,
            ];
            $semester = $this->getSemester();
            $tahunAjaran = date('Y');
            
            return view('pelatih.nilai.index', compact('anggotas', 'ekskul', 'statistik', 'semester', 'tahunAjaran'))
                   ->with('error', 'Anda belum terdaftar di ekskul manapun!');
        }

        // Hanya ambil anggota yang mengikuti ekskul pelatih ini
        $anggotas = User::where('role', 'anggota')
                        ->whereHas('ekskuls', function ($query) use ($ekskul) {
                            $query->where('ekstrakurikulers.id', $ekskul->id);
                        })
                        ->where(function ($query) use ($pelatih) {
                            $query->where('pelatih_id', $pelatih->id)
                                  ->orWhereNull('pelatih_id');
                        })
                        ->orderBy('name')
                        ->get();

        foreach ($anggotas as $anggota) {
            $anggota->nilai = NilaiAnggota::where('anggota_id', $anggota->id)
                                          ->where('pelatih_id', $pelatih->id)
                                          ->where('ekskul_id', $ekskul->id)
                                          ->first();
            
            $anggota->kehadiran = Kehadiran::where('anggota_id', $anggota->id)
                                           ->where('ekskul_id', $ekskul->id)
                                           ->whereDate('tanggal', today())
                                           ->first();
        }

        // Statistik predikat (huruf S/A/B)
        $nilaiQuery = NilaiAnggota::where('pelatih_id', $pelatih->id)
                                  ->where('ekskul_id', $ekskul->id);

        $statistik = [
            'total' => $nilaiQuery->count(),
            's' => (clone $nilaiQuery)->where('predikat', 'S')->count(),
            'a' => (clone $nilaiQuery)->where('predikat', 'A')->count(),
            'b' => (clone $nilaiQuery)->where('predikat', 'B')->count(),
        ];

        $semester = $this->getSemester();
        $tahunAjaran = date('Y');

        return view('pelatih.nilai.index', compact('anggotas', 'ekskul', 'statistik', 'semester', 'tahunAjaran'));
    }

    public function getSemester()
    {
        $bulan = date('n');
        return ($bulan >= 1 && $bulan <= 6) ? 'Genap' : 'Ganjil';
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:users,id',
            'predikat' => 'required|in:S,A,B',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;

        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum memiliki ekskul!');
        }

        // Cek apakah anggota ini mengikuti ekskul pelatih dan di bawah naungannya
        $anggota = User::where('id', $request->anggota_id)
                       ->where('role', 'anggota')
                       ->whereHas('ekskuls', function ($query) use ($ekskul) {
                           $query->where('ekstrakurikulers.id', $ekskul->id);
                       })
                       ->where(function ($query) use ($pelatih) {
                           $query->where('pelatih_id', $pelatih->id)
                                 ->orWhereNull('pelatih_id');
                       })
                       ->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan atau bukan anggota Anda!');
        }

        $existing = NilaiAnggota::where('anggota_id', $request->anggota_id)
                                ->where('pelatih_id', $pelatih->id)
                                ->where('ekskul_id', $ekskul->id)
                                ->first();

        if ($existing) {
            $existing->update([
                'predikat' => $request->predikat,
                'nilai_total' => 0,
                'catatan' => $request->catatan
            ]);
            $message = '✅ Nilai berhasil diupdate!';
        } else {
            NilaiAnggota::create([
                'anggota_id' => $request->anggota_id,
                'pelatih_id' => $pelatih->id,
                'ekskul_id' => $ekskul->id,
                'predikat' => $request->predikat,
                'nilai_total' => 0,
                'catatan' => $request->catatan,
                'semester' => $this->getSemester(),
                'tahun_ajaran' => date('Y')
            ]);
            $message = '✅ Nilai berhasil ditambahkan!';
        }

        return redirect()->route('pelatih.nilai')->with('success', $message);
    }

    public function storeKehadiran(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:users,id',
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string|max:255'
        ]);

        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;

        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum memiliki ekskul!');
        }

        // Cek apakah anggota ini mengikuti ekskul pelatih dan di bawah naungannya
        $anggota = User::where('id', $request->anggota_id)
                       ->where('role', 'anggota')
                       ->whereHas('ekskuls', function ($query) use ($ekskul) {
                           $query->where('ekstrakurikulers.id', $ekskul->id);
                       })
                       ->where(function ($query) use ($pelatih) {
                           $query->where('pelatih_id', $pelatih->id)
                                 ->orWhereNull('pelatih_id');
                       })
                       ->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan atau bukan anggota Anda!');
        }

        $existing = Kehadiran::where('anggota_id', $request->anggota_id)
                             ->where('ekskul_id', $ekskul->id)
                             ->whereDate('tanggal', today())
                             ->first();

        if ($existing) {
            $existing->update([
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'ekskul_id' => $ekskul->id,
                'pelatih_id' => $pelatih->id,
            ]);
            $message = '✅ Kehadiran berhasil diupdate!';
        } else {
            Kehadiran::create([
                'anggota_id' => $request->anggota_id,
                'pelatih_id' => $pelatih->id,
                'ekskul_id' => $ekskul->id,
                'tanggal' => today(),
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]);
            $message = '✅ Kehadiran berhasil dicatat!';
        }

        return redirect()->route('pelatih.nilai')->with('success', $message);
    }

    public function export()
    {
        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;

        if (!$ekskul) {
            return redirect()->route('pelatih.nilai')->with('error', 'Anda belum memiliki ekskul!');
        }

        $anggotas = User::where('role', 'anggota')
                        ->whereHas('ekskuls', function ($query) use ($ekskul) {
                            $query->where('ekstrakurikulers.id', $ekskul->id);
                        })
                        ->where(function ($query) use ($pelatih) {
                            $query->where('pelatih_id', $pelatih->id)
                                  ->orWhereNull('pelatih_id');
                        })
                        ->orderBy('name')
                        ->get();

        foreach ($anggotas as $anggota) {
            $anggota->nilai = NilaiAnggota::where('anggota_id', $anggota->id)
                                          ->where('pelatih_id', $pelatih->id)
                                          ->where('ekskul_id', $ekskul->id)
                                          ->first();
        }

        $filename = 'nilai_anggota_' . $ekskul->nama_ekskul . '_' . date('Ymd_His') . '.xlsx';

        return Excel::download(new NilaiPelatihExport($anggotas), $filename);
    }
}