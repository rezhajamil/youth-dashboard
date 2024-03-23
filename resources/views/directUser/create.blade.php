@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Tambah Data Direct User</h4>

                <div class="mx-auto w-fit overflow-auto rounded-md bg-white px-6 py-4 shadow sm:mx-0">
                    <form action="{{ route('direct_user.store') }}" method="POST" class="">
                        @csrf
                        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="col-span-full grid grid-cols-3 gap-x-3">
                                <div class="w-full">
                                    <label class="block text-gray-700" for="regional">Regional</label>
                                    <select name="regional" id="regional" class="w-full rounded-md">
                                        @if (auth()->user()->privilege == 'superadmin')
                                            <option value="" selected disabled>Pilih Region</option>
                                        @endif
                                        @foreach ($region as $item)
                                            <option value="{{ $item->regional }}"
                                                {{ old('regional') == $item->regional ? 'selected' : '' }}>
                                                {{ $item->regional }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('regional')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="branch">Branch</label>
                                    <select name="branch" id="branch" class="w-full rounded-md">
                                        @if (auth()->user()->privilege == 'superadmin')
                                            <option value="" selected disabled>Pilih Branch</option>
                                        @endif
                                        @foreach ($branch as $item)
                                            <option value="{{ $item->branch }}"
                                                {{ old('branch') == $item->branch ? 'selected' : '' }}>
                                                {{ $item->branch }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="cluster">Cluster</label>
                                    <select name="cluster" id="cluster" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Cluster</option>
                                        @foreach ($cluster as $item)
                                            <option value="{{ $item->cluster }}"
                                                {{ old('cluster') == $item->cluster ? 'selected' : '' }}>
                                                {{ $item->cluster }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cluster')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="city">Kota</label>
                                <select name="city" id="city" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Kota</option>
                                </select>
                                @error('city')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="kecamatan">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Kecamatan</option>
                                </select>
                                @error('kecamatan')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="tap">TAP</label>
                                <select name="tap" id="tap" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih TAP</option>
                                    @foreach ($tap as $item)
                                        <option value="{{ $item->nama }}"
                                            {{ old('tap') == $item->nama ? 'selected' : '' }}>
                                            {{ strtoupper($item->nama) }}</option>
                                    @endforeach
                                </select>
                                @error('tap')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="role">Role</label>
                                <select name="role" id="role" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Role</option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->user_type }}"
                                            {{ old('role') == $item->user_type ? 'selected' : '' }}>{{ $item->user_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="text-gray-700" for="nama">Nama Lengkap</label>
                                <input class="form-input w-full rounded-md focus:border-indigo-600" type="text"
                                    name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="text-gray-700" for="panggilan">Panggilan</label>
                                <input class="form-input w-full rounded-md focus:border-indigo-600" type="text"
                                    name="panggilan" value="{{ old('panggilan') }}">

                                @error('panggilan')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="kampus">Pendidikan</label>
                                <select name="kampus" id="kampus" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Pendidikan</option>
                                    <option value="SLTA" {{ old('kampus') == 'SLTA' ? 'selected' : '' }}>SLTA</option>
                                    <option value="D3" {{ old('kampus') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ old('kampus') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('kampus') == 'S2' ? 'selected' : '' }}>S2</option>
                                </select>
                                @error('kampus')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="tgl_lahir">Tanggal Lahir</label>
                                <input class="form-input w-full rounded-md focus:border-indigo-600" type="date"
                                    name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                                @error('tgl_lahir')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="col-span-full grid grid-cols-3 gap-x-3">
                                <div>
                                    <label class="text-gray-700" for="telp">Telepon</label>
                                    <input class="form-input w-full rounded-md focus:border-indigo-600" type="number"
                                        name="telp" placeholder="081234567890" value="{{ old('telp') }}">

                                    @error('telp')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div>
                                    <label class="text-gray-700" for="mkios">MKios</label>
                                    <input class="form-input w-full rounded-md focus:border-indigo-600" type="number"
                                        name="mkios" value="{{ old('mkios') }}">

                                    @error('mkios')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div>
                                    <label class="text-gray-700" for="id_digipos">ID Digipos</label>
                                    <input class="form-input w-full rounded-md focus:border-indigo-600" type="number"
                                        name="id_digipos" value="{{ old('id_digipos') }}">

                                    @error('id_digipos')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            <div>
                                <label class="text-gray-700" for="user_calista">User Calista</label>
                                <input class="form-input w-full rounded-md focus:border-indigo-600" type="text"
                                    name="user_calista" value="{{ old('user_calista') }}">

                                @error('user_calista')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="password">Password</label>
                                <input class="form-input w-full rounded-md focus:border-indigo-600" type="text"
                                    name="password" value="{{ old('password') }}">

                                @error('password')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="reff_byu">Reff Code BY.U</label>
                                <input class="form-input w-full rounded-md focus:border-indigo-600" type="text"
                                    name="reff_byu" value="{{ old('reff_byu') }}">

                                @error('reff_byu')
                                    <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="reff_code">Reff Code Orbit</label>
                                <input class="form-input w-full rounded-md focus:border-indigo-600" type="text"
                                    name="reff_code" value="{{ old('reff_code') }}">

                                @error('reff_code')
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $("#regional").on('input', () => {
                var regional = $("#regional").val();
                console.log(regional)
                $.ajax({
                    url: "{{ route('wilayah.get_branch') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        regional: regional,
                        _token: "{{ csrf_token() }}"
                    }

                    ,
                    success: (data) => {
                        $("#branch").html(
                            data.map((item) => {
                                return `
                            <option value="${item.branch}">${item.branch}</option>
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
                            `<option value="" selected disabled>Pilih Cluster</option>` +
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
                        $("#tap").html(`<option value="" selected disabled>Pilih TAP</option>` +
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

                $.ajax({
                    url: "{{ route('wilayah.get_kabupaten') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        cluster: cluster,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#city").html(
                            `<option value="" selected disabled>Pilih City</option>` +
                            data.map((item) => {
                                return `
                    <option value="${item.kabupaten}">${item.kabupaten}</option>
                    `
                            })

                        )

                    },
                    error: (e) => {
                        console.log(e)
                    }
                })
            })

            $("#city").on('input', () => {
                var kabupaten = $("#city").val();
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
                        $("#kecamatan").html(
                            `<option value="" selected disabled>Pilih Kecamatan</option>` +
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
