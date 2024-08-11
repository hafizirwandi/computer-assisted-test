 @extends('layouts.main-layout.app')
 @section('title', 'Create Butir Soal')
 @section('content')


     <div class="alert alert-primary" role="alert">
         <form action="">
             <div class="row g-3">
                 <div class="col-md-5">
                     <select name="tipe-soal" class="form-control" placeholder="Enter Text" required>
                         <option value="">-- Pilih --</option>
                         <option value="1" {{ request()->get('tipe-soal') == '1' ? 'selected' : '' }}>Pilihan Ganda
                             Single
                             Option</option>
                         <option value="2" {{ request()->get('tipe-soal') == '2' ? 'selected' : '' }}>Pilihan Ganda
                             Multi Options</option>
                         <option value="3" {{ request()->get('tipe-soal') == '3' ? 'selected' : '' }}>Pilihan Ganda
                             Komplek</option>
                         <option value="4" {{ request()->get('tipe-soal') == '4' ? 'selected' : '' }}>Isian Singkat
                         </option>
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

 @endsection
