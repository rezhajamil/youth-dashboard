@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Edit Data Sekolah</h4>
                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                    <span class="inline-block mb-2 font-bold">{{ $sekolah->NAMA_SEKOLAH }}</span>
                    <form action="{{ route('sekolah.update', $sekolah->NPSN) }}" method="POST" class="">
                        @csrf
                        @method('put')
                        <input type="hidden" name="url" value="{{ Request::url() }}">
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div class="w-full">
                                <label class="text-gray-700" for="latitude">Latitude</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="latitude" value="{{ old('latitude', $sekolah->LATITUDE) }}">
                                @error('latitude')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="longitude">Longitude</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="longitude" value="{{ old('longitude', $sekolah->LONGITUDE) }}">
                                @error('longitude')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="pjp">PJP</label>
                                <select name="pjp" id="pjp" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih PJP</option>
                                    <option value="PJP" {{ old('pjp', $sekolah->PJP) == 'PJP' ? 'selected' : '' }}>PJP
                                    </option>
                                    <option value="NON PJP" {{ old('pjp', $sekolah->PJP) == 'NON PJP' ? 'selected' : '' }}>
                                        NON PJP
                                    </option>
                                </select>
                                @error('pjp')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="frekuensi">Frekuensi Kunjungan</label>
                                <select name="frekuensi" id="frekuensi" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Frekuensi</option>
                                    <option value="F1"
                                        {{ old('frekuensi', $sekolah->FREKUENSI) == 'F1' ? 'selected' : '' }}>
                                        F1</option>
                                    <option value="F2"
                                        {{ old('frekuensi', $sekolah->FREKUENSI) == 'F2' ? 'selected' : '' }}>
                                        F2</option>
                                    <option value="F3"
                                        {{ old('frekuensi', $sekolah->FREKUENSI) == 'F3' ? 'selected' : '' }}>
                                        F3</option>
                                    <option value="F4"
                                        {{ old('frekuensi', $sekolah->FREKUENSI) == 'F4' ? 'selected' : '' }}>
                                        F4</option>
                                </select>
                                @error('frekuensi')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="telp">Telp</label>
                                <select name="telp" id="telp" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Telp</option>
                                    @foreach ($user as $data)
                                        <option value="{{ $data->telp }}"
                                            {{ old('telp', $sekolah->TELP) == $data->telp ? 'selected' : '' }}>
                                            {{ $data->nama }} | {{ $data->telp }}</option>
                                    @endforeach
                                </select>
                                @error('telp')
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
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Edit Data P1</h4>
                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                    <form action="{{ route('sekolah.update_favorit', $sekolah->NPSN) }}" method="POST" class="">
                        @csrf
                        @method('put')
                        <input type="hidden" name="url" value="{{ Request::url() }}">
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div class="w-full">
                                <label class="text-gray-700" for="nama_kepala_sekolah">Kepala Sekolah</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="nama_kepala_sekolah"
                                    value="{{ old('nama_kepala_sekolah', $sekolah->nama_kepala_sekolah) }}">
                                @error('nama_kepala_sekolah')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="nama_operator">Operator Sekolah</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="nama_operator" value="{{ old('nama_operator', $sekolah->nama_operator) }}">
                                @error('nama_operator')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="akses_internet">Akses Internet</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="akses_internet" value="{{ old('akses_internet', $sekolah->akses_internet) }}">
                                @error('akses_internet')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="sumber_listrik">Sumber Listrik</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="sumber_listrik" value="{{ old('sumber_listrik', $sekolah->sumber_listrik) }}">
                                @error('sumber_listrik')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="jlh_siswa_lk">Siswa Laki-Laki</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="jlh_siswa_lk" value="{{ old('jlh_siswa_lk', $sekolah->jlh_siswa_lk) }}">
                                @error('jlh_siswa_lk')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="jlh_siswa_pr">Siswa Perempuan</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="jlh_siswa_pr" value="{{ old('jlh_siswa_pr', $sekolah->jlh_siswa_pr) }}">
                                @error('jlh_siswa_pr')
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $("#kabupaten").on('input', () => {
                var kabupaten = $("#kabupaten").val();
                console.log(kabupaten)
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
                        $("#kecamatan").html(
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

            $("#branch").on('input', () => {
                var branch = $("#branch").val();
                console.log(branch)
                $.ajax({
                    url: "{{ route('wilayah.get_cluster') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        branch: branch,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        $("#cluster").html(
                            data.map((item) => {
                                return `
                    <option value="${item.cluster}">${item.cluster}</option>
                    `
                            })

                        )

                    },
                    error: (e) => {
                        console.log(e)
                    }
                })
            })

            $("#cluster").on('input', () => {
                var cluster = $("#cluster").val();
                console.log(cluster)
                $.ajax({
                    url: "{{ route('wilayah.get_tap') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        cluster: cluster,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#tap").html(
                            data.map((item) => {
                                return `
                    <option value="${item.nama}">${item.nama}</option>
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
