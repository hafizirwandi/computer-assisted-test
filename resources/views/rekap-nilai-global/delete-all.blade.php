 @extends('layouts.main-layout.app')
 @section('title', 'Rekap Nilai Global')
 @section('content')

     <div class="card mb-4">
         <div class="card-body">
             <button id="deleteSelected" class="btn btn-danger"><i class="ti ti-trash ti-sm me-2"></i> Hapus yang
                 Dipilih</button>
             <div class="table-responsive">

                 <table class="datatable table">
                     <thead>
                         <tr>
                             <th><input type="checkbox" id="checkAll"></th>
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
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>
                                 <td><input type="checkbox" class="checkbox" name="id[]" value="{{ $r->id }}">
                                 </td>
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

                             </tr>
                         @endforeach
                     </tbody>

                 </table>
             </div>
         </div>
     </div>
 @endsection
 @section('script')
     <script>
         $(document).ready(function() {
             // Ketika checkbox "Check All" diubah statusnya
             $("#checkAll").change(function() {
                 if ($(this).is(":checked")) {
                     // Jika dicentang, tandai semua checkbox
                     $(".checkbox").prop("checked", true);
                 } else {
                     // Jika tidak dicentang, hapus centang dari semua checkbox
                     $(".checkbox").prop("checked", false);
                 }
             });
             $("#deleteSelected").click(function() {
                 var selectedItems = []; // Simpan ID item yang dipilih
                 // Loop melalui setiap checkbox
                 $(".checkbox:checked").each(function() {
                     // Dapatkan nilai dari checkbox yang dipilih dan tambahkan ke dalam array
                     selectedItems.push($(this).val());
                 });


                 // Kirim data menggunakan AJAX
                 $.ajax({
                     url: '{{ route('rekap-nilai-global.destroy-all') }}',
                     method: 'POST',
                     data: {
                         _token: '{{ csrf_token() }}',
                         selectedItems: selectedItems
                     }, // Kirim ID item yang dipilih
                     success: function(response) {
                         Swal.fire({
                             title: 'Berhasil!',
                             text: 'Data anda berhasil dihapus',
                             icon: 'success',
                             customClass: {
                                 confirmButton: 'btn btn-primary waves-effect waves-light',

                             },
                             buttonsStyling: false
                         });
                         location.reload();
                         console.log('Data berhasil dihapus');
                     },
                     error: function(xhr, status, error) {
                         // Tindakan jika terjadi kesalahan
                         Swal.fire({
                             title: 'Gagal!',
                             text: 'Data anda gagal dihapus',
                             icon: 'error',
                             customClass: {
                                 confirmButton: 'btn btn-primary waves-effect waves-light',

                             },
                             buttonsStyling: false
                         });
                         location.reload();
                         console.error('Terjadi kesalahan saat menghapus data');
                     }
                 });
             });
         });
     </script>
 @endsection
