<div class="card mb-4">
    <div class="card-body">
        @php $data = $data->butirSoal2; @endphp
        <form class="row g-3" method="post" action="{{ route('soal.butirsoal.update2', $data->id) }}">
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
            <div class="col-12 col-md-12 {{ !in_array('a', $const) ? 'd-none' : '' }} poin_benar_a poin_benar">
                <label class="form-label">Poin Benar A</label>
                <input type="text" name="poin_benar_a" class="form-control" value="{{ $data->poin_benar_a }}"
                    placeholder="Enter Text" />
            </div>
            <div class="col-12 col-md-12 {{ !in_array('b', $const) ? 'd-none' : '' }} jawaban_b jawaban">
                <label class="form-label">Jawaban B</label>
                <textarea name="jawaban_b" class="form-control summernote">{{ $data->jawaban_b }}</textarea>
            </div>
            <div class="col-12 col-md-12 {{ !in_array('b', $const) ? 'd-none' : '' }} poin_benar_b poin_benar">
                <label class="form-label">Poin Benar B</label>
                <input type="text" name="poin_benar_b" class="form-control" value="{{ $data->poin_benar_b }}"
                    placeholder="Enter Text" />
            </div>

            <div class="col-12 col-md-12 {{ !in_array('c', $const) ? 'd-none' : '' }} jawaban_c jawaban">
                <label class="form-label">Jawaban C</label>
                <textarea name="jawaban_c" class="form-control summernote">{{ $data->jawaban_c }}</textarea>
            </div>
            <div class="col-12 col-md-12 {{ !in_array('c', $const) ? 'd-none' : '' }} poin_benar_c poin_benar">
                <label class="form-label">Poin Benar C</label>
                <input type="text" name="poin_benar_c" class="form-control" value="{{ $data->poin_benar_c }}"
                    placeholder="Enter Text" />
            </div>
            <div class="col-12 col-md-12 {{ !in_array('d', $const) ? 'd-none' : '' }} jawaban_d jawaban">
                <label class="form-label">Jawaban D</label>
                <textarea name="jawaban_d" class="form-control summernote">{{ $data->jawaban_d }}</textarea>
            </div>
            <div class="col-12 col-md-12 {{ !in_array('d', $const) ? 'd-none' : '' }} poin_benar_d poin_benar">
                <label class="form-label">Poin Benar D</label>
                <input type="text" name="poin_benar_d" class="form-control" value="{{ $data->poin_benar_d }}"
                    placeholder="Enter Text" />
            </div>
            <div class="col-12 col-md-12 {{ !in_array('e', $const) ? 'd-none' : '' }} jawaban_e jawaban">
                <label class="form-label">Jawaban E</label>
                <textarea name="jawaban_e" class="form-control summernote">{{ $data->jawaban_e }}</textarea>
            </div>
            <div class="col-12 col-md-12 {{ !in_array('e', $const) ? 'd-none' : '' }} poin_benar_e poin_benar">
                <label class="form-label">Poin Benar E</label>
                <input type="text" name="poin_benar_e" class="form-control" value="{{ $data->poin_benar_e }}"
                    placeholder="Enter Text" />
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
    @include('partials.summernote')
    <script>
        $(document).ready(function() {
            $("#optional_jawaban").change(function() {
                var selectedValue = $(this).val();
                $('.jawaban').addClass('d-none');
                $('.poin_benar').addClass('d-none');

                if (selectedValue) {
                    var valuesArray = selectedValue.split(',');
                    $.each(valuesArray, function(index, value) {
                        $('.jawaban_' + value).removeClass('d-none');
                        $('.poin_benar_' + value).removeClass('d-none');
                    });
                }
            })
        });
    </script>
@endsection
