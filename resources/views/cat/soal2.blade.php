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

    /* Teks di dalam lingkaran */
    .circle-text {

        text-align: center;
    }

    .circle-container.active {
        background-color: #7367f0;
        color: #fff !important;
    }
</style>
@php $butirsoal = $ps->butirsoal2 @endphp
<h5 class="card-title">Soal Nomor {{ $ps->nomor }}</h5>
{!! tipeSoal($ps->ref_butir_soal) !!}
<hr class="my-4">
{!! $butirsoal->soal !!}

<div class="mb-4"></div>
@php

    $const_jwb = explode(',', $butirsoal->tipe_optional_jawaban);
    $jawaban = json_decode($ps->jawaban, true);
@endphp
@foreach ($const_jwb as $jwb)
    <div class="form-check custom-option custom-option-basic mb-3 ">
        <label class="form-check-label custom-option-content">
            <div class="circle-container {{ is_array($jawaban) && in_array($jwb, $jawaban) ? 'active' : '' }}  form-check-input checkbox-jwb"
                data-id="{{ $ps->id }}" value="{{ $jwb }}">
                <span class="circle-text">{{ strtoupper($jwb) }}</span>
            </div>
            <span class="custom-option-body ">
                {!! $butirsoal->{'jawaban_' . $jwb} !!}
            </span>
        </label>
    </div>
@endforeach

<script>
    $('.checkbox-jwb').click(function() {

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }

        // let jwb = $(this).attr('value');
        let id = $(this).data('id');

        let activeValues = [];
        $('.checkbox-jwb.active').each(function() {
            activeValues.push($(this).attr('value'));
        });
        let activeValuesJson = JSON.stringify(activeValues);

        console.log(activeValuesJson);
        updateJawaban(id, activeValuesJson);

    });
</script>
