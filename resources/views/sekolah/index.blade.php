@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Data Sekolah</h4>
                <div class="flex mr-4 gap-x-4">
                    {{-- <a href="" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800"><i class="mr-2 fa-solid fa-square-up-right"></i>PJP</a> --}}
                    {{-- <a href="" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800"><i class="mr-2 fa-solid fa-square-up-right"></i>OSS</a> --}}
                    {{-- <a href="" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800"><i class="mr-2 fa-solid fa-square-up-right"></i>OSK</a> --}}
                </div>
            </div>
            <div class="flex justify-between">
                <form class="flex flex-wrap items-center my-3 gap-x-4 gap-y-2" action="{{ route('sekolah.index') }}" method="get">
                    <select name="provinsi" id="provinsi" class="px-8 rounded-lg">
                        <option value="" selected disabled>Pilih Provinsi</option>
                        @foreach ($provinsi as $item)
                        <option value="{{ $item->provinsi }}" {{ $item->provinsi==request()->get('provinsi')?'selected':'' }}>{{ $item->provinsi }}</option>
                        @endforeach
                    </select>
                    <select name="kabupaten" id="kabupaten" class="px-8 rounded-lg">
                        <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                        @foreach ($kabupaten as $item)
                        <option value="{{ $item->kabupaten }}" {{ $item->kabupaten==request()->get('kabupaten')?'selected':'' }}>{{ $item->kabupaten }}</option>
                        @endforeach
                    </select>
                    <select name="kecamatan" id="kecamatan" class="px-8 rounded-lg">
                        <option value="" selected disabled>Pilih Kecamatan</option>
                        @foreach ($kecamatan as $item)
                        <option value="{{ $item->kecamatan }}" {{ $item->kecamatan==request()->get('kecamatan')?'selected':'' }}>{{ $item->kecamatan }}</option>
                        @endforeach
                    </select>
                    <div class="flex gap-x-3">
                        <button class="px-4 py-2 font-bold text-white transition bg-y_premier rounded-lg hover:bg-y_premier"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        @if (request()->get('provinsi')||request()->get('kabupaten')||request()->get('kecamatan'))
                        <a href="{{ route('sekolah.index') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="flex items-center my-3 gap-x-4">
                <select name="branch" id="branch" class="px-6 rounded-lg">
                    <option value="" selected>Pilih Branch</option>
                    @foreach ($branch as $item)
                    <option value="{{ $item->branch }}">{{ $item->branch }}</option>
                    @endforeach
                </select>
                <select name="cluster" id="cluster" class="px-6 rounded-lg">
                    <option value="" selected disabled>Pilih Cluster</option>
                </select>
            </div>

            <div class="flex flex-wrap items-end my-3 gap-x-4">
                <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                <div class="flex flex-col">
                    {{-- <span class="font-bold text-gray-600">Berdasarkan</span> --}}
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="npsn">Berdasarkan NPSN</option>
                        <option value="nama">Berdasarkan Nama</option>
                        <option value="status">Berdasarkan Status</option>
                        <option value="jenjang">Berdasarkan Jenjang</option>
                    </select>
                </div>
            </div>


            {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
            {{-- <a href="{{ route('direct_user.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-y_premier rounded-md hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data User Baru</a> --}}

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">NPSN</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Provinsi</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kabupaten</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kecamatan</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama Sekolah</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Status</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jenjang</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Regional</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">PJP</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">FREKUENSI</th>
                            @if (Auth::user()->privilege!='cluster')
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($sekolah as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b npsn">{{ $data->NPSN }}</td>
                            <td class="p-4 text-gray-700 border-b provinsi">{{ $data->PROVINSI }}</td>
                            <td class="p-4 text-gray-700 border-b kabupaten">{{ $data->KAB_KOTA }}</td>
                            <td class="p-4 text-gray-700 border-b kecamatan">{{ $data->KECAMATAN }}</td>
                            <td class="p-4 text-gray-700 border-b nama">{{ $data->NAMA_SEKOLAH }}</td>
                            <td class="p-4 text-gray-700 border-b status">{{ $data->STATUS_SEKOLAH }}</td>
                            <td class="p-4 text-gray-700 border-b jenjang">{{ $data->JENJANG }}</td>
                            <td class="p-4 text-gray-700 border-b regional">{{ $data->REGIONAL }}</td>
                            <td class="p-4 text-gray-700 border-b branch">{{ $data->BRANCH }}</td>
                            <td class="p-4 text-gray-700 border-b cluster">{{ $data->CLUSTER }}</td>
                            <td class="p-4 text-gray-700 border-b cluster">{{ $data->PJP }}</td>
                            <td class="p-4 text-gray-700 border-b cluster">{{ $data->FREKUENSI }}</td>
                            @if (Auth::user()->privilege!='cluster')
                            <td class="p-4 text-gray-700 border-b">
                                <a href="{{ route('sekolah.show',$data->NPSN) }}" target="_blank" class="block my-1 text-base font-semibold text-teal-600 transition hover:text-teal-800">Detail</a>
                                @if (!$data->KAB_KOTA||!$data->KECAMATAN||!$data->BRANCH||!$data->CLUSTER)
                                <a href="{{ route('sekolah.edit',$data->NPSN) }}" class="block my-1 text-base font-semibold text-y_premier transition hover:text-indigo-800">Edit</a>
                                @endif
                                {{-- <form action="{{ route('direct_user.change_status',$data->id) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Ubah Status</button>
                                </form> --}}
                                @endif
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
                        `<option value="" selected>Pilih Cluster</option> ` +
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

            let search = $("#branch").val();
            let pattern = new RegExp(search, "i");
            $(`.branch`).each(function() {
                let label = $(this).text();
                if (pattern.test(label)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        })

        $("#cluster").on("input", function() {
            let search = $("#cluster").val();
            let pattern = new RegExp(search, "i");
            $(`.cluster`).each(function() {
                let label = $(this).text();
                if (pattern.test(label)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });

        })

        $("#search").on("input", function() {
            find();
        });

        $("#search_by").on("input", function() {
            find();
        });

        const find = () => {
            let search = $("#search").val();
            let searchBy = $('#search_by').val();
            let pattern = new RegExp(search, "i");
            $(`.${searchBy}`).each(function() {
                let label = $(this).text();
                if (pattern.test(label)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        }
    })

</script>
@endsection
