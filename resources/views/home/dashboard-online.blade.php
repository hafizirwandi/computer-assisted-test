@extends('layouts.main-layout.app')
@section('title', 'Dashboard Online')

@section('css')
    <style>
        /* ─── Color Tokens ─────────────────────────────── */
        :root {
            --c-blue: #4E65FF;
            --c-teal: #00C6AE;
            --c-orange: #FF8C42;
            --c-purple: #8B5CF6;
            --c-pink: #EC4899;
            --c-green: #10B981;
        }

        /* ─── Header ───────────────────────────────────── */
        .dashboard-header {
            background: linear-gradient(135deg, var(--c-blue) 0%, var(--c-teal) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: -0.5px;
        }

        /* ─── Stat Cards ────────────────────────────────── */
        .stat-card {
            border: none;
            border-radius: 20px;
            color: #fff;
            overflow: hidden;
            position: relative;
            transition: transform .3s cubic-bezier(.4, 0, .2, 1), box-shadow .3s cubic-bezier(.4, 0, .2, 1);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -40%;
            left: -40%;
            width: 180%;
            height: 180%;
            background: radial-gradient(circle, rgba(255, 255, 255, .15) 0%, rgba(255, 255, 255, 0) 65%);
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-6px);
        }

        .stat-card.c-blue {
            background: linear-gradient(135deg, #4E65FF 0%, #7B93FF 100%);
        }

        .stat-card.c-teal {
            background: linear-gradient(135deg, #00C6AE 0%, #00E5C8 100%);
        }

        .stat-card.c-orange {
            background: linear-gradient(135deg, #FF8C42 0%, #FFB347 100%);
        }

        .stat-card.c-purple {
            background: linear-gradient(135deg, #8B5CF6 0%, #A78BFA 100%);
        }

        .stat-card.c-pink {
            background: linear-gradient(135deg, #EC4899 0%, #F472B6 100%);
        }

        .stat-card.c-green {
            background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
        }

        .stat-card.c-dark {
            background: linear-gradient(135deg, #1E293B 0%, #334155 100%);
        }

        .stat-card:hover.c-blue {
            box-shadow: 0 16px 32px rgba(78, 101, 255, .35);
        }

        .stat-card:hover.c-teal {
            box-shadow: 0 16px 32px rgba(0, 198, 174, .35);
        }

        .stat-card:hover.c-orange {
            box-shadow: 0 16px 32px rgba(255, 140, 66, .35);
        }

        .stat-card:hover.c-purple {
            box-shadow: 0 16px 32px rgba(139, 92, 246, .35);
        }

        .stat-card:hover.c-pink {
            box-shadow: 0 16px 32px rgba(236, 72, 153, .35);
        }

        .stat-card:hover.c-green {
            box-shadow: 0 16px 32px rgba(16, 185, 129, .35);
        }

        .stat-card:hover.c-dark {
            box-shadow: 0 16px 32px rgba(30, 41, 59, .35);
        }

        .stat-icon {
            background: rgba(255, 255, 255, .22);
            backdrop-filter: blur(6px);
            border-radius: 14px;
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon i {
            font-size: 28px;
        }

        /* ─── Section Cards ─────────────────────────────── */
        .section-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .06);
        }

        .section-card .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 700;
            font-size: 1.05rem;
            color: #1e293b;
            padding: 1.2rem 1.5rem;
        }

        /* ─── Table ─────────────────────────────────────── */
        .table-hover tbody tr:hover {
            background: #f8faff;
        }

        .badge-rank {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .85rem;
        }

        .rank-1 {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #fff;
        }

        .rank-2 {
            background: linear-gradient(135deg, #C0C0C0, #A8A8A8);
            color: #fff;
        }

        .rank-3 {
            background: linear-gradient(135deg, #CD7F32, #A0522D);
            color: #fff;
        }

        .rank-n {
            background: #f1f5f9;
            color: #64748b;
        }

        /* ─── Progress ──────────────────────────────────── */
        .progress {
            height: 10px;
            border-radius: 999px;
            background: #f1f5f9;
        }

        .progress-bar {
            border-radius: 999px;
        }

        /* ─── Chart container ───────────────────────────── */
        #distribusiChart {
            max-height: 260px;
        }
    </style>
@endsection

@section('content')
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="dashboard-header mb-1">Dashboard Rekap Global</h2>
            <p class="text-muted fw-medium">Statistik nilai siswa dari seluruh sekolah yang tersinkronisasi.</p>
        </div>
    </div>

    {{-- ── Stat Cards Row 1 ── --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card c-blue">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.9rem;">Total Siswa</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($widget['total_siswa']) }}</h2>
                    </div>
                    <div class="stat-icon"><i class="ti ti-users"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card c-teal">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.9rem;">Total Sekolah</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($widget['total_sekolah']) }}</h2>
                    </div>
                    <div class="stat-icon"><i class="ti ti-school"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card c-orange">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.9rem;">Total Ujian</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($widget['total_ujian']) }}</h2>
                    </div>
                    <div class="stat-icon"><i class="ti ti-clipboard-list"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card c-purple">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.9rem;">Mata Pelajaran</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($widget['total_mapel']) }}</h2>
                    </div>
                    <div class="stat-icon"><i class="ti ti-books"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Stat Cards Row 2 (Nilai) ── --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card stat-card c-green">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.9rem;">Rata-rata Nilai</p>
                        <h2 class="mb-0 fw-bold">{{ $widget['rata_nilai'] }}</h2>
                    </div>
                    <div class="stat-icon"><i class="ti ti-chart-bar"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card stat-card c-blue">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.9rem;">Nilai Tertinggi</p>
                        <h2 class="mb-0 fw-bold">{{ $widget['nilai_tertinggi'] }}</h2>
                    </div>
                    <div class="stat-icon"><i class="ti ti-trophy"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card stat-card c-pink">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold" style="opacity:.85; font-size:.9rem;">Nilai Terendah</p>
                        <h2 class="mb-0 fw-bold">{{ $widget['nilai_terendah'] }}</h2>
                    </div>
                    <div class="stat-icon"><i class="ti ti-arrow-down-circle"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Chart + Rekap Mapel ── --}}
    <div class="row g-4 mb-4">
        {{-- Distribusi Nilai (Pie Chart) --}}
        <div class="col-lg-5">
            <div class="card section-card h-100">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="ti ti-chart-pie text-primary"></i>
                    Distribusi Nilai
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="distribusiChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Rekap Per Mata Pelajaran --}}
        <div class="col-lg-7">
            <div class="card section-card h-100">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="ti ti-books text-primary"></i>
                    Rekap Per Mata Pelajaran
                </div>
                <div class="card-body p-0">
                    @if ($rekapMapel->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="ti ti-database-off" style="font-size:3rem; opacity:.4;"></i>
                            <p class="mt-2 mb-0">Belum ada data nilai.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width:50px;">#</th>
                                        <th>Mata Pelajaran</th>
                                        <th class="text-center">Siswa</th>
                                        <th class="text-center">Min</th>
                                        <th class="text-center">Max</th>
                                        <th>Rata-rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekapMapel as $i => $mapel)
                                        <tr>
                                            <td class="ps-4">
                                                @php $r = $i + 1; @endphp
                                                <span
                                                    class="badge-rank {{ $r === 1 ? 'rank-1' : ($r === 2 ? 'rank-2' : ($r === 3 ? 'rank-3' : 'rank-n')) }}">
                                                    {{ $r }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold">{{ $mapel->matapelajaran }}</td>
                                            <td class="text-center">{{ number_format($mapel->jumlah_siswa) }}</td>
                                            <td class="text-center">{{ $mapel->nilai_min }}</td>
                                            <td class="text-center">{{ $mapel->nilai_max }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress flex-grow-1">
                                                        <div class="progress-bar bg-primary"
                                                            style="width: {{ min($mapel->rata_nilai, 100) }}%"></div>
                                                    </div>
                                                    <span class="fw-bold"
                                                        style="min-width:38px; text-align:right;">{{ $mapel->rata_nilai }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ── Rekap Per Sekolah ── --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="card section-card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="ti ti-building-community text-primary"></i>
                    Rekap Per Sekolah
                </div>
                <div class="card-body p-0">
                    @if ($rekapSekolah->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="ti ti-database-off" style="font-size:3rem; opacity:.4;"></i>
                            <p class="mt-2 mb-0">Belum ada data nilai.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width:50px;">#</th>
                                        <th>Nama Sekolah</th>
                                        <th>Kode Sekolah</th>
                                        <th class="text-center">Jumlah Siswa</th>
                                        <th class="text-center">Nilai Min</th>
                                        <th class="text-center">Nilai Max</th>
                                        <th>Rata-rata Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekapSekolah as $i => $sekolah)
                                        <tr>
                                            <td class="ps-4">
                                                @php $r = $i + 1; @endphp
                                                <span
                                                    class="badge-rank {{ $r === 1 ? 'rank-1' : ($r === 2 ? 'rank-2' : ($r === 3 ? 'rank-3' : 'rank-n')) }}">
                                                    {{ $r }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold">{{ $sekolah->nama_sekolah }}</td>
                                            <td><span class="badge bg-label-secondary">{{ $sekolah->kode_sekolah }}</span>
                                            </td>
                                            <td class="text-center">{{ number_format($sekolah->jumlah_siswa) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-label-danger">{{ $sekolah->nilai_min }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-label-success">{{ $sekolah->nilai_max }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress flex-grow-1">
                                                        <div class="progress-bar"
                                                            style="width: {{ min($sekolah->rata_nilai, 100) }}%;
                                                            background: linear-gradient(90deg, #4E65FF, #00C6AE);">
                                                        </div>
                                                    </div>
                                                    <span class="fw-bold"
                                                        style="min-width:38px; text-align:right;">{{ $sekolah->rata_nilai }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // ── Pie Chart: Distribusi Nilai ─────────────────
        const distribusiData = {
            labels: ['0 – 20', '21 – 40', '41 – 60', '61 – 80', '81 – 100'],
            datasets: [{
                data: [
                    {{ $distribusi['0-20'] }},
                    {{ $distribusi['21-40'] }},
                    {{ $distribusi['41-60'] }},
                    {{ $distribusi['61-80'] }},
                    {{ $distribusi['81-100'] }},
                ],
                backgroundColor: ['#EC4899', '#FF8C42', '#FBBF24', '#4E65FF', '#10B981'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 10,
            }]
        };

        new Chart(document.getElementById('distribusiChart'), {
            type: 'doughnut',
            data: distribusiData,
            options: {
                responsive: true,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 18,
                            font: {
                                size: 13
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                                return ` ${ctx.label}: ${ctx.parsed} siswa (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
