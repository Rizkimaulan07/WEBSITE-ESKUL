<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NilaiAnggota;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data nilai anggota
        $nilai = NilaiAnggota::where('anggota_id', $user->id)
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);
        
        // Statistik - gunakan 'nilai_total' bukan 'nilai'
        $statistik = [
            'total' => NilaiAnggota::where('anggota_id', $user->id)->count(),
            'rata_rata' => NilaiAnggota::where('anggota_id', $user->id)->avg('nilai_total') ?? 0,
            'tertinggi' => NilaiAnggota::where('anggota_id', $user->id)->max('nilai_total') ?? 0,
            'terendah' => NilaiAnggota::where('anggota_id', $user->id)->min('nilai_total') ?? 0,
        ];
        
        return view('anggota.nilai', compact('nilai', 'statistik'));
    }

    public function detail($id)
    {
        $nilai = NilaiAnggota::where('anggota_id', Auth::id())
                             ->where('id', $id)
                             ->firstOrFail();
        
        return view('anggota.nilai_detail', compact('nilai'));
    }
}