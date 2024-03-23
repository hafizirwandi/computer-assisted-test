 @extends('layouts.main-layout.app')
 @section('title', 'CAT')

 @section('content')

     <div class="row">
         <div class="col-md-4">
             <div class="card mb-4">
                 <div class="card-body">
                     <form class="row g-3" method="post" action="{{ route('cat.checkKodeUjian') }}">
                         @csrf
                         <div class="col-12 col-md-12">
                             <label class="form-label">Kode Ujian</label>
                             <input type="text" name="kode_ujian" class="form-control" placeholder="Enter Text"
                                 required />
                         </div>



                         <div class="col-12 text-center">
                             <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                             <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                 aria-label="Close">
                                 Cancel
                             </button>
                         </div>
                     </form>

                 </div>
             </div>

         </div>
     </div>



 @endsection
