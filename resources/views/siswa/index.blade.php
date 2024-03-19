 @extends('layouts.main-layout.app')
 @section('title', 'Siswa')
 @section('content')


     <button onclick="create()" class="btn btn-primary mb-3 text-nowrap add-new-role waves-effect waves-light">
         <i class="ti ti-plus ti-sm me-2"></i>Tambah Siswa
     </button>

     <button onclick="importData()" class="btn btn-warning mb-3 text-nowrap add-new-role waves-effect waves-light">
         <i class="ti ti-transfer-in ti-sm me-2"></i>Import Siswa
     </button>

     <div class="alert alert-primary" role="alert">
         <form action="">
             <div class="row g-3">
                 <div class="col-md-5">
                     <select id="sekolah" name="sekolah" class="form-control" placeholder="Enter Text">
                         <option value="">-- Pilih Sekolah--</option>
                         @foreach ($sekolah as $r)
                             <option value="{{ $r->id }}"
                                 {{ $r->id == request()->get('sekolah') ? 'selected' : '' }}>{{ $r->nama }}
                             </option>
                         @endforeach
                     </select>
                 </div>

                 <div class="col-md-6">
                     <select id="kelas" name="kelas" class="form-control" placeholder="Enter Text">
                         <option value="">-- Pilih Kelas--</option>
                         @if (request()->get('kelas'))
                             <option value="{{ request()->get('kelas') }}" selected>{{ request()->get('kelas') }}
                             </option>
                         @endif

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
                             <th>NIS</th>
                             <th>Nama</th>
                             <th>Username</th>
                             <th>Sekolah</th>
                             <th>Kelas</th>
                             <th>Status</th>
                             <th>Created at</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>
                                 <td>{{ $r->nis }}</td>
                                 <td>{{ $r->nama }}</td>
                                 <td>{{ $r->username }}</td>
                                 <td>{{ $r->sekolah->nama }}</td>
                                 <td>{{ $r->kelas }}</td>
                                 <td> {!! statusUser($r->status) !!} </td>


                                 <td>{{ \Carbon\Carbon::parse($r->created_at)->isoFormat('dddd, D MMM YYYY, HH:mm:ss') }}
                                 </td>
                                 <td>
                                     <div class="d-flex align-items-center">
                                         <a href="javascript:;" onclick="edit(`{{ $r->id }}`)" class="text-body">
                                             <i class="ti ti-edit ti-sm me-2"></i>
                                         </a>
                                         <form method="post" action="{{ route('siswa.destroy') }}">
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
     </div>
     <div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-simple modal-dialog-centered">
             <div class="modal-content p-3 p-md-5">
                 <div class="modal-body">

                 </div>
             </div>
         </div>
     </div>
 @endsection
 @section('script')
     <script>
         function create() {

             $("#myModal .modal-body").load("{{ route('siswa.create') }}");
             $("#myModal").modal("show");

         }

         function edit(id) {

             $("#myModal .modal-body").load("{{ route('siswa.edit', ['id' => ':id']) }}".replace(':id', id));
             $("#myModal").modal("show");

         }

         function importData() {

             $("#myModal .modal-body").load("{{ route('siswa.import') }}");
             $("#myModal").modal("show");

         }
     </script>
     <script>
         // Event listener untuk perubahan pada dropdown sekolah
         $('#sekolah').change(function() {
             var sekolah_id = $(this).val(); // Mendapatkan nilai ID sekolah yang dipilih

             // Mengirim permintaan Ajax untuk mendapatkan data kelas berdasarkan sekolah
             $.ajax({
                 url: "{{ route('siswa.getKelas') }}",
                 method: 'POST',
                 data: {
                     _token: '{{ csrf_token() }}',
                     sekolah_id: sekolah_id
                 },
                 success: function(response) {
                     // Menghapus semua opsi pada dropdown kelas
                     $('#kelas').empty();
                     // Menambahkan opsi untuk setiap kelas yang diterima dari server
                     $.each(response, function(index, kelas) {
                         $('#kelas').append('<option value="' + kelas.kelas + '">' + kelas
                             .kelas +
                             '</option>');
                     });
                 },
                 error: function(xhr) {
                     console.log(xhr.responseText);
                 }
             });
         });
     </script>
 @endsection
