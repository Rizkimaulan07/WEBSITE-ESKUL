<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use Illuminate\Support\Facades\Auth;

class KehadiranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $kehadiran = Kehadiran::where('anggota_id', $user->id)
                              ->orderBy('tanggal', 'desc')
                              ->paginate(10);
        
        $statistik = [
            'total' => Kehadiran::where('anggota_id', $user->id)->count(),
            'hadir' => Kehadiran::where('anggota_id', $user->id)->where('status', 'hadir')->count(),
            'izin' => Kehadiran::where('anggota_id', $user->id)->where('status', 'izin')->count(),
            'sakit' => Kehadiran::where('anggota_id', $user->id)->where('status', 'sakit')->count(),
            'alpa' => Kehadiran::where('anggota_id', $user->id)->where('status', 'alpa')->count(),
        ];
        
        return view('anggota.kehadiran', compact('kehadiran', 'statistik'));
    }

    public function detail(int $id)
    {
        $kehadiran = Kehadiran::where('anggota_id', Auth::id())
                              ->where('id', $id)
                              ->firstOrFail();
        
        return view('anggota.kehadiran_detail', compact('kehadiran'));
    }
}