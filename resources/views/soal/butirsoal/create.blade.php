 @extends('layouts.main-layout.app')
 @section('title', 'Create Butir Soal')
 @section('content')




     <div class="card mb-4">
         <div class="card-body">

             <form class="row g-3" method="post" action="{{ route('soal.butirsoal.store') }}">
                 @csrf
                 <input type="hidden" name="soal_id" value="{{ $soal->id }}">
                 <div class="col-12 col-md-12">
                     <label class="form-label">Optional Jawaban</label>
                     <select name="tipe_optional_jawaban" class="form-control" placeholder="Enter Text"
                         id="optional_jawaban" required>
                         <option value="">-- Pilih --</option>
                         <option value="a,b,c,d">a,b,c,d</option>
                         <option value="a,b,c,d,e">a,b,c,d,e</option>
                     </select>
                 </div>
                 <div class="col-12 col-md-12">
                     <label class="form-label">Soal</label>
                     <textarea name="soal" class="form-control summernote" required></textarea>
                 </div>

                 <div class="col-12 col-md-12 d-none jawaban_a jawaban">
                     <label class="form-label">Jawaban A</label>
                     <textarea name="jawaban_a" class="form-control summernote"></textarea>
                 </div>
                 <div class="col-12 col-md-12 d-none jawaban_b jawaban">
                     <label class="form-label">Jawaban B</label>
                     <textarea name="jawaban_b" class="form-control summernote"></textarea>
                 </div>

                 <div class="col-12 col-md-12 d-none jawaban_c jawaban">
                     <label class="form-label">Jawaban C</label>
                     <textarea name="jawaban_c" class="form-control summernote"></textarea>
                 </div>
                 <div class="col-12 col-md-12 d-none jawaban_d jawaban">
                     <label class="form-label">Jawaban D</label>
                     <textarea name="jawaban_d" class="form-control summernote"></textarea>
                 </div>
                 <div class="col-12 col-md-12 d-none jawaban_e jawaban">
                     <label class="form-label">Jawaban E</label>
                     <textarea name="jawaban_e" class="form-control summernote"></textarea>
                 </div>

                 <div class="col-12 col-md-6">
                     <label class="form-label">Jawaban Benar</label>
                     <select name="jawaban_benar" class="form-control" placeholder="Enter Text" required>
                         <option value="">-- Pilih --</option>

                     </select>
                 </div>
                 <div class="col-12 col-md-6">
                     <label class="form-label">Poin Benar</label>
                     <input type="text" name="poin_benar" class="form-control" placeholder="Enter Text" required />
                 </div>


                 <div class="col-12 text-center">
                     <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                     <button type="reset" class="btn btn-label-secondary">
                         Cancel
                     </button>
                 </div>
             </form>

         </div>
     </div>
 @endsection

 @section('script')
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
     <script>
         $(document).ready(function() {
             $('.summernote').summernote({
                 height: 300
             });


             $("#optional_jawaban").change(function() {

                 var selectedValue = $(this).val(); // Mendapatkan nilai yang dipilih dari select
                 var $jawabanBenarSelect = $('select[name="jawaban_benar"]');
                 $jawabanBenarSelect.empty();
                 // Tambahkan opsi default
                 $jawabanBenarSelect.append('<option value="">-- Pilih --</option>');
                 $('.jawaban').addClass('d-none');

                 if (selectedValue) {
                     // Mendapatkan array dari nilai yang dipilih
                     var valuesArray = selectedValue.split(',');

                     // Loop melalui setiap nilai yang dipilih
                     $.each(valuesArray, function(index, value) {
                         // Menampilkan elemen dengan kelas yang sesuai dengan nilai yang dipilih
                         $('.jawaban_' + value).removeClass('d-none');
                         $jawabanBenarSelect.append('<option value="' + value + '">' + value +
                             '</option>');
                     });
                 }
             })
         });
     </script>
 @endsection
