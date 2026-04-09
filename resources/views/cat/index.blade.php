@extends('layouts.main-layout.app-without-menu')
@section('title', 'Ujian CAT')

@section('content')
    <style>
        .bg-primary {
            background-color: #3b82f6 !important;
            /* Softer Blue */
        }

        .bg-label-primary {
            background-color: #eff6ff !important;
            color: #3b82f6 !important;
        }

        .text-primary {
            color: #3b82f6 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            transform: scale(1.02);
        }

        .btn-warning {
            background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%) !important;
            /* Orange Gradient */
            border: none !important;
            color: #fff !important;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f97316 0%, #c2410c 100%) !important;
            /* Darker Orange */
            transform: scale(1.02);
            color: #fff !important;
        }

        .badge.bg-white.text-primary {
            color: #3b82f6 !important;
        }

        .hero-siswa {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%) !important;
            overflow: hidden;
        }

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

    <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded mb-5 position-relative hero-siswa shadow-sm"
        style="padding-top: 3rem; padding-bottom: 4rem;">

        <!-- Tombol Kembali -->
        <a href="{{ route('home.siswa') }}"
            class="btn btn-warning rounded-pill position-absolute top-0 start-0 m-4 shadow-sm fw-bold text-white"
            style="z-index: 2;">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>

        <h3 class="text-center text-white mb-2 fw-bold mt-3" style="z-index: 1;"> Jadwal Ujian CAT</h3>
        <p class="text-center text-white mb-0 px-3 fs-6" style="z-index: 1;">Daftar ujian yang tersedia untuk dikerjakan</p>
    </div>

    <div class="row justify-content-center position-relative" style="margin-top: -60px; z-index: 2;">
        <div class="col-12 ">
            @if (count($ujian) == 0)
                <div class="alert alert-info text-center mt-5 mb-5 shadow-sm rounded-4 border-0 p-4">
                    <i class="ti ti-info-circle ti-xl mb-3 text-info"></i>
                    <h5 class="mb-0 text-info fw-bold">Belum ada jadwal ujian aktif untuk Anda saat ini!</h5>
                </div>
            @endif

            @foreach ($ujian as $r)
                <div class="card shadow-sm border-0 mb-4 rounded-4 overflow-hidden">
                    <div
                        class="card-header bg-primary py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                        <h5 class="mb-2 mb-sm-0 text-white fw-bold d-flex align-items-center">
                            <i class="ti ti-device-laptop me-2"></i> {{ $r->soal->nama }}
                        </h5>
                        <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold shadow-sm">
                            Kode: {{ $r->kode_ujian }}
                        </span>
                    </div>

                    <div class="card-body p-4">
                        @if ($r->hu)
                            <div class="alert alert-success d-flex align-items-center mb-4 border-0 border-start border-5 border-success shadow-sm"
                                role="alert">
                                <span class="alert-icon text-success me-3">
                                    <i class="ti ti-checkbox ti-md"></i>
                                </span>
                                <div>
                                    <strong>Selamat!</strong> Anda sudah mentuntaskan ujian ini. Jika status ini keliru,
                                    segera hubungi operator untuk bantuan reset sesi ujian.
                                </div>
                            </div>
                        @endif

                        <div class="row align-items-center g-4">
                            <!-- Info 1: Jumlah Soal -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-circle bg-label-primary p-3 me-3">
                                        <i class="ti ti-notes ti-md"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted fw-semibold"
                                            style="font-size: 0.8rem; text-transform: uppercase;">Jumlah Soal</p>
                                        <h6 class="mb-0 fw-bold fs-5 text-primary">{{ $r->jlh_soal }} Butir</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Info 2: Waktu Ujian -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-circle bg-label-primary p-3 me-3">
                                        <i class="ti ti-clock-hour-4 ti-md"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted fw-semibold"
                                            style="font-size: 0.8rem; text-transform: uppercase;">Durasi</p>
                                        <h6 class="mb-0 fw-bold fs-5 text-primary">{{ $r->waktu }} Menit</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Info 3: Tanggal -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-circle bg-label-primary p-3 me-3">
                                        <i class="ti ti-calendar ti-md"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted fw-semibold"
                                            style="font-size: 0.8rem; text-transform: uppercase;">Tenggat</p>
                                        <h6 class="mb-0 fw-bold fs-5 text-primary">
                                            {{ \Carbon\Carbon::parse($r->tanggal_ujian)->format('d M Y') }}</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="col-12 col-md-3 text-md-end mt-4 mt-md-0">
                                <form method="post" action="{{ route('cat.checkKodeUjian') }}" class="m-0">
                                    @csrf
                                    <input type="hidden" name="kode_ujian" value="{{ $r->kode_ujian }}">
                                    <button
                                        onclick="return confirm('Sudah siap dan yakin? Waktu mundur akan langsung berjalan ya!')"
                                        type="submit" class="btn btn-warning shadow-sm w-100 py-3 fw-bold"
                                        style="border-radius: 50px;" {{ $r->hu ? 'disabled' : '' }}>
                                        <i class="ti ti-player-play me-2"></i> Mulai Ujian
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection
