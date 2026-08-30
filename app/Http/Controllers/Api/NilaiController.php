<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NilaiAnggota;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $nilai = NilaiAnggota::with(['ekskul', 'pelatih'])
            ->where('anggota_id', $request->user()->id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $nilai
        ]);
    }
}