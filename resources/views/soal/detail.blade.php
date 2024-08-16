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
         <a href="{{ route('soal.butirsoal.create', $soal->id) }}"
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

                         {{-- @dd($data); --}}
                         @foreach ($data as $j)
                             <tr>
                                 <td>
                                     {!! tipeSoal($j->ref_butir_soal) !!}
                                     @if ($j->ref_butir_soal == '1')
                                         @php $r = $j->butirSoal; @endphp

                                         {!! $r->soal !!}
                                         <br>
                                         <ol class="styled-list">
                                             @php $const = explode(",", $r->tipe_optional_jawaban) @endphp
                                             @foreach ($const as $m)
                                                 <li>
                                                     {!! $r->{'jawaban_' . $m} !!}</li>
                                             @endforeach
                                         </ol>


                                         <h6>Jawaban : {{ $r->jawaban_benar }}</h6>
                                         <h6>Poin : {{ $r->poin_benar }} </h6>
                                     @elseif ($j->ref_butir_soal == '2')
                                         @php $r = $j->butirSoal2; @endphp
                                         {!! $r->soal !!}
                                         <br>
                                         <ol class="styled-list">
                                             @php $const = explode(",", $r->tipe_optional_jawaban) @endphp
                                             @foreach ($const as $l)
                                                 <li {!! $r->jawaban_benar == $l ? 'class="bg-label-primary"' : '' !!}>
                                                     {!! $r->{'jawaban_' . $l} !!}</li>
                                             @endforeach
                                         </ol>


                                         <h6>Poin :
                                             @foreach ($const as $l)
                                                 {{ $l }} = {!! $r->{'poin_benar_' . $l} !!} |
                                             @endforeach
                                         </h6>
                                     @elseif ($j->ref_butir_soal == '3')
                                         @php $r = $j->butirSoal3; @endphp
                                         {!! $r->soal !!}
                                         <br>
                                         <table class="table table-bordered">
                                             <thead>
                                                 <tr>
                                                     <th style="width:70%">Pernyataan</th>

                                                     @foreach (json_decode($r->optional_jawaban) as $oj)
                                                         <th>{{ $oj }}</th>
                                                     @endforeach
                                                 </tr>
                                             </thead>
                                             <tbody>

                                                 @php
                                                     $pernyataan = json_decode($r->pernyataan_soal);
                                                     $poin_benar = json_decode($r->poin_benar);
                                                     $i = 0;
                                                 @endphp

                                                 @foreach ($pernyataan as $p)
                                                     <tr>
                                                         <td>{{ $p }}</td>

                                                         @for ($m = 0; $m < count(json_decode($r->optional_jawaban)); $m++)
                                                             <td>{{ $poin_benar[$i][$m] }}</td>
                                                         @endfor

                                                     </tr>
                                                     @php $i++; @endphp
                                                 @endforeach
                                             </tbody>
                                         </table>
                                     @elseif ($j->ref_butir_soal == '4')
                                         @php $r = $j->butirSoal4; @endphp

                                         {!! $r->soal !!}
                                         <br>
                                         <h6>Jawaban : {{ $r->jawaban }}</h6>
                                         <h6>Kunci Kata : {{ $r->kunci_kata == '1' ? 'Ya' : 'Tidak' }}</h6>
                                         <h6>Poin : {{ $r->poin_minimal }} - {{ $r->poin_maksimal }} </h6>
                                     @endif
                                 </td>
                                 <td>

                                     <div class="d-flex align-items-center">
                                         @can('butirsoal-edit')
                                             <a href="{{ route('soal.butirsoal.edit', $j->id) }}" class="text-body">
                                                 <i class="ti ti-edit ti-sm me-2"></i>
                                             </a>
                                         @endcan
                                         @can('butirsoal-delete')
                                             <form method="post" action="{{ route('soal.butirsoal.destroy') }}">
                                                 @csrf
                                                 @method('delete')
                                                 <input type="hidden" name="id" value="{{ $j->id }}">
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
