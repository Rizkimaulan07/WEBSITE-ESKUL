@extends('layouts.app')

@section('title', 'Dashboard Anggota')
@section('subtitle', 'Selamat datang di dashboard anggota')

@section('content')
@php
    $user = Auth::user();
    $hour = date('H');
    $greeting = $hour < 11 ? '🌅 Selamat Pagi' : ($hour < 15 ? '☀️ Selamat Siang' : ($hour < 19 ? '🌤️ Selamat Sore' : '🌙 Selamat Malam'));
@endphp

<!-- ===== HERO SECTION - Biru Cerah ===== -->
<div class="hero-section mb-4" style="background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 30%, #38bdf8 60%, #7dd3fc 100%); border-radius: 24px; padding: 32px 40px; position: relative; overflow: hidden; box-shadow: 0 8px 40px rgba(14,165,233,0.25);">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-4">
                <div class="hero-icon" style="width: 64px; height: 64px; border-radius: 16px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-user-graduate fa-2x text-white"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1" style="font-size: 22px; letter-spacing: -0.5px;">{{ $greeting }}, {{ $user->name }}! 👋</h4>
                    <p class="text-white-75 mb-1" style="color: rgba(255,255,255,0.75); font-size: 14px;">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-white-75 mb-0" id="clock" style="color: rgba(255,255,255,0.75); font-size: 14px;">
                        <i class="far fa-clock me-2"></i>
                        {{ now()->format('H:i:s') }} WIB
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <span class="hero-badge" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); color: #e2e8f0; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 500; border: 1px solid rgba(255,255,255,0.08);">
                    <i class="fas fa-shield-alt me-2"></i>{{ ucfirst($user->role) }}
                </span>
                <span class="hero-badge" style="background: rgba(16,185,129,0.15); backdrop-filter: blur(12px); color: #34d399; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 500; border: 1px solid rgba(16,185,129,0.1);">
                    <span class="dot" style="width: 7px; height: 7px; background: #34d399; border-radius: 50%; display: inline-block; animation: pulse 2s infinite; margin-right: 8px;"></span>Online
                </span>
            </div>
        </div>
    </div>
    <div class="hero-shapes">
        <div class="shape-circle" style="position: absolute; width: 250px; height: 250px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.05), transparent 70%); top: -120px; right: 10%; pointer-events: none;"></div>
        <div class="shape-circle" style="position: absolute; width: 150px; height: 150px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.04), transparent 70%); bottom: -75px; left: 15%; pointer-events: none;"></div>
        <div class="shape-circle" style="position: absolute; width: 80px; height: 80px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.06), transparent 70%); top: 20%; right: 25%; pointer-events: none; animation: float 8s ease-in-out infinite;"></div>
    </div>
</div>

<!-- ===== STATISTICS CARDS ===== -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Total Kehadiran</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $data['total_kehadiran'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-trend-modern up" style="display: inline-flex; align-items: center; gap: 4px; margin-top: 12px; background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                <i class="fas fa-check-circle"></i> Total
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #0ea5e9, #38bdf8); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Hadir</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $data['hadir'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="stat-trend-modern up" style="display: inline-flex; align-items: center; gap: 4px; margin-top: 12px; background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                <i class="fas fa-arrow-up"></i> Kehadiran
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #10b981, #34d399); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #fffbeb, #fef3c7); display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Persentase Kehadiran</span>
                    <h3 class="stat-number-modern" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -1px;">{{ $data['persentase_hadir'] ?? 0 }}%</h3>
                </div>
            </div>
            <div class="stat-trend-modern up" style="display: inline-flex; align-items: center; gap: 4px; margin-top: 12px; background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                <i class="fas fa-percent"></i> Baik
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #f59e0b, #fbbf24); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-modern" style="background: #ffffff; border-radius: 20px; padding: 22px 24px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); position: relative; overflow: hidden;">
            <div class="d-flex align-items-center gap-4">
                <div class="stat-icon-modern" style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); display: flex; align-items: center; justify-content: center; color: #0ea5e9; font-size: 20px; flex-shrink: 0; transition: all 0.4s ease;">
                    <i class="fas fa-trophy"></i>
                </div>
                <div style="flex: 1;">
                    <span class="stat-label-modern" style="display: block; font-size: 11px; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Ekskul</span>
                    <h3 class="stat-number-modern" style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; letter-spacing: -0.5px; word-break: break-word;">
                        {{ $data['ekskul']->nama_ekskul ?? '-' }}
                    </h3>
                </div>
            </div>
            <div class="stat-trend-modern up" style="display: inline-flex; align-items: center; gap: 4px; margin-top: 12px; background: rgba(16,185,129,0.06); color: #10b981; padding: 2px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                <i class="fas fa-check-circle"></i> Bergabung
            </div>
            <div class="stat-progress-modern" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #0ea5e9, #38bdf8); transform: scaleX(0); transform-origin: left; transition: transform 0.6s ease;"></div>
        </div>
    </div>
</div>

<!-- ===== RIWAYAT KEHADIRAN ===== -->
<div class="card premium-card" style="background: #ffffff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03); box-shadow: 0 2px 12px rgba(0,0,0,0.03); overflow: hidden; transition: all 0.4s ease;">
    <div class="card-header premium-card-header" style="padding: 18px 24px; border-bottom: 1px solid rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; background: rgba(248,250,252,0.2);">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(14,165,233,0.08); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-weight: 700; font-size: 14px; color: #0f172a;">Riwayat Kehadiran Terbaru</h6>
                <small class="text-muted" style="font-size: 12px; color: #94a3b8;">5 kehadiran terakhir</small>
            </div>
        </div>
        <span class="badge-count" style="background: rgba(14,165,233,0.06); color: #0ea5e9; padding: 2px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $data['total_kehadiran'] ?? 0 }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table premium-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">No</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Tanggal</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Status</th>
                        <th style="background: rgba(248,250,252,0.3); color: #64748b; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.03); text-align: left;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($data['riwayat_terbaru'] ?? []) as $index => $item)
                    <tr style="transition: all 0.3s ease; animation: fadeRow 0.5s ease forwards;">
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="number-badge" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: rgba(14,165,233,0.04); color: #0ea5e9; font-weight: 600; font-size: 12px;">{{ $loop->iteration }}</span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span style="color: #475569;">
                                <i class="far fa-calendar-alt me-2 text-muted"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle;">
                            <span class="badge status-{{ $item->status }}" style="padding: 4px 14px; border-radius: 12px; font-size: 12px; font-weight: 500; {{ $item->status == 'hadir' ? 'background: rgba(16,185,129,0.08); color: #10b981;' : ($item->status == 'izin' ? 'background: rgba(245,158,11,0.08); color: #f59e0b;' : ($item->status == 'sakit' ? 'background: rgba(14,165,233,0.08); color: #0ea5e9;' : 'background: rgba(239,68,68,0.08); color: #ef4444;')) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.015); vertical-align: middle; color: #64748b;">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted" style="padding: 12px 16px; text-align: center; color: #94a3b8;">
                            <div class="empty-state" style="padding: 30px 0;">
                                <div class="empty-icon" style="font-size: 48px; color: #d1d5db; margin-bottom: 12px;">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h6 style="color: #64748b; margin-bottom: 4px;">Belum ada riwayat kehadiran</h6>
                                <p style="color: #94a3b8; font-size: 13px;">Kehadiran Anda akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* ===== ANIMATIONS ===== */
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.7); }
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(10px, -20px); }
    }
    
    @keyframes fadeRow {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .hero-section {
            padding: 24px 20px;
        }
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
    function updateClock() {
        const now = new Date();
        const options = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const time = now.toLocaleTimeString('id-ID', options);
        document.getElementById('clock').innerHTML = '<i class="far fa-clock me-2"></i> ' + time + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection