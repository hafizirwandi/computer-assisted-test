 @extends('layouts.main-layout.app-without-menu')
 @section('title', 'CAT')
 @section('css')
     <style>
         .wrap-nomor {
             display: flex;
             flex-wrap: wrap;
             justify-content: space-between;
         }

         .btn-nomor {
             width: calc(20% - 10px);
             height: 50px;
             margin: 5px;
             border: 1px solid #eaeaea;
             border-radius: 5px;
         }

         .btn-nomor:hover {
             background-color: lightgray;
         }

         /* Mengubah warna tombol saat aktif (ditekan) */
         .btn-nomor:active {
             background-color: gray;
         }

         /* Mengubah warna tombol yang memiliki kelas active */
         .btn-nomor.active {
             background-color: #7367f0;
             /* background-color: #ff9f43; */
             color: #fff;
         }

         .btn-nomor.onlink {
             background-color: gray;
         }

         #countdown {
             font-size: 20pt;
             font-weight: 700;
             text-align: right;
             letter-spacing: 2pt
         }

         .box-pointer-soal {
             display: flex;
             flex-wrap: wrap;
             justify-content: space-between;
         }
     </style>
 @endsection
 @section('content')

     <div class="card mb-4">
         <div class="card-body row g-3">
             <div class="col-lg-9">

                 <div class="card shadow-none border">

                     <div id="soal" class="card-body">


                     </div>
                 </div>

                 <div class="box-pointer-soal mt-3">
                     <button id="btn-prev" class="btn btn-warning d-none"><i class="tf-icons ti ti-chevrons-left"></i> Sebelum
                         nya</button>
                     <button id="btn-next" class="btn btn-primary d-none">Selanjutnya nya <i
                             class="tf-icons ti ti-chevrons-right"></i></button>
                 </div>
             </div>
             <div class="col-lg-3">

                 <div class="card mb-3">
                     <div class="card-header header-elements">
                         <i class="ti ti-clock-hour-3" style="font-size: 18pt; margin-right:10px"></i>
                         <span id="countdown">00:00</span>

                         <div class="card-header-elements ms-auto">
                             <button type="button" id="btnSelesai"
                                 class="btn btn-outline-warning waves-effect waves-light">Selesai</button>
                         </div>
                     </div>
                     <div class="card-body">
                         <div class="progress">
                             <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                 role="progressbar" style="width:{{ $progres }}" aria-valuemin="0" aria-valuemax="100">
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="card mb-3 p-2">
                     <div class="d-flex mb-3 mt-3">
                         <span>
                             <svg style="color: #7367f0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="currentColor"
                                 class="icon icon-tabler icons-tabler-filled icon-tabler-point">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                 <path d="M12 7a5 5 0 1 1 -4.995 5.217l-.005 -.217l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
                             </svg>Sudah dijawab
                         </span>
                         <span>
                             <svg style="color:lightgray " xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="currentColor"
                                 class="icon icon-tabler icons-tabler-filled icon-tabler-point">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                 <path d="M12 7a5 5 0 1 1 -4.995 5.217l-.005 -.217l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
                             </svg>Belum dijawab
                         </span>
                     </div>
                     <div class="wrap-nomor">
                         @foreach ($ps as $s)
                             <button class="btn-nomor {{ $s->jawaban != null ? 'active' : '' }}" value="{{ $s->nomor }}"
                                 data-id="{{ $s->id }}">{{ $s->nomor }}</button>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
     </div>



 @endsection

 @section('script')
     <script>
         let nomor_pub = 1;
         $(function() {
             // Fungsi untuk memulai atau melanjutkan hitung mundur
             function startCountdown() {
                 //  localStorage.removeItem(
                 //      'remainingTime');
                 // Cek apakah ada waktu yang tersimpan di localStorage
                 const storedTime = localStorage.getItem('remainingTime');
                 if (storedTime) {
                     const endTime = parseInt(storedTime);
                     updateCountdown(endTime);
                 } else {
                     const endTime = new Date().getTime() + ({{ $pu->waktu }} * 60 * 1000);
                     updateCountdown(endTime);
                 }
             }

             // Fungsi untuk memperbarui tampilan hitung mundur
             function updateCountdown(endTime) {
                 const countdownInterval = setInterval(function() {
                     const currentTime = new Date().getTime();
                     const remainingTime = endTime - currentTime;

                     // Konversi sisa waktu ke dalam menit dan detik
                     const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                     const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                     // Tampilkan waktu mundur pada elemen dengan id "countdown"
                     $("#countdown").text(minutes + ' : ' + seconds);

                     // Simpan sisa waktu ke dalam localStorage
                     localStorage.setItem('remainingTime', endTime.toString());

                     if (minutes < 2) {
                         $("#countdown").addClass('text-danger').css('font-size',
                             '25pt');
                     }

                     // Hentikan hitung mundur jika waktu telah habis
                     if (remainingTime < 0) {
                         clearInterval(countdownInterval);
                         $("#countdown").text('Waktu habis!');
                         localStorage.removeItem('remainingTime');
                         Swal.fire({
                             title: 'Ups!',
                             text: 'Waktu Anda sudah habis',
                             icon: 'error',
                             customClass: {
                                 confirmButton: 'btn btn-primary waves-effect waves-light',

                             },
                             buttonsStyling: false,
                         }).then((result) => {
                             hitungHasil();
                         });

                     }
                 }, 1000); // Setiap detik

                 $('#btnSelesai').click(function() {

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
                             clearInterval(countdownInterval);
                             localStorage.removeItem(
                                 'remainingTime');
                             hitungHasil();
                         }

                     });
                 });
             }
             startCountdown();


             fetchSoal(nomor_pub);
             showNextPrevBtn(nomor_pub);
             $(".btn-nomor").click(function() {
                 let nomor = $(this).val();
                 if (!$(this).hasClass('active')) {
                     $('.btn-nomor').removeClass('onlink');
                     $(this).addClass('onlink');
                 }

                 nomor_pub = nomor;
                 fetchSoal(nomor_pub);
                 showNextPrevBtn(nomor_pub);


             });
             $("#btn-next").click(function() {
                 nomor_pub++;
                 fetchSoal(nomor_pub);
                 showNextPrevBtn(nomor_pub);
                 $('.btn-nomor').removeClass('onlink');
                 if (!$('.btn-nomor[value="' + nomor_pub + '"]').hasClass('active')) {
                     $('.btn-nomor[value="' + nomor_pub + '"]').addClass('onlink');
                 }


             });
             $("#btn-prev").click(function() {
                 nomor_pub--;
                 fetchSoal(nomor_pub);
                 showNextPrevBtn(nomor_pub);
                 $('.btn-nomor').removeClass('onlink');
                 if (!$('.btn-nomor[value="' + nomor_pub + '"]').hasClass('active')) {
                     $('.btn-nomor[value="' + nomor_pub + '"]').addClass('onlink');
                 }


             });

         });

         function fetchSoal(nomor) {
             $.ajax({
                 url: "{{ route('cat.getSoal') }}",
                 method: 'POST',
                 data: {
                     _token: '{{ csrf_token() }}',
                     nomor: nomor
                 },
                 success: function(response) {
                     $("#soal").html(response);
                     $('.checkbox-jwb').change(function() {
                         let jwb = $(this).val();
                         let id = $(this).data('id');
                         updateJawaban(id, jwb);
                         hitungRasioActive();

                     });
                 },
                 error: function(xhr) {
                     console.log(xhr.responseText);
                 }
             });
         }

         function showNextPrevBtn(nomor) {
             var btnPrev = $("#btn-prev");
             var btnNext = $("#btn-next");
             var jumlahSoal = {{ count($ps) }};

             if (nomor < jumlahSoal) {
                 btnNext.removeClass("d-none");
             } else {
                 btnNext.addClass("d-none");
             }

             // Menampilkan tombol sebelumnya jika nomor soal bukan 1
             if (nomor > 1) {
                 btnPrev.removeClass("d-none");
             } else {
                 btnPrev.addClass("d-none");
             }
         }

         function updateJawaban(id, jwb) {
             $.ajax({
                 url: "{{ route('cat.updateJawaban') }}",
                 method: 'POST',
                 data: {
                     _token: '{{ csrf_token() }}',
                     id: id,
                     jwb: jwb,
                 },
                 success: function(response) {
                     $('.btn-nomor').removeClass('onlink');
                     $('.btn-nomor[data-id="' + id + '"]').addClass('active');
                 },
                 error: function(xhr) {
                     console.log(xhr.responseText);
                 }
             });
         }

         function hitungRasioActive() {

             var jumlahActive = $('.btn-nomor.active').length;
             var jumlahTotal = $('.btn-nomor').length;
             // Hitung rasio
             var rasio = jumlahActive / jumlahTotal;

             // Kembalikan hasil rasio
             var widthValue = rasio * 100 + '%';

             $('.progress-bar').css('width', widthValue);
         }

         function hitungHasil() {
             $.ajax({
                 url: "{{ route('cat.hitungHasil') }}",
                 method: 'POST',
                 data: {
                     _token: '{{ csrf_token() }}',
                     kode_ujian: '{{ $pu->kode_ujian }}'
                 },
                 success: function(response) {
                     Swal.fire({
                         title: 'Berhasil!',
                         text: 'Data anda berhasil disimpan',
                         icon: 'success',
                         timer: 3000, // Waktu dalam milidetik (misalnya 3000ms = 3 detik)
                         timerProgressBar: true,
                         customClass: {
                             confirmButton: 'btn btn-primary waves-effect waves-light',

                         },
                         buttonsStyling: false
                     }).then((result) => {
                         window.location.href = "{{ route('cat.hasil', $ku_en) }}";
                     });

                 },
                 error: function(xhr) {
                     console.log(xhr.responseText);
                 }
             });
             setTimeout(function() {
                 window.location.href = "{{ route('cat.hasil', $ku_en) }}";
             }, 4000);
         }
     </script>
 @endsection
