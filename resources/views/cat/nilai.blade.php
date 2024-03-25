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
                             <th>Jlh Benar</th>
                             <th>Jlh Salah</th>
                             <th>Jlh Tidak Jawab</th>
                             <th>Nilai</th>
                             <th>Created at</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>
                                 <td>{{ $r->pengaturanUjian->kode_ujian }} - {{ $r->pengaturanUjian->soal->nama }}</td>
                                 <td>{{ $r->jlh_soal }}</td>
                                 <td>{{ $r->jlh_jawab_benar }}</td>
                                 <td>{{ $r->jlh_jawab_salah }}</td>
                                 <td>{{ $r->jlh_tidak_jawab }}</td>
                                 <td>{{ $r->nilai }}</td>

                                 <td>{{ \Carbon\Carbon::parse($r->created_at)->isoFormat('dddd, D MMM YYYY, HH:mm:ss') }}
                                 </td>

                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
     </div>



 @endsection
