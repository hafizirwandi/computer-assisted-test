@php $butirsoal = $ps->butirsoal @endphp
<h5 class="card-title">Soal Nomor {{ $ps->nomor }}</h5>
<hr class="my-4">
{!! $butirsoal->soal !!}

<div class="mb-4"></div>
@php $const_jwb = ['a','b','c','d','e']; @endphp
@foreach ($const_jwb as $jwb)
    <div class="form-check custom-option custom-option-basic mb-3 ">
        <label class="form-check-label custom-option-content">
            <input name="soal" class="form-check-input checkbox-jwb" type="radio"
                {{ $jwb == $ps->jawaban ? 'checked' : '' }} value="{{ $jwb }}" data-id="{{ $ps->id }}">

            <span class="custom-option-body ">
                {!! $butirsoal->{'jawaban_' . $jwb} !!}
            </span>
        </label>
    </div>
@endforeach
