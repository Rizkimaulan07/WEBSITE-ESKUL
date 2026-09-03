@extends('layouts.app')

@section('title', 'Nilai Saya')
@section('subtitle', 'Lihat nilai Anda di ekstrakurikuler')

@section('content')
<!-- ===== STATISTICS CARDS ===== -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Penilaian</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $statistik['total'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #0ea5e9, #38bdf8); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-star"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Sangat Baik (S)</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $statistik['s'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #10b981, #34d399); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-thumbs-up"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Baik (A)</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $statistik['a'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #0ea5e9, #38bdf8); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #fffbeb, #fef3c7); display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-handshake"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Cukup (B)</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $statistik['b'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #f59e0b, #fbbf24); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
</div>

<!-- ===== FILTER EKSKUL ===== -->
<div class="card glass-card mb-4" style="background: rgba(255,255,255,0.85); backdrop-filter: blur(16px); border: 1px solid rgba(0,0,0,0.04); border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.04);">
    <div class="card-body px-4 py-3">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 16px; flex-shrink: 0;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size: 14px; color: #0f172a;">Filter Berdasarkan Ekskul</div>
                        <small class="text-muted" style="font-size: 12px; color: #64748b;">Pilih ekskul untuk melihat nilai masing-masing</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <select id="filterEkskul" class="form-select" onchange="filterByEkskul(this.value)"
                        style="padding: 10px 14px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13px; background: #fff; color: #0f172a; transition: all 0.3s ease; cursor: pointer; width: 100%;">
                    <option value="">📚 Semua Ekskul</option>
                    @foreach($ekskuls ?? collect() as $eskul)
                        <option value="{{ $eskul->id }}" {{ (string)($selectedEkskul ?? '') === (string)$eskul->id ? 'selected' : '' }}>
                            {{ $eskul->nama_ekskul }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<!-- ===== TABLE ===== -->
<div class="card premium-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); overflow: hidden; transition: all 0.4s ease;">
    <div class="card-header premium-card-header" style="padding: 18px 24px; border-bottom: 1px solid rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; background: rgba(248,250,252,0.2);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-weight: 700; font-size: 14px; color: #0f172a;">Daftar Nilai</h6>
                <small class="text-muted" style="font-size: 12px; color: #64748b;">Semua nilai Anda dari pelatih (hanya bisa dilihat)</small>
            </div>
        </div>
        <span class="badge-count" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $nilai->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">No</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Ekskul</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Predikat</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Keterangan</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Semester</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Tanggal</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $item)
                    <tr style="transition: all 0.3s ease; animation: fadeRow 0.5s ease forwards;">
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.04); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $loop->iteration }}</span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-icon" style="width: 32px; height: 32px; border-radius: 50%; background: rgba(14,165,233,0.06); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 14px;">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <span class="fw-semibold" style="color: #0f172a;">{{ $item->ekskul->nama_ekskul ?? '-' }}</span>
                            </div>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="badge nilai-{{ $item->predikat }}" style="padding: 4px 14px; border-radius: 12px; font-size: 14px; font-weight: 700; background: {{ $item->predikat_background }}; color: {{ $item->predikat_color }};">
                                {{ $item->predikat }}
                            </span>
                            <small class="d-block mt-1" style="color: {{ $item->predikat_color }}; font-weight: 600;">{{ $item->predikat_label }}</small>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; color: #64748b; max-width: 260px;">{{ $item->catatan ?? '-' }}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; color: #475569;">
                            {{ ($item->semester ?? '-') . ' ' . ($item->tahun_ajaran ?? '') }}
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span style="color: #475569;">
                                <i class="far fa-calendar-alt me-2 text-muted"></i>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; text-align: center;">
                            <a href="{{ route('anggota.nilai.detail', $item->id) }}" class="btn btn-sm btn-detail" title="Lihat Detail" style="background: transparent; border: none; color: #0ea5e9; padding: 4px 10px; border-radius: 6px; transition: all 0.3s ease; text-decoration: none;">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted" style="padding: 12px 16px; text-align: center; color: #64748b;">
                            <div class="empty-state" style="padding: 30px 0;">
                                <div class="empty-icon" style="font-size: 48px; color: #d1d5db; margin-bottom: 12px;">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h6 style="color: #64748b; margin-bottom: 4px;">Belum ada nilai</h6>
                                <p style="color: #64748b; font-size: 13px;">Nilai Anda akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer premium-table-footer" style="padding: 14px 24px; border-top: 1px solid rgba(0,0,0,0.03); background: rgba(248,250,252,0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="footer-info" style="font-size: 12px; color: #64748b;">
                <i class="fas fa-list me-1"></i>
                @if($nilai->total() > 0)
                    Menampilkan {{ $nilai->firstItem() }} - {{ $nilai->lastItem() }} 
                    dari {{ $nilai->total() }} data
                @else
                    Tidak ada data
                @endif
            </span>
            <div>
                {{ $nilai->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- ===== KETERANGAN PREDIKAT ===== -->
<div class="alert alert-info rounded-4 border-0 shadow-sm" style="background: #f0f9ff; border-left: 4px solid #0ea5e9;">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="bg-info bg-opacity-10 rounded-circle p-2" style="background: rgba(14,165,233,0.08);">
            <i class="fas fa-info-circle fa-2x" style="color: #0ea5e9;"></i>
        </div>
        <div>
            <strong style="color: #0c4a6e;">Keterangan Predikat:</strong>
            <ul class="mb-0 mt-1" style="color: #0c4a6e;">
                <li><strong>S</strong> = Sangat Baik</li>
                <li><strong>A</strong> = Baik</li>
                <li><strong>B</strong> = Cukup</li>
            </ul>
        </div>
    </div>
</div>

<style>
    /* ===== STAT CARD HOVER ===== */
    .stat-card-modern:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(14,165,233,0.08);
        border-color: rgba(14,165,233,0.06);
    }
    
    .stat-card-modern:hover .stat-icon-modern {
        transform: scale(1.08) rotate(-3deg);
    }
    
    .stat-card-modern:hover .stat-progress-modern {
        transform: scaleX(1);
    }

    /* ===== TABLE HOVER ===== */
    .premium-card:hover {
        box-shadow: 0 12px 40px rgba(14,165,233,0.06);
    }
    
    .premium-table tbody tr:hover {
        background: rgba(14,165,233,0.015);
    }

    .btn-detail:hover {
        background: rgba(14,165,233,0.08);
        transform: translateY(-2px);
    }

    @keyframes fadeRow {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== PAGINATION ===== */
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .stat-card-modern {
            padding: 16px 18px;
        }
        .stat-number-modern {
            font-size: 22px !important;
        }
        .premium-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        .premium-table {
            font-size: 12px;
        }
    }
</style>

<script>
    function filterByEkskul(value) {
        const url = new URL(window.location.href);
        if (value) {
            url.searchParams.set('ekskul_id', value);
        } else {
            url.searchParams.delete('ekskul_id');
        }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
</script>
@endsection