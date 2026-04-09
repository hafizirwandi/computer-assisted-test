 @extends('layouts.main-layout.app-without-menu')
 @section('title', 'Hasil CAT')
 @section('css')
     <style>
         .card-hasil {
             background-color: #3b82f6;
             /* Solid Blue Theme */
             border-radius: 16px;
             border: none;
             box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
             color: white;
         }

         .score-box {
             background-color: #ffffff;
             border-radius: 16px;
             box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
             display: inline-block;
         }

         .btn-warning {
             background: #f97316 !important;
             /* Solid Orange */
             border-color: #f97316 !important;
             color: #ffffff !important;
             padding: 12px 40px;
             border-radius: 50px;
             font-weight: 600;
             transition: all 0.3s ease;
         }

         .btn-warning:hover {
             background: #ea580c !important;
             transform: translateY(-2px);
             box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
         }

         .stat-detail {
             background: rgba(255, 255, 255, 0.1);
             border-radius: 10px;
             border: 1px solid rgba(255, 255, 255, 0.2);
         }

         /* Customize ApexCharts for dark/blue background */
         .apexcharts-legend-text {
             color: #ffffff !important;
             font-weight: 500;
         }

         .apexcharts-datalabel-value,
         .apexcharts-datalabel-label {
             fill: #ffffff !important;
         }
     </style>
 @endsection
 @section('content')

     <div class="row justify-content-center mt-4 mb-5">
         <div class="col-12 col-md-10 col-lg-8 col-xl-6">
             <div class="card card-hasil overflow-hidden">
                 <div class="card-body p-4 p-md-5 text-center">

                     <div class="mb-4">
                         <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-3 shadow"
                             style="width: 70px; height: 70px; color: #f97316;">
                             <i class="ti ti-trophy" style="font-size: 36px;"></i>
                         </div>
                         <h1 class="fw-bold  mb-2">Selamat!</h1>
                         <h5 class="fw-normal opacity-75 ">Sesi ujian Anda telah berakhir</h5>
                     </div>

                     <div class="score-box p-4 mb-4 mt-2 w-100 text-center">
                         <p class="text-muted mb-2 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.85rem;">
                             Total Skor Perolehan</p>
                         <h1 class="display-3 fw-bolder mb-0 lh-1" style="color: #3b82f6;">{{ $hu->nilai }}</h1>
                     </div>

                     <div class="row g-3 mb-4">
                         <div class="col-6">
                             <div class="stat-detail p-3 h-100">
                                 <h3 class="fw-bold mb-1" style="color: #3b82f6">{{ $hu->jlh_soal - $hu->jlh_tidak_jawab }}
                                 </h3>
                                 <span class="small opacity-75">Soal Dijawab</span>
                             </div>
                         </div>
                         <div class="col-6">
                             <div class="stat-detail p-3 h-100">
                                 <h3 class="fw-bold mb-1 text-warning">{{ $hu->jlh_tidak_jawab }}</h3>
                                 <span class="small opacity-75">Tidak Dijawab</span>
                             </div>
                         </div>
                     </div>

                     <div class="d-flex justify-content-center mb-4">
                         <div id="chart" class="w-100 d-flex justify-content-center"></div>
                     </div>

                     <div class="mt-4 pt-2">
                         <a href="{{ route('home.siswa') }}" class="btn btn-warning fs-6">
                             <i class="ti ti-home me-2"></i> Kembali ke Beranda
                         </a>
                     </div>

                 </div>
             </div>
         </div>
     </div>

 @endsection
 @section('script')
     <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
     <script>
         var dijawab = {{ $hu->jlh_soal - $hu->jlh_tidak_jawab }};
         var tidakDijawab = {{ $hu->jlh_tidak_jawab }};

         var options = {
             series: [dijawab, tidakDijawab],
             chart: {
                 width: 320,
                 type: 'donut',
                 dropShadow: {
                     enabled: true,
                     color: '#111',
                     top: -1,
                     left: 3,
                     blur: 3,
                     opacity: 0.2
                 }
             },
             colors: ['#3b82f6', '#f97316'],
             labels: ['Dijawab', 'Kosong'],
             plotOptions: {
                 pie: {
                     donut: {
                         size: '70%',
                         labels: {
                             show: true,
                             name: {
                                 show: true,
                                 color: '#ffffff'
                             },
                             value: {
                                 show: true,
                                 color: '#ffffff',
                                 fontSize: '24px',
                                 fontWeight: 'bold'
                             },
                             total: {
                                 show: true,
                                 showAlways: true,
                                 label: 'Total Soal',
                                 color: '#ffffff',
                                 formatter: function(w) {
                                     return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                 }
                             }
                         }
                     }
                 }
             },
             stroke: {
                 width: 0,
             },
             dataLabels: {
                 enabled: true
             },

         };

         var chart = new ApexCharts(document.querySelector("#chart"), options);
         chart.render();
     </script>
 @endsection
