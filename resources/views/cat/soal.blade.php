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
@php $butirsoal = $ps->butirsoal @endphp
<h5 class="card-title">Soal Nomor {{ $ps->nomor }}</h5>
<hr class="my-4">
{!! $butirsoal->soal !!}

<div class="mb-4"></div>
@php $const_jwb = explode(",",$butirsoal->tipe_optional_jawaban); @endphp
@foreach ($const_jwb as $jwb)
    <div class="form-check custom-option custom-option-basic mb-3 ">
        <label class="form-check-label custom-option-content">
            {{-- <input name="soal" class="form-check-input checkbox-jwb" type="radio"
                {{ $jwb == $ps->jawaban ? 'checked' : '' }} value="{{ $jwb }}" data-id="{{ $ps->id }}"> --}}
            <div class="circle-container {{ $jwb == $ps->jawaban ? 'active' : '' }}  form-check-input checkbox-jwb"
                data-id="{{ $ps->id }}" value="{{ $jwb }}">
                <span class="circle-text">{{ strtoupper($jwb) }}</span>
            </div>
            <span class="custom-option-body ">
                {!! $butirsoal->{'jawaban_' . $jwb} !!}
            </span>
        </label>
    </div>
@endforeach
