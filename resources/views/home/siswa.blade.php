@extends('layouts.main-layout.app-without-menu')
@section('title', 'Home Siswa')
@section('css')
    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/css/pages/page-faq.css') }}" />
    <style>
        .menu-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            border-radius: 16px;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(78, 101, 255, 0.15) !important;
        }

        .icon-container {
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            margin: 0 auto 15px;
        }

        .hero-siswa {
            background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%) !important;
            overflow: hidden;
        }

        /* Decorative circle */
        .hero-siswa::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50px;
            right: -50px;
        }
    </style>
@endsection
@section('content')
    <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded mb-5 position-relative hero-siswa shadow-sm"
        style="padding-top: 5rem; padding-bottom: 6rem;">

        <!-- Tombol Logout -->
        <a href="{{ route('logout') }}" class="btn btn-sm btn-danger position-absolute"
            style="top: 20px; right: 20px; z-index: 2; border-radius: 8px;">
            <i class="ti ti-logout me-1"></i> Logout
        </a>

        <h3 class="text-center text-white mb-2 fw-bold mt-3" style="z-index: 1;"> Hai,
            {{ auth()->guard('siswa')->user()->nama }}</h3>
        <p class="text-center text-white mb-4 px-3 fs-6" style="z-index: 1;">Selamat datang di Sistem Computer Assisted Test
            (CAT)</p>
    </div>

    <div class="row justify-content-center position-relative" style="margin-top: -90px; z-index: 2;">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="row g-4 justify-content-center">
                <!-- Menu Ujian -->
                <div class="col-6 col-md-4">
                    <a href="{{ route('cat') }}" class="card text-center menu-card h-100 shadow-sm text-decoration-none">
                        <div class="card-body py-5">
                            <div class="icon-container bg-label-primary">
                                <i class="ti ti-device-desktop ti-xl text-primary"></i>
                            </div>
                            <h5 class="card-title text-body mb-0 fw-bold">Ujian CAT</h5>
                        </div>
                    </a>
                </div>

                <!-- Menu Nilai -->
                <div class="col-6 col-md-4">
                    <a href="{{ route('cat.nilai') }}"
                        class="card text-center menu-card h-100 shadow-sm text-decoration-none">
                        <div class="card-body py-5">
                            <div class="icon-container bg-label-success">
                                <i class="ti ti-star ti-xl text-success"></i>
                            </div>
                            <h5 class="card-title text-body mb-0 fw-bold">Riwayat Nilai</h5>
                        </div>
                    </a>
                </div>

                <!-- Menu Profil -->
                <div class="col-6 col-md-4">
                    <a href="{{ route('profile') }}"
                        class="card text-center menu-card h-100 shadow-sm text-decoration-none">
                        <div class="card-body py-5">
                            <div class="icon-container bg-label-warning">
                                <i class="ti ti-user-circle ti-xl text-warning"></i>
                            </div>
                            <h5 class="card-title text-body mb-0 fw-bold">Profil Saya</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
