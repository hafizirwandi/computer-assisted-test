<div class="card mb-4">
    <div class="card-body">


        @php $data = $data->butirSoal4; @endphp
        <form class="row g-3" method="post" action="{{ route('soal.butirsoal.update4', $data->id) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="soal_id" value="{{ $data->soal_id }}">

            <div class="col-12 col-md-12">
                <label class="form-label">Soal</label>
                <textarea name="soal" class="form-control summernote" required>{{ $data->soal }}</textarea>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">Poin Minimal</label>
                <input type="text" name="poin_minimal" class="form-control" value="{{ $data->poin_minimal }}"
                    placeholder="Enter Text" required />
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Poin Maksimal</label>
                <input type="text" name="poin_maksimal" class="form-control" value="{{ $data->poin_maksimal }}"
                    placeholder="Enter Text" required />
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">Jawaban</label>
                <input type="text" name="jawaban" class="form-control" value="{{ $data->jawaban }}"
                    placeholder="Enter Text" required />
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">Kunci Kata</label>
                <select name="kunci_kata" class="form-control" placeholder="Enter Text" required>
                    <option value="0" {{ $data->kunci_kata == '0' ? 'selected' : '' }}>Tidak</option>
                    <option value="1" {{ $data->kunci_kata == '1' ? 'selected' : '' }}>Ya</option>

                </select>
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
