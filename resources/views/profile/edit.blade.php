{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card-modern" data-aos="fade-up">
            <div class="card-header">
                <i class="bi bi-person-circle me-2"></i> Edit Profile
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Avatar/Photo -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <div class="avatar-wrapper rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 120px; height: 120px; font-size: 48px; font-weight: 700; border: 4px solid var(--primary);">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2" 
                                 style="width: 36px; height: 36px; border: 3px solid var(--bg-card); cursor: pointer;">
                                <i class="bi bi-camera text-white" style="font-size: 16px;"></i>
                            </div>
                        </div>
                        <h5 class="mt-3 fw-bold">{{ Auth::user()->name }}</h5>
                        <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', Auth::user()->name) }}" 
                               required>
                        <i class="bi bi-person input-icon"></i>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', Auth::user()->email) }}" 
                               required>
                        <i class="bi bi-envelope input-icon"></i>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div class="form-group">
                        <label for="no_hp">No HP</label>
                        <input type="text" 
                               class="form-control @error('no_hp') is-invalid @enderror" 
                               id="no_hp" 
                               name="no_hp" 
                               value="{{ old('no_hp', Auth::user()->no_hp) }}" 
                               placeholder="Contoh: 08123456789">
                        <i class="bi bi-phone input-icon"></i>
                        @error('no_hp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Kelas (khusus anggota) -->
                    @if(Auth::user()->role == 'anggota')
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" 
                               class="form-control @error('kelas') is-invalid @enderror" 
                               id="kelas" 
                               name="kelas" 
                               value="{{ old('kelas', Auth::user()->kelas) }}" 
                               placeholder="Contoh: XI - A">
                        <i class="bi bi-mortarboard input-icon"></i>
                        @error('kelas')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    <!-- Ekskul (khusus pelatih) -->
                    @if(Auth::user()->role == 'pelatih' && Auth::user()->ekskul)
                    <div class="form-group">
                        <label>Ekstrakurikuler</label>
                        <div class="form-control" style="background: var(--bg-primary); cursor: default;">
                            <i class="bi bi-building me-2"></i>
                            {{ Auth::user()->ekskul->nama_ekskul }}
                        </div>
                    </div>
                    @endif

                    <hr>

                    <!-- Password -->
                    <h6 class="fw-bold mb-3"><i class="bi bi-lock me-2"></i> Ubah Password (Opsional)</h6>
                    
                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password" 
                               placeholder="Masukkan password saat ini">
                        <i class="bi bi-lock input-icon"></i>
                        <button type="button" class="toggle-password" onclick="togglePassword('current_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Minimal 8 karakter">
                        <i class="bi bi-key input-icon"></i>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Ketik ulang password baru">
                        <i class="bi bi-check-circle input-icon"></i>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>

                <!-- Delete Account -->
                <hr>
                <div class="mt-3">
                    <h6 class="text-danger fw-bold"><i class="bi bi-exclamation-triangle me-2"></i> Hapus Akun</h6>
                    <p class="text-muted small">Setelah akun dihapus, semua data akan hilang permanen.</p>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash me-1"></i> Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--bg-card);">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle me-2"></i> Hapus Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <label for="delete_password">Masukkan Password untuk Konfirmasi</label>
                        <input type="password" 
                               class="form-control" 
                               id="delete_password" 
                               name="password" 
                               placeholder="Masukkan password Anda"
                               required>
                        <i class="bi bi-lock input-icon"></i>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i> Hapus Akun
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        const icon = btn.querySelector('i');
        if (icon) {
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }
    }

    // SweetAlert for delete account
    document.getElementById('deleteAccountForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin hapus akun?',
            text: "Semua data akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endpush
@endsection