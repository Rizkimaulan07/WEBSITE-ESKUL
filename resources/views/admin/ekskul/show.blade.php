@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">📋 Detail Ekstrakurikuler</h3>
                    <div class="card-tools">
                        <a href="{{ route('ekskul.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('ekskul.edit', $ekskul->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($ekskul->logo)
                                <img src="{{ asset('storage/' . $ekskul->logo) }}" 
                                     alt="{{ $ekskul->nama_ekskul }}" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white rounded d-inline-flex align-items-center justify-content-center" 
                                     style="width: 200px; height: 200px;">
                                    <i class="fas fa-image fa-4x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $ekskul->nama_ekskul }}</h3>
                            <p class="text-muted">Slug: {{ $ekskul->slug }}</p>
                            <hr>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Pembina</th>
                                    <td>{{ $ekskul->pembina }}</td>
                                </tr>
                                <tr>
                                    <th>Hari Latihan</th>
                                    <td>{{ $ekskul->hari_latihan }}</td>
                                </tr>
                                <tr>
                                    <th>Jam Latihan</th>
                                    <td>{{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Latihan</th>
                                    <td>{{ $ekskul->tempat_latihan }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Anggota</th>
                                    <td><span class="badge badge-success">{{ $ekskul->users->count() }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Deskripsi</h5>
                        <p>{{ $ekskul->deskripsi }}</p>
                    </div>

                    @if($ekskul->users->count() > 0)
                    <div class="mt-4">
                        <h5>Daftar Anggota</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ekskul->users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="mt-4 alert alert-info">
                        <i class="fas fa-info-circle"></i> Belum ada anggota yang bergabung
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection