<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ===== IMPORT CONTROLLER API =====
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EkskulController;
use App\Http\Controllers\Api\NilaiController;
use App\Http\Controllers\Api\KehadiranController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ===== TESTING HALAMAN LOGIN (GET) - BISA DIBUKA DI BROWSER =====
Route::get('/login', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Halaman API Login. Silakan gunakan method POST untuk login dengan email dan password.',
        'example' => [
            'email' => 'admin@mail.com',
            'password' => 'password'
        ]
    ]);
});

// ===== AUTH (POST - DIGUNAKAN OLEH MOBILE) =====
Route::post('/login', [AuthController::class, 'login']);

// ===== DATA (PERLU TOKEN) =====
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/ekskul', [EkskulController::class, 'index']);
    Route::get('/ekskul/{id}', [EkskulController::class, 'show']);
    Route::get('/nilai', [NilaiController::class, 'index']);

    // Kehadiran
    Route::get('/kehadiran', [KehadiranController::class, 'index']);
    Route::get('/kehadiran/stats', [KehadiranController::class, 'stats']);
});
