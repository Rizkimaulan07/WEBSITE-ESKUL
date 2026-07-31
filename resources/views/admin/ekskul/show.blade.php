@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')
@section('subtitle', 'Informasi lengkap ekstrakurikuler')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="card-header border-0 py-3 px-4" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <h5 class="text-white fw-bold mb-0">
                    <i class="fas fa-image me-2"></i>Logo Ekskul
                </h5>
            </div>
            <div class="card-body text-center py-4">
                @if($ekskul->logo)
                    <img src="{{ asset('storage/' . $ekskul->logo) }}" 
                         class="img-fluid rounded-3" 
                         style="max-height: 200px; object-fit: contain;">
                @else
                    <div class="logo-placeholder rounded-circle d-inline-flex align-items-center justify-content-center"
                         style="width: 150px; height: 150px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); border: 4px solid white; box-shadow: 0 8px 30px rgba(99,102,241,0.2);">
                        <i class="fas fa-image fa-4x text-white opacity-75"></i>
                    </div>
                @endif
                <h4 class="fw-bold mt-3">{{ $ekskul->nama_ekskul }}</h4>
                <span class="badge bg-{{ $ekskul->status == 'aktif' ? 'success' : 'danger' }} rounded-pill px-4 py-2">
                    {{ $ekskul->status == 'aktif' ? '🟢 Aktif' : '🔴 Nonaktif' }}
                </span>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0 pb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="btn btn-warning rounded-pill">
                        <i class="fas fa-edit me-2"></i>Edit Ekskul
                    </a>
                    <form action="{{ route('admin.ekskul.destroy', $ekskul->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus ekskul {{ $ekskul->nama_ekskul }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill w-100">
                            <i class="fas fa-trash-alt me-2"></i>Hapus Ekskul
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header border-0 py-3 px-4" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <h5 class="text-white fw-bold mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Ekstrakurikuler
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px; color: #64748b; font-weight: 600;">Nama Ekskul</th>
                            <td><strong>{{ $ekskul->nama_ekskul }}</strong></td>
                        </tr>
                        <tr>
                            <th style="color: #64748b; font-weight: 600;">Pembina</th>
                            <td>{{ $ekskul->pembina }}</td>
                        </tr>
                        <tr>
                            <th style="color: #64748b; font-weight: 600;">Hari Latihan</th>
                            <td>
                                <span class="badge bg-info rounded-pill px-3 py-2">
                                    <i class="fas fa-calendar-day me-1"></i>
                                    {{ $ekskul->hari_latihan }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="color: #64748b; font-weight: 600;">Jam Latihan</th>
                            <td>
                                <i class="far fa-clock text-primary me-2"></i>
                                {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <th style="color: #64748b; font-weight: 600;">Tempat Latihan</th>
                            <td>
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                {{ $ekskul->tempat_latihan }}
                            </td>
                        </tr>
                        <tr>
                            <th style="color: #64748b; font-weight: 600;">Status</th>
                            <td>
                                <span class="badge bg-{{ $ekskul->status == 'aktif' ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                    {{ $ekskul->status == 'aktif' ? '🟢 Aktif' : '🔴 Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="color: #64748b; font-weight: 600;">Deskripsi</th>
                            <td>{{ $ekskul->deskripsi }}</td>
                        </tr>
                        <tr>
                            <th style="color: #64748b; font-weight: 600;">Total Anggota</th>
                            <td>
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $ekskul->users_count ?? 0 }} Anggota
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="color: #64748b; font-weight: 600;">Tanggal Dibuat</th>
                            <td>
                                <i class="far fa-calendar-alt text-muted me-2"></i>
                                {{ \Carbon\Carbon::parse($ekskul->created_at)->format('d M Y H:i') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer border-0 bg-transparent px-4 pb-4 pt-0">
                <a href="{{ route('admin.ekskul.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Ekskul
                </a>
            </div>
        </div>

        <!-- Daftar Anggota -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
            <div class="card-header border-0 py-3 px-4" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #312e81 60%, #4f46e5 100%);">
                <h5 class="text-white fw-bold mb-0">
                    <i class="fas fa-users me-2"></i>Daftar Anggota
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="py-3">Nama</th>
                                <th class="py-3">Kelas</th>
                                <th class="py-3">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ekskul->users as $user)
                                @if($user->role == 'anggota')
                                <tr>
                                    <td class="px-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-placeholder rounded-circle d-inline-flex align-items-center justify-content-center"
                                                 style="width: 32px; height: 32px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; font-weight: 600; font-size: 12px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->kelas ?? '-' }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                        Belum ada anggota
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .logo-placeholder {
        transition: all 0.3s ease;
    }
    .logo-placeholder:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 30px rgba(99, 102, 241, 0.3);
    }
    .table-borderless tr {
        border-bottom: 1px solid #f1f3f5;
    }
    .table-borderless tr:last-child {
        border-bottom: none;
    }
    .avatar-placeholder {
        flex-shrink: 0;
    }
    .btn-outline-secondary {
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        background: #f8fafc;
        border-color: #94a3b8;
    }
    .btn-warning {
        transition: all 0.3s ease;
    }
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
    }
    .btn-danger {
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
    }
</style>
@endsection