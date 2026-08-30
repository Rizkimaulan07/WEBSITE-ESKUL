<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $kehadiran = Kehadiran::with(['ekskul', 'pelatih'])
            ->where('anggota_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $kehadiran,
        ]);
    }

    public function stats(Request $request)
    {
        $user = $request->user();

        $total = Kehadiran::where('anggota_id', $user->id)->count();

        $stats = [
            'total' => $total,
            'hadir' => Kehadiran::where('anggota_id', $user->id)->where('status', 'hadir')->count(),
            'izin' => Kehadiran::where('anggota_id', $user->id)->where('status', 'izin')->count(),
            'sakit' => Kehadiran::where('anggota_id', $user->id)->where('status', 'sakit')->count(),
            'alpa' => Kehadiran::where('anggota_id', $user->id)->where('status', 'alpa')->count(),
            'persentase' => $total > 0
                ? round(Kehadiran::where('anggota_id', $user->id)->where('status', 'hadir')->count() / $total * 100, 1)
                : 0,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats,
        ]);
    }
}
