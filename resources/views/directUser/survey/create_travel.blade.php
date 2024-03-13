@extends('layouts.dashboard.app')
@section('body')
    <section class="flex h-full min-h-screen w-full flex-col justify-center gap-3 bg-premier px-4 py-4">
        @if (session('success'))
            <div class="w-full rounded bg-green-300 px-3 py-3 font-bold text-green-800 sm:w-3/4">Berhasil menambah data</div>
        @endif
        <input type="hidden" id="list_travel" name="list_travel" value="{{ json_encode($travel) }}">
        <div class="h-fit w-full rounded-lg bg-white px-4 py-2 shadow-xl sm:w-3/4">
            <span class="mb-2 block w-full border-b-2 py-2 text-center text-2xl font-bold text-sekunder">Data Travel</span>
            <form action="{{ route('survey.store_travel') }}" method="post" class="my-4 flex flex-col gap-4"
                x-data="{ search: false }">
                @csrf
                <input type="hidden" name="telp" value="{{ $user->telp ?? '' }}">
                <input type="hidden" name="cluster" value="{{ $user->cluster ?? '' }}">
                <label for="nama_travel" class="">Nama Travel
                    <input class="form-input w-full rounded-md focus:border-indigo-600" type="text" name="nama_travel"
                        id="nama_travel" placeholder="Masukkan Nama Travel" value="{{ old('nama_travel') }}" required>
                    <span x-on:click="search=true"
                        class="mt-1 inline-block cursor-pointer text-sm text-sekunder underline transition-all hover:text-black"><i
                            class="fa-solid fa-magnifying-glass mr-1 text-sm text-sekunder"></i>Cari Travel</span>
                </label>
                <label for="periode">Periode Keberangkatan
                    <input class="form-input w-full rounded-md focus:border-indigo-600" type="date" name="periode"
                        id="periode" placeholder="Periode Keberangkatan" value="{{ old('periode') }}" required>
                </label>
                <label for="jlh_jemaah">Jumlah Jemaah
                    <input class="form-input w-full rounded-md focus:border-indigo-600" type="number" name="jlh_jemaah"
                        id="jlh_jemaah" placeholder="Jumlah Jemaah" value="{{ old('jlh_jemaah') }}" required>
                </label>
                <label for="city">Kabupaten
                    <select name="city" id="city" class="form-input w-full rounded-md focus:border-indigo-600">
                        <option value="" selected disabled>Pilih Kabupaten</option>
                        @foreach ($city as $item)
                            <option value="{{ $item->city }}">{{ $item->city }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="kecamatan">Kecamatan
                    <select name="kecamatan" id="kecamatan" class="form-input w-full rounded-md focus:border-indigo-600">
                        <option value="" selected disabled>Pilih Kecamatan</option>
                    </select>
                </label>
                <button type="submit" id="btn-submit"
                    class="my-4 w-full rounded bg-sekunder px-6 py-2 font-semibold text-white">Submit</button>
                <div class="fixed inset-0 z-20 flex h-full w-full items-center justify-center overflow-auto bg-black/80"
                    style="display:none;" id="search" x-show="search" x-transition>
                    <i class="fa-solid fa-xmark absolute right-10 top-5 z-10 cursor-pointer text-3xl text-white transition hover:text-premier"
                        x-on:click="search=false"></i>
                    <div class="mx-4 flex w-full flex-col overflow-hidden rounded-lg bg-white sm:w-1/2">
                        <span class="mb-4 inline-block w-full bg-premier p-4 text-center text-lg font-bold text-white">Cari
                            Travel</span>
                        <div class="flex w-full justify-center">
                            <input type="text" class="rounded-l" name="travel" id="travel"
                                placeholder="Ketik Nama Travel" class="mb-4" autofocus>
                            <div id="submit-search"
                                class="rounded-r bg-sekunder p-3 font-bold text-white hover:bg-slate-900">
                                Cari
                            </div>
                        </div>
                        <img src="{{ asset('images/loading.svg') }}" alt="Loading" id="loading"
                            class="mx-auto mt-6 h-24 w-24" style="display: none">
                        <div class="mt-2 flex h-64 w-full flex-col overflow-auto py-2" id="travel-list">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#loading').hide();
            const travels = JSON.parse($("#list_travel").val())
            console.log('travels', travels)

            $('#submit-search').on('click', function() {
                $("#travel-list").html()
                $('#loading').show();
                findTravel();
            })

            $("#city").on('input', () => {
                var kabupaten = $("#city").val();
                $.ajax({
                    url: "{{ route('sekolah.get_kecamatan') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        kabupaten: kabupaten,
                        _token: "{{ csrf_token() }}"
                    }

                    ,
                    success: (data) => {
                        console.log(data)
                        $("#kecamatan").html(
                            `<option value="" selected disabled>Pilih Kecamatan</option> ` +
                            data.map((item) => {
                                return `
                            <option value="${item.kecamatan}">${item.kecamatan}</option>
                            `
                            })
                        )
                    },
                    error: (e) => {
                        console.log(e)
                    }
                })
            })
            const findTravel = () => {
                if (travels.length > 0) {
                    $('#travel-list').html(
                        travels.map((data) => {
                            return `
                            <div class="flex flex-col p-4 transition border-b-2 cursor-pointer travel-item hover:bg-gray-500/50" nama_travel="${data.nama_travel}" x-on:click="search=false">
                                <span class="font-bold text-sekunder">${data.nama_travel}</span>
                            </div>
                        `
                        })
                    )
                    $('#loading').hide();
                    $('.travel-item').click(function() {
                        let nama_travel = $(this).attr('nama_travel');
                        // $('#search').hide();
                        $('#nama_travel').val(nama_travel);
                    })
                } else {
                    $('#loading').hide();
                    $('#travel-list').html("<p class=text-center italic>Tidak ada data travel</p>")
                }
            }
        });
    </script>
@endsection
