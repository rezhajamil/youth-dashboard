@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data POI</h4>

                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow w-fit sm:mx-0">
                    <form action="{{ route('location.poi.store') }}" method="POST" class="">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div class="grid grid-cols-5 col-span-full gap-x-3">
                                <div class="w-full">
                                    <label class="block text-gray-700" for="regional">Regional</label>
                                    <select name="regional" id="regional" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Region</option>
                                        @foreach ($region as $item)
                                            <option value="{{ $item->regional }}"
                                                {{ old('regional') == $item->regional ? 'selected' : '' }}>
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
                                        <option value="" selected disabled>Pilih Branch</option>
                                    </select>
                                    @error('branch')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="w-full">
                                <label class="block text-gray-700" for="sub_branch">Sub Branch</label>
                                <select name="sub_branch" id="sub_branch" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Sub Branch</option>
                                </select>
                                @error('sub_branch')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div> --}}
                                <div class="w-full">
                                    <label class="block text-gray-700" for="cluster">Cluster</label>
                                    <select name="cluster" id="cluster" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Cluster</option>
                                    </select>
                                    @error('cluster')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="kabupaten">Kabupaten</label>
                                    <select name="kabupaten" id="kabupaten" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Kabupaten</option>
                                    </select>
                                    @error('kabupaten')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="kecamatan">Kecamatan</label>
                                    <select name="kecamatan" id="kecamatan" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Kecamatan</option>
                                    </select>
                                    @error('kecamatan')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 col-span-full gap-x-3">
                                <div class="w-full">
                                    <label class="block text-gray-700" for="location">Location</label>
                                    <select name="location" id="location" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Location</option>
                                        @foreach ($location as $item)
                                            <option value="{{ $item->name }}"
                                                {{ old('location') == $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('location')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="keterangan_poi">Keterangan POI</label>
                                    <select name="keterangan_poi" id="keterangan_poi" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Keterangan POI</option>
                                        @foreach ($keterangan as $item)
                                            <option value="{{ $item->name }}"
                                                {{ old('keterangan_poi') == $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('keterangan_poi')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="jenis_poi">Jenis POI</label>
                                    <select name="jenis_poi" id="jenis_poi" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Jenis POI</option>
                                        <option value="Event">Event</option>
                                        <option value="Sekolah">Sekolah</option>
                                        <option value="TRADE IN SBS">TRADE IN SBS</option>
                                        {{-- <option value="Orbit">Orbit</option> --}}
                                        {{-- @foreach ($jenis as $item)
                                    <option value="{{ $item->jenis_poi }}" {{ old('jenis_poi')==$item->jenis_poi?'selected':'' }}>
                                        {{ $item->jenis_poi }}
                                    </option>
                                    @endforeach --}}
                                    </select>
                                    @error('jenis_poi')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 col-span-full gap-x-3">
                                <div>
                                    <label class="text-gray-700" for="name">Nama POI</label>
                                    <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                        name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-gray-700" for="latitude">Latitude</label>
                                    <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                        name="latitude" value="{{ old('latitude') }}">
                                    @error('latitude')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-gray-700" for="longitude">Longitude</label>
                                    <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                        name="longitude" value="{{ old('longitude') }}">
                                    @error('longitude')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex justify-end mt-4 col-span-full">
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
                            "<option disabled selected>Pilih Branch</option>" +
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
                        console.log(data)
                        $("#cluster").html(
                            "<option disabled selected>Pilih Sub Branch</option>" +
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

            $("#sub_branch").on('input', () => {
                var sub_branch = $("#sub_branch").val();
                console.log(sub_branch)
                $.ajax({
                    url: "{{ route('wilayah.get_cluster') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        sub_branch: sub_branch,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#cluster").html(
                            "<option disabled selected>Pilih Cluster</option>" +
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
                    url: "{{ route('wilayah.get_kabupaten') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        cluster: cluster,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#kabupaten").html(
                            "<option disabled selected>Pilih Kabupaten</option>" +
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

            $("#kabupaten").on('input', () => {
                var kabupaten = $("#kabupaten").val();
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
