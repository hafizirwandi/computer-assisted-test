@extends('layouts.main-layout.app-without-menu')
@section('title', 'Detail Rekap Nilai')
@section('css')
    <style>
        .box-jwb {
            border: 1px solid #dbdade;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .circle-container {
            width: 30px !important;
            height: 30px !important;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
            font-size: 16px;
        }

        .circle-container-sm {
            width: 20px !important;
            height: 20px !important;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
            font-size: 16px;
        }

        .circle-text {
            text-align: center;
        }

        .circle-container.active {
            background-color: #7367f0;
            color: #fff !important;
        }

        .circle-container-sm.active {
            background-color: #7367f0;
            color: #fff !important;
        }

        /* Hero Styles */
        .bg-primary {
            background-color: #3b82f6 !important;
        }

        .bg-label-primary {
            background-color: #eff6ff !important;
            color: #3b82f6 !important;
        }

        .text-primary {
            color: #3b82f6 !important;
        }

        .btn-warning {
            background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f97316 0%, #c2410c 100%) !important;
            transform: scale(1.02);
            color: #fff !important;
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
@endsection

@section('content')
    <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded mb-5 position-relative hero-siswa shadow-sm"
        style="padding-top: 3rem; padding-bottom: 4rem;">

        <!-- Tombol Kembali -->
        <a href="{{ route('cat.nilai') }}"
            class="btn btn-warning rounded-pill position-absolute top-0 start-0 m-4 shadow-sm fw-bold text-white"
            style="z-index: 2;">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>

        <h3 class="text-center text-white mb-2 fw-bold mt-3" style="z-index: 1;"> Detail Hasil Ujian</h3>
        <p class="text-center text-white mb-0 px-3 fs-6" style="z-index: 1;">Rincian poin dan jawaban untuk ujian Anda</p>
    </div>

    <div class="row justify-content-center position-relative" style="margin-top: -60px; z-index: 2;">
        <div class="col-12 ">
            <div class="card shadow-sm border-0 mb-4 rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    @php $no = 1; @endphp
                    @foreach ($data as $j)
                        <div class="mb-5 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm"
                                    style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold; flex-shrink: 0;">
                                    {{ $no }}
                                </div>
                                <div class="w-100 d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1 fw-bold text-dark">Detail Pertanyaan</h5>
                                        <div class="badge bg-label-info px-2 py-1 rounded small">{!! tipeSoal($j->ref_butir_soal) !!}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                            Skor Anda: {{ $j->poin_benar }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-white shadow-sm rounded-4 border mb-4">
                                @if ($j->ref_butir_soal == '1')
                                    @php $r = $j->butirSoal; @endphp
                                    <div class="fs-6 text-dark mb-4">{!! $r->soal !!}</div>

                                    <div class="row g-3">
                                        @php $const_jwb = explode(",",$r->tipe_optional_jawaban); @endphp
                                        @foreach ($const_jwb as $jwb)
                                            <div class="col-12">
                                                <div
                                                    class="d-flex p-3 rounded-3 border {{ $jwb == $j->jawaban ? 'bg-label-primary border-primary' : 'bg-light' }} align-items-center">
                                                    <div class="circle-container {{ $jwb == $j->jawaban ? 'active shadow-sm' : 'bg-white border' }}"
                                                        style="flex-shrink: 0;">
                                                        <span
                                                            class="circle-text fw-bold {{ $jwb == $j->jawaban ? 'text-white' : 'text-dark' }}">{{ strtoupper($jwb) }}</span>
                                                    </div>
                                                    <div class="ms-3 mb-0">
                                                        {!! $r->{'jawaban_' . $jwb} !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4 pt-3 border-top">
                                        <span class="badge bg-success bg-glow rounded-pill px-3 py-2">
                                            <i class="ti ti-check me-1"></i> Jawaban Benar:
                                            {{ strtoupper($r->jawaban_benar) }} (Poin Maks: {{ $r->poin_benar }})
                                        </span>
                                    </div>
                                @elseif ($j->ref_butir_soal == '2')
                                    @php $r = $j->butirSoal2; @endphp
                                    <div class="fs-6 text-dark mb-4">{!! $r->soal !!}</div>

                                    <div class="row g-3">
                                        @php
                                            $const_jwb = explode(',', $r->tipe_optional_jawaban);
                                            $jawaban = json_decode($j->jawaban, true);
                                        @endphp
                                        @foreach ($const_jwb as $jwb)
                                            @php $isSelected = is_array($jawaban) && in_array($jwb, $jawaban); @endphp
                                            <div class="col-12">
                                                <div
                                                    class="d-flex p-3 rounded-3 border {{ $isSelected ? 'bg-label-primary border-primary' : 'bg-light' }} align-items-center">
                                                    <div class="circle-container {{ $isSelected ? 'active shadow-sm' : 'bg-white border' }}"
                                                        style="flex-shrink: 0; border-radius: 8px !important;">
                                                        <i
                                                            class="ti {{ $isSelected ? 'ti-check text-white' : 'ti-square text-muted' }} fs-5"></i>
                                                    </div>
                                                    <div class="ms-3 mb-0">
                                                        {!! $r->{'jawaban_' . $jwb} !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4 pt-3 border-top">
                                        <div
                                            class="badge bg-success bg-glow rounded-pill px-3 py-2 d-inline-flex align-items-center flex-wrap gap-2">
                                            <i class="ti ti-check me-1"></i> Poin Benar Kunci:
                                            @foreach ($const_jwb as $l)
                                                <span
                                                    class="bg-white text-success px-2 py-1 rounded small">{{ strtoupper($l) }}
                                                    = {!! $r->{'poin_benar_' . $l} !!}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif ($j->ref_butir_soal == '3')
                                    @php $r = $j->butirSoal3; @endphp
                                    <div class="fs-6 text-dark mb-4">{!! $r->soal !!}</div>

                                    @php
                                        $jawaban = json_decode($j->jawaban, true);
                                        $pernyataan = json_decode($r->pernyataan_soal);
                                        $poin_benar = json_decode($r->poin_benar);
                                        $opsi_jawaban = json_decode($r->optional_jawaban);
                                    @endphp
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover align-middle mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th style="width:50%" class="text-dark fw-bold">Pernyataan</th>
                                                    @foreach ($opsi_jawaban as $oj)
                                                        <th class="text-center text-dark fw-bold">{{ $oj }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 0; @endphp
                                                @foreach ($pernyataan as $p)
                                                    <tr>
                                                        <td class="text-wrap">{{ $p }}</td>
                                                        @for ($m = 0; $m < count($opsi_jawaban); $m++)
                                                            @php $isSelected = ($jawaban[$i] ?? '') == $m; @endphp
                                                            <td
                                                                class="text-center {{ $isSelected ? 'bg-label-primary' : '' }}">
                                                                <div
                                                                    class="d-flex flex-column align-items-center justify-content-center">
                                                                    <div class="circle-container-sm mb-2 {{ $isSelected ? 'active shadow-sm' : 'bg-light border' }}"
                                                                        style="margin-right: 0;">
                                                                        @if ($isSelected)
                                                                            <i class="ti ti-check text-white fs-6"></i>
                                                                        @endif
                                                                    </div>
                                                                    <span class="badge bg-success bg-glow small">Poin:
                                                                        {{ $poin_benar[$i][$m] }}</span>
                                                                </div>
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @elseif ($j->ref_butir_soal == '4')
                                    @php $r = $j->butirSoal4; @endphp
                                    <div class="fs-6 text-dark mb-4">{!! $r->soal !!}</div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark">Jawaban Anda:</label>
                                        <div class="p-3 bg-light rounded-3 border">
                                            {{ $j->jawaban ?: '(Kosong)' }}
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-top d-flex flex-column gap-2">
                                        <span class="badge bg-success bg-glow rounded-pill px-3 py-2 align-self-start">
                                            <i class="ti ti-check me-1"></i> Referensi Jawaban: {{ $r->jawaban }}
                                        </span>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-label-secondary text-dark rounded-pill">Range Poin:
                                                {{ $r->poin_minimal }} - {{ $r->poin_maksimal }}</span>
                                            <span class="badge bg-label-secondary text-dark rounded-pill">Penilaian Kunci
                                                Kata: {{ $r->kunci_kata == 1 ? 'Ya (Otomatis)' : 'Tidak (Manual)' }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @php $no++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
