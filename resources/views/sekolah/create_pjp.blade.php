@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data PJP</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit" x-data="{search:false}">
                <form action="{{ route('sekolah.pjp.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div class="grid grid-cols-3 gap-x-3 col-span-full gap-y-4">
                            <div>
                                <label class="text-gray-700" for="npsn">NPSN</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" id="npsn" type="text" name="npsn" value="{{ old('npsn') }}" placeholder="NPSN">
                                <span class="inline-block mt-1 text-sm underline transition-all cursor-pointer text-sekunder hover:text-black" x-on:click="search=true"><i class="mr-1 text-sm fa-solid fa-magnifying-glass text-sekunder"></i>Cari Sekolah</span>
                                @error('npsn')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="date">Tanggal</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="date" name="date" value="{{ old('date') }}">
                                @error('date')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="time">Waktu</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="time" name="time" value="{{ old('time') }}">
                                @error('time')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="telp">Telp</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number" name="telp" value="{{ old('telp') }}" placeholder="6281234567890">
                                @error('telp')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700" for="frekuensi">Frekuensi</label>
                                <select name="frekuensi" id="frekuensi" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Frekuensi</option>
                                    <option value="F1">F1</option>
                                    <option value="F2">F2</option>
                                    <option value="F3">F3</option>
                                    <option value="F4">F4</option>
                                </select>
                                @error('frekuensi')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700" for="activity">Activity</label>
                                <select name="activity" id="activity" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Activity</option>
                                    <option value="Kunjungan Biasa">Kunjungan Biasa</option>
                                    <option value="Event">Event</option>
                                    <option value="Check Market Share">Check Market Share</option>
                                    <option value="Selling">Selling</option>
                                </select>
                                @error('activity')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-4 col-span-full">
                            <button class="w-full px-4 py-2 font-bold text-white bg-indigo-800 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="fixed inset-0 z-20 flex items-center justify-center w-full h-full overflow-auto bg-black/80" style="display:none;" id="search" x-show="search" x-transition>
                    <i class="absolute z-10 text-3xl text-white transition cursor-pointer fa-solid fa-xmark top-5 right-10 hover:text-premier" x-on:click="search=false"></i>
                    <div class="flex flex-col w-full mx-4 overflow-hidden bg-white rounded-lg sm:w-1/2">
                        <span class="inline-block w-full p-4 mb-4 text-lg font-bold text-center text-white bg-premier">Cari Sekolah</span>
                        <input type="text" class="mx-4 rounded" name="sekolah" id="sekolah" placeholder="Ketik Nama Sekolah" class="mb-4" autofocus>
                        <img src="{{ asset('images/loading.svg') }}" alt="Loading" id="loading" class="w-24 h-24 mx-auto mt-6">
                        <div class="flex flex-col w-full h-64 py-2 mt-2 overflow-auto" id="school-list">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#loading').hide();

        $('#sekolah').on('input', function() {
            $('#loading').show();
            findSchool();
        })

        const findSchool = () => {
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ URL::to('/find_school') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    name: $('#sekolah').val()
                    , _token: _token
                }
                , success: (data) => {
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
                        // $('#search').hide();
                        $('#npsn').val(npsn);
                    })

                }
                , error: (e) => {
                    console.log('error', e);
                }
            })
        }
    })

</script>
@endsection
