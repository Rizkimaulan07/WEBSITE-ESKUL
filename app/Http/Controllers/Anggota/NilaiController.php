<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NilaiAnggota;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Filter berdasarkan ekskul yang dipilih
        $selectedEkskul = $request->query('ekskul_id');

        $query = NilaiAnggota::with(['ekskul', 'pelatih'])
                             ->where('anggota_id', $user->id);

        if (!empty($selectedEkskul)) {
            $query->where('ekskul_id', $selectedEkskul);
        }

        // Ambil data nilai anggota
        $nilai = $query->orderBy('created_at', 'desc')
                       ->paginate(10)
                       ->withQueryString();

        // Statistik predikat huruf (S/A/B) sesuai filter
        $statistik = [
            'total' => (clone $query)->count(),
            's' => (clone $query)->where('predikat', 'S')->count(),
            'a' => (clone $query)->where('predikat', 'A')->count(),
            'b' => (clone $query)->where('predikat', 'B')->count(),
        ];

        // Ekskul yang diikuti untuk dropdown filter
        $ekskuls = $user->ekskuls;

        return view('anggota.nilai', compact('nilai', 'statistik', 'ekskuls', 'selectedEkskul'));
    }

    public function detail($id)
    {
        $nilai = NilaiAnggota::with(['ekskul', 'pelatih'])
                             ->where('anggota_id', Auth::id())
                             ->where('id', $id)
                             ->firstOrFail();

        return view('anggota.nilai_detail', compact('nilai'));
    }
}