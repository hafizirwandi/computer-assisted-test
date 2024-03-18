 @extends('layouts.main-layout.app')
 @section('title', 'Butir Soal')
 @section('content')


     <a href="{{ route('soal.butirsoal.create', $data->id) }}"
         class="btn btn-primary mb-3 text-nowrap add-new-role waves-effect waves-light">
         <i class="ti ti-plus ti-sm me-2"></i>Tambah Butir Soal
     </a>

     <div class="card mb-4">
         <div class="card-body">

             <table class="table">
                 <thead>
                     <tr>
                         <th>Soal</th>
                         <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>

                     @foreach ($data->butirSoal as $r)
                         <tr>

                             <td>{!! $r->soal !!}
                                 <br>
                                 <div class="row">
                                     <div class="col-md-6">
                                         (A)
                                         <br> {!! $r->jawaban_a !!}
                                     </div>
                                     <div class="col-md-6">
                                         (B)
                                         <br> {!! $r->jawaban_b !!}
                                     </div>
                                     <div class="col-md-6">
                                         (C)
                                         <br> {!! $r->jawaban_c !!}
                                     </div>
                                     <div class="col-md-6">
                                         (D)
                                         <br> {!! $r->jawaban_d !!}
                                     </div>
                                     <div class="col-md-6">
                                         (E)
                                         <br> {!! $r->jawaban_e !!}
                                     </div>
                                 </div>

                                 <h6>Jawaban : {{ $r->jawaban_benar }}</h6>
                                 <h6>Poin : {{ $r->poin_benar }} </h6>
                             </td>
                             <td>
                                 <div class="d-flex align-items-center">
                                     <a href="{{ route('soal.butirsoal.edit', $r->id) }}" class="text-body">
                                         <i class="ti ti-edit ti-sm me-2"></i>
                                     </a>
                                     <form method="post" action="{{ route('soal.butirsoal.destroy') }}">
                                         @csrf
                                         @method('delete')
                                         <input type="hidden" name="id" value="{{ $r->id }}">
                                         <button type="submit"
                                             onclick="return confirm('Are you sure you want to proceed?')"
                                             class="text-body no-style">
                                             <i class="ti ti-trash ti-sm me-2"></i>
                                         </button>
                                     </form>
                                 </div>
                             </td>
                         </tr>
                     @endforeach
                 </tbody>
             </table>
         </div>
     </div>

 @endsection
