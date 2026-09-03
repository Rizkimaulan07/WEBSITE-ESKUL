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
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // ===== FORGOT PASSWORD (KIRIM KODE OTP KE EMAIL) =====
    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    // ===== KIRIM ULANG KODE OTP (dengan cooldown 1 menit) =====
    Route::post('forgot-password/resend', function (Request $request) {
        $email = $request->input('email', session('reset_email'));
        $wantsJson = $request->expectsJson();

        if (!$email) {
            if ($wantsJson) return response()->json(['success' => false, 'message' => 'Silakan masukkan email terlebih dahulu.'], 422);
            return redirect()->route('password.request')
                             ->withErrors(['email' => 'Silakan masukkan email terlebih dahulu.']);
        }

        // Cek user terdaftar
        $user = DB::table('users')->where('email', $email)->first();
        if (!$user) {
            if ($wantsJson) return response()->json(['success' => false, 'message' => 'Email tidak terdaftar di sistem.'], 422);
            return redirect()->route('password.request')
                             ->withErrors(['email' => 'Email tidak terdaftar di sistem.']);
        }

        // Cooldown 1 menit sebelum kirim ulang
        $sentAt = session('reset_otp_sent_at');
        if ($sentAt && is_numeric($sentAt) && (now()->timestamp - (int) $sentAt) < 60) {
            $sisa = 60 - (now()->timestamp - (int) $sentAt);
            if ($wantsJson) return response()->json(['success' => false, 'message' => "Mohon tunggu {$sisa} detik sebelum mengirim ulang kode OTP."], 429);
            return redirect()->route('password.request')
                             ->with('error', "Mohon tunggu {$sisa} detik sebelum mengirim ulang kode OTP.");
        }

        // Buat OTP baru dan kirim
        $otp = random_int(100000, 999999);
        session([
            'reset_otp' => $otp,
            'reset_email' => $email,
            'reset_otp_sent_at' => now()->timestamp,
        ]);

        $mailSent = false;
        $devOtp = null;
        try {
            Mail::to($email)->send(new OtpMail($otp, $user->name ?? null, 10));
            $mailSent = true;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('GAGAL KIRIM OTP (password.resend): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Fallback: jika SMTP tidak tersedia, kirim via mailer 'log' dan tampilkan OTP
            // di layar agar alur reset tetap bisa berjalan (mode pengembangan).
            if (config('app.env') === 'local') {
                try {
                    Mail::mailer('log')->to($email)->send(new OtpMail($otp, $user->name ?? null, 10));
                    $devOtp = $otp;
                    $mailSent = true;
                } catch (\Throwable $e2) {
                    \Illuminate\Support\Facades\Log::error('GAGAL LOG OTP: ' . $e2->getMessage());
                }
            }
        }

        if (!$mailSent) {
            if ($wantsJson) return response()->json(['success' => false, 'message' => 'Gagal mengirim email. Silakan coba lagi.'], 500);
            return redirect()->route('password.request')
                             ->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }

        if ($wantsJson) {
            return response()->json([
                'success' => true,
                'message' => 'Kode OTP baru berhasil dikirim.',
                'dev_otp' => $devOtp,
            ]);
        }

        return redirect()->route('password.request')
                         ->with('status', "Kode OTP berhasil dikirim ke email <strong>{$email}</strong>. Periksa inbox Anda.")
                         ->with('otp_resent', true)
                         ->with('dev_otp', $devOtp);
    })->name('password.resend');

    Route::post('forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        // Cari user berdasarkan email
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar di sistem.']);
        }

        // Batasi pengiriman ulang: cek cooldown 60 detik
        $sentAt = session('reset_otp_sent_at');
        if ($sentAt && is_numeric($sentAt) && (now()->timestamp - (int) $sentAt) < 60) {
            $sisa = 60 - (now()->timestamp - (int) $sentAt);
            return back()->withErrors(['email' => "Mohon tunggu {$sisa} detik sebelum mengirim ulang."]);
        }

        // Buat kode OTP acak 6 digit
        $otp = random_int(100000, 999999);

        // Simpan OTP, email, dan waktu kirim di session (berlaku 10 menit)
        session([
            'reset_otp' => $otp,
            'reset_email' => $request->email,
            'reset_otp_sent_at' => now()->timestamp,
        ]);

        // Kirim kode OTP ke email pengguna
        $mailSent = false;
        $devOtp = null;
        try {
            Mail::to($request->email)->send(new OtpMail($otp, $user->name ?? null, 10));
            $mailSent = true;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('GAGAL KIRIM OTP (password.email): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Fallback: jika SMTP tidak tersedia, kirim via mailer 'log' dan tampilkan OTP
            // di layar agar alur reset tetap bisa berjalan (mode pengembangan).
            if (config('app.env') === 'local') {
                try {
                    Mail::mailer('log')->to($request->email)->send(new OtpMail($otp, $user->name ?? null, 10));
                    $devOtp = $otp;
                    $mailSent = true;
                } catch (\Throwable $e2) {
                    \Illuminate\Support\Facades\Log::error('GAGAL LOG OTP (password.email): ' . $e2->getMessage());
                }
            }
        }

        if (!$mailSent) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }

        return back()->with('status', "Kode OTP berhasil dikirim ke email <strong>{$request->email}</strong>. Periksa inbox Anda untuk melanjutkan.")
                     ->with('dev_otp', $devOtp);
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

        // Cek OTP sesuai (dan belum kedaluwarsa - berlaku 10 menit)
        $sentAt = session('reset_otp_sent_at');
        $otpExpired = $sentAt && is_numeric($sentAt) && (now()->timestamp - (int) $sentAt) >= 600;
        if ($request->otp != session('reset_otp') || $request->email != session('reset_email') || $otpExpired) {
            return back()->withErrors(['otp' => 'Kode OTP tidak sesuai atau sudah kedaluwarsa. Silakan kirim ulang.']);
        }

        // Ubah password
        DB::table('users')->where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus session OTP
        session()->forget(['reset_otp', 'reset_email', 'reset_otp_sent_at']);

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
