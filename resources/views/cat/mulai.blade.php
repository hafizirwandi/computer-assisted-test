 @extends('layouts.main-layout.app-without-menu')
 @section('title', 'CAT')
 @section('css')
     <style>
         .wrap-nomor {
             display: flex;
             flex-wrap: wrap;
             justify-content: flex-start;
             gap: 8px;
         }

         .btn-nomor {
             width: calc(20% - 8px);
             height: 45px;
             border: 1px solid #d1d5db;
             /* gray-300 */
             border-radius: 8px;
             background-color: #ffffff;
             color: #374151;
             font-weight: 600;
             transition: all 0.2s ease;
         }

         .btn-nomor:hover {
             background-color: #f3f4f6;
             /* gray-100 */
         }

         /* Mengubah warna tombol saat aktif (sudah dijawab) */
         .btn-nomor.active {
             background-color: #3b82f6 !important;
             /* solid blue */
             color: #ffffff !important;
             border-color: #3b82f6 !important;
         }

         /* Mengubah warna tombol yang sedang dilihat (fokus/onlink) */
         .btn-nomor.onlink {
             background-color: #f97316 !important;
             /* solid orange */
             color: #ffffff !important;
             border-color: #f97316 !important;
             transform: scale(1.05);
             box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.3);
         }

         #countdown {
             font-size: 18pt;
             font-weight: 700;
             text-align: right;
             letter-spacing: 1pt;
             color: #3b82f6;
             /* solid blue */
         }

         .box-pointer-soal {
             display: flex;
             flex-wrap: wrap;
             justify-content: space-between;
         }

         /* Mengabaikan batas lebar container khusus untuk halaman ini */
         .container-xxl {
             max-width: 100% !important;
             padding-left: 2rem !important;
             padding-right: 2rem !important;
         }

         /* Menghilangkan padding container bawaan dan margin bottom layout */
         .container-p-y {
             padding-top: 0 !important;
         }

         .container-xxl>.mb-5,
         .container-xxl>.mb-3 {
             display: none !important;
         }

         .row-pull-up {
             margin-top: -60px !important;
         }

         /* Reset gradient to solid */
         .btn-primary {
             background: #3b82f6 !important;
             border-color: #3b82f6 !important;
             color: #ffffff !important;
         }

         .btn-primary:hover {
             background: #2563eb !important;
         }

         .btn-outline-primary {
             color: #3b82f6 !important;
             border-color: #3b82f6 !important;
         }

         .btn-outline-primary:hover {
             background: #3b82f6 !important;
             color: #ffffff !important;
         }

         .bg-primary {
             background-color: #3b82f6 !important;
         }

         .text-primary {
             color: #3b82f6 !important;
         }

         .btn-warning {
             background: #f97316 !important;
             border-color: #f97316 !important;
             color: #ffffff !important;
         }

         .sticky-sidebar {
             position: sticky;
             top: 2rem;
             z-index: 1020;
         }

         .card-soal-wrapper {
             border-radius: 12px;
             border: none;
             box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
         }
     </style>
 @endsection
 @section('content')
     <div class="row g-4 mt-0 pt-0 row-pull-up">
         <div class="col-lg-9">
             <div class="card card-soal-wrapper mb-4">
                 <div id="soal" class="card-body p-4 p-md-5">
                 </div>
             </div>

             <div class="box-pointer-soal mt-3 mb-5">
                 <button id="btn-prev" class="btn btn-outline-primary fw-bold px-4 py-2 d-none rounded-pill">
                     <i class="tf-icons ti ti-chevrons-left me-2"></i> Sebelumnya
                 </button>
                 <button id="btn-next" class="btn btn-primary fw-bold px-4 py-2 d-none rounded-pill">
                     Selanjutnya <i class="tf-icons ti ti-chevrons-right ms-2"></i>
                 </button>
             </div>
         </div>
         <div class="col-lg-3">
             <div class="sticky-sidebar">
                 <div class="card card-soal-wrapper mb-4 border-top border-2 border-primary">
                     <div class="card-header bg-white d-flex align-items-center justify-content-between p-3">
                         <div class="d-flex align-items-center text-primary">
                             <i class="ti ti-clock-hour-4 fs-3 me-2"></i>
                             <span id="countdown" class="fs-4">00:00:00</span>
                         </div>
                         <button type="button" id="btnSelesai"
                             class="btn btn-warning fw-bold btn-sm rounded-pill px-3">Selesai</button>
                     </div>
                     <div class="card-body p-3">
                         <div class="progress" style="height: 10px; border-radius: 10px;">
                             <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                 role="progressbar" style="width:{{ $progres }}" aria-valuemin="0" aria-valuemax="100">
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="card card-soal-wrapper p-3">
                     <div class="d-flex justify-content-between mb-4 mt-2 px-2 text-muted small fw-semibold">
                         <div class="d-flex align-items-center">
                             <span class="d-inline-block rounded-circle  me-2"
                                 style="width: 12px; height: 12px; background-color:#3b82f6"
                                 style="width: 12px; height: 12px;"></span> Dijawab
                         </div>
                         <div class="d-flex align-items-center">
                             <span class="d-inline-block rounded-circle bg-light border me-2"
                                 style="width: 12px; height: 12px;"></span> Kosong
                         </div>
                         <div class="d-flex align-items-center">
                             <span class="d-inline-block rounded-circle me-2"
                                 style="width: 12px; height: 12px; background-color: #f97316;"></span> Saat ini
                         </div>
                     </div>
                     <div class="wrap-nomor">
                         @foreach ($ps as $s)
                             <button class="btn-nomor shadow-sm {{ $s->jawaban != null ? 'active' : '' }}"
                                 value="{{ $s->nomor }}" data-id="{{ $s->id }}">{{ $s->nomor }}</button>
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
                     const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                     const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                     const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                     // Tampilkan waktu mundur pada elemen dengan id "countdown"
                     $("#countdown").text(hours + ' : ' + minutes + ' : ' + seconds);

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
                     kode_ujian: '{{ $pu->kode_ujian }}',
                     nomor: nomor

                 },
                 success: function(response) {
                     $("#soal").html(response);
                     //  $('.checkbox-jwb').click(function() {
                     //      $('.checkbox-jwb').removeClass('active');
                     //      $(this).addClass('active');
                     //      let jwb = $(this).attr('value');
                     //      let id = $(this).data('id');
                     //      //  alert(jwb);
                     //      //  alert(id);
                     //      updateJawaban(id, jwb);
                     //      hitungRasioActive();

                     //  });
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


                     hitungRasioActive();
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

         // Mematikan hak-klik / klik kanan
         document.addEventListener('contextmenu', function(e) {
             e.preventDefault();
         });
     </script>
 @endsection
