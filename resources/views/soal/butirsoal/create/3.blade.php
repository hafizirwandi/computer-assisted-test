<div class="card mb-4">
    <div class="card-body">
        <form class="row g-3" method="post" action="{{ route('soal.butirsoal.store3') }}">
            @csrf
            <input type="hidden" name="soal_id" value="{{ $soal->id }}">
            <div class="col-12 col-md-12">
                <label class="form-label">Optional Jawaban</label>
                <input type="text" name="optional_jawaban" class="form-control" id="optional_jawaban"
                    placeholder="Enter Text">
                <small>NB : Pisahkan teks dengan koma. Contohnya Benar,Salah. Kemudian klik "Enter" untuk menggenerate
                    Form</small>
            </div>
            <div class="col-12 col-md-12">
                <label class="form-label">Soal</label>
                <textarea name="soal" class="form-control summernote" required></textarea>
            </div>
            <hr>
            <a href="javascript:;" class="text-body d-none" id="tambahRow">
                <i class="ti ti-circle-plus ti-sm me-2"></i>
            </a>
            <table class="table d-none" id="jawabanTable">
                <thead>

                </thead>
                <tbody>

                </tbody>
            </table>






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
            var valuesArray;
            $('.summernote').summernote({
                height: 300
            });
            $('#optional_jawaban').keydown(function(event) {
                if (event.key === 'Enter') {
                    var jawaban = $(this).val();
                    if (jawaban.length === 0) {
                        $('#tambahRow').addClass('d-none');
                        $('#jawabanTable thead').html('');
                        $('#jawabanTable tbody').html('');
                        return;
                    }
                    valuesArray = jawaban.split(',');

                    var str = '<tr>' +
                        '<th style="width: 70%">Pernyataan</th>';
                    $.each(valuesArray, function(index, value) {
                        str +=
                            '<th>' +
                            value + '</th>';

                    });

                    str += '<th>Aksi</th>' +
                        '</tr>';

                    $('#jawabanTable thead').html('');
                    $('#jawabanTable tbody').html('');
                    $('#jawabanTable thead').append(str);

                    $('#jawabanTable').removeClass('d-none');
                    $('#tambahRow').removeClass('d-none');


                    event.preventDefault();
                }

            });
            $('#tambahRow').click(function() {
                var str = '<tr>' +
                    '<td><input type="text" name="pernyataan_soal[]" class="form-control"></td>';

                var i = 0;
                $.each(valuesArray, function(index, value) {

                    str +=
                        '<td><input type="text" name="poin_benar_' + i +
                        '[]" class="form-control"></td>';
                    i++;


                });

                str += '<td><a href="javascript:;" onclick="deleteRow(this)" class="text-body">' +
                    '<i class="ti ti-trash ti-sm me-2"></i></a></td>' +
                    '</tr>';

                $('#jawabanTable tbody').append(str);
                event.preventDefault();
            });




        });

        function deleteRow(element) {
            $(element).closest('tr').remove();
        }
    </script>
@endsection
