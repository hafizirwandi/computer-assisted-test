@extends('layouts.main-layout.app')
@section('title', 'Admin Dashboard')

@section('css')
    <style>
        .gradient-card {
            color: #fff;
            border: none;
            border-radius: 20px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .gradient-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(30deg);
            pointer-events: none;
        }

        .gradient-card:hover {
            transform: translateY(-8px);
        }

        .gradient-card.siswa-card {
            background: linear-gradient(135deg, #FF6B6B 0%, #4E65FF 100%) !important;
        }

        .gradient-card.siswa-card:hover {
            box-shadow: 0 15px 30px rgba(78, 101, 255, 0.3);
        }

        .gradient-card.sekolah-card {
            background: linear-gradient(135deg, #FF9A9E 0%, #FECFEF 99%, #FECFEF 100%) !important;
            /* Let's use a stronger orange/red gradient instead for better contrast with white text */
            background: linear-gradient(135deg, #FAD961 0%, #F76B1C 100%) !important;
        }

        .gradient-card.sekolah-card:hover {
            box-shadow: 0 15px 30px rgba(247, 107, 28, 0.3);
        }

        .gradient-card.mapel-card {
            background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%) !important;
        }

        .gradient-card.mapel-card:hover {
            box-shadow: 0 15px 30px rgba(0, 114, 255, 0.3);
        }

        .gradient-card.soal-card {
            background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%) !important;
        }

        .gradient-card.soal-card:hover {
            box-shadow: 0 15px 30px rgba(74, 0, 224, 0.3);
        }

        .gradient-card .card-title {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .gradient-card .avatar {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            width: 60px;
            height: 60px;
            border-radius: 15px !important;
            backdrop-filter: blur(5px);
        }

        .gradient-card .avatar i {
            font-size: 28px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #FF6B6B 0%, #4E65FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 2.2rem;
            letter-spacing: -0.5px;
        }
    </style>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="dashboard-header mb-1">Overview Dashboard</h2>
            <p class="text-muted fw-medium">Ringkasan data statistik Computer Assisted Test saat ini.</p>
        </div>
    </div>

    <div class="row">
        <!-- Card Siswa -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card gradient-card siswa-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Total Siswa</h5>
                        <h2 class="mb-0 text-white fw-bold">{{ number_format($widget['siswa'] ?? 0) }}</h2>
                    </div>
                    <div class="avatar d-flex justify-content-center align-items-center">
                        <i class="ti ti-user-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Sekolah -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card gradient-card sekolah-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Sekolah</h5>
                        <h2 class="mb-0 text-white fw-bold">{{ number_format($widget['sekolah'] ?? 0) }}</h2>
                    </div>
                    <div class="avatar d-flex justify-content-center align-items-center">
                        <i class="ti ti-school"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Mapel -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card gradient-card mapel-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Mata Pelajaran</h5>
                        <h2 class="mb-0 text-white fw-bold">{{ number_format($widget['matapelajaran'] ?? 0) }}</h2>
                    </div>
                    <div class="avatar d-flex justify-content-center align-items-center">
                        <i class="ti ti-books"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Soal -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card gradient-card soal-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Bank Soal</h5>
                        <h2 class="mb-0 text-white fw-bold">{{ number_format($widget['soal'] ?? 0) }}</h2>
                    </div>
                    <div class="avatar d-flex justify-content-center align-items-center">
                        <i class="ti ti-microscope"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar d-flex justify-content-center align-items-center me-4"
                            style="background: rgba(78, 101, 255, 0.1); width: 80px; height: 80px; border-radius: 20px;">
                            <i class="ti ti-chart-bar" style="font-size: 40px; color: #4E65FF;"></i>
                        </div>
                        <div>
                            <h4 class="mb-2 fw-bold" style="color: #1e293b;">Computer Assisted Test System</h4>
                            <p class="text-muted mb-0" style="font-size: 1.1rem;">Platform ujian berbasis komputer terpadu.
                                Pastikan seluruh data master seperti sekolah, mata pelajaran, dan bank soal telah diisi
                                dengan benar sebelum memulai jadwal ujian.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
