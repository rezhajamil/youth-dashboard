@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Edit Data {{$tap->nama}}</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('location.taps.update',$tap->id) }}" method="POST" class="">
                    @csrf
                    @method('put')
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div class="grid grid-cols-3 gap-x-3 col-span-full">
                            <div class="w-full">
                                <label class="block text-gray-700" for="cluster">Cluster</label>
                                <select name="cluster" id="cluster" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Cluster</option>
                                    @foreach ($cluster as $item)
                                    <option value="{{ $item->cluster }}" {{ old('cluster',$tap->cluster)==$item->cluster?'selected':'' }}>{{ $item->cluster }}</option>
                                    @endforeach
                                </select>
                                @error('cluster')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="latitude">Latitude</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="latitude" value="{{ old('latitude',$tap->latitude) }}">
                                @error('latitude')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="text-gray-700" for="longitude">Longitude</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="longitude" value="{{ old('longitude',$tap->longitude) }}">
                                @error('longitude')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:outline-none focus:bg-y_sekunder">Submit</button>
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
                url: "{{ route('wilayah.get_branch') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    regional: regional
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    $("#branch").html(
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
            })
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
                    $("#cluster").html(
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

        $("#cluster").on('input', () => {
            var cluster = $("#cluster").val();
            console.log(cluster)
            $.ajax({
                url: "{{ route('wilayah.get_tap') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    cluster: cluster
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    console.log(data)
                    $("#tap").html(
                        data.map((item) => {
                            return `
                    <option value="${item.nama}">${item.nama}</option>
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
