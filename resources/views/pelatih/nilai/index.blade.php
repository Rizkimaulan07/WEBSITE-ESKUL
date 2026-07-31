@extends('layouts.app')

@section('title', 'Nilai Anggota')
@section('subtitle', 'Input dan kelola nilai anggota ekstrakurikuler')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Total Nilai</span>
                <h3 class="stat-number">{{ $statistik['total'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-user-check me-1"></i> Terdaftar
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card gold">
            <div class="stat-icon gold">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Rata-rata</span>
                <h3 class="stat-number">{{ number_format($statistik['rata_rata'] ?? 0, 1) }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-arrow-up me-1"></i> Total
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Tertinggi</span>
                <h3 class="stat-number">{{ $statistik['tertinggi'] ?? 0 }}</h3>
                <span class="stat-change up">
                    <i class="fas fa-star me-1"></i> Terbaik
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card purple">
            <div class="stat-icon purple">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-body">
                <span class="stat-label">Terendah</span>
                <h3 class="stat-number">{{ $statistik['terendah'] ?? 0 }}</h3>
                <span class="stat-change down">
                    <i class="fas fa-arrow-down me-1"></i> Perlu perhatian
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Info Ekskul -->
<div class="card-modern mb-4">
    <div class="card-body-modern">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-trophy text-primary me-2"></i>
                    {{ $ekskul->nama_ekskul ?? 'Ekskul' }}
                </h6>
                <small class="text-muted">Input nilai anggota</small>
            </div>
            <div>
                <span class="badge-soft">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Semester {{ $semester }} {{ $tahunAjaran }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Form Nilai -->
<div class="card-modern">
    <div class="card-header-modern">
        <h6><i class="fas fa-star me-2" style="color: #f59e0b;"></i>Input Nilai Anggota</h6>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn-average" onclick="setAverage()">
                <i class="fas fa-equals me-1"></i> Rata-rata 75
            </button>
            <a href="{{ route('pelatih.nilai.export') }}" class="btn-export">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
        </div>
    </div>
    <div class="card-body-modern">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('pelatih.nilai.store') }}" method="POST" id="nilaiForm">
            @csrf
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Kelas</th>
                            <th>Kehadiran (0-100)</th>
                            <th>Keterampilan (0-100)</th>
                            <th>Sikap (0-100)</th>
                            <th>Total</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggotas as $index => $a)
                        @php
                            $nilai = $a->nilaiAnggota->first();
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($a->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $a->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-soft">{{ $a->kelas ?? '-' }}</span>
                            </td>
                            <td>
                                <input type="number" 
                                       class="form-control form-control-sm nilai-input" 
                                       name="nilai_kehadiran[]" 
                                       min="0" 
                                       max="100"
                                       value="{{ $nilai->nilai_kehadiran ?? 0 }}"
                                       style="width: 80px;"
                                       onchange="updateTotal(this)"
                                       data-index="{{ $index }}">
                            </td>
                            <td>
                                <input type="number" 
                                       class="form-control form-control-sm nilai-input" 
                                       name="nilai_keterampilan[]" 
                                       min="0" 
                                       max="100"
                                       value="{{ $nilai->nilai_keterampilan ?? 0 }}"
                                       style="width: 80px;"
                                       onchange="updateTotal(this)"
                                       data-index="{{ $index }}">
                            </td>
                            <td>
                                <input type="number" 
                                       class="form-control form-control-sm nilai-input" 
                                       name="nilai_sikap[]" 
                                       min="0" 
                                       max="100"
                                       value="{{ $nilai->nilai_sikap ?? 0 }}"
                                       style="width: 80px;"
                                       onchange="updateTotal(this)"
                                       data-index="{{ $index }}">
                            </td>
                            <td>
                                <span class="badge-custom" id="total_{{ $index }}">
                                    {{ $nilai->nilai_total ?? 0 }}
                                </span>
                            </td>
                            <td>
                                <input type="text" 
                                       class="form-control form-control-sm" 
                                       name="catatan[]" 
                                       placeholder="Catatan"
                                       value="{{ $nilai->catatan ?? '' }}"
                                       style="min-width: 100px;">
                            </td>
                        </tr>
                        <input type="hidden" name="anggota_id[]" value="{{ $a->id }}">
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox me-2"></i>Belum ada anggota
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <a href="{{ route('pelatih.dokumentasi') }}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i> Simpan Nilai
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .badge-custom {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        background: rgba(99, 102, 241, 0.06);
        color: #6366f1;
    }

    .badge-soft {
        background: rgba(99, 102, 241, 0.05);
        color: #6366f1;
        padding: 2px 14px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 22px 24px;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
    }

    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-card .stat-icon.blue { background: rgba(99, 102, 241, 0.06); color: #6366f1; }
    .stat-card .stat-icon.gold { background: rgba(245, 158, 11, 0.06); color: #f59e0b; }
    .stat-card .stat-icon.green { background: rgba(16, 185, 129, 0.06); color: #10b981; }
    .stat-card .stat-icon.purple { background: rgba(139, 92, 246, 0.06); color: #8b5cf6; }

    .stat-card .stat-body {
        flex: 1;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin: 2px 0;
        letter-spacing: -0.5px;
    }

    .stat-change {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-change.up {
        background: rgba(16, 185, 129, 0.06);
        color: #10b981;
    }

    .stat-change.down {
        background: rgba(239, 68, 68, 0.06);
        color: #ef4444;
    }

    .card-modern {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .card-body-modern {
        padding: 20px 24px;
    }

    .card-header-modern {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        background: rgba(248, 250, 252, 0.3);
    }

    .card-header-modern h6 {
        font-weight: 600;
        font-size: 14px;
        color: #0f172a;
        margin: 0;
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table-modern thead th {
        background: rgba(248, 250, 252, 0.3);
        color: #64748b;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        text-align: left;
    }

    .table-modern tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.015);
        vertical-align: middle;
    }

    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        flex-shrink: 0;
    }

    .form-control-sm {
        padding: 4px 8px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 6px;
        font-size: 12px;
        font-family: 'Inter', sans-serif;
        background: #f8fafc;
        transition: all 0.3s ease;
        text-align: center;
    }

    .form-control-sm:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.04);
        background: #ffffff;
    }

    .btn-average {
        padding: 6px 16px;
        border: none;
        border-radius: 8px;
        background: rgba(245, 158, 11, 0.06);
        color: #f59e0b;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-average:hover {
        background: rgba(245, 158, 11, 0.12);
        transform: translateY(-2px);
    }

    .btn-export {
        padding: 6px 16px;
        border: none;
        border-radius: 8px;
        background: rgba(16, 185, 129, 0.06);
        color: #10b981;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-export:hover {
        background: rgba(16, 185, 129, 0.12);
        transform: translateY(-2px);
        color: #10b981;
    }

    .btn-cancel {
        padding: 10px 32px;
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 10px;
        background: transparent;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        color: #0f172a;
        text-decoration: none;
    }

    .btn-submit {
        padding: 10px 40px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(99, 102, 241, 0.35);
    }

    .alert {
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }

    .alert .btn-close {
        padding: 12px;
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 16px 18px;
        }
        .stat-card .stat-number {
            font-size: 22px;
        }
        .card-header-modern {
            flex-direction: column;
            align-items: stretch;
            padding: 14px 16px;
        }
        .card-body-modern {
            padding: 14px 16px;
        }
        .table-modern {
            font-size: 12px;
        }
        .form-control-sm {
            width: 60px !important;
        }
    }
</style>

<script>
    function updateTotal(input) {
        const row = input.closest('tr');
        const inputs = row.querySelectorAll('.nilai-input');
        const totalSpan = row.querySelector('.badge-custom');
        
        let total = 0;
        let count = 0;
        
        inputs.forEach(inp => {
            const val = parseInt(inp.value) || 0;
            if (val >= 0 && val <= 100) {
                total += val;
                count++;
            }
        });
        
        if (count > 0) {
            const average = (total / count).toFixed(1);
            totalSpan.textContent = average;
        } else {
            totalSpan.textContent = '0';
        }
    }

    function setAverage() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const inputs = row.querySelectorAll('.nilai-input');
            inputs.forEach(inp => {
                inp.value = 75;
            });
            if (inputs.length > 0) {
                updateTotal(inputs[0]);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nilai-input').forEach(input => {
            updateTotal(input);
        });
    });
</script>
@endsection