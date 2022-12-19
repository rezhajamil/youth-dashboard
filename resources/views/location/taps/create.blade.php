@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data TAPS</h4>
            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit" x-data="{search:false}">
                <form action="{{ route('location.taps.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div class="grid grid-cols-3 gap-x-3 col-span-full">
                            <div class="w-full">
                                <label class="block text-gray-700" for="regional">Regional*</label>
                                <select name="regional" id="regional" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Region</option>
                                    @foreach ($region as $item)
                                    <option value="{{ $item->regional }}" {{ old('regional')==$item->regional?'selected':'' }}>
                                        {{ $item->regional }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('regional')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="branch">Branch*</label>
                                <select name="branch" id="branch" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Branch</option>
                                </select>
                                @error('branch')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="cluster">Cluster*</label>
                                <select name="cluster" id="cluster" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Cluster</option>
                                </select>
                                @error('cluster')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-5 gap-x-3 col-span-full">
                            <div class="w-full">
                                <label class="block text-gray-700" for="provinsi">Provinsi*</label>
                                <select name="provinsi" id="provinsi" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Provinsi</option>
                                </select>
                                @error('regional')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="kabupaten">Kabupaten*</label>
                                <select name="kabupaten" id="kabupaten" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Kabupaten</option>
                                </select>
                                @error('kabupaten')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="kecamatan">Kecamatan*</label>
                                <select name="kecamatan" id="kecamatan" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Kecamatan</option>
                                </select>
                                @error('kecamatan')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="kelurahan">Kelurahan*</label>
                                <select name="kelurahan" id="kelurahan" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Kelurahan</option>
                                </select>
                                @error('kelurahan')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div classs="w-full">
                                <label class="text-gray-700" for="kode_pos">Kode Pos</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number" name="kode_pos" value="{{ old('kode_pos') }}">
                                @error('kode_pos')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-x-3 col-span-full">
                            <div classs="w-full">
                                <label class="text-gray-700" for="nama">Nama*</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div classs="w-full">
                                <label class="text-gray-700" for="alamat">Alamat*</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="alamat" value="{{ old('alamat') }}">
                                @error('alamat')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div classs="w-full">
                                <label class="text-gray-700" for="mitra_ad_cluster">Mitra AD Cluster*</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="mitra_ad_cluster" value="{{ old('mitra_ad_cluster') }}">
                                @error('mitra_ad_cluster')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-x-3 col-span-full">
                            <div classs="w-full">
                                <label class="text-gray-700" for="call_center">Call Center</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="call_center" value="{{ old('call_center') }}">
                                @error('call_center')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div classs="w-full">
                                <label class="text-gray-700" for="email">Email</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div classs="w-full">
                                <label class="text-gray-700" for="latitude">Latitude*</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="latitude" value="{{ old('latitude') }}">
                                @error('latitude')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div classs="w-full">
                                <label class="text-gray-700" for="longitude">Longitude*</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="longitude" value="{{ old('longitude') }}">
                                @error('longitude')
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
        $("#regional").on('input', () => {
            var regional = $("#regional").val();
            console.log(regional)
            $.ajax({
                url: "{{ route('wilayah.get_branch') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    regional: regional
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    console.log(data)
                    $("#branch").html(
                        "<option disabled selected>Pilih Branch</option>"+
                        data.map((item) => {
                            return `
                            <option value="${item.branch}">${item.branch}</option>
                            `
                        })
                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            });

            $.ajax({
                url: "{{ route('wilayah.get_provinsi') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    regional: regional
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    console.log(data)
                    $("#provinsi").html(
                        "<option disabled selected>Pilih Provinsi</option>"+
                        data.map((item) => {
                            return `
                            <option value="${item.provinsi}">${item.provinsi}</option>
                            `
                        })

                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            });
        })

        $("#branch").on('input', () => {
            var branch = $("#branch").val();
            console.log(branch)
            $.ajax({
                url: "{{ route('wilayah.get_cluster') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    branch: branch
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    console.log(data)
                    $("#cluster").html(
                        "<option disabled selected>Pilih Cluster</option>"+
                        data.map((item) => {
                            return `
                    <option value="${item.cluster}">${item.cluster}</option>
                    `
                        })
                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            })
        })

        $("#provinsi").on('input', () => {
            var provinsi = $("#provinsi").val();
            console.log(provinsi)
            $.ajax({
                url: "{{ route('wilayah.get_kabupaten') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    provinsi: provinsi
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    console.log(data)
                    $("#kabupaten").html(
                        "<option disabled selected>Pilih Kabupaten</option>"+
                        data.map((item) => {
                            return `
                    <option value="${item.kabupaten}">${item.kabupaten}</option>
                    `
                        })
                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            })
        })

        $("#kabupaten").on('input', () => {
            var kabupaten = $("#kabupaten").val();
            console.log(kabupaten)
            $.ajax({
                url: "{{ route('wilayah.get_kecamatan') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    kabupaten: kabupaten
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    console.log(data)
                    $("#kecamatan").html(
                        "<option disabled selected>Pilih Kecamatan</option>"+
                        data.map((item) => {
                            return `
                    <option value="${item.kecamatan}">${item.kecamatan}</option>
                    `
                        })
                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            })
        });

        $("#kecamatan").on('input', () => {
            var kecamatan = $("#kecamatan").val();
            console.log(kecamatan)
            $.ajax({
                url: "{{ route('wilayah.get_kelurahan') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    kecamatan: kecamatan
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    console.log(data)
                    $("#kelurahan").html(
                        "<option disabled selected>Pilih kelurahan</option>"+
                        data.map((item) => {
                            return `
                    <option value="${item.desa}">${item.desa}</option>
                    `
                        })
                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            })
        })
    })

</script>
@endsection
