<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
    public function index()
    {
        $ekskuls = Ekstrakurikuler::all();
        return response()->json([
            'status' => 'success',
            'data' => $ekskuls
        ]);
    }

    public function show($id)
    {
        $ekskul = Ekstrakurikuler::find($id);
        if (!$ekskul) {
            return response()->json(['status' => 'error', 'message' => 'Ekstrakurikuler tidak ditemukan'], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $ekskul
        ]);
    }
}