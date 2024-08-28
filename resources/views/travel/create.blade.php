@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Create Data Travel</h4>
                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow w-fit sm:mx-0">
                    <form action="{{ route('travel.store') }}" method="POST" class="" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
                            <div class="w-full">
                                <label class="text-gray-700" for="nama">Nama Travel</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="provinsi">Provinsi</label>
                                <select name="provinsi" id="provinsi" class="w-full rounded-md select2" style="">
                                    <option value="" selected disabled>Pilih Provinsi</option>
                                    @foreach ($province as $item)
                                        <option value="{{ $item->provinsi }}">{{ $item->provinsi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('provinsi')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="kota">Kota</label>
                                <select name="kota" id="kota" class="w-full rounded-md select2" style="">
                                    <option value="" selected disabled>Pilih Kota</option>
                                    @foreach ($city as $item)
                                        <option value="{{ $item->city }}">{{ $item->city }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kota')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="kecamatan">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="w-full rounded-md select2" style="">
                                    <option value="" selected disabled>Pilih Kecamatan</option>
                                    @foreach ($district as $item)
                                        <option value="{{ $item->kecamatan }}">{{ $item->kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kecamatan')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="cluster">Cluster</label>
                                <select name="cluster" id="cluster" class="w-full rounded-md select2" style="">
                                    <option value="" selected disabled>Pilih Cluster</option>
                                    @foreach ($cluster as $item)
                                        <option value="{{ $item->cluster }}">{{ $item->cluster }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cluster')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="sbp">SBP</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="sbp" value="{{ old('sbp') }}">
                                @error('sbp')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="direktur">Direktur</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="direktur" value="{{ old('direktur') }}">
                                @error('direktur')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="alamat">Alamat</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="alamat" value="{{ old('alamat') }}">
                                @error('alamat')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="email">Email</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="email"
                                    name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="current_status">Current Status</label>
                                <select name="current_status" id="current_status" class="w-full rounded-md">
                                    <option value="" selected>Pilih Current status</option>
                                    <option value="B2B" {{ old('current_status') == 'B2B' ? 'selected' : '' }}>
                                        B2B</option>
                                    <option value="B2B2C" {{ old('current_status') == 'B2B2C' ? 'selected' : '' }}>
                                        B2B2C</option>
                                </select>
                                @error('current_status')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="rs_digipos">No RS Digipos (62xxxx)</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="rs_digipos" value="{{ old('rs_digipos') }}">
                                @error('rs_digipos')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="id_digipos_travel_agent">ID Digipos Travel Agent</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="id_digipos_travel_agent" value="{{ old('id_digipos_travel_agent') }}">
                                @error('id_digipos_travel_agent')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="telp">Petugas</label>
                                <select name="telp" id="telp" class="w-full rounded-md select2" style="">
                                    <option value="" selected disabled>Pilih Petugas</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->telp }}">{{ $item->nama }} | {{ $item->telp }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('telp')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="latitude">Latitude</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    step="any" name="latitude" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="longitude">Longitude</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    step="any" name="longitude" value="{{ old('longitude') }}">
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

            $("#kota").on('input', () => {
                var kabupaten = $("#kota").val();
                console.log(kabupaten)
                $.ajax({
                    url: "{{ route('wilayah.get_kecamatan') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        kabupaten: kabupaten,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#kecamatan").html(
                            "<option disabled selected>Pilih Kecamatan</option>" +
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
        })
    </script>
@endsection
