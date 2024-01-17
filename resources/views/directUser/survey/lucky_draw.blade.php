@extends('layouts.dashboard.app')
@section('body')
    @php
        function convertToRoman($number)
        {
            $result = '';

            // Define numeral symbols and their corresponding values
            $numerals = [
                'M' => 1000,
                'CM' => 900,
                'D' => 500,
                'CD' => 400,
                'C' => 100,
                'XC' => 90,
                'L' => 50,
                'XL' => 40,
                'X' => 10,
                'IX' => 9,
                'V' => 5,
                'IV' => 4,
                'I' => 1,
            ];

            // Loop through each numeral and subtract its value from the number
            foreach ($numerals as $numeral => $value) {
                while ($number >= $value) {
                    $result .= $numeral;
                    $number -= $value;
                }
            }

            return $result;
        }
    @endphp
    <div class="fixed inset-0 flex items-center justify-center w-full min-h-screen bg-white" id="loading">
        <img src="{{ asset('images/loading.svg') }}" alt="" class="w-40 h-40 mx-auto my-4">
    </div>
    <section class="w-full h-full min-h-screen px-4 py-8 bg-premier">
        <span class="block w-full mb-12 text-3xl text-center text-white sm:text-5xl font-batik">LUCKY DRAW</span>
        <form action="" method="get" class="grid grid-cols-1 sm:grid-cols-4 gap-x-4 gap-y-4">
            <select name="survey" id="survey"
                class="font-bold text-white border-2 border-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white"
                required>
                <option value="" selected disabled class="font-semibold bg-white text-tersier opacity-60">Pilih
                    Survey</option>
                @foreach ($list_survey as $item)
                    <option value="{{ $item->url }}" class="font-semibold bg-white text-premier"
                        {{ $item->url == request()->get('survey') ? 'selected' : '' }}>
                        {{ $item->nama }} | {{ $item->url }}</option>
                @endforeach
            </select>
            <input type="date" name="tanggal" id="tanggal" placeholder="Tanggal"
                value="{{ request()->get('tanggal') }}"
                class="font-bold border-2 border-white text-slate-300 placeholder:text-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white">
            <button type="submit"
                class="px-4 py-2 font-bold transition-all bg-white border-2 border-white text-premier hover:bg-premier hover:text-white"><i
                    class="mr-2 fa-solid fa-shuffle"></i>Cari</button>
            <a href="{{ url()->current() }}"
                class="px-4 py-2 font-bold text-center text-white transition-all bg-gray-600 border-2 border-white hover:bg-gray-600 hover:text-white">Reset</a>
        </form>
        <hr class="w-full my-4 border-4 border-white">
        @if (request()->get('survey'))
            <input type="hidden" id="participant" name="participant" value="{{ json_encode($participant) }}">
            <form id="shuffle-form" action="" method="get" class="grid grid-cols-1 sm:grid-cols-4 gap-x-4 gap-y-4">
                @csrf
                <input type="hidden" name="session" id="session" value="{{ $survey->id }}">
                <select name="sekolah" id="sekolah"
                    class="font-bold text-white border-2 border-white select-shuffle focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white"
                    required>
                    <option value="" selected disabled class="font-semibold bg-white text-tersier opacity-60">Pilih
                        Sekolah</option>
                    <option value="" class="font-semibold bg-white text-premier opacity-60" selected>Semua Sekolah
                    </option>
                    @foreach ($sekolah as $item)
                        <option value="{{ $item->NPSN }}" class="font-semibold bg-white text-premier">
                            {{ $item->NAMA_SEKOLAH }}</option>
                    @endforeach
                </select>
                <select name="kelas" id="kelas"
                    class="font-bold text-white border-2 border-white select-shuffle focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white"
                    required>
                    <option value="" selected disabled class="font-semibold bg-white text-tersier opacity-60">Pilih
                        Kelas
                    </option>
                    <option value="All" class="font-semibold bg-white text-premier opacity-60" selected>Semua Kelas
                    </option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ convertToRoman($i) }}" class="font-semibold bg-white text-premier">
                            {{ $i }}
                        </option>
                    @endfor
                </select>
                <input type="number" name="jumlah" id="jumlah" placeholder="Jumlah Pemenang"
                    class="font-bold border-2 border-white text-slate-300 placeholder:text-white focus:border-white focus:ring-white focus:outline-white bg-premier prioritas accent-white"
                    required>
                {{-- <div class="flex flex-col">
        </div> --}}
                <button type="submit"
                    class="px-4 py-2 font-bold transition-all bg-white border-2 border-white text-premier hover:bg-premier hover:text-white"><i
                        class="mr-2 fa-solid fa-shuffle"></i>Acak Pemenang</button>
            </form>
            <span class="inline-block my-2 font-semibold text-white">Jumlah Partisipan : <span
                    id="partisipan"></span></span>
            <img src="{{ asset('images/draw.svg') }}" alt="" class="w-40 h-40 mx-auto my-4 draw"
                style="display: none">
            <span class="block w-full mt-12 mb-8 text-3xl font-semibold text-center text-white random-title"
                style="display: none">Pemenangnya adalah...</span>
            <span
                class="block w-full mt-12 mb-8 text-4xl font-semibold text-center text-white sm:text-6xl random-number font-batik"
                style="display: none"></span>
            <div class="grid grid-cols-2 gap-4 pt-2 border-t-4 border-t-white winner" style="display: none">
            </div>
        @endif
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

            let participant = JSON.parse($("#participant").val())
            let phone_numbers = participant.map(data => data.telp_siswa);
            $("#partisipan").text(phone_numbers.length)
            console.log(phone_numbers);


            const getNumber = (d_sekolah, d_kelas, d_jumlah, d_session, d_token) => {
                // $('.draw').show();

                let pattern_sekolah = new RegExp(d_sekolah, "i");
                let pattern_kelas = new RegExp(d_kelas, "i");

                // $.ajax({
                //     url: "{{ URL::to('/qns/survey/telp_list') }}",
                //     method: "POST",
                //     dataType: "JSON",
                //     data: {
                //         npsn: d_sekolah,
                //         kelas: d_kelas,
                //         jumlah: d_jumlah,
                //         survey: d_session,
                //         _token: d_token
                //     },
                //     success: (data) => {
                //         $('.draw').hide();
                //         telp = data.map(d => d.telp_siswa);
                //         // console.log(data)
                //         $("#partisipan").text(telp.length);
                //     },
                //     error: (e) => {
                //         $('.draw').hide();
                //         console.log('error', e);
                //     }
                // });

                phone_numbers = participant.filter((data) => {
                    return pattern_sekolah.test(data.npsn) && pattern_kelas.test(data.kelas);
                }).map((data) => data.telp_siswa);

                $("#partisipan").text(phone_numbers.length)

            }

            $(".select-shuffle").change(function() {
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

            $('#shuffle-form').on('submit', function() {
                event.preventDefault();
                $('.winner').html('');
                jumlah = $('#jumlah').val();

                telp = phone_numbers.map(d => d.telp_siswa);
                console.log({
                    telp
                });

                if (jumlah > phone_numbers.length) {
                    alert(`Nomor Telepon tidak mencukupi. Maksimal sebanyak ${phone_numbers.length}`)
                } else {
                    let pos = 0;
                    $('.random-title').show();
                    $('.random-number').show();
                    $('.winner').show();
                    for (let index = 0; index < jumlah; index++) {
                        pos = Math.floor(Math.random() * phone_numbers.length);
                        console.log(phone_numbers[pos]);
                        $('.random-number').prop('Counter', 0).animate({
                            Counter: phone_numbers[pos]
                        }, {
                            duration: 2000,
                            easing: 'swing',
                            step: function(now) {
                                $(this).text('0' + Math.ceil(now));
                            },
                            complete: function() {
                                $('.winner').append(
                                    `<div class="py-3 text-lg font-bold text-center bg-white text-premier">${'0'+$(this).prop('Counter')}</div>`
                                );
                                phone_numbers = phone_numbers.filter(e => e != phone_numbers[
                                    pos]);
                                console.log(phone_numbers)
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
