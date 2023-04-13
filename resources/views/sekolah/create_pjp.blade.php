@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="flex gap-x-3">
                <span class="text-xl font-bold align-baseline">Jenis Kunjungan : </span>
                <select name="jenis" id="jenis" class="p-0 pr-8 text-xl font-bold underline bg-transparent border-0">
                    <option value="sekolah" selected disabled class="text-gray-600">Pilih Jenis Kunjungan</option>
                    <option value="sekolah">Sekolah</option>
                    <option value="event">Event</option>
                    <option value="u60">U60</option>
                    <option value="orbit">Orbit</option>
                    <option value="outlet">Outlet</option>
                </select>
            </div>

            <div class="grid mt-4 gap-y-12" id="container">
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

            $(document).on("click", "#search", function() {
                $("#search-container").show();
                console.log('qq')
            })

            $("#search-close").click(function() {
                $("#search-container").hide();
            })

            $("#jenis").on('change', function() {
                $("#container").html('');

                if ($(this).val() == 'sekolah') {
                    $("#container").html(`<div class="" x-data="{search:false}">
                        <h4 class="text-xl font-bold text-gray-600 align-baseline">Kunjungan Sekolah</h4>
                        <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                            <form action="{{ route('sekolah.pjp.store') }}" method="POST" class="">
                                @csrf
                                <input type="hidden" name="kategori" value="sekolah">
                                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                    <div class="grid grid-cols-3 gap-x-3 col-span-full gap-y-4">
                                        <div>
                                            <label class="block text-gray-700" for="cluster">Cluster</label>
                                            <select name="cluster" id="cluster" class="w-full rounded-md cluster">
                                                <option value="" selected disabled>Pilih Cluster</option>
                                                @foreach ($cluster as $item)
                                                    <option value="{{ $item->cluster }}">{{ $item->cluster }}</option>
                                                @endforeach
                                            </select>
                                            @error('cluster')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="npsn">NPSN</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600 npsn" id="npsn" type="text" name="npsn" value="{{ old('npsn') }}" placeholder="NPSN" required>
                                            <span class="inline-block mt-1 text-sm underline transition-all cursor-pointer text-sekunder hover:text-black" id="search"  x-on:click="search=true"><i class="mr-1 text-sm fa-solid fa-magnifying-glass text-sekunder"></i>Cari Sekolah</span>
                                            @error('npsn')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="telp">Direct Sales</label>
                                            <select name="telp" id="telp" class="w-full rounded-md telp" required>
                                                <option value="" selected disabled>Pilih Direct Sales</option>
                                            </select>
                                            @error('telp')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="hari">Hari</label>
                                            <select name="hari" id="hari" class="w-full rounded-md" required>
                                                <option value="" selected disabled>Pilih Hari</option>
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                                <option value="Sabtu">Sabtu</option>
                                            </select>
                                            @error('hari')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="frekuensi">Frekuensi</label>
                                            <select name="frekuensi" id="frekuensi" class="w-full rounded-md" required>
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
                                    </div>
            
                                    <div class="flex justify-end mt-4 col-span-full">
                                        <button class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:outline-none focus:bg-y_sekunder">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>`);
                } else if ($(this).val() == 'event') {
                    $("#container").html(`<div class="" x-data="{search:false}">
                        <h4 class="text-xl font-bold text-gray-600 align-baseline">Kunjungan Event</h4>
                        <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit" x-data="{search:false}">
                            <form action="{{ route('sekolah.pjp.store') }}" method="POST" class="">
                                @csrf
                                <input type="hidden" name="kategori" value="event">
                                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                    <div class="grid grid-cols-3 gap-x-3 col-span-full gap-y-4">
                                        <div>
                                            <label class="block text-gray-700" for="cluster">Cluster</label>
                                            <select name="cluster" id="cluster" class="w-full rounded-md cluster">
                                                <option value="" selected disabled>Pilih Cluster</option>
                                                @foreach ($cluster as $item)
                                                    <option value="{{ $item->cluster }}">{{ $item->cluster }}</option>
                                                @endforeach
                                            </select>
                                            @error('cluster')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="telp">Direct Sales</label>
                                            <select name="telp" id="telp" class="w-full rounded-md telp" required>
                                                <option value="" selected disabled>Pilih Direct Sales</option>
                                            </select>
                                            @error('telp')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="poi">POI</label>
                                            <select name="poi" id="poi" class="w-full rounded-md poi" required>
                                                <option value="" selected disabled>Pilih POI</option>
                                            </select>
                                            @error('poi')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="event">Nama Event</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="event" placeholder="Nama Event" value="{{ old('event') }}" required>
                                            @error('event')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="date">Tanggal Kunjungan</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="date" name="date" value="{{ old('date') }}">
                                            @error('date')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="date_start">Tanggal Mulai</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="date" name="date_start" value="{{ old('date_start') }}">
                                            @error('date_start')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="date_end">Tanggal Selesai</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="date" name="date_end" value="{{ old('date_end') }}">
                                            @error('date_end')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- <div>
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
                                        </div> --}}
                                    </div>
            
                                    <div class="flex justify-end mt-4 col-span-full">
                                        <button class="w-full px-4 py-2 font-bold text-white bg-orange-800 rounded-md hover:bg-orange-700 focus:outline-none focus:bg-orange-700">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>`);
                } else if ($(this).val() == 'u60') {
                    $("#container").html(`<div class="" x-data="{search:false}">
                        <h4 class="text-xl font-bold text-gray-600 align-baseline">Kunjungan U60</h4>
                        <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit" x-data="{search:false}">
                            <form action="{{ route('sekolah.pjp.store') }}" method="POST" class="">
                                @csrf
                                <input type="hidden" name="kategori" value="u60">
                                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                    <div class="grid grid-cols-3 gap-x-3 col-span-full gap-y-4">
                                        <div>
                                            <label class="block text-gray-700" for="cluster">Cluster</label>
                                            <select name="cluster" id="cluster" class="w-full rounded-md cluster">
                                                <option value="" selected disabled>Pilih Cluster</option>
                                                @foreach ($cluster as $item)
                                                    <option value="{{ $item->cluster }}">{{ $item->cluster }}</option>
                                                @endforeach
                                            </select>
                                            @error('cluster')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="telp">Direct Sales</label>
                                            <select name="telp" id="telp" class="w-full rounded-md telp" required>
                                                <option value="" selected disabled>Pilih Direct Sales</option>
                                            </select>
                                            @error('telp')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="site_id">SITE ID</label>
                                            <select name="site_id" id="site_id" class="w-full rounded-md site-id" required>
                                                <option value="" selected disabled>Pilih SITE ID</option>
                                            </select>
                                            @error('site_id')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="date">Tanggal Kunjungan</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="date" name="date" value="{{ old('date') }}">
                                            @error('date')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="keterangan">Keterangan</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="keterangan" placeholder="Keterangan" value="{{ old('keterangan') }}">
                                            @error('keterangan')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="flex justify-end mt-4 col-span-full">
                                        <button class="w-full px-4 py-2 font-bold text-white bg-orange-800 rounded-md hover:bg-orange-700 focus:outline-none focus:bg-orange-700">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>`);
                } else if ($(this).val() == 'orbit') {
                    $("#container").html(`<div class="" x-data="{search:false}">
                        <h4 class="text-xl font-bold text-gray-600 align-baseline">Kunjungan Orbit</h4>
                        <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit" x-data="{search:false}">
                            <form action="{{ route('sekolah.pjp.store') }}" method="POST" class="">
                                @csrf
                                <input type="hidden" name="kategori" value="orbit">
                                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                    <div class="grid grid-cols-3 gap-x-3 col-span-full gap-y-4">
                                        <div>
                                            <label class="block text-gray-700" for="cluster">Cluster</label>
                                            <select name="cluster" id="cluster" class="w-full rounded-md cluster">
                                                <option value="" selected disabled>Pilih Cluster</option>
                                                @foreach ($cluster as $item)
                                                    <option value="{{ $item->cluster }}">{{ $item->cluster }}</option>
                                                @endforeach
                                            </select>
                                            @error('cluster')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="telp">Direct Sales</label>
                                            <select name="telp" id="telp" class="w-full rounded-md telp" required>
                                                <option value="" selected disabled>Pilih Direct Sales</option>
                                            </select>
                                            @error('telp')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="date">Tanggal Kunjungan</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="date" name="date" value="{{ old('date') }}">
                                            @error('date')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="poi">POI</label>
                                            <select name="poi" id="poi" class="w-full rounded-md poi" required>
                                                <option value="" selected disabled>Pilih POI</option>
                                            </select>
                                            @error('poi')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="lokasi">Nama Lokasi</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="lokasi" placeholder="Nama Lokasi" value="{{ old('lokasi') }}">
                                            @error('lokasi')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="keterangan">Keterangan</label>
                                            <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="keterangan" placeholder="Keterangan" value="{{ old('keterangan') }}">
                                            @error('keterangan')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="flex justify-end mt-4 col-span-full">
                                        <button class="w-full px-4 py-2 font-bold text-white bg-orange-800 rounded-md hover:bg-orange-700 focus:outline-none focus:bg-orange-700">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>`);
                } else if ($(this).val() == 'outlet') {
                    $("#container").html(`<div class="" x-data="{search:false}">
                        <h4 class="text-xl font-bold text-gray-600 align-baseline">Kunjungan Outlet</h4>
                        <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                            <form action="{{ route('sekolah.pjp.store') }}" method="POST" class="">
                                @csrf
                                <input type="hidden" name="kategori" value="outlet">
                                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                    <div class="grid grid-cols-3 gap-x-3 col-span-full gap-y-4">
                                        <div>
                                            <label class="block text-gray-700" for="cluster">Cluster</label>
                                            <select name="cluster" id="cluster" class="w-full rounded-md cluster">
                                                <option value="" selected disabled>Pilih Cluster</option>
                                                @foreach ($cluster as $item)
                                                    <option value="{{ $item->cluster }}">{{ $item->cluster }}</option>
                                                @endforeach
                                            </select>
                                            @error('cluster')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-gray-700" for="outlet">Outlet</label>
                                            <select name="outlet" id="outlet" class="w-full rounded-md outlet" required>
                                                <option value="" selected disabled>Pilih Outlet</option>
                                            </select>
                                            @error('outlet')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="telp">Direct Sales</label>
                                            <select name="telp" id="telp" class="w-full rounded-md telp" required>
                                                <option value="" selected disabled>Pilih Direct Sales</option>
                                            </select>
                                            @error('telp')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="hari">Hari</label>
                                            <select name="hari" id="hari" class="w-full rounded-md" required>
                                                <option value="" selected disabled>Pilih Hari</option>
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                                <option value="Sabtu">Sabtu</option>
                                            </select>
                                            @error('hari')
                                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700" for="frekuensi">Frekuensi</label>
                                            <select name="frekuensi" id="frekuensi" class="w-full rounded-md" required>
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
                                    </div>
            
                                    <div class="flex justify-end mt-4 col-span-full">
                                        <button class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:outline-none focus:bg-y_sekunder">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>`);
                }

                $(document).on('change', "#cluster", () => {
                    var cluster = $("#cluster").val();

                    $.ajax({
                        url: "{{ route('sekolah.pjp.user') }}",
                        method: "GET",
                        dataType: "JSON",
                        data: {
                            cluster: cluster,
                            _token: "{{ csrf_token() }}"
                        },
                        success: (data) => {
                            const {
                                users
                            } = data;

                            if (users.length) {
                                $("#telp").html(
                                    `<option value="" disabled selected>Pilih Direct Sales</option>` +
                                    users.map((item) => {
                                        return `
                                    <option value="${item.telp}">${item.nama.toString().toUpperCase()} | ${item.telp}</option>
                                    `
                                    })
                                )
                            } else {
                                $("#telp").html(
                                    `<option value="" disabled selected>Pilih Direct Sales</option>`
                                )
                            }

                        },
                        error: (e) => {
                            console.log(e)
                        }
                    });

                    $.ajax({
                        url: "{{ route('sekolah.pjp.poi') }}",
                        method: "GET",
                        dataType: "JSON",
                        data: {
                            cluster: cluster,
                            _token: "{{ csrf_token() }}"
                        },
                        success: (data) => {
                            const {
                                poi
                            } = data;
                            console.log(data);

                            if (poi.length) {
                                $("#poi").html(
                                    `<option value="" disabled selected>Pilih POI</option>` +
                                    poi.map((item) => {
                                        return `
                                    <option value="${item.id}">${item.poi_name.toString().toUpperCase()}</option>
                                    `
                                    })
                                )
                            } else {
                                $("#poi").html(
                                    `<option value="" disabled selected>Pilih POI</option>`
                                )
                            }

                        },
                        error: (e) => {
                            console.log(e)
                        }
                    });

                    $.ajax({
                        url: "{{ route('sekolah.pjp.site') }}",
                        method: "GET",
                        dataType: "JSON",
                        data: {
                            cluster: cluster,
                            _token: "{{ csrf_token() }}"
                        },
                        success: (data) => {
                            const {
                                site
                            } = data;
                            console.log(data);

                            if (site.length) {
                                $("#site_id").html(
                                    `<option value="" disabled selected>Pilih SITE ID</option>` +
                                    site.map((item) => {
                                        return `
                                    <option value="${item.site_id}">${item.site_id.toString().toUpperCase()}</option>
                                    `
                                    })
                                )
                            } else {
                                $("#site_id").html(
                                    `<option value="" disabled selected>Pilih SITE ID</option>`
                                )
                            }

                        },
                        error: (e) => {
                            console.log(e)
                        }
                    });

                    $.ajax({
                        url: "{{ route('sekolah.pjp.outlet') }}",
                        method: "GET",
                        dataType: "JSON",
                        data: {
                            cluster: cluster,
                            _token: "{{ csrf_token() }}"
                        },
                        success: (data) => {
                            const {
                                outlet
                            } = data;
                            console.log(data);

                            if (outlet.length) {
                                $("#outlet").html(
                                    `<option value="" disabled selected>Pilih OUTLET</option>` +
                                    outlet.map((item) => {
                                        return `
                                    <option value="${item.outlet_id}">${item.outlet_id} | ${item.nama_outlet.toString().toUpperCase()}</option>
                                    `
                                    })
                                )
                            } else {
                                $("#outlet").html(
                                    `<option value="" disabled selected>Pilih OUTLET</option>`
                                )
                            }

                        },
                        error: (e) => {
                            console.log(e)
                        }
                    });
                    // }
                })

                const findSchool = () => {
                    let _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "{{ URL::to('/find_school_pjp') }}",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            name: $('#sekolah').val(),
                            cluster: $('#cluster').val(),
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
                                $('#search-container').hide();
                                $(document).find("#npsn").val(npsn);
                            })

                        },
                        error: (e) => {
                            console.log('error', e);
                        }
                    })
                }
            })
        })
    </script>
@endsection
