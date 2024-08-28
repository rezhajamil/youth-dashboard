@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Edit Data Travel</h4>
                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow w-fit sm:mx-0">
                    <span class="inline-block mb-2 font-bold">{{ $travel->nama }}</span>
                    <form action="{{ route('travel.update', $travel->id) }}" method="POST" class=""
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
                            <div class="w-full">
                                <label class="block text-gray-700" for="current_status">Current Status</label>
                                <select name="current_status" id="current_status" class="w-full rounded-md">
                                    <option value="" selected>Pilih Current status</option>
                                    <option value="B2B"
                                        {{ old('current_status', $travel->current_status) == 'B2B' ? 'selected' : '' }}>
                                        B2B</option>
                                    <option value="B2B2C"
                                        {{ old('current_status', $travel->current_status) == 'B2B2C' ? 'selected' : '' }}>
                                        B2B2C</option>
                                </select>
                                @error('current_status')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="rs_digipos">No RS Digipos (62xxxx)</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="rs_digipos" value="{{ old('rs_digipos', $travel->rs_digipos) }}">
                                @error('rs_digipos')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="id_digipos_travel_agent">ID Digipos Travel Agent</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="id_digipos_travel_agent"
                                    value="{{ old('id_digipos_travel_agent', $travel->id_digipos_travel_agent) }}">
                                @error('id_digipos_travel_agent')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="telp_ds">Petugas</label>
                                <select name="telp_ds" id="telp_ds" class="w-full rounded-md select2" style="">
                                    <option value="" selected disabled>Pilih Petugas</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->telp }}">{{ $item->nama }} | {{ $item->telp }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('telp_ds')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="latitude">Latitude</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    step="any" name="latitude" value="{{ old('latitude', $travel->latitude) }}">
                                @error('latitude')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="longitude">Longitude</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    step="any" name="longitude" value="{{ old('longitude', $travel->longitude) }}">
                                @error('longitude')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="foto_travel">Foto Travel</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="file"
                                    accept=".jpg,.png,.jpeg" name="foto_travel">
                                @error('foto_travel')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="foto_bak">Foto BAK</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="file"
                                    accept=".jpg,.png,.jpeg" name="foto_bak">
                                @error('foto_bak')
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
