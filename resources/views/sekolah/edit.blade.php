@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Edit Data Sekolah</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <span class="inline-block mb-2 font-bold">{{ $sekolah->NAMA_SEKOLAH }}</span>
                <form action="{{ route('sekolah.update',$sekolah->NPSN) }}" method="POST" class="">
                    @csrf
                    @method('put')
                    <input type="hidden" name="url" value="{{ Request::url() }}">
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div class="w-full">
                            <label class="block text-gray-700" for="kabupaten">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten" class="w-full rounded-md">
                                {{-- @if (auth()->user()->privilege=='superadmin') --}}
                                <option value="" selected disabled>Pilih Kabupaten</option>
                                {{-- @endif --}}
                                @foreach ($kabupaten as $item)
                                <option value="{{ $item->kabupaten }}" {{ old('kabupaten')==$item->kabupaten?'selected':'' }}>
                                    {{ $item->kabupaten }}</option>
                                @endforeach

                            </select>
                            @error('kecamatan')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-gray-700" for="kecamatan">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="w-full rounded-md">
                                {{-- @if (auth()->user()->privilege=='superadmin') --}}
                                <option value="" selected disabled>Pilih Kecamatan</option>
                                {{-- @endif --}}
                                @foreach ($kecamatan as $item)
                                <option value="{{ $item->kecamatan }}" {{ old('kecamatan')==$item->kecamatan?'selected':'' }}>
                                    {{ $item->kecamatan }}</option>
                                @endforeach

                            </select>
                            @error('kecamatan')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-gray-700" for="branch">Branch</label>
                            <select name="branch" id="branch" class="w-full rounded-md">
                                {{-- @if (auth()->user()->privilege=='superadmin') --}}
                                <option value="" selected disabled>Pilih Branch</option>
                                {{-- @endif --}}
                                @foreach ($branch as $item)
                                <option value="{{ $item->branch }}" {{ old('branch')==$item->branch?'selected':'' }}>
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
                            </select>
                            @error('cluster')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-gray-700" for="pjp">PJP</label>
                            <select name="pjp" id="pjp" class="w-full rounded-md" required>
                                <option value="" selected disabled>Pilih PJP</option>
                                <option value="PJP">PJP</option>
                                <option value="NON PJP">NON PJP</option>
                            </select>
                            @error('pjp')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-gray-700" for="frekuensi">Frekuensi Kunjungan</label>
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

                    <div class="flex justify-end mt-4">
                        <button class="w-full px-4 py-2 font-bold text-white bg-indigo-800 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">Submit</button>
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
                url: "{{ route('sekolah.get_kecamatan') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    kabupaten: kabupaten
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    $("#kecamatan").html(
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
