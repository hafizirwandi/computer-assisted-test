 @extends('layouts.main-layout.app')
 @section('title', 'Nilai CAT')

 @section('content')

     <div class="card mb-4">
         <div class="card-body ">
             <div class="table-responsive">

                 <table class="datatable table">
                     <thead>
                         <tr>
                             <th>Ujian</th>
                             <th>Jlh Soal</th>
                             <th>Jlh Jawab</th>
                             <th>Jlh Tidak Jawab</th>
                             <th>Nilai</th>
                             <th>Created at</th>
                             <th>Aksi</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             {{-- @dd($r) --}}
                             <tr>
                                 <td>
                                     @if ($r->pengaturanUjian)
                                         {{ $r->pengaturanUjian->kode_ujian }} - {{ $r->pengaturanUjian->soal->nama }}
                                     @endif
                                 </td>
                                 <td>{{ $r->jlh_soal }}</td>
                                 <td>{{ $r->jlh_soal - $r->jlh_tidak_jawab }}</td>
                                 <td>{{ $r->jlh_tidak_jawab }}</td>
                                 <td>{{ $r->nilai }}</td>

                                 <td>{{ \Carbon\Carbon::parse($r->created_at)->isoFormat('dddd, D MMM YYYY, HH:mm:ss') }}
                                 </td>
                                 <td> <a href="{{ route('cat.nilai.detail', $r->id) }}" class="text-body">
                                         <i class="ti ti-eye ti-sm me-2"></i>
                                     </a>
                                 </td>

                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
     </div>



 @endsection
