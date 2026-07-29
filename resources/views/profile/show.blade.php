@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card-modern" data-aos="fade-up">
            <div class="card-header">
                <i class="bi bi-person-circle me-2"></i> Profile Saya
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar-wrapper rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                         style="width: 120px; height: 120px; font-size: 48px; font-weight: 700;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h4 class="mt-3 fw-bold">{{ Auth::user()->name }}</h4>
                    <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                    <p class="text-muted mt-2">{{ Auth::user()->email }}</p>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: var(--bg-primary);">
                            <small class="text-muted d-block">No HP</small>
                            <strong>{{ Auth::user()->no_hp ?? '-' }}</strong>
                        </div>
                    </div>
                    @if(Auth::user()->role == 'anggota')
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: var(--bg-primary);">
                            <small class="text-muted d-block">Kelas</small>
                            <strong>{{ Auth::user()->kelas ?? '-' }}</strong>
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->role == 'pelatih' && Auth::user()->ekskul)
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: var(--bg-primary);">
                            <small class="text-muted d-block">Ekstrakurikuler</small>
                            <strong>{{ Auth::user()->ekskul->nama_ekskul }}</strong>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: var(--bg-primary);">
                            <small class="text-muted d-block">Bergabung Sejak</small>
                            <strong>{{ Auth::user()->created_at->format('d M Y') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i> Edit Profile
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection