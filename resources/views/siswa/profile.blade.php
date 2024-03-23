 @extends('layouts.main-layout.app')
 @section('title', 'Profile')
 @section('content')

     <div class="row">
         <div class="col-md-6">
             <div class="card mb-4">
                 <div class="card-body">
                     <table class="table table-striped">
                         <tr>
                             <td>NIS</td>
                             <td>:</td>
                             <td>{{ $data->nis }}</td>
                         </tr>
                         <tr>
                             <td>Nama</td>
                             <td>:</td>
                             <td>{{ $data->nama }}</td>
                         </tr>
                         <tr>
                             <td>Kelas</td>
                             <td>:</td>
                             <td>{{ $data->kelas }}</td>
                         </tr>
                         <tr>
                             <td>Sekolah</td>
                             <td>:</td>
                             <td>{{ $data->sekolah->nama }}</td>
                         </tr>
                     </table>

                 </div>
             </div>
         </div>
     </div>

 @endsection
