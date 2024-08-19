@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Create Data Keberangkatan</h4>
                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow w-fit sm:mx-0">
                    <form action="{{ route('travel.store_keberangkatan') }}" method="POST" class=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-4">
                            <div class="w-full">
                                <label class="block text-gray-700" for="id_travel">Travel</label>
                                <select name="id_travel" id="id_travel" class="w-full rounded-md select2" style="">
                                    <option value="" selected disabled>Pilih Travel</option>
                                    @foreach ($travels as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('id_travel')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="negara">Negara</label>
                                <select name="negara" id="negara" class="w-full rounded-md select2" style="">
                                    <option value="" selected disabled>Pilih Negara</option>
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->negara }}">{{ $item->negara }}</option>
                                    @endforeach
                                </select>
                                @error('negara')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="tgl">Tanggal</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="date"
                                    name="tgl" value="{{ old('tgl') }}">
                                @error('tgl')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="jumlah_jamaah">Jumlah Jamaah</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="jumlah_jamaah" value="{{ old('jumlah_jamaah') }}">
                                @error('jumlah_jamaah')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button
                        class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:bg-y_sekunder focus:outline-none">
                        Submit
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                // placeholder: 'Pilih Travel',
                allowClear: false
            });
        })
    </script>
@endsection
