@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Edit Data Direct User</h4>

                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow w-fit sm:mx-0">
                    <form action="{{ route('direct_user.update', $user->id) }}" method="POST" class="">
                        @csrf
                        @method('put')
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div class="grid grid-cols-3 col-span-full gap-x-3">
                                <div class="w-full">
                                    <label class="block text-gray-700" for="regional">Regional</label>
                                    <select name="regional" id="regional" class="w-full rounded-md">
                                        @if (auth()->user()->privilege == 'superadmin')
                                            <option value="" selected disabled>Pilih Region</option>
                                        @endif
                                        @foreach ($region as $item)
                                            <option value="{{ $item->regional }}"
                                                {{ old('regional', $user->regional) == $item->regional ? 'selected' : '' }}>
                                                {{ $item->regional }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('regional')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
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
                                                {{ old('branch', $user->branch) == $item->branch ? 'selected' : '' }}>
                                                {{ $item->branch }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="cluster">Cluster</label>
                                    <select name="cluster" id="cluster" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Cluster</option>
                                        @foreach ($cluster as $item)
                                            <option value="{{ $item->cluster }}"
                                                {{ old('cluster', $user->cluster) == $item->cluster ? 'selected' : '' }}>
                                                {{ $item->cluster }}</option>
                                        @endforeach
                                    </select>
                                    @error('cluster')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="city">Kota</label>
                                <select name="city" id="city" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Kota</option>
                                    @foreach ($city as $item)
                                        <option value="{{ $item->city }}"
                                            {{ old('city', $user->city) == $item->city ? 'selected' : '' }}>
                                            {{ $item->city }}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="kecamatan">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Kecamatan</option>
                                    @foreach ($kecamatan as $item)
                                        <option value="{{ $item->kecamatan }}"
                                            {{ old('kecamatan', $user->kecamatan) == $item->kecamatan ? 'selected' : '' }}>
                                            {{ $item->kecamatan }}</option>
                                    @endforeach
                                </select>
                                @error('kecamatan')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="tap">TAP</label>
                                <select name="tap" id="tap" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih TAP</option>
                                    @foreach ($tap as $item)
                                        <option value="{{ $item->nama }}"
                                            {{ old('tap', $user->tap) == $item->nama ? 'selected' : '' }}>
                                            {{ strtoupper($item->nama) }}</option>
                                    @endforeach
                                </select>
                                @error('tap')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="role">Role</label>
                                <select name="role" id="role" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Role</option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->user_type }}"
                                            {{ old('role', $user->role) == $item->user_type ? 'selected' : '' }}>
                                            {{ $item->user_type }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="text-gray-700" for="nama">Nama Lengkap</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="nama" value="{{ old('nama', $user->nama) }}">
                                @error('nama')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="text-gray-700" for="panggilan">Panggilan</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="panggilan" value="{{ old('panggilan', $user->panggilan) }}">

                                @error('panggilan')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="kampus">Pendidikan</label>
                                <select name="kampus" id="kampus" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Pendidikan</option>
                                    <option value="SLTA" {{ old('kampus', $user->kampus) == 'SLTA' ? 'selected' : '' }}>
                                        SLTA
                                    </option>
                                    <option value="D3" {{ old('kampus', $user->kampus) == 'D3' ? 'selected' : '' }}>D3
                                    </option>
                                    <option value="S1" {{ old('kampus', $user->kampus) == 'S1' ? 'selected' : '' }}>S1
                                    </option>
                                    <option value="S2" {{ old('kampus', $user->kampus) == 'S2' ? 'selected' : '' }}>S2
                                    </option>
                                </select>
                                @error('kampus')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="tgl_lahir">Tanggal Lahir</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="date"
                                    name="tgl_lahir" value="{{ old('tgl_lahir', $user->tgl_lahir) }}">
                                @error('tgl_lahir')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="telp">Telepon</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="telp" value="{{ old('telp', $user->telp) }}">

                                @error('telp')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>
                            <div>
                                <label class="text-gray-700" for="mkios">MKios</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="mkios" value="{{ old('mkios', $user->mkios) }}">

                                @error('mkios')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>
                            <div>
                                <label class="text-gray-700" for="link_aja">LinkAja</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="link_aja" value="{{ old('link_aja', $user->link_aja) }}">

                                @error('link_aja')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>
                            <div>
                                <label class="text-gray-700" for="id_digipos">ID Digipos</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="id_digipos" value="{{ old('id_digipos', $user->id_digipos) }}">

                                @error('id_digipos')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            {{-- <div class="grid grid-cols-3 gap-x-3 col-span-full">
                        </div> --}}

                            <div>
                                <label class="text-gray-700" for="user_calista">User Calista</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="user_calista" value="{{ old('user_calista', $user->user_calista) }}">

                                @error('user_calista')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="password">Password</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="password" value="{{ old('password', $user->password) }}">

                                @error('password')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="reff_byu">Reff Code BY.U</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="reff_byu" value="{{ old('reff_byu', $user->reff_byu) }}">

                                @error('reff_byu')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <label class="text-gray-700" for="reff_code">Reff Code Orbit</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                    name="reff_code" value="{{ old('reff_code', $user->reff_code) }}">

                                @error('reff_code')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror

                            </div>


                        </div>

                        <div class="flex justify-end mt-4">
                            <button
                                class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:bg-y_sekunder focus:outline-none">Submit</button>
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
                getRegional()
            })

            $("#branch").on('input', () => {
                getBranch()
            })

            $("#cluster").on('input', () => {
                getTap()
                getKabupaten()
            })

            $("#city").on('input', () => {
                getKecamatan()
            })

            function getRegional() {
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
                            `<option value="" selected disabled>Pilih Branch</option>` +
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
            }

            function getBranch() {
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
                        `<option value="" selected disabled>Pilih Cluster</option>` +
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
            }

            function getTap() {
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
            }

            function getKabupaten() {
                var cluster = $("#cluster").val();
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
            }

            function getKecamatan() {
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
            }
        })
    </script>
@endsection
