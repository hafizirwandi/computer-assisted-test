 @extends('layouts.main-layout.app')
 @section('title', 'Reset Ujian')
 @section('content')

     @can('reset-ujian-create')
         <button onclick="create()" class="btn btn-primary mb-3 text-nowrap add-new-role waves-effect waves-light">
             <i class="ti ti-refresh ti-sm me-2"></i>Reset Ujian
         </button>
     @endcan

     <div class="card mb-4">
         <div class="card-body">

             <div class="table-responsive">

                 <table class="datatable table">
                     <thead>
                         <tr>
                             <th>Nama</th>
                             <th>Kode Ujian</th>
                             <th>Alasan</th>
                             <th>Created at</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>
                                 <td>{{ $r->siswa->nama }}</td>
                                 <td>{{ $r->pengaturanUjian->kode_ujian }} - {{ $r->pengaturanUjian->soal->nama }}</td>
                                 <td>{{ $r->keterangan }}</td>

                                 <td>{{ \Carbon\Carbon::parse($r->created_at)->isoFormat('dddd, D MMM YYYY, HH:mm:ss') }}
                                 </td>
                                 <td>
                                     <div class="d-flex align-items-center">
                                         @can('reset-ujian-edit')
                                             <a href="javascript:;" onclick="edit(`{{ $r->id }}`)" class="text-body">
                                                 <i class="ti ti-edit ti-sm me-2"></i>
                                             </a>
                                         @endcan
                                         @can('siswa-delete')
                                             <form method="post" action="{{ route('reset-ujian.destroy') }}">
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
     <br>
     <hr>
     <div class="card mb-4">
         <div class="card-title p-2">
             <h4>Reset Ujian</h4>
         </div>
         <div class="card-body">

             <div class="table-responsive">

                 <table class="datatable table">
                     <thead>
                         <tr>
                             <th>Kode Ujian</th>
                             <th>Tanggal Ujian</th>
                             <th>Waktu</th>
                             <th>Soal</th>
                             <th>Jlh Soal</th>
                             <th>Is Random</th>
                             <th>Status</th>
                             <th>Created at</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($pujian as $r)
                             <tr>
                                 <td>{{ $r->kode_ujian }}</td>
                                 <td>{{ \Carbon\Carbon::parse($r->tanggal_ujian)->isoFormat('dddd, D MMM YYYY') }}
                                 </td>
                                 <td>{{ $r->waktu }} Menit</td>
                                 <td>{{ $r->soal->kode_soal . ' - ' . $r->soal->nama }}</td>
                                 <td>{{ $r->jlh_soal }}</td>
                                 <td>{!! statusIsRandomSoal($r->is_random) !!}</td>
                                 <td>{!! statusGeneral($r->status) !!}</td>
                                 <td>{{ \Carbon\Carbon::parse($r->created_at)->isoFormat('dddd, D MMM YYYY, HH:mm:ss') }}
                                 </td>
                                 <td>
                                     <div class="d-flex align-items-center">

                                         <form method="post" action="{{ route('reset-ujian.resetall') }}">
                                             @csrf
                                             <input type="hidden" name="kode_ujian" value="{{ $r->kode_ujian }}">
                                             <button type="submit"
                                                 onclick="return confirm('Are you sure you want to proceed?')"
                                                 class="text-body no-style">
                                                 <i class="ti ti-refresh ti-sm me-2"></i>
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

             $("#myModal .modal-body").load("{{ route('reset-ujian.create') }}", function() {
                 // Ketika konten modal selesai dimuat, inisialisasikan Select2

                 $('#sekolah').change(function() {
                     var sekolah_id = $(this).val(); // Mendapatkan nilai ID sekolah yang dipilih

                     // Mengirim permintaan Ajax untuk mendapatkan data kelas berdasarkan sekolah
                     $.ajax({
                         url: "{{ route('siswa.getSiswa') }}",
                         method: 'POST',
                         data: {
                             _token: '{{ csrf_token() }}',
                             sekolah_id: sekolah_id
                         },
                         success: function(response) {
                             $('#siswa').empty();

                             $.each(response, function(index, siswa) {
                                 $('#siswa').append('<option value="' + siswa.nis +
                                     '">' +
                                     siswa.nis + ' - ' + siswa.nama +
                                     '</option>');
                             });
                             $('#siswa').select2({
                                 dropdownParent: $('#myModal')
                             });
                         },
                         error: function(xhr) {
                             console.log(xhr.responseText);
                         }
                     });
                 });

                 // Menampilkan modal setelah konten dimuat dan Select2 diinisialisasi
                 $("#myModal").modal("show");
             });

         }

         @can('reset-ujian-edit')
             function edit(id) {

                 $("#myModal .modal-body").load("{{ route('reset-ujian.edit', ['id' => ':id']) }}".replace(':id', id));
                 $("#myModal").modal("show");

             }
         @endcan
     </script>

 @endsection
