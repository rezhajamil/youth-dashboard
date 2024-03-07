@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Edit Data {{ $poi->poi_name }}</h4>

                <div class="mx-auto w-fit overflow-auto rounded-md bg-white px-6 py-4 shadow sm:mx-0">
                    <form action="{{ route('location.poi.update', $poi->id) }}" method="POST" class="">
                        @csrf
                        @method('put')
                        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-3">
                            <div class="col-span-full grid grid-cols-3 gap-x-3">
                                <div class="w-full">
                                    <label class="text-gray-700" for="latitude">Latitude</label>
                                    <input class="form-input w-full rounded-md focus:border-indigo-600" type="text"
                                        name="latitude" value="{{ old('latitude', $poi->latitude) }}">
                                    @error('latitude')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="text-gray-700" for="longitude">Longitude</label>
                                    <input class="form-input w-full rounded-md focus:border-indigo-600" type="text"
                                        name="longitude" value="{{ old('longitude', $poi->longitude) }}">
                                    @error('longitude')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="kecamatan">Kecamatan</label>
                                    <select name="kecamatan" id="kecamatan" class="w-full rounded-md">
                                        <option value="" selected disabled>Pilih Kecamatan</option>
                                        @foreach ($kecamatan as $item)
                                            <option value="{{ $item->kecamatan }}"
                                                {{ $poi->kecamatan == $item->kecamatan ? 'selected' : '' }}>{{ $item->kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kecamatan')
                                        <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
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
