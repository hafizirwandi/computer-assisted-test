 @extends('layouts.main-layout.app')
 @section('title', 'Pengaturan Ujian')
 @section('content')

     @can('p-ujian-create')
         <button onclick="create()" class="btn btn-primary mb-3 text-nowrap add-new-role waves-effect waves-light">
             <i class="ti ti-plus ti-sm me-2"></i>Tambah Pengaturan Ujian
         </button>
     @endcan

     <div class="card mb-4">
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
                             <th>Aktif</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
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
                                     <label class="switch switch-square">
                                         <input type="checkbox" class="switch-input"
                                             {{ $r->status == '1' ? 'checked' : '' }} />
                                         <span class="switch-toggle-slider">
                                             <span class="switch-on"></span>
                                             <span class="switch-off"></span>
                                         </span>
                                     </label>
                                 </td>
                                 <td>
                                     <div class="d-flex align-items-center">

                                         @can('p-ujian-edit')
                                             <a href="javascript:;" onclick="edit(`{{ $r->id }}`)" class="text-body">
                                                 <i class="ti ti-edit ti-sm me-2"></i>
                                             </a>
                                         @endcan
                                         @can('p-ujian-delete')
                                             <form method="post" action="{{ route('pengaturan-ujian.destroy') }}">
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
         @can('p-ujian-create')
             function create() {

                 $("#myModal .modal-body").load("{{ route('pengaturan-ujian.create') }}");
                 $("#myModal").modal("show");

             }
         @endcan
         @can('p-ujian-edit')
             function edit(id) {

                 $("#myModal .modal-body").load("{{ route('pengaturan-ujian.edit', ['id' => ':id']) }}".replace(':id', id));
                 $("#myModal").modal("show");

             }
         @endcan
     </script>

     <script>
         function aktif(id) {
             $.ajax({
                 url: "{{ route('cat.hitungHasil') }}",
                 method: 'POST',
                 data: {
                     _token: '{{ csrf_token() }}',
                     id: id
                 },
                 success: function(response) {
                     Swal.fire({
                         title: 'Berhasil!',
                         text: 'Data anda berhasil disimpan',
                         icon: 'success',
                         timerProgressBar: true,
                         customClass: {
                             confirmButton: 'btn btn-primary waves-effect waves-light',

                         },
                         buttonsStyling: false
                     });

                 },
                 error: function(xhr) {
                     console.log(xhr.responseText);
                 }
             });

         }
     </script>
 @endsection
