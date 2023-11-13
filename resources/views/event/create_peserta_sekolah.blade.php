@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="my-4 text-xl font-bold text-gray-600 align-baseline">Upload Peserta Event</h4>

                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                    @if (session('success'))
                        <span class="inline-block p-2 font-semibold text-green-600 bg-green-300 rounded">Berhasil Upload Data
                            Peserta</span>
                    @endif
                    <form action="{{ route('event.store_peserta_sekolah') }}" method="POST" class="">
                        @csrf
                        <div class="grid grid-cols-1 gap-3 mt-4 sm:grid-cols-3">
                            <div class="w-full">
                                <label class="block text-gray-700" for="ds">DS</label>
                                <select name="telp_ds" id="ds" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih DS</option>
                                    @foreach ($ds as $item)
                                        <option value="{{ $item->telp }}"
                                            {{ old('ds') == $item->telp ? 'selected' : '' }}>
                                            {{ $item->nama }}||{{ $item->telp }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ds')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="npsn">NPSN</label>
                                <input id="npsn" class="w-full rounded-md form-input focus:border-indigo-600"
                                    type="number" name="npsn" placeholder="NPSN" value="{{ old('npsn') }}">
                                <span id="btn-search"
                                    class="inline-block mt-1 text-sm underline transition-all cursor-pointer text-sekunder hover:text-black"><i
                                        class="mr-1 text-sm fa-solid fa-magnifying-glass text-sekunder"></i>Cari
                                    Sekolah</span>
                                @error('npsn')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="nama_peserta">Nama Peserta</label>
                                <input id="nama_peserta" class="w-full rounded-md form-input focus:border-indigo-600"
                                    type="text" name="nama_peserta" placeholder="NAMA PESERTA"
                                    value="{{ old('nama_peserta') }}">
                                @error('nama_peserta')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="telp_peserta">Telepon Peserta</label>
                                <input id="telp_peserta" class="w-full rounded-md form-input focus:border-indigo-600"
                                    type="number" name="telp_peserta" placeholder="081234xxxx"
                                    value="{{ old('telp_peserta') }}">
                                @error('telp_peserta')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="no_akuisisi_byu">Nomor Akuisisi ByU</label>
                                <input id="no_akuisisi_byu" class="w-full rounded-md form-input focus:border-indigo-600"
                                    type="number" name="no_akuisisi_byu" placeholder="081234xxxx"
                                    value="{{ old('no_akuisisi_byu') }}">
                                @error('no_akuisisi_byu')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button
                                class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:outline-none focus:bg-y_sekunder">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="fixed inset-0 z-20 flex items-center justify-center w-full h-full overflow-auto bg-black/80"
        style="display:none;" id="search" x-transition>
        <i class="absolute z-10 text-3xl text-white transition cursor-pointer fa-solid fa-xmark top-5 right-10 hover:text-y_premier"
            id="close-search" x-on:click="search=false"></i>
        <div class="flex flex-col w-full mx-4 overflow-hidden bg-white rounded-lg sm:w-1/2">
            <span class="inline-block w-full p-4 mb-4 text-lg font-bold text-center text-white bg-y_premier">Cari
                Sekolah</span>
            <input type="text" class="mx-4 rounded" name="sekolah" id="sekolah" placeholder="Ketik Nama Sekolah"
                class="mb-4" autofocus>
            <img src="{{ asset('images/loading.svg') }}" alt="Loading" id="loading" class="w-24 h-24 mx-auto mt-6"
                style="display: none">
            <div class="flex flex-col w-full h-64 py-2 mt-2 overflow-auto" id="school-list">
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#sekolah').on('input', function() {
                $('#loading').show();
                findSchool();
            })
            $("#btn-search").click(function() {
                $('#search').show()
            })
            $("#close-search").click(function() {
                $('#search').hide()
            })
            const findSchool = () => {
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ URL::to('/find_school') }}",
                    method: "GET",
                    dataType: "JSON",
                    data: {
                        name: $('#sekolah').val(),
                        _token: _token
                    },
                    success: (data) => {
                        $('#school-list').html(
                            data.map((data) => {
                                return `
                                <div class="flex flex-col p-4 transition border-b-2 cursor-pointer school-item hover:bg-gray-500/50" npsn="${data.NPSN}" x-on:click="search=false">
                                    <span class="font-bold text-sekunder">${data.NAMA_SEKOLAH}</span>
                                    <span class="font-semibold text-tersier">${data.NPSN}</span>
                                </div>
                                `
                            })
                        )
                        $('#loading').hide();
                        $('.school-item').click(function() {
                            let npsn = $(this).attr('npsn');
                            $('#search').hide();
                            $('#npsn').val(npsn);
                        })
                    },
                    error: (e) => {
                        console.log('error', e);
                    }
                })
            }
        })
    </script>
@endsection
