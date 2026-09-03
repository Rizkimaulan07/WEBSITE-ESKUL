@extends('layouts.guest')

@section('title', 'Verifikasi Dua Faktor')

@section('content')
<div class="logo">
    <div class="logo-icon" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); box-shadow: 0 8px 30px rgba(14,165,233,0.25);">
        <i class="fas fa-shield-check"></i>
    </div>
    <h3 style="color: #0f172a;">Verifikasi Dua Faktor</h3>
    <p class="subtitle" style="color: #64748b;">Masukkan kode dari aplikasi authenticator Anda</p>
</div>

@if ($errors->any())
    <div class="alert-custom" style="background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;">
        <i class="fas fa-exclamation-circle alert-icon" style="color: #dc2626; font-size: 18px;"></i>
        <div style="color: #991b1b;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif

<form method="POST" action="{{ route('two-factor.login') }}">
    @csrf

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="code" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block;">Kode Authenticator</label>
        <div class="input-wrapper" style="position: relative;">
            <input type="text" 
                   class="form-control @error('code') is-invalid @enderror" 
                   id="code" 
                   name="code" 
                   placeholder="Masukkan 6 digit kode"
                   required
                   style="width: 100%; padding: 14px 16px 14px 48px; border: 2px solid #e5e7eb; border-radius: 14px; font-size: 14px; font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
            <i class="fas fa-shield-lock input-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 16px;"></i>
            @error('code')
                <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="text-center mb-3">
        <small class="text-muted" style="color: #64748b;">Atau gunakan salah satu recovery code</small>
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="recovery_code" style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block;">Recovery Code</label>
        <div class="input-wrapper" style="position: relative;">
            <input type="text" 
                   class="form-control @error('recovery_code') is-invalid @enderror" 
                   id="recovery_code" 
                   name="recovery_code" 
                   placeholder="Masukkan recovery code"
                   required
                   style="width: 100%; padding: 14px 16px 14px 48px; border: 2px solid #e5e7eb; border-radius: 14px; font-size: 14px; font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; transition: all 0.3s ease;">
            <i class="fas fa-key input-icon" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 16px;"></i>
            @error('recovery_code')
                <small class="text-danger" style="color: #dc2626; font-size: 13px; display: block; margin-top: 4px;">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn-auth" style="width: 100%; padding: 16px; border: none; border-radius: 14px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff; font-size: 15px; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer; box-shadow: 0 4px 24px rgba(14,165,233,0.25);">
        <span class="btn-text">Verifikasi <i class="fas fa-arrow-right ms-2"></i></span>
        <span class="spinner"></span>
    </button>
</form>

<div class="auth-footer" style="text-align: center; margin-top: 20px;">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none p-0" style="color: #0ea5e9; font-weight: 600; border: none; background: none; cursor: pointer;">
            Logout
        </button>
    </form>
</div>
@endsection