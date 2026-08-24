<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // ===== FORGOT PASSWORD (TANPA EMAIL, TAMPILKAN OTP DI LAYAR) =====
    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        // Cari user berdasarkan email
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar di sistem.']);
        }

        // Buat kode OTP acak 6 digit (TIDAK BISA DITEBAK)
        $otp = random_int(100000, 999999);

        // Simpan OTP dan email di session
        session(['reset_otp' => $otp, 'reset_email' => $request->email]);

        // Tampilkan OTP langsung di layar
        return back()->with('status', "Kode OTP Anda adalah: <b style='font-size: 24px; letter-spacing: 5px; color: #2563eb;'>$otp</b>. Masukkan kode ini untuk reset password.");
    })->name('password.email');

    // ===== RESET PASSWORD (TANPA EMAIL) =====
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        // Cek OTP sesuai
        if ($request->otp != session('reset_otp') || $request->email != session('reset_email')) {
            return back()->withErrors(['otp' => 'Kode OTP tidak sesuai. Silakan coba lagi.']);
        }

        // Ubah password
        DB::table('users')->where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus session OTP
        session()->forget(['reset_otp', 'reset_email']);

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Sekarang Anda bisa login.');
    })->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
