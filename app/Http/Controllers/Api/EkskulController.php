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
}