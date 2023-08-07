@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <a href="{{ route('byu.index') }}"
                    class="inline-block px-4 py-2 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
                <a href="{{ route('byu.distribusi.view') }}" target="_blank"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_tersier hover:bg-y_tersier"><i
                        class="mr-2 fa-solid fa-list"></i> Hasil Input Distribusi ByU</a>
                <h4 class="my-4 text-xl font-bold text-gray-600 align-baseline">Tambah Data Distribusi ByU</h4>

                <div class="flex flex-col justify-between gap-4">
                    <div class="w-full px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0">
                        <span class="text-lg font-semibold">Distribusi DS</span>
                        <form action="{{ route('byu.distribusi.store') }}" method="POST" class=""
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="DS">
                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                <div class="w-full">
                                    <label class="block text-gray-700" for="cluster">Cluster</label>
                                    <select name="cluster" id="cluster_ds" class="w-full rounded-md" required>
                                        <option value="" selected disabled>Pilih Cluster</option>
                                        @foreach ($list_cluster as $item)
                                            <option value="{{ $item->cluster }}"
                                                {{ old('cluster') == $item->cluster ? 'selected' : '' }}>
                                                {{ $item->cluster }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cluster')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="w-full">
                                    <label class="block text-gray-700" for="city">City</label>
                                    <select name="city" id="city_ds" class="w-full rounded-md" required>
                                        <option value="" selected disabled>Pilih City</option>
                                    </select>
                                    @error('city')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="id_digipos">Pilih DS</label>
                                    <select name="id_digipos" id="id_digipos" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih DS</option>
                                        @foreach ($ds as $data)
                                            <option value="{{ $data->id_digipos }}">{{ $data->nama }} |
                                                {{ $data->id_digipos }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_digipos')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-gray-700" for="date">Tanggal</label>
                                    <input class="w-full rounded-md form-input focus:border-indigo-600" type="date"
                                        name="date" value="{{ old('date') }}">
                                    @error('date')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="pt-4 border-0 border-t-2 col-span-full">
                                    <label class="flex items-end mb-2 text-gray-700 gap-x-4" for="file">atau Upload
                                        File
                                    </label>
                                    <div class="flex gap-x-4">
                                        <input class="w-full rounded-md form-input focus:border-indigo-600" type="file"
                                            name="file" placeholder="File" value="{{ old('file') }}">
                                        <img src="{{ asset('images/contoh-distribusi-ds.jpg') }}" class="w-72"
                                            alt="Contoh">
                                    </div>

                                    @error('file')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                    @if ($errors->any())
                                        {{-- {{ ddd($errors) }} --}}
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $errors->all()[0] }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-end mt-4">
                                <button
                                    class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:outline-none focus:bg-y_sekunder">Submit</button>
                            </div>
                        </form>
                    </div>

                    <div class="w-full px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0">
                        <span class="text-lg font-semibold">Distribusi Outlet</span>
                        <form action="{{ route('byu.distribusi.store') }}" method="POST" class=""
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="Outlet">
                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                <div class="w-full">
                                    <label class="block text-gray-700" for="cluster">Cluster</label>
                                    <select name="cluster" id="cluster_outlet" class="w-full rounded-md" required>
                                        <option value="" selected disabled>Pilih Cluster</option>
                                        @foreach ($list_cluster as $item)
                                            <option value="{{ $item->cluster }}"
                                                {{ old('cluster') == $item->cluster ? 'selected' : '' }}>
                                                {{ $item->cluster }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cluster')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="w-full">
                                    <label class="block text-gray-700" for="city">City</label>
                                    <select name="city" id="city_outlet" class="w-full rounded-md" required>
                                        <option value="" selected disabled>Pilih City</option>
                                    </select>
                                    @error('city')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="id_digipos_outlet">Pilih Outlet</label>
                                    <select name="id_digipos" id="id_digipos_outlet" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Outlet</option>
                                    </select>
                                    @error('id_digipos')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-gray-700" for="date">Tanggal</label>
                                    <input class="w-full rounded-md form-input focus:border-indigo-600" type="date"
                                        name="date" value="{{ old('date') }}">
                                    @error('date')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="pt-4 border-0 border-t-2 col-span-full">
                                    <label class="flex items-end mb-2 text-gray-700 gap-x-4" for="file">atau Upload
                                        File
                                    </label>
                                    <div class="flex gap-x-4">
                                        <input class="w-full rounded-md form-input focus:border-indigo-600" type="file"
                                            name="file" placeholder="File" value="{{ old('file') }}">
                                        <img src="{{ asset('images/contoh-distribusi-outlet.jpg') }}" class="w-72"
                                            alt="Contoh">
                                    </div>

                                    @error('file')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                    @if ($errors->any())
                                        {{-- {{ ddd($errors->all()) }} --}}
                                        <span
                                            class="block mt-1 text-sm italic text-red-600">{{ $errors->all()[0] }}</span>
                                    @endif
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
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#cluster_ds").on('input', () => {
                let cluster_ds = $("#cluster_ds").val();
                $.ajax({
                    url: "{{ route('wilayah.get_lbo_city') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        cluster: cluster_ds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#city_ds").html(
                            "<option value='' selected disabled>Pilih City</option>" +
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

            $("#cluster_outlet").on('input', () => {
                let cluster_outlet = $("#cluster_outlet").val();
                $.ajax({
                    url: "{{ route('wilayah.get_lbo_city') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        cluster: cluster_outlet,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#city_outlet").html(
                            "<option selected disabled>Pilih City</option>" +
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

            $("#city_outlet").on('input', () => {
                var city = $("#city_outlet").val();
                $.ajax({
                    url: "{{ route('byu.get_outlet') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        city: city,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#id_digipos_outlet").html(
                            "<option value='' selected disabled>Pilih Outlet</option>" +
                            data.map((item) => {
                                return `
                    <option value="${item.outlet_id}">${item.nama_outlet} | ${item.outlet_id}</option>
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
