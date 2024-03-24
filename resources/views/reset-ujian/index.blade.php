 @extends('layouts.main-layout.app')
 @section('title', 'Reset Ujian')
 @section('content')


     <button onclick="create()" class="btn btn-primary mb-3 text-nowrap add-new-role waves-effect waves-light">
         <i class="ti ti-refresh ti-sm me-2"></i>Reset Ujian
     </button>

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
     </script>

 @endsection
