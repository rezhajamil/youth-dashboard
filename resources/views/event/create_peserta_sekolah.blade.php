@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="my-4 align-baseline text-xl font-bold text-gray-600">Upload Peserta Event</h4>

                <div class="mx-auto w-fit overflow-auto rounded-md bg-white px-6 py-4 shadow sm:mx-0">
                    {{-- {{ ddd(session('error')) }} --}}
                    @if (session('error'))
                        <span
                            class="inline-block rounded bg-red-300 p-2 font-semibold text-red-600">{{ session('error') }}</span>
                    @endif
                    @if (session('success'))
                        <span
                            class="inline-block rounded bg-green-300 p-2 font-semibold text-green-600">{{ session('success') }}</span>
                    @endif
                    <form action="{{ route('event.store_peserta_sekolah') }}" method="POST" class=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                            <div class="w-full">
                                <label class="block text-gray-700" for="ds">DS</label>
                                <select name="telp_ds" id="ds" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih DS</option>
                                    @foreach ($ds as $item)
                                        <option value="{{ $item->telp }}"
                                            {{ old('telp_ds') == $item->telp ? 'selected' : '' }}>
                                            {{ $item->nama }}||{{ $item->telp }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('telp_ds')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="npsn">NPSN</label>
                                <input id="npsn" class="form-input w-full rounded-md focus:border-indigo-600"
                                    type="number" name="npsn" placeholder="NPSN" value="{{ old('npsn') }}">
                                <span id="btn-search"
                                    class="mt-1 inline-block cursor-pointer text-sm text-sekunder underline transition-all hover:text-black"><i
                                        class="fa-solid fa-magnifying-glass mr-1 text-sm text-sekunder"></i>Cari
                                    Sekolah</span>
                                @error('npsn')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div>
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
                            </div> --}}
                            <div class="col-span-full">
                                <label class="text-gray-700" for="file">CSV Data Peserta
                                    (nomor_akuisisi_byu)</label>
                                <input id="file" class="form-input w-full rounded-md focus:border-indigo-600"
                                    type="file" name="file" value="{{ old('file') }}">
                                @error('file')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button
                                class="w-full rounded-md bg-y_premier px-4 py-2 font-bold text-white hover:bg-y_sekunder focus:bg-y_sekunder focus:outline-none">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="fixed inset-0 z-20 flex h-full w-full items-center justify-center overflow-auto bg-black/80"
        style="display:none;" id="search" x-transition>
        <i class="fa-solid fa-xmark absolute right-10 top-5 z-10 cursor-pointer text-3xl text-white transition hover:text-y_premier"
            id="close-search" x-on:click="search=false"></i>
        <div class="mx-4 flex w-full flex-col overflow-hidden rounded-lg bg-white sm:w-1/2">
            <span class="mb-4 inline-block w-full bg-y_premier p-4 text-center text-lg font-bold text-white">Cari
                Sekolah</span>
            <input type="text" class="mx-4 rounded" name="sekolah" id="sekolah" placeholder="Ketik Nama Sekolah"
                class="mb-4" autofocus>
            <img src="{{ asset('images/loading.svg') }}" alt="Loading" id="loading" class="mx-auto mt-6 h-24 w-24"
                style="display: none">
            <div class="mt-2 flex h-64 w-full flex-col overflow-auto py-2" id="school-list">
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#sekolah').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#loading').show();
                    findSchool();
                }
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
                        console.log(data);
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
