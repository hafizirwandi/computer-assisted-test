 @extends('layouts.main-layout.app')
 @section('title', 'Rekap Nilai Global')
 @section('content')
     <style>
         input[type="text"] {
             width: 200px !important;
         }

         input[type="number"] {
             width: 100px !important;
         }
     </style>
     <div class="card mb-4">
         <div class="card-body">

             <div class="table-responsive">
                 <table class=" table table-responsive">
                     <thead>
                         <tr>

                             <th>Kode Sekolah</th>
                             <th>Sekolah</th>
                             <th>Kode Ujian</th>
                             <th>Matapelajaran</th>
                             <th>NIS</th>
                             <th>Nama</th>
                             <th>Kelas</th>
                             <th>Jlh Soal</th>
                             <th>Jlh Benar</th>
                             <th>Jlh Salah</th>
                             <th>Jlh Tidak Jawab</th>
                             <th>Nilai</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>

                                 <td>
                                     <input type="text" name="kode_sekolah_{{ $r->id }}"
                                         value="{{ $r->kode_sekolah }}" class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="text" name="nama_sekolah_{{ $r->id }}"
                                         value="{{ $r->nama_sekolah }}" class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="text" name="kode_ujian_{{ $r->id }}"
                                         value="{{ $r->kode_ujian }}" class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="text" name="matapelajaran_{{ $r->id }}"
                                         value="{{ $r->matapelajaran }}" class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="text" name="nis_{{ $r->id }}" value="{{ $r->nis }}"
                                         class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="text" name="nama_siswa_{{ $r->id }}"
                                         value="{{ $r->nama_siswa }}" class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="text" name="kelas_{{ $r->id }}" value="{{ $r->kelas }}"
                                         class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="number" name="jlh_soal_{{ $r->id }}" value="{{ $r->jlh_soal }}"
                                         class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="number" name="jlh_jawab_benar_{{ $r->id }}"
                                         value="{{ $r->jlh_jawab_benar }}" class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="number" name="jlh_jawab_salah_{{ $r->id }}"
                                         value="{{ $r->jlh_jawab_salah }}" class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="number" name="jlh_tidak_jawab_{{ $r->id }}"
                                         value="{{ $r->jlh_tidak_jawab }}" class="form-control" required>
                                 </td>
                                 <td>
                                     <input type="number" name="nilai_{{ $r->id }}" value="{{ $r->nilai }}"
                                         class="form-control" required>
                                 </td>
                                 <td>
                                     <a href="javascript:;" onclick="save(`{{ $r->id }}`)" class="btn btn-primary">
                                         Simpan
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

 @section('script')
     <script>
         function save(id) {
             var kode_sekolah = $('input[name="kode_sekolah_' + id + '"]').val();
             var nama_sekolah = $('input[name="nama_sekolah_' + id + '"]').val();
             var kode_ujian = $('input[name="kode_ujian_' + id + '"]').val();
             var matapelajaran = $('input[name="matapelajaran_' + id + '"]').val();
             var nis = $('input[name="nis_' + id + '"]').val();
             var nama_siswa = $('input[name="nama_siswa_' + id + '"]').val();
             var kelas = $('input[name="kelas_' + id + '"]').val();
             var jlh_soal = $('input[name="jlh_soal_' + id + '"]').val();
             var jlh_jawab_benar = $('input[name="jlh_jawab_benar_' + id + '"]').val();
             var jlh_jawab_salah = $('input[name="jlh_jawab_salah_' + id + '"]').val();
             var jlh_tidak_jawab = $('input[name="jlh_tidak_jawab_' + id + '"]').val();
             var nilai = $('input[name="nilai_' + id + '"]').val();

             $.ajax({
                 url: "{{ route('rekap-nilai-global.save-edit-all', ['id' => ':id']) }}".replace(':id', id),
                 method: 'POST',
                 data: {
                     _token: '{{ csrf_token() }}',
                     _method: 'put',
                     kode_sekolah: kode_sekolah,
                     nama_sekolah: nama_sekolah,
                     kode_ujian: kode_ujian,
                     matapelajaran: matapelajaran,
                     nis: nis,
                     nama_siswa: nama_siswa,
                     kelas: kelas,
                     jlh_soal: jlh_soal,
                     jlh_jawab_benar: jlh_jawab_benar,
                     jlh_jawab_salah: jlh_jawab_salah,
                     jlh_tidak_jawab: jlh_tidak_jawab,
                     nilai: nilai
                 },
                 success: function(response) {
                    // console.log(response);
                     Swal.fire({
                         title: 'Berhasil!',
                         text: 'Data anda berhasil disimpan',
                         icon: 'success',
                         customClass: {
                             confirmButton: 'btn btn-primary waves-effect waves-light',

                         },
                         buttonsStyling: false
                     });

                 },
                 error: function(xhr) {
                     console.log(xhr.responseText);
                     Swal.fire({
                         title: 'Gagal!',
                         text: 'Data anda gagal disimpan',
                         icon: 'error',
                         customClass: {
                             confirmButton: 'btn btn-primary waves-effect waves-light',

                         },
                         buttonsStyling: false
                     });
                 }
             });

         }
     </script>
 @endsection
