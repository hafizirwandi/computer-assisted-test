<style>
    .circle-container {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 10px;
        font-size: 16px;
    }

    .circle-text {
        text-align: center;
    }

    .circle-container.active {
        background-color: #7367f0;
        color: #fff !important;
    }
</style>
@php
    $r = $ps->butirsoal3;
    $jawaban = json_decode($ps->jawaban, true);
@endphp
<h2 class="card-title fw-bold text-dark mb-2">Soal Nomor {{ $ps->nomor }}</h2>
<div class="mb-3">{!! tipeSoal($ps->ref_butir_soal) !!}</div>
<hr class="my-4">
<div class="fs-5 text-dark mb-4">
    {!! $r->soal !!}
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width:70%">Pernyataan</th>

            @foreach (json_decode($r->optional_jawaban) as $oj)
                <th>{{ $oj }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @php
            $pernyataan = json_decode($r->pernyataan_soal);
            $poin_benar = json_decode($r->poin_benar);
            $i = 0;
        @endphp


        @foreach ($pernyataan as $p)
            <tr>
                <td>{{ $p }}</td>

                @for ($m = 0; $m < count(json_decode($r->optional_jawaban)); $m++)
                    <td>
                        <input value="{{ $m }}" name="soal_{{ $i }}[]"
                            class="form-check-input checkbox-jwb soal-{{ $i }}-{{ $m }}"
                            type="radio" {{ ($jawaban[$i] ?? '') == $m ? 'checked' : '' }}>
                    </td>
                @endfor

            </tr>
            @php $i++; @endphp
        @endforeach
    </tbody>
</table>

<script>
    $('.checkbox-jwb').click(function() {

        let id = {{ $ps->id }};

        let pernyataan = {{ count($pernyataan) }};
        let ob = {{ count(json_decode($r->optional_jawaban)) }};

        let allValues = [];
        for (var i = 0; i < pernyataan; i++) {
            let val = null;
            for (var m = 0; m < ob; m++) {

                let isChecked = $('.soal-' + i + '-' + m).is(':checked');
                if (isChecked) {
                    val = $('.soal-' + i + '-' + m).val();
                }

            }
            allValues.push(val);
        }

        let allValuesJson = JSON.stringify(allValues);
        console.log(allValuesJson);

        updateJawaban(id, allValuesJson);

    });
</script>
