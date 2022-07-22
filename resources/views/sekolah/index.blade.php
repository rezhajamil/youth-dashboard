@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Data Sekolah</h4>

            <form class="flex flex-wrap items-center my-4 gap-x-4 gap-y-2" action="{{ route('sekolah.index') }}" method="get">
                <select name="provinsi" id="provinsi" class="px-8 rounded-lg">
                    <option value="" selected disabled>Pilih Provinsi</option>
                    @foreach ($provinsi as $item)
                    <option value="{{ $item->provinsi }}" {{ $item->provinsi==request()->get('provinsi')?'selected':'' }}>{{ $item->provinsi }}</option>
                    @endforeach
                </select>
                <select name="kabupaten" id="kabupaten" class="px-8 rounded-lg">
                    <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                    @foreach ($kabupaten as $item)
                    <option value="{{ $item->kab_kota }}" {{ $item->kab_kota==request()->get('kabupaten')?'selected':'' }}>{{ $item->kab_kota }}</option>
                    @endforeach
                </select>
                <select name="kecamatan" id="kecamatan" class="px-8 rounded-lg">
                    <option value="" selected disabled>Pilih Kecamatan</option>
                    @foreach ($kecamatan as $item)
                    <option value="{{ $item->kecamatan }}" {{ $item->kecamatan==request()->get('kecamatan')?'selected':'' }}>{{ $item->kecamatan }}</option>
                    @endforeach
                </select>
                <div class="flex gap-x-3">
                    <button class="px-4 py-2 font-bold text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-800"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                    @if (request()->get('provinsi')||request()->get('kabupaten')||request()->get('kecamatan'))
                    <a href="{{ route('sekolah.index') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                    @endif
                </div>
            </form>

            <div class="flex items-center my-3 gap-x-4">
                <select name="branch" id="branch" class="px-6 rounded-lg">
                    <option value="" selected disabled>Pilih Branch</option>
                    @foreach ($branch as $item)
                    <option value="{{ $item->branch }}">{{ $item->branch }}</option>
                    @endforeach
                </select>
                <select name="cluster" id="cluster" class="px-6 rounded-lg">
                    <option value="" selected disabled>Pilih Cluster</option>
                </select>
            </div>

            {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
            {{-- <a href="{{ route('direct_user.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-plus"></i> Data User Baru</a> --}}

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">NPSN</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Provinsi</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Kabupaten</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Kecamatan</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama Sekolah</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Status</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Jenjang</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Regional</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Branch</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($sekolah as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->NPSN }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->PROVINSI }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->KAB_KOTA }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->KECAMATAN }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->NAMA_SEKOLAH }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->STATUS_SEKOLAH }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->JENJANG }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->REGIONAL }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->BRANCH }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->CLUSTER }}</td>
                            <td class="p-4 text-gray-700 border-b">
                                {{-- <a href="{{ route('sekolah.edit',$data->npsn) }}" class="block my-1 text-base font-semibold text-indigo-600 transition hover:text-indigo-800">Edit</a> --}}
                                {{-- <form action="{{ route('direct_user.change_status',$data->id) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Ubah Status</button>
                                </form> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#provinsi").on('input', () => {
            var provinsi = $("#provinsi").val();
            $.ajax({
                url: "{{ route('sekolah.get_kabupaten') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    provinsi: provinsi
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    console.log(data)
                    $("#kabupaten").html(
                        `<option value="" selected disabled>Pilih Kabupaten/Kota</option> ` +
                        data.map((item) => {
                            return `
                            <option value="${item.kab_kota}">${item.kab_kota}</option>
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
            $.ajax({
                url: "{{ route('sekolah.get_kecamatan') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    kabupaten: kabupaten
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    console.log(data)
                    $("#kecamatan").html(
                        `<option value="" selected disabled>Pilih Kecamatan</option> ` +
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
                        `<option value="" selected disabled>Pilih Cluster</option> ` +
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


    })

</script>
@endsection
