<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\NilaiAnggota;
use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                'rata_rata' => 0,
                'tertinggi' => 0,
                'terendah' => 0,
            ];
            $semester = $this->getSemester();
            $tahunAjaran = date('Y');
            
            return view('pelatih.nilai.index', compact('anggotas', 'ekskul', 'statistik', 'semester', 'tahunAjaran'))
                   ->with('error', 'Anda belum terdaftar di ekskul manapun!');
        }

        // Ambil semua anggota dari ekskul yang sama
        $anggotas = User::where('role', 'anggota')
                        ->where('ekskul_id', $ekskul->id)
                        ->orderBy('name')
                        ->get();

        // Ambil nilai untuk setiap anggota
        foreach ($anggotas as $anggota) {
            $anggota->nilai = NilaiAnggota::where('anggota_id', $anggota->id)
                                          ->where('pelatih_id', $pelatih->id)
                                          ->where('ekskul_id', $ekskul->id)
                                          ->first();
            
            // Ambil kehadiran hari ini
            $anggota->kehadiran = Kehadiran::where('anggota_id', $anggota->id)
                                           ->whereDate('tanggal', today())
                                           ->first();
        }

        // Statistik Nilai
        $nilaiQuery = NilaiAnggota::where('pelatih_id', $pelatih->id)
                                  ->where('ekskul_id', $ekskul->id);

        $statistik = [
            'total' => $nilaiQuery->count(),
            'rata_rata' => $nilaiQuery->avg('nilai_total') ?? 0,
            'tertinggi' => $nilaiQuery->max('nilai_total') ?? 0,
            'terendah' => $nilaiQuery->min('nilai_total') ?? 0,
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
            'nilai' => 'required|in:A,B,C,D,E',
            'keterangan' => 'nullable|string|max:255'
        ]);

        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;

        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum memiliki ekskul!');
        }

        // Cek anggota
        $anggota = User::where('id', $request->anggota_id)
                       ->where('role', 'anggota')
                       ->where('ekskul_id', $ekskul->id)
                       ->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan!');
        }

        // Konversi nilai ke angka
        $nilaiMap = ['A' => 90, 'B' => 80, 'C' => 70, 'D' => 60, 'E' => 50];
        $nilaiTotal = $nilaiMap[$request->nilai] ?? 70;

        // Cek existing
        $existing = NilaiAnggota::where('anggota_id', $request->anggota_id)
                                ->where('pelatih_id', $pelatih->id)
                                ->where('ekskul_id', $ekskul->id)
                                ->first();

        if ($existing) {
            $existing->update([
                'nilai_kehadiran' => 0,
                'nilai_keterampilan' => 0,
                'nilai_sikap' => 0,
                'nilai_total' => $nilaiTotal,
                'catatan' => $request->keterangan
            ]);
            $message = '✅ Nilai berhasil diupdate!';
        } else {
            NilaiAnggota::create([
                'anggota_id' => $request->anggota_id,
                'pelatih_id' => $pelatih->id,
                'ekskul_id' => $ekskul->id,
                'nilai_kehadiran' => 0,
                'nilai_keterampilan' => 0,
                'nilai_sikap' => 0,
                'nilai_total' => $nilaiTotal,
                'catatan' => $request->keterangan,
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
            'status' => 'required|in:hadir,izin,sakit,alpa'
        ]);

        $pelatih = Auth::user();
        $ekskul = $pelatih->ekskul;

        if (!$ekskul) {
            return redirect()->back()->with('error', 'Anda belum memiliki ekskul!');
        }

        $anggota = User::where('id', $request->anggota_id)
                       ->where('role', 'anggota')
                       ->where('ekskul_id', $ekskul->id)
                       ->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan!');
        }

        // Cek existing kehadiran hari ini
        $existing = Kehadiran::where('anggota_id', $request->anggota_id)
                             ->whereDate('tanggal', today())
                             ->first();

        if ($existing) {
            $existing->update([
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]);
            $message = '✅ Kehadiran berhasil diupdate!';
        } else {
            Kehadiran::create([
                'anggota_id' => $request->anggota_id,
                'pelatih_id' => $pelatih->id,
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
        return redirect()->route('pelatih.nilai')
                         ->with('info', 'Fitur export sedang dalam pengembangan');
    }
}