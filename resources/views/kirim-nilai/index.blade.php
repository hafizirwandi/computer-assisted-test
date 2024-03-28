@extends('layouts.main-layout.app')
@section('title', 'Home')
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Ketentuan untuk sinkronisasi data ke Cloud</h5>
                    <ol style="text-align:justify">
                        <li>Pastikan server lokal anda terhubung dengan internet;</li>
                        <li>Pastikan data sekolah sudah terisi dengan benar;</li>
                        <li>Kode Sekolah harus berbeda tiap-tiap sekolah, disarankan menggunakan Nomor Kode Sekolah Nasional
                            agar data yang sedang disinkronisasi tidak menimpa dengan sekolah lainnya;</li>
                        <li>Pastikan Pada data siswa sudah terisi dengan benar;</li>
                        <li>Pastikan NIS Siswa juga menggunakan Nomor Induk Siswa Nasional;</li>
                        <li>Pastikan Ujian sudah selesai terlaksana dengan benar untuk menghindari duplikat entry;</li>
                        <li>Bagi sekolah yang tidak memiliki jaringan internet silahkan untuk mengeksport data dulu
                            modul <a href=""><i>Export Nilai</i></a> untuk kemudian selanjut nya di Import ke Cloud di
                            modul <a href=""><i>Import Nilai</i></a>;
                        </li>
                        <li>Silahkan hubungi pihak panitia apabila mengalami kendala dalam hal Sikroniasi Data ke Cloud;
                        </li>
                        <li>Apabilah sudah yakin , silahkan klik tombol <i>Sinkornisasi Nilai</i> dibawah ini.</li>
                        <li>Silahkan klik tombol <i>Check Hasil Sinkornisasi</i> untuk melihat apakah data sudah benar
                            tersinkron ke server cloud</li>
                    </ol>
                    <button class="btn btn-primary" id="syncData">Sinkroniasi Nilai</button>
                    <button class="btn btn-warning" id="checkSyncData">Check Hasil Sinkronisasi</button>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('script')
    <script>
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
                $.ajax({
                    url: "{{ route('kirim-nilai.syncData') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            customClass: {
                                confirmButton: 'btn btn-primary waves-effect waves-light'
                            },
                            buttonsStyling: false
                        });

                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseText,
                            customClass: {
                                confirmButton: 'btn btn-primary waves-effect waves-light'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            }
        })
    </script>
@endsection
