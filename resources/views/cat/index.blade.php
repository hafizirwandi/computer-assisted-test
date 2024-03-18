 @extends('layouts.main-layout.app')
 @section('title', 'Siswa')
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
             background-color: gray;
         }

         .waktu-mundur {
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

                     <div class="card-body">
                         {!! $butirsoal->soal !!}
                         <hr class="my-4">
                         @php $const_jwb = ['a','b','c','d','e']; @endphp
                         @foreach ($const_jwb as $jwb)
                             <div class="form-check custom-option custom-option-basic mb-3">
                                 <label class="form-check-label custom-option-content">
                                     <input name="customRadioTemp" class="form-check-input" type="radio" value="">
                                     <span class="custom-option-header">
                                         <span class="h6 mb-0">{{ strtoupper($jwb) }}</span>
                                     </span>
                                     <span class="custom-option-body">
                                         {!! $butirsoal->{'jawaban_' . $jwb} !!}
                                     </span>
                                 </label>
                             </div>
                         @endforeach


                     </div>
                 </div>

                 <div class="box-pointer-soal mt-3">
                     <button class="btn btn-primary"><i class="tf-icons ti ti-chevrons-left"></i> Sebelum nya</button>
                     <button class="btn btn-primary">Selanjutnya nya <i class="tf-icons ti ti-chevrons-right"></i></button>
                 </div>
             </div>
             <div class="col-lg-3">

                 <div class="card shadow-none border mb-3">
                     <div class="card-body">
                         <span class="waktu-mundur">60:30</span>
                     </div>

                 </div>
                 <div class="wrap-nomor">
                     @for ($i = 1; $i <= 40; $i++)
                         <button class="btn-nomor">{{ $i }}</button>
                     @endfor

                 </div>
             </div>
         </div>
     </div>



 @endsection
