@extends('layouts.main-layout.app')
@section('title', 'Home')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-label-primary text-center pb-3 border-bottom">
                    <i class="ti ti-cloud-upload text-primary" style="font-size: 3rem;"></i>
                    <h4 class="card-title fw-bold mt-2 mb-0 text-primary">Sinkronisasi Data Ujian ke Cloud</h4>
                </div>
                <div class="card-body mt-4">
                    <div class="alert alert-warning d-flex align-items-center mb-4 text-justify" role="alert">
                        <span class="alert-icon text-warning me-2">
                            <i class="ti ti-info-circle ti-md"></i>
                        </span>
                        <span>Mohon baca dengan sangat teliti pedoman teknis di bawah ini sebelum Anda mengambil tindakan
                            pengiriman maupun pengeksporan data nilai ujian.</span>
                    </div>

                    <ol class="list-group list-group-numbered list-group-flush mb-4">
                        <li class="list-group-item text-body">Pastikan server lokal anda terhubung dengan jaringan internet
                            yang stabil.</li>
                        <li class="list-group-item text-body">Pastikan data sekolah sudah terisi dengan benar.</li>
                        <li class="list-group-item text-body"><span class="text-danger fw-semibold">Wajib:</span> Kode
                            Sekolah harus berbeda (menggunakan Nomor Pokok Sekolah Nasional / NPSN) agar data yang terkirim
                            ke Cloud tidak error/menimpa data sekolah lainnya.</li>
                        <li class="list-group-item text-body">Pastikan seluruh profil data siswa telah divalidasi
                            kebenarannya.</li>
                        <li class="list-group-item text-body">Pastikan kolom NIS Siswa menggunakan format Nomor Induk Siswa
                            Nasional.</li>
                        <li class="list-group-item text-body">Proses Sinkronisasi dilakukan <strong>setelah seluruh sesi
                                Ujian selesai sepenuhnya</strong> guna menghindari <i>duplikat pengiriman entry</i> ke
                            server pusat.</li>
                        <li class="list-group-item text-body"><strong>Bagi sekolah tanpa akses internet:</strong> Silakan
                            klik <i>Kirim Nilai Offline</i> guna mendownload rekap data komputer, file tersebut nantinya
                            dapat di-import secara manual lewat portal Cloud di lokasi yang berinternet (misal: Disdik).
                        </li>
                    </ol>

                    <div
                        class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-4 border-top pt-4">
                        @can('sinkronisasi-nilai')
                            <button class="btn btn-primary d-flex align-items-center btn-lg" id="syncData">
                                <i class="ti ti-cloud-up me-2"></i> Kirim Nilai Online
                            </button>
                        @endcan
                        @can('eksport-nilai')
                            <a href="{{ route('kirim-nilai.export') }}"
                                class="btn btn-success d-flex align-items-center btn-lg">
                                <i class="ti ti-download me-2"></i> Kirim Nilai Offline
                            </a>
                        @endcan
                        @can('cek-hasil-sinkronisasi-nilai')
                            <a href="{{ route('kirim-nilai.checkSyncData') }}"
                                class="btn btn-outline-secondary d-flex align-items-center btn-lg">
                                <i class="ti ti-search me-2"></i> Cek Hasil Pengiriman
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        @can('sinkronisasi-nilai')
            $(function() {
                $("#syncData").click(function() {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        icon: 'warning',
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light',
                            cancelButton: 'btn btn-label-secondary waves-effect waves-light',

                        },
                        showCancelButton: true,
                        buttonsStyling: false

                    }).then((result) => {
                        if (result.isConfirmed) {
                            syncData();
                        }

                    });

                })

                function syncData() {
                    Swal.fire({
                        title: 'Mohon menunggu...',
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: 'd-none'
                        },
                        buttonsStyling: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: "{{ route('kirim-nilai.syncData') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // Cek status sebenarnya di dalam response JSON
                            if (response.status === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Terkirim!',
                                    text: response.message,
                                    customClass: {
                                        confirmButton: 'btn btn-primary waves-effect waves-light'
                                    },
                                    buttonsStyling: false
                                });
                            } else {
                                // status false tapi HTTP 200 — tampilkan sebagai error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message ||
                                        'Data gagal dikirim ke server. Silakan coba lagi.',
                                    customClass: {
                                        confirmButton: 'btn btn-primary waves-effect waves-light'
                                    },
                                    buttonsStyling: false
                                });
                            }
                        },
                        error: function(xhr) {
                            let msg = 'Terjadi kesalahan koneksi atau server.';
                            try {
                                const resp = JSON.parse(xhr.responseText);
                                msg = resp.message || msg;
                            } catch (e) {}
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: msg,
                                customClass: {
                                    confirmButton: 'btn btn-primary waves-effect waves-light'
                                },
                                buttonsStyling: false
                            });
                        }
                    });
                }
            })
        @endcan
    </script>
@endsection
