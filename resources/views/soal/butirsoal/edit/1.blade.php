<div class="card mb-4">
    <div class="card-body">
        @php $data = $data->butirSoal; @endphp
        <form class="row g-3" method="post" action="{{ route('soal.butirsoal.update', $data->id) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="soal_id" value="{{ $data->soal_id }}">
            <div class="col-12 col-md-12">
                <label class="form-label">Optional Jawaban</label>
                <select name="tipe_optional_jawaban" class="form-control" placeholder="Enter Text" id="optional_jawaban"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="a,b,c,d" {{ $data->tipe_optional_jawaban == 'a,b,c,d' ? 'selected' : '' }}>a,b,c,d
                    </option>
                    <option value="a,b,c,d,e" {{ $data->tipe_optional_jawaban == 'a,b,c,d,e' ? 'selected' : '' }}>
                        a,b,c,d,e</option>
                </select>
            </div>
            <div class="col-12 col-md-12">
                <label class="form-label">Soal</label>
                <textarea name="soal" class="form-control summernote" required>{{ $data->soal }}</textarea>
            </div>
            @php $const =  explode(",", $data->tipe_optional_jawaban) ;@endphp
            <div class="col-12 col-md-12 {{ !in_array('a', $const) ? 'd-none' : '' }} jawaban_a jawaban">
                <label class="form-label">Jawaban A</label>
                <textarea name="jawaban_a" class="form-control summernote">{{ $data->jawaban_a }}</textarea>
            </div>
            <div class="col-12 col-md-12 {{ !in_array('b', $const) ? 'd-none' : '' }} jawaban_b jawaban">
                <label class="form-label">Jawaban B</label>
                <textarea name="jawaban_b" class="form-control summernote">{{ $data->jawaban_b }}</textarea>
            </div>

            <div class="col-12 col-md-12 {{ !in_array('c', $const) ? 'd-none' : '' }} jawaban_c jawaban">
                <label class="form-label">Jawaban C</label>
                <textarea name="jawaban_c" class="form-control summernote">{{ $data->jawaban_c }}</textarea>
            </div>
            <div class="col-12 col-md-12 {{ !in_array('d', $const) ? 'd-none' : '' }} jawaban_d jawaban">
                <label class="form-label">Jawaban D</label>
                <textarea name="jawaban_d" class="form-control summernote">{{ $data->jawaban_d }}</textarea>
            </div>
            <div class="col-12 col-md-12 {{ !in_array('e', $const) ? 'd-none' : '' }} jawaban_e jawaban">
                <label class="form-label">Jawaban E</label>
                <textarea name="jawaban_e" class="form-control summernote">{{ $data->jawaban_e }}</textarea>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Jawaban Benar</label>
                <select name="jawaban_benar" class="form-control" placeholder="Enter Text" required>
                    <option value="">-- Pilih --</option>

                    @foreach ($const as $r)
                        <option value="{{ $r }}" {{ $data->jawaban_benar == $r ? 'selected' : '' }}>
                            {{ $r }}</option>
                    @endforeach

                </select>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Poin Benar</label>
                <input type="text" name="poin_benar" class="form-control" placeholder="Enter Text"
                    value="{{ $data->poin_benar }}" required />
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300
            });
            $("#optional_jawaban").change(function() {

                var jawaban_benar = {{ $data->jawaban_benar }};
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
                        $jawabanBenarSelect.append('<option value="' + value + '"' + (value ==
                            jawaban_benar ?
                            ' selected' : '') + '>' + value + '</option>');
                    });
                }
            })
        });
    </script>
@endsection
