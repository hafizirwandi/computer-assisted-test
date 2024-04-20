 @extends('layouts.main-layout.app')
 @section('title', 'Butir Soal')
 @section('css')
     <style>
         .box-jwb {
             border: 1px solid #dbdade;
             border-radius: 10px;
             margin-bottom: 10px;
         }

         .styled-list {
             list-style-type: lower-alpha;
             margin-left: 10px;
         }

         .styled-list li {
             margin-left: 10px;
         }
     </style>
 @endsection
 @section('content')

     @can('butirsoal-create')
         <a href="{{ route('soal.butirsoal.create', $data->id) }}"
             class="btn btn-primary mb-3 text-nowrap add-new-role waves-effect waves-light">
             <i class="ti ti-plus ti-sm me-2"></i>Tambah Butir Soal
         </a>
     @endcan

     <div class="card mb-4">
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table datatable">
                     <thead>
                         <tr>
                             <th>Soal</th>
                             <th style="width: 10px">Action</th>
                         </tr>
                     </thead>
                     <tbody>

                         @foreach ($data->butirSoal as $r)
                             <tr>

                                 <td>{!! $r->soal !!}
                                     <br>
                                     <ol class="styled-list">
                                         @php $const = explode(",", $r->tipe_optional_jawaban) @endphp
                                         @foreach ($const as $j)
                                             <li {!! $r->jawaban_benar == $j ? 'class="bg-label-primary"' : '' !!}>
                                                 {!! $r->{'jawaban_' . $j} !!}</li>
                                         @endforeach
                                     </ol>


                                     <h6>Jawaban : {{ $r->jawaban_benar }}</h6>
                                     <h6>Poin : {{ $r->poin_benar }} </h6>

                                 </td>
                                 <td>
                                     <div class="d-flex align-items-center">
                                         @can('butirsoal-edit')
                                             <a href="{{ route('soal.butirsoal.edit', $r->id) }}" class="text-body">
                                                 <i class="ti ti-edit ti-sm me-2"></i>
                                             </a>
                                         @endcan
                                         @can('butirsoal-delete')
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
                                         @endcan
                                     </div>
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

 @endsection
