<style>
    .circle-container {
        width: 35px;
        height: 35px;
        border-radius: 8px !important;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 15px;
        font-size: 16px;
        flex-shrink: 0;
    }

    .circle-text {
        text-align: center;
        font-weight: bold;
    }

    .option-wrapper {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid #d1d5db;
        /* gray-300 */
        border-radius: 8px;
        background-color: #ffffff;
    }

    .option-wrapper:hover {
        background-color: #f9fafb;
        /* gray-50 */
    }

    .option-wrapper.active {
        border-color: #f97316;
        /* solid orange */
        background-color: #fffaf0;
        /* light orange tint */
        box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.1);
    }

    .option-wrapper .circle-container {
        background-color: #f3f4f6;
        /* gray-100 */
        color: #374151;
        /* gray-700 */
        border: 1px solid #d1d5db;
    }

    .option-wrapper.active .circle-container {
        background-color: #f97316 !important;
        /* solid orange */
        color: #fff !important;
        border-color: #f97316 !important;
    }
</style>
@php $butirsoal = $ps->butirsoal2 @endphp
<h2 class="card-title fw-bold text-dark mb-2">Soal Nomor {{ $ps->nomor }}</h2>
<div class="mb-3">{!! tipeSoal($ps->ref_butir_soal) !!}</div>
<hr class="my-4">
<div class="fs-5 text-dark mb-4">
    {!! $butirsoal->soal !!}
</div>

@php
    $const_jwb = explode(',', $butirsoal->tipe_optional_jawaban);
    $jawaban = json_decode($ps->jawaban, true);
@endphp
@foreach ($const_jwb as $jwb)
    @php $isActive = is_array($jawaban) && in_array($jwb, $jawaban); @endphp
    <div class="d-flex p-3 mb-3 option-wrapper checkbox-jwb {{ $isActive ? 'active' : '' }}" data-id="{{ $ps->id }}"
        value="{{ $jwb }}">
        <div class="circle-container">
            <span class="circle-text">{{ strtoupper($jwb) }}</span>
        </div>
        <div class="d-flex align-items-center" style="width: 100%;">
            {!! $butirsoal->{'jawaban_' . $jwb} !!}
        </div>
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
