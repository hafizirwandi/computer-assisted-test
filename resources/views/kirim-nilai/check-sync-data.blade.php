 @extends('layouts.main-layout.app')
 @section('title', 'Rekap Nilai')
 @section('content')
     <div class="alert alert-primary" role="alert">
         <form action="">
             <div class="row g-3">

                 <div class="col-md-11">
                     <select name="ujian" class="form-control" placeholder="Enter Text">
                         <option value="">-- Pilih Ujian--</option>
                         @foreach ($ujian as $r)
                             <option value="{{ $r->kode_ujian }}"
                                 {{ $r->kode_ujian == request()->get('ujian') ? 'selected' : '' }}>
                                 {{ $r->kode_ujian . ' - ' . $r->soal->nama }}
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
                             <th>Ujian</th>
                             <th>NIS</th>
                             <th>Nama</th>
                             <th>Kelas</th>
                             <th>Jlh Soal</th>
                             <th>Jlh Benar</th>
                             <th>Jlh Salah</th>
                             <th>Jlh Tidak Jawab</th>
                             <th>Nilai</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>
                                 <td>{{ $r['kode_ujian'] . ' - ' . $r['matapelajaran'] }}</td>
                                 <td>{{ $r['nis'] }}</td>
                                 <td>{{ $r['nama_siswa'] }}</td>
                                 <td>{{ $r['kelas'] }}</td>
                                 <td>{{ $r['jlh_soal'] }}</td>
                                 <td>{{ $r['jlh_jawab_benar'] }}</td>
                                 <td>{{ $r['jlh_jawab_salah'] }}</td>
                                 <td>{{ $r['jlh_tidak_jawab'] }}</td>
                                 <td>{{ $r['nilai'] }}</td>



                             </tr>
                         @endforeach
                     </tbody>

                 </table>
             </div>
         </div>
     </div>
 @endsection
