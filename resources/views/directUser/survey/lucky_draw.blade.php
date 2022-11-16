@extends('layouts.dashboard.app')
@section('body')
<div class="fixed inset-0 flex items-center justify-center w-full min-h-screen bg-white" id="loading">
    <img src="{{ asset('images/loading.svg') }}" alt="" class="w-40 h-40 mx-auto my-4">
</div>
<section class="w-full h-full min-h-screen px-4 py-8 bg-premier">
    <span class="block w-full mb-12 text-3xl text-center text-white sm:text-5xl font-batik">LUCKY DRAW</span>
    <form action="" method="get" class="grid grid-cols-1 sm:grid-cols-4 gap-x-4 gap-y-4">
        @csrf
        <input type="hidden" name="session" id="session" value="{{ $survey->id }}">
        <select name="sekolah" id="sekolah" class="font-bold text-white border-2 border-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white" required>
            <option value="" selected disabled class="font-semibold bg-white text-tersier opacity-60">Pilih Sekolah</option>
            @foreach ($sekolah as $item)
            <option value="{{ $item->NPSN }}" class="font-semibold bg-white text-premier">{{ $item->NAMA_SEKOLAH }}</option>
            @endforeach
        </select>
        <select name="kelas" id="kelas" class="font-bold text-white border-2 border-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white" required>
            <option value="" selected disabled class="font-semibold bg-white text-tersier opacity-60">Pilih Kelas</option>
            <option value="" class="font-semibold bg-white text-premier opacity-60">Semua Kelas</option>
            @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" class="font-semibold bg-white text-premier">{{ $i }}</option>@endfor
        </select>
        <input type="number" name="jumlah" id="jumlah" placeholder="Jumlah Pemenang" class="font-bold border-2 border-white text-slate-300 placeholder:text-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white" required>
        {{-- <div class="flex flex-col">
        </div> --}}
        <button type="submit" class="px-4 py-2 font-bold transition-all bg-white border-2 border-white text-premier hover:bg-premier hover:text-white"><i class="mr-2 fa-solid fa-shuffle"></i>Acak Pemenang</button>
    </form>
    <span class="inline-block my-2 font-semibold text-white">Jumlah Partisipan : <span id="partisipan"></span></span>
    <img src="{{ asset('images/draw.svg') }}" alt="" class="w-40 h-40 mx-auto my-4 draw" style="display: none">
    <span class="block w-full mt-12 mb-8 text-3xl font-semibold text-center text-white random-title" style="display: none">Pemenangnya adalah...</span>
    <span class="block w-full mt-12 mb-8 text-4xl font-semibold text-center text-white sm:text-6xl random-number font-batik" style="display: none"></span>
    <div class="grid grid-cols-2 gap-4 pt-2 border-t-4 border-t-white winner" style="display: none">

    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#loading').hide();
        var telp;
        let _token;
        let sekolah;
        let kelas;
        let jumlah;
        let session;


        const getNumber = (d_sekolah, d_kelas, d_jumlah, d_session, d_token) => {
            $('.draw').show();
            console.log({
                npsn: d_sekolah
                , kelas: d_kelas
                , jumlah: d_jumlah
                , survey: d_session
                , _token: d_token
            })

            $.ajax({
                url: "{{ URL::to('/qns/survey/telp_list') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    npsn: d_sekolah
                    , kelas: d_kelas
                    , jumlah: d_jumlah
                    , survey: d_session
                    , _token: d_token
                }
                , success: (data) => {
                    $('.draw').hide();
                    telp = data.map(d => d.telp_siswa);
                    // console.log(data)
                    $("#partisipan").text(telp.length);
                }
                , error: (e) => {
                    $('.draw').hide();
                    console.log('error', e);
                }
            });
        }

        $("select").change(function() {
            _token = $('meta[name="csrf-token"]').attr('content');
            sekolah = $('#sekolah').val();
            kelas = $('#kelas').val();
            session = $('#session').val();
            $('.winner').html('').hide();
            $('.random-title').hide();
            $('.random-number').hide();

            // console.log(sekolah)
            getNumber(sekolah, kelas, jumlah, session, _token);
        })

        $('form').on('submit', function() {
            event.preventDefault();
            $('.winner').html('');
            jumlah = $('#jumlah').val();

            if (jumlah > telp.length) {
                alert(`Nomor Telepon tidak mencukupi. Maksimal sebanyak ${telp.length}`)
            } else {
                let pos = 0;
                $('.random-title').show();
                $('.random-number').show();
                $('.winner').show();
                for (let index = 0; index < jumlah; index++) {
                    pos = Math.floor(Math.random() * telp.length);
                    console.log(telp[pos]);
                    $('.random-number').prop('Counter', 0).animate({
                        Counter: telp[pos]
                    }, {
                        duration: 2000
                        , easing: 'swing'
                        , step: function(now) {
                            $(this).text('0' + Math.ceil(now));
                        }
                        , complete: function() {
                            $('.winner').append(`<div class="py-3 text-lg font-bold text-center bg-white text-premier">${'0'+$(this).prop('Counter')}</div>`);
                            telp = telp.filter(e => e != telp[pos]);
                            console.log(telp)
                            $(this).prop('Counter', 0)

                        }
                    });
                }

            }


            // $.ajax({
            //     url: "{{ URL::to('/qns/survey/telp_list') }}"
            //     , method: "POST"
            //     , dataType: "JSON"
            //     , data: {
            //         npsn: sekolah
            //         , kelas: kelas
            //         , jumlah: jumlah
            //         , survey: session
            //         , _token: _token
            //     }
            //     , success: (data) => {
            //         $('.draw').hide();
            //         telp = data.map(d => d.telp_siswa);
            //         console.log(telp);


            //     }
            //     , error: (e) => {
            //         $('.draw').hide();
            //         console.log('error', e);
            //     }
            // })
        })
    })

</script>
@endsection
