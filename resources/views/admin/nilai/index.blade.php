@extends('layouts.app')

@section('title', 'Nilai Anggota')
@section('subtitle', 'Pantau penilaian anggota di semua ekskul')

@section('content')
<!-- ===== STATISTICS ===== -->
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 20px 22px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="stat-icon-modern" style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 18px; margin-bottom: 12px;">
                <i class="fas fa-file-alt"></i>
            </div>
            <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Nilai</span>
            <h3 class="stat-number-modern mb-0" style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -1px;">{{ $ringkasan['total'] }}</h3>
            <small class="text-muted" style="font-size: 11px; color: #64748b;">Seluruh ekskul</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 20px 22px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="stat-icon-modern" style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 18px; margin-bottom: 12px;">
                <i class="fas fa-star"></i>
            </div>
            <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Sangat Baik (S)</span>
            <h3 class="stat-number-modern mb-0" style="font-size: 26px; font-weight: 800; color: #047857; letter-spacing: -1px;">{{ $ringkasan['s'] }}</h3>
            <small class="text-muted" style="font-size: 11px; color: #64748b;">Capaian terbaik</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 20px 22px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="stat-icon-modern" style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 18px; margin-bottom: 12px;">
                <i class="fas fa-thumbs-up"></i>
            </div>
            <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Baik (A)</span>
            <h3 class="stat-number-modern mb-0" style="font-size: 26px; font-weight: 800; color: #0284c7; letter-spacing: -1px;">{{ $ringkasan['a'] }}</h3>
            <small class="text-muted" style="font-size: 11px; color: #64748b;">Baik</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 20px 22px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="stat-icon-modern" style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #fffbeb, #fef3c7); display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 18px; margin-bottom: 12px;">
                <i class="fas fa-handshake"></i>
            </div>
            <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Cukup (B)</span>
            <h3 class="stat-number-modern mb-0" style="font-size: 26px; font-weight: 800; color: #b45309; letter-spacing: -1px;">{{ $ringkasan['b'] }}</h3>
            <small class="text-muted" style="font-size: 11px; color: #64748b;">Perlu dibina</small>
        </div>
    </div>
</div>

<!-- ===== FILTER ===== -->
<div class="card-modern mb-4" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
    <div class="card-body-modern" style="padding: 16px 20px;">
        <form action="{{ route('admin.nilai.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Filter Ekskul</label>
                <select name="ekskul_id" class="form-select form-select-sm" style="border: 2px solid #e5e7eb; border-radius: 8px; font-size: 13px;">
                    <option value="">Semua Ekskul</option>
                    @foreach($ekskuls as $ekskul)
                        <option value="{{ $ekskul->id }}" {{ request('ekskul_id') == $ekskul->id ? 'selected' : '' }}>{{ $ekskul->nama_ekskul }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small text-muted mb-1" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Cari Anggota / Kelas</label>
                <input type="text" name="cari" class="form-control form-control-sm" value="{{ request('cari') }}" placeholder="Nama anggota atau kelas..." style="border: 2px solid #e5e7eb; border-radius: 8px; font-size: 13px;">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-primary-gradient btn-sm flex-fill" style="font-weight: 600; border-radius: 8px; padding: 6px 16px;">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary btn-sm" style="background: #f1f5f9; color: #64748b; border: none; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-redo-alt"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="card-modern" style="background: #ffffff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header-modern" style="padding: 16px 20px; border-bottom: 1px solid rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
        <h6 class="fw-bold mb-0" style="font-size: 14px; color: #0f172a;">
            <i class="fas fa-list me-2" style="color: #0ea5e9;"></i>Data Nilai Anggota
            <span class="badge-soft ms-2" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 12px; font-size: 11px; font-weight: 500;">{{ $nilai->total() }} data</span>
        </h6>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.nilai.export', request()->query()) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #10b981, #34d399); border: none; color: #fff; border-radius: 8px; font-weight: 600; padding: 6px 16px; text-decoration: none; box-shadow: 0 2px 12px rgba(16,185,129,0.25);">
                <i class="fas fa-download me-1"></i>Unduh File
            </a>
        </div>
    </div>
    <div class="card-body-modern p-0" style="padding: 0;">
        <div class="table-responsive">
            <table class="table-modern" style="width: 100%; border-collapse: collapse; font-size: 13px; table-layout: auto;">
                <thead>
                    <tr>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left; white-space: nowrap;">No</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left; white-space: nowrap;">Nama Anggota</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left; white-space: nowrap;">Ekskul</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left; white-space: nowrap;">Pelatih</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: center; white-space: nowrap;">Predikat</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left;">Keterangan</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left; white-space: nowrap;">Semester</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.02); text-align: left; white-space: nowrap;">Dinilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $item)
                        @php
                            switch ($item->predikat) {
                                case 'S':
                                    $bg = 'rgba(16,185,129,0.12)';
                                    $color = '#047857';
                                    $label = $item->predikat_label;
                                    break;
                                case 'A':
                                    $bg = 'rgba(14,165,233,0.10)';
                                    $color = '#0284c7';
                                    $label = $item->predikat_label;
                                    break;
                                case 'B':
                                    $bg = 'rgba(245,158,11,0.10)';
                                    $color = '#b45309';
                                    $label = $item->predikat_label;
                                    break;
                                default:
                                    $bg = 'rgba(100,116,139,0.08)';
                                    $color = '#64748b';
                                    $label = '-';
                            }
                        @endphp
                        <tr style="transition: all 0.3s ease;">
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.04); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $loop->iteration }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 12px; flex-shrink: 0;">
                                        {{ strtoupper(substr($item->anggota->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color: #0f172a;">{{ $item->anggota->name ?? '-' }}</div>
                                        <small class="text-muted" style="color: #64748b;">{{ $item->anggota->kelas ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span class="badge-soft" style="background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 8px; font-size: 12px; font-weight: 500;">{{ $item->ekskul->nama_ekskul ?? '-' }}</span>
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; color: #475569;">{{ $item->pelatih->name ?? '-' }}</td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; text-align: center;">
                                @if($item->predikat)
                                    <span class="badge-nilai d-inline-block" title="{{ $label }}" style="padding: 4px 12px; border-radius: 8px; font-size: 15px; font-weight: 800; min-width: 34px; text-align: center; background: {{ $bg }}; color: {{ $color }};">{{ $item->predikat }}</span>
                                    <small class="d-block mt-1" style="font-size: 10px; font-weight: 600; color: {{ $color }};">{{ $label }}</small>
                                @else
                                    <span class="badge-soft" style="background: rgba(245,158,11,0.08); color: #f59e0b; padding: 4px 10px; border-radius: 8px; font-size: 11px;">-</span>
                                @endif
                            </td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; color: #64748b; max-width: 240px;">{{ $item->catatan ?? '-' }}</td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; color: #475569;">{{ ($item->semester ?? '-') . ' ' . ($item->tahun_ajaran ?? '') }}</td>
                            <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                                <span style="color: #475569; font-size: 12px;">{{ $item->created_at->format('d/m/Y') }}</span>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding: 12px 16px; text-align: center;">
                            <div class="empty-state" style="padding: 40px 0; text-align: center;">
                                <div class="empty-icon" style="font-size: 56px; color: #d1d5db; margin-bottom: 16px; opacity: 0.5;"><i class="fas fa-file-alt"></i></div>
                                <h6 class="empty-title" style="font-weight: 600; color: #0f172a; margin-bottom: 4px;">Belum ada data nilai</h6>
                                <p class="empty-desc" style="color: #64748b; font-size: 13px; margin-bottom: 4px;">Nilai akan muncul setelah pelatih mengisi penilaian anggota</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer-modern" style="padding: 14px 20px; border-top: 1px solid rgba(0,0,0,0.02); background: rgba(248,250,252,0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span style="font-size: 12px; color: #64748b;">
                @if($nilai->total() > 0)
                    Menampilkan {{ $nilai->firstItem() }} - {{ $nilai->lastItem() }} dari {{ $nilai->total() }} data
                @else
                    Tidak ada data
                @endif
            </span>
            <div>{{ $nilai->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>

<style>
    .stat-card-modern:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(14,165,233,0.08); }
    .table-modern tbody tr:hover { background: rgba(14,165,233,0.015); }

    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px;
        margin: 0 3px;
        color: #64748b;
        transition: all 0.3s ease;
        font-size: 13px;
        padding: 8px 14px;
    }
    .pagination .page-item .page-link:hover {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(14,165,233,0.3);
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white;
        border: none;
        box-shadow: 0 4px 16px rgba(14,165,233,0.3);
    }

    @media (max-width: 768px) {
        .stat-card-modern { padding: 16px 18px; }
        .stat-number-modern { font-size: 22px !important; }
        .table-modern { font-size: 12px; }
    }
</style>
@endsection