 @extends('layouts.main-layout.app')
 @section('title', 'Rekap Nilai Kumulatif')
 @section('content')
     <div class="alert alert-primary" role="alert">
         <form action="">
             <div class="row g-3">
                 <div class="col-md-11">
                     <select name="sekolah" class="form-control " placeholder="Enter Text">
                         <option value="">-- Pilih Sekolah--</option>
                         @foreach ($sekolah as $r)
                             <option value="{{ $r->id }}" {{ $r->id == request()->get('sekolah') ? 'selected' : '' }}>
                                 {{ $r->nama }}
                             </option>
                         @endforeach
                     </select>
                 </div>

                 <div class="col-md-1">
                     <button type="submit" class="btn btn-warning  text-nowrap  btn-sm waves-effect waves-light">
                         <i class="ti ti-search ti-sm me-2"></i>Cari
                     </button>
                 </div>
             </div>
         </form>
     </div>
     <div class="card mb-4">
         <div class="card-body">

             <div class="table-responsive">

                 <table class="datatable table">
                     <thead>
                         <tr>

                             <th rowspan="2">NIS</th>
                             <th rowspan="2">Nama</th>
                             <th rowspan="2">Kelas</th>
                             <th colspan="{{ count($ujian) }}" style="text-align: center">Nilai</th>
                             <th rowspan="2">Total</th>
                             <th rowspan="2">Rata-rata</th>
                             {{-- <th rowspan="2">Rank</th>
                             <th rowspan="2">Rank2</th> --}}
                         </tr>
                         <tr>
                             @foreach ($ujian as $j)
                                 <th>{{ $j->soal->nama }}</th>
                             @endforeach

                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>
                                 <td>{{ $r->nis }}</td>
                                 <td>{{ $r->nama }}</td>
                                 <td>{{ $r->kelas }}</td>

                                 @php
                                     $validScoreCount = 0;
                                 @endphp
                                 @foreach ($r->ujian as $ps)
                                     @if ($ps != null)
                                         @php
                                             $obj = is_string($ps) ? json_decode($ps) : $ps;
                                             if (isset($obj->nilai) && $obj->nilai > 0) {
                                                 $validScoreCount++;
                                             }
                                         @endphp
                                         <td>{{ $obj->nilai }}</td>
                                     @else
                                         <td>0</td>
                                     @endif
                                 @endforeach
                                 <td>{{ $r->nilai }}</td>
                                 @php
                                     $rataRata = $validScoreCount > 0 ? $r->nilai / $validScoreCount : 0;
                                 @endphp
                                 <td>{{ number_format($rataRata, 2, '.', '') }}</td>
                                 {{-- <td>{{ $r->rank }}</td>
                                 <td>{{ $r->rank2 }}</td> --}}
                             </tr>
                         @endforeach
                     </tbody>

                 </table>
             </div>
         </div>
     </div>
 @endsection
