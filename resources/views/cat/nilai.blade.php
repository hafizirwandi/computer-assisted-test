@extends('layouts.main-layout.app-without-menu')
@section('title', 'Nilai CAT')

@section('content')
    <style>
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

        <h3 class="text-center text-white mb-2 fw-bold mt-3" style="z-index: 1;"> Riwayat Nilai & Hasil Ujian</h3>
        <p class="text-center text-white mb-0 px-3 fs-6" style="z-index: 1;">Catatan pencapaian ujian CAT Anda</p>
    </div>

    <div class="row justify-content-center position-relative" style="margin-top: -60px; z-index: 2;">
        <div class="col-12">

            @if ($data->isEmpty())
                <div class="alert alert-info text-center rounded-4 border-0 p-4 shadow-sm">
                    <i class="ti ti-info-circle ti-xl mb-2 d-block text-info"></i>
                    <h6 class="mb-0 fw-bold text-info">Anda belum memiliki riwayat nilai ujian.</h6>
                </div>
            @endif

            @foreach ($data as $r)
                <div class="card shadow-sm border-0 mb-4 rounded-4 overflow-hidden">
                    <!-- Header Kartu -->
                    <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center"
                        style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);">
                        <div>
                            <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
                                <i class="ti ti-device-laptop me-2"></i>
                                @if ($r->pengaturanUjian)
                                    {{ $r->pengaturanUjian->soal->nama }}
                                @else
                                    Ujian (data dihapus)
                                @endif
                            </h6>
                            <small class="text-white opacity-75">
                                <i class="ti ti-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($r->created_at)->isoFormat('D MMM YYYY, HH:mm') }}
                            </small>
                        </div>
                        @if ($r->pengaturanUjian)
                            <span class="badge bg-white fw-semibold rounded-pill px-3 py-2 mt-2 mt-sm-0"
                                style="color: #3b82f6;">
                                Kode: {{ $r->pengaturanUjian->kode_ujian }}
                            </span>
                        @endif
                    </div>

                    <!-- Body Kartu: Statistik -->
                    <div class="card-body p-4">
                        <div class="row g-3 align-items-center">
                            <!-- Total Soal -->
                            <div class="col-6 col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-primary p-2 me-3">
                                        <i class="ti ti-notes ti-md"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted fw-semibold"
                                            style="font-size: 0.75rem; text-transform: uppercase;">Total Soal</p>
                                        <h6 class="mb-0 fw-bold" style="color:#3b82f6">{{ $r->jlh_soal }}</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Dijawab -->
                            <div class="col-6 col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-success p-2 me-3">
                                        <i class="ti ti-circle-check ti-md"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted fw-semibold"
                                            style="font-size: 0.75rem; text-transform: uppercase;">Dijawab</p>
                                        <h6 class="mb-0 fw-bold text-success">{{ $r->jlh_soal - $r->jlh_tidak_jawab }}</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Tidak Jawab -->
                            <div class="col-6 col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-secondary p-2 me-3">
                                        <i class="ti ti-circle-minus ti-md"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted fw-semibold"
                                            style="font-size: 0.75rem; text-transform: uppercase;">Kosong</p>
                                        <h6 class="mb-0 fw-bold text-secondary">{{ $r->jlh_tidak_jawab }}</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Nilai -->
                            <div class="col-6 col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-warning p-2 me-3">
                                        <i class="ti ti-star ti-md"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-muted fw-semibold"
                                            style="font-size: 0.75rem; text-transform: uppercase;">Nilai</p>
                                        <h6 class="mb-0 fw-bold text-warning">{{ $r->nilai }}</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Detail -->
                            <div class="col-12 col-md-2 text-md-end">
                                <a href="{{ route('cat.nilai.detail', $r->id) }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-4 fw-semibold">
                                    <i class="ti ti-eye me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
