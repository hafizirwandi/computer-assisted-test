 @extends('layouts.main-layout.app')
 @section('title', 'Rekap Nilai Global')
 @section('content')
     <div class="alert alert-primary" role="alert">
         <form action="">
             <div class="row g-3">
                 <div class="col-md-5">
                     <select name="sekolah" class="form-control " placeholder="Enter Text">
                         <option value="">-- Pilih Sekolah--</option>
                         @foreach ($sekolah as $r)
                             <option value="{{ $r->kode_sekolah }}"
                                 {{ $r->kode_sekolah == request()->get('sekolah') ? 'selected' : '' }}>
                                 {{ $r->kode_sekolah . ' - ' . $r->nama_sekolah }}
                             </option>
                         @endforeach
                     </select>
                 </div>

                 <div class="col-md-6">
                     <select name="ujian" class="form-control" placeholder="Enter Text">
                         <option value="">-- Pilih Ujian--</option>
                         @foreach ($ujian as $r)
                             <option value="{{ $r->kode_ujian }}"
                                 {{ $r->kode_ujian == request()->get('ujian') ? 'selected' : '' }}>
                                 {{ $r->kode_ujian . ' - ' . $r->matapelajaran }}
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
                             {{-- <th>Rank</th>
                             <th>Rank2</th> --}}
                             <th>Created at</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>
                                 <td>{{ $r->kode_ujian . ' - ' . $r->matapelajaran }}</td>
                                 <td>{{ $r->nis }}</td>
                                 <td>{{ $r->nama_siswa }}</td>
                                 <td>{{ $r->kelas }}</td>
                                 <td>{{ $r->jlh_soal }}</td>
                                 <td>{{ $r->jlh_jawab_benar }}</td>
                                 <td>{{ $r->jlh_jawab_salah }}</td>
                                 <td>{{ $r->jlh_tidak_jawab }}</td>
                                 <td>{{ $r->nilai }}</td>
                                 {{-- <td>{{ $r->rank }}</td>
                                 <td>{{ $r->rank2 }}</td> --}}

                                 <td>{{ \Carbon\Carbon::parse($r->created_at)->isoFormat('dddd, D MMM YYYY, HH:mm:ss') }}
                                 </td>
                                 <td>
                                     <div class="d-flex align-items-center">
                                         <a href="javascript:;" onclick="edit(`{{ $r->id }}`)" class="text-body">
                                             <i class="ti ti-edit ti-sm me-2"></i>
                                         </a>
                                         <form method="post" action="{{ route('reset-ujian.resetall') }}">
                                             @csrf
                                             <input type="hidden" name="kode_ujian" value="{{ $r->kode_ujian }}">
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
     </div>
 @endsection
 <div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-simple modal-dialog-centered">
         <div class="modal-content p-3 p-md-5">
             <div class="modal-body">

             </div>
         </div>
     </div>
 </div>
 <script>
     function edit(id) {

         $("#myModal .modal-body").load("{{ route('reset-ujian.edit', ['id' => ':id']) }}".replace(':id', id));
         $("#myModal").modal("show");

     }
 </script>
