<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Jika user adalah admin, izinkan akses semua
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Anggota tanpa role diperlakukan sebagai 'anggota'
        $safeRole = $user->role ?? 'anggota';
        if ($safeRole === '') {
            $safeRole = 'anggota';
        }

        // Cek apakah role user ada di daftar roles yang diizinkan
        if (in_array($safeRole, $roles, true)) {
            return $next($request);
        }

        // Jika tidak punya akses, redirect ke halaman yang sesuai
        if ($safeRole === 'pelatih') {
            return redirect('/pelatih/dashboard');
        } elseif ($safeRole === 'anggota') {
            return redirect('/anggota/dashboard');
        }

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        abort(403, 'Unauthorized access.');
    }
}