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

        // Cek apakah role user ada di daftar roles yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, redirect ke halaman yang sesuai
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'pelatih') {
            return redirect('/pelatih/nilai');
        } elseif ($user->role === 'anggota') {
            return redirect('/anggota/dashboard');
        }

        abort(403, 'Unauthorized access.');
    }
}