<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NilaiAnggota;
use App\Models\Ekstrakurikuler;
use App\Exports\NilaiAnggotaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = NilaiAnggota::query()->with(['anggota', 'ekskul', 'pelatih']);

        if ($request->filled('ekskul_id')) {
            $query->where('ekskul_id', $request->ekskul_id);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('anggota', function ($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                  ->orWhere('kelas', 'like', "%{$cari}%");
            });
        }

        $nilai = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        $ekskuls = Ekstrakurikuler::orderBy('nama_ekskul')->get();

        $ringkasan = [
            'total' => (clone $query)->count(),
            's' => (clone $query)->where('predikat', 'S')->count(),
            'a' => (clone $query)->where('predikat', 'A')->count(),
            'b' => (clone $query)->where('predikat', 'B')->count(),
        ];

        return view('admin.nilai.index', compact('nilai', 'ekskuls', 'ringkasan'));
    }

    public function export(Request $request)
    {
        $query = NilaiAnggota::query()->with(['anggota', 'ekskul', 'pelatih']);

        if ($request->filled('ekskul_id')) {
            $query->where('ekskul_id', $request->ekskul_id);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('anggota', function ($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                  ->orWhere('kelas', 'like', "%{$cari}%");
            });
        }

        $nilai = $query->orderByDesc('created_at')->get();

        $filename = 'nilai_anggota_' . date('Ymd_His') . '.xlsx';

        return Excel::download(new NilaiAnggotaExport($nilai), $filename);
    }
}