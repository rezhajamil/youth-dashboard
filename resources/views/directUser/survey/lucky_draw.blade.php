@extends('layouts.dashboard.app')
@section('body')
<section class="w-full h-full min-h-screen px-4 py-8 bg-premier">
    <span class="block w-full mb-12 text-5xl text-center text-white font-batik">LUCKY DRAW</span>
    <form action="" method="get" class="grid grid-cols-1 sm:grid-cols-3 gap-x-3 gap-y-3">
        @csrf
        <input type="hidden" name="session" id="session" value="{{ $survey->id }}">
        <select name="sekolah" id="sekolah" class="font-bold text-white border-2 border-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white">
            <option value="" selected disabled class="font-semibold bg-white text-tersier opacity-60">Pilih Sekolah</option>
            @foreach ($sekolah as $item)
            <option value="{{ $item->NPSN }}" class="font-semibold bg-white text-premier">{{ $item->NAMA_SEKOLAH }}</option>
            @endforeach
        </select>
        <input type="number" name="jumlah" id="jumlah" placeholder="Jumlah Pemenang" class="font-bold border-2 border-white text-slate-300 placeholder:text-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white">
        <button type="submit" class="px-4 py-2 font-bold transition-all bg-white border-2 border-white text-premier hover:bg-premier hover:text-white"><i class="mr-2 fa-solid fa-shuffle"></i>Acak Pemenang</button>
    </form>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('form').on('submit', function() {
            event.preventDefault();
            // $('#loading').show();

            let _token = $('meta[name="csrf-token"]').attr('content');
            let sekolah = $('#sekolah').val();
            let jumlah = $('#jumlah').val();
            let session = $('#session').val();

            let telp = [];
            $.ajax({
                url: "{{ URL::to('/qns/survey/telp_list') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    npsn: sekolah
                    , jumlah: jumlah
                    , survey: session
                    , _token: _token
                }
                , success: (data) => {
                    telp = data.map(d => d.telp_siswa);
                    if (jumlah > telp.length) {
                        alert(`Nomor Telepon tidak mencukupi. Maksimal sebanyak ${telp.length}`)
                    }

                }
                , error: (e) => {
                    console.log('error', e);
                }
            })
        })
    })

</script>
@endsection
