 @extends('layouts.main-layout.app')
 @section('title', 'CAT')

 @section('content')
     @foreach ($ujian as $r)
         @if ($r->hu)
             <center class="mb-5">
                 <h5>Anda sudah melakukan ujian! Jika ini adalah kesalahan, <br> Silahkan hubungi operator sekolah untuk
                     mereset
                     ujian anda!</h5>
             </center>
         @endif

         <div class="row ">
             <div class="col-sm-6 col-lg-3 mb-4">
                 <div class="card card-border-shadow-primary">
                     <div class="card-body">
                         <h5 class="mb-1">Jumlah Soal</h5>
                         <div class="d-flex align-items-center mb-2 pb-1">
                             <div class="avatar me-2">
                                 <span class="avatar-initial rounded bg-label-primary"><i
                                         class="ti ti-notes ti-md"></i></span>
                             </div>
                             <h6 class="ms-1 mb-0">{{ $r->jlh_soal }} Soal</h6>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-sm-6 col-lg-3 mb-4">
                 <div class="card card-border-shadow-warning">
                     <div class="card-body">
                         <h5 class="mb-1">Waktu Pengerjaan</h5>
                         <div class="d-flex align-items-center mb-2 pb-1">
                             <div class="avatar me-2">
                                 <span class="avatar-initial rounded bg-label-warning"><i
                                         class="ti ti-clock-hour-4 ti-md"></i></span>
                             </div>
                             <h6 class="ms-1 mb-0">{{ $r->waktu }} Menit</h6>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-sm-6 col-lg-3 mb-4">
                 <div class="card card-border-shadow-danger">
                     <div class="card-body">
                         <h5 class="mb-1">Matapelajaran</h5>
                         <div class="d-flex align-items-center mb-2 pb-1">
                             <div class="avatar me-2">
                                 <span class="avatar-initial rounded bg-label-danger"><i
                                         class="ti ti-device-laptop ti-md"></i></span>
                             </div>
                             <h6 class="ms-1 mb-0">{{ $r->soal->nama }}</h6>
                         </div>


                     </div>
                 </div>
             </div>
             <div class="col-sm-6 col-lg-3 mb-4">
                 <div class="card card-border-shadow-info">
                     <div class="card-body">
                         <h5 class="mb-1">Kode Ujian</h5>
                         <div class="d-flex align-items-center mb-2 pb-1">
                             <div class="avatar me-2">
                                 <span class="avatar-initial rounded bg-label-info"><i class="ti ti-code ti-md"></i></span>
                             </div>
                             <h6 class="ms-1 mb-0">{{ $r->kode_ujian }}</h6>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="row mb-5">
             <div class="col-12 text-center">
                 <form class="row g-3" method="post" action="{{ route('cat.checkKodeUjian') }}">
                     @csrf
                     <input type="hidden" name="kode_ujian" value="{{ $r->kode_ujian }}">
                     <button onclick="return confirm('Apakah anda sudah yakin ?')" type="submit"
                         class="btn btn-lg btn-primary " {{ $r->hu ? 'disabled' : '' }}>Mulai Ujian</button>
                 </form>
             </div>
         </div>
         <hr>
     @endforeach


 @endsection
