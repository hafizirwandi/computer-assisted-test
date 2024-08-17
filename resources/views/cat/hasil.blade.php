 @extends('layouts.main-layout.app-without-menu')
 @section('title', 'Hasil CAT')

 @section('content')

     <div class="row justify-content-center">
         <div class="col-md-6 ">
             <div class="card mb-4">
                 <div class="card-body ">
                     <center>
                         <h2>Skor : {{ $hu->nilai }}</h2>
                         <div id="chart"></div>
                         <a href="{{ route('home.siswa') }}" class="btn btn-primary mt-5">Kembali ke Home</a>
                     </center>
                 </div>
             </div>

         </div>
     </div>



 @endsection
 @section('script')
     <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
     <script>
         var options = {
             series: [{{ $hu->jlh_soal - $hu->jlh_tidak_jawab }}, {{ $hu->jlh_tidak_jawab }}],
             chart: {
                 width: 380,
                 type: 'pie',
             },
             labels: ['Jumlah Jawab', 'Jumlah Tidak Jawab'],
             responsive: [{
                 breakpoint: 480,
                 options: {
                     chart: {
                         width: 200
                     },
                     legend: {
                         position: 'bottom'
                     }
                 }
             }]
         };

         var chart = new ApexCharts(document.querySelector("#chart"), options);
         chart.render();
     </script>
 @endsection
