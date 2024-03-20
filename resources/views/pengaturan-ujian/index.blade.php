 @extends('layouts.main-layout.app')
 @section('title', 'Pengaturan Ujian')
 @section('content')


     <button onclick="create()" class="btn btn-primary mb-3 text-nowrap add-new-role waves-effect waves-light">
         <i class="ti ti-plus ti-sm me-2"></i>Tambah Pengaturan Ujian
     </button>

     <div class="card mb-4">
         <div class="card-body">

             <div class="table-responsive">

                 <table class="datatable table">
                     <thead>
                         <tr>
                             <th>Kode Ujian</th>
                             <th>Tanggal Ujian</th>
                             <th>Soal</th>
                             <th>Is Random</th>
                             <th>Status</th>
                             <th>Created at</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($data as $r)
                             <tr>
                                 <td>{{ $r->kode_ujian }}</td>
                                 <td>{{ \Carbon\Carbon::parse($r->tanggal_ujian)->isoFormat('dddd, D MMM YYYY') }}
                                 </td>
                                 <td>{{ $r->soal->kode_soal . ' - ' . $r->soal->nama }}</td>
                                 <td>{!! statusIsRandomSoal($r->is_random) !!}</td>
                                 <td>{!! statusGeneral($r->status) !!}</td>
                                 <td>{{ \Carbon\Carbon::parse($r->created_at)->isoFormat('dddd, D MMM YYYY, HH:mm:ss') }}
                                 </td>
                                 <td>
                                     <div class="d-flex align-items-center">
                                         <a href="javascript:;" onclick="edit(`{{ $r->id }}`)" class="text-body">
                                             <i class="ti ti-edit ti-sm me-2"></i>
                                         </a>
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

             $("#myModal .modal-body").load("{{ route('pengaturan-ujian.create') }}");
             $("#myModal").modal("show");

         }

         function edit(id) {

             $("#myModal .modal-body").load("{{ route('pengaturan-ujian.edit', ['id' => ':id']) }}".replace(':id', id));
             $("#myModal").modal("show");

         }
     </script>

 @endsection
