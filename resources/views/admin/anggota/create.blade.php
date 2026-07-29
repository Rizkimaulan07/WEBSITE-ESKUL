@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card-modern">
            <div class="card-header">
                <i class="bi bi-person-plus me-2"></i> Tambah Anggota Baru
            </div>
            <div class="card-body">
                <form action="{{ route('anggota.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                <i class="bi bi-person input-icon"></i>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Masukkan email"
                                       required>
                                <i class="bi bi-envelope input-icon"></i>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Minimal 8 karakter"
                                       required>
                                <i class="bi bi-lock input-icon"></i>
                                <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kelas">Kelas <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('kelas') is-invalid @enderror" 
                                       id="kelas" 
                                       name="kelas" 
                                       value="{{ old('kelas') }}" 
                                       placeholder="Contoh: XI - A"
                                       required>
                                <i class="bi bi-mortarboard input-icon"></i>
                                @error('kelas')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp">No HP <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" 
                                       name="no_hp" 
                                       value="{{ old('no_hp') }}" 
                                       placeholder="Contoh: 08123456789"
                                       required>
                                <i class="bi bi-phone input-icon"></i>
                                @error('no_hp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ekskul_id">Ekstrakurikuler <span class="text-danger">*</span></label>
                                <select class="form-control @error('ekskul_id') is-invalid @enderror" 
                                        id="ekskul_id" 
                                        name="ekskul_id" 
                                        required>
                                    <option value="">-- Pilih Ekskul --</option>
                                    @foreach($ekskuls as $ekskul)
                                        <option value="{{ $ekskul->id }}" {{ old('ekskul_id') == $ekskul->id ? 'selected' : '' }}>
                                            {{ $ekskul->nama_ekskul }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="bi bi-building input-icon"></i>
                                @error('ekskul_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="jabatan" 
                                       name="jabatan" 
                                       value="{{ old('jabatan', 'anggota') }}" 
                                       placeholder="Contoh: Ketua, Sekretaris">
                                <i class="bi bi-tag input-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        const icon = btn.querySelector('i');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }
</script>
@endpush
@endsection