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
@php $butirsoal = $ps->butirsoal4 @endphp
<h2 class="card-title fw-bold text-dark mb-2">Soal Nomor {{ $ps->nomor }}</h2>
<div class="mb-3">{!! tipeSoal($ps->ref_butir_soal) !!}</div>
<hr class="my-4">
<div class="fs-5 text-dark mb-4">
    {!! $butirsoal->soal !!}
</div>
<span>Jawab : </span>
<input type="text" data-id="{{ $ps->id }}" id="isian" class="form-control" value="{{ $ps->jawaban }}"
    placeholder="Enter Text">
<small class="text-muted">Tekan "Enter" di dalam Form untuk menyimpan jawaban!</small>

<script>
    $('#isian').on('keydown', function(e) {
        if (e.key === 'Enter') {
            let id = $(this).data('id');
            let jwb = $(this).val();


            console.log(jwb);

            updateJawaban(id, jwb);
        }

    });
</script>
