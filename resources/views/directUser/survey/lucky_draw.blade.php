@extends('layouts.dashboard.app')
@section('body')
<section class="w-full h-full min-h-screen px-4 py-8 bg-premier">
    <span class="block mx-auto mb-12 text-5xl text-white font-batik">LUCKY DRAW</span>
    <form action="" method="get" class="grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-3">
        @csrf
        <select name="sekolah" class="font-bold text-white border-2 border-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white">
            <option value="" selected disabled class="font-semibold bg-white text-tersier opacity-60">Pilih Sekolah</option>
            @foreach ($sekolah as $item)
            <option value="{{ $item->NAMA_SEKOLAH }}" class="font-semibold bg-white text-premier">{{ $item->NAMA_SEKOLAH }}</option>
            @endforeach
        </select>
        <input type="number" name="jumlah" id="jumlah" placeholder="Jumlah Pemenang" class="font-bold border-2 border-white text-slate-300 placeholder:text-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white">
    </form>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#loading').hide();
        var prioritas = [];

        $(document).on('change', '.pi', function() {
            let soal = $(this).attr('data-soal');
            if ($(this).hasClass('other')) {
                $(`input.other-isian[data-soal=${soal}]`).prop('disabled', (i, v) => v = false);
            } else {
                $(`input.other-isian[data-soal=${soal}]`).prop('disabled', (i, v) => v = true);
            }
            $(`input.other-isian[data-soal=${soal}]`).val("");
        })

        $('.prioritas').each(function() {
            var theValue = $(this).val();
            $(this).data("value", theValue);
        });

        $(document).on('change', '.prioritas', function() {
            let id = $(this).attr('id');
            let soal = $(this).attr('data-soal');
            let value = $(this).val();
            let previousValue = $(this).data("value");
            prioritas.push(value + `_${soal}`);
            prioritas = prioritas.filter(e => e != previousValue + `_${soal}`);
            $(this).data("value", value);

            console.log(prioritas);
            $(`.prioritas[data-soal=${soal}] option`).each(function() {
                if ($(this).id != id) {
                    if (prioritas.includes($(this).val() + `_${soal}`)) {
                        // $(this).prop('disabled', (i, v) => v = true);
                        $(this).hide();
                    } else {
                        // $(this).prop('disabled', (i, v) => v = false);
                        $(this).show();
                    }
                }
            })
        })

    });

</script>
@endsection
