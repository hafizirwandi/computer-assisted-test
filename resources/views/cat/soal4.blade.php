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
@php $butirsoal = $ps->butirsoal4 @endphp
<h5 class="card-title">Soal Nomor {{ $ps->nomor }}</h5>
{!! tipeSoal($ps->ref_butir_soal) !!}
<hr class="my-4">
{!! $butirsoal->soal !!}

<div class="mb-4"></div>
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
