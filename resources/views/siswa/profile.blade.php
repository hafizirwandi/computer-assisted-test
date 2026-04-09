@extends('layouts.main-layout.app-without-menu')
@section('title', 'Profile')
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


        <h3 class="text-center text-white mb-2 fw-bold" style="z-index: 1;">Profil Saya</h3>
        <p class="text-center text-white mb-0 px-3 fs-6" style="z-index: 1;">Data identitas Anda sebagai peserta ujian</p>
    </div>

    <div class="row justify-content-center position-relative" style="margin-top: -60px; z-index: 2;">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush mb-0">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-4">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded bg-label-primary p-2 me-3">
                                    <i class="ti ti-id ti-md"></i>
                                </div>
                                <span class="text-muted fw-semibold">Nomor Induk Siswa (NIS)</span>
                            </div>
                            <span class="fw-bold fs-6">{{ $data->nis }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center p-4">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded bg-label-primary p-2 me-3">
                                    <i class="ti ti-user ti-md"></i>
                                </div>
                                <span class="text-muted fw-semibold">Nama Lengkap</span>
                            </div>
                            <span class="fw-bold fs-6">{{ $data->nama }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center p-4">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded bg-label-primary p-2 me-3">
                                    <i class="ti ti-bookmark ti-md"></i>
                                </div>
                                <span class="text-muted fw-semibold">Kelas & Tingkat</span>
                            </div>
                            <span class="badge bg-primary px-3 py-2 fw-bold fs-6">{{ $data->kelas }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center p-4">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded bg-label-primary p-2 me-3">
                                    <i class="ti ti-building-mosque ti-md"></i>
                                </div>
                                <span class="text-muted fw-semibold">Instansi Sekolah</span>
                            </div>
                            <span class="fw-bold fs-6 text-end">{{ $data->sekolah->nama }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
