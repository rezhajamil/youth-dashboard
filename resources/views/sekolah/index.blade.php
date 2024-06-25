@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <div class="mb-4 flex justify-between">
                    <h4 class="align-baseline text-xl font-bold text-gray-600">Data Sekolah</h4>
                    <div class="mr-4 flex gap-x-4">
                        {{-- <a href="" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800"><i class="mr-2 fa-solid fa-square-up-right"></i>PJP</a> --}}
                        {{-- <a href="" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800"><i class="mr-2 fa-solid fa-square-up-right"></i>OSS</a> --}}
                        {{-- <a href="" class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-800"><i class="mr-2 fa-solid fa-square-up-right"></i>OSK</a> --}}
                    </div>
                </div>
                <div class="flex justify-between">
                    <form class="my-3 flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('sekolah.index') }}"
                        method="get">
                        <select name="provinsi" id="provinsi" class="rounded-lg px-8">
                            <option value="" selected disabled>Pilih Provinsi</option>
                            @foreach ($provinsi as $item)
                                <option value="{{ $item->provinsi }}"
                                    {{ $item->provinsi == request()->get('provinsi') ? 'selected' : '' }}>
                                    {{ $item->provinsi }}
                                </option>
                            @endforeach
                        </select>
                        <select name="kabupaten" id="kabupaten" class="rounded-lg px-8">
                            <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                            @foreach ($kabupaten as $item)
                                <option value="{{ $item->kabupaten }}"
                                    {{ $item->kabupaten == request()->get('kabupaten') ? 'selected' : '' }}>
                                    {{ $item->kabupaten }}
                                </option>
                            @endforeach
                        </select>
                        <select name="kecamatan" id="kecamatan" class="rounded-lg px-8">
                            <option value="" selected disabled>Pilih Kecamatan</option>
                            @foreach ($kecamatan as $item)
                                <option value="{{ $item->kecamatan }}"
                                    {{ $item->kecamatan == request()->get('kecamatan') ? 'selected' : '' }}>
                                    {{ $item->kecamatan }}
                                </option>
                            @endforeach
                        </select>
                        <div class="flex gap-x-3">
                            <button
                                class="rounded-lg bg-y_premier px-4 py-2 font-bold text-white transition hover:bg-y_premier"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                            @if (request()->get('provinsi') || request()->get('kabupaten') || request()->get('kecamatan'))
                                <a href="{{ route('sekolah.index') }}"
                                    class="rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                        class="fa-solid fa-circle-xmark mr-2"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
                <hr class="h-1 w-1/2 bg-neutral-600">
                <div class="flex justify-between">
                    <form class="my-3 flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('sekolah.index') }}"
                        method="get">
                        <input type="number" name="npsn" id="npsn" placeholder="NPSN" class="rounded-lg px-4 py-2"
                            value="{{ request()->get('npsn') ?? '' }}" />
                        <div class="flex gap-x-3">
                            <button
                                class="rounded-lg bg-y_tersier px-4 py-2 font-bold text-white transition hover:bg-y_tersier"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                            @if (request()->get('npsn'))
                                <a href="{{ route('sekolah.index') }}"
                                    class="rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                        class="fa-solid fa-circle-xmark mr-2"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="my-3 flex items-center gap-x-4">
                    <select name="branch" id="branch" class="rounded-lg px-6">
                        <option value="" selected>Pilih Branch</option>
                        @foreach ($branch as $item)
                            <option value="{{ $item->branch }}">{{ $item->branch }}</option>
                        @endforeach
                    </select>
                    <select name="cluster" id="cluster" class="rounded-lg px-6">
                        <option value="" selected disabled>Pilih Cluster</option>
                    </select>
                </div>

                <div class="my-3 flex flex-wrap items-end gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Filter..." class="rounded-lg px-4">
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
                {{-- <a href="{{ route('direct_user.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data User Baru</a> --}}

                <div class="w-fit overflow-auto rounded-md bg-white shadow">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border">
                            <tr>
                                <th class="border border-white bg-y_tersier p-2 text-sm font-bold uppercase text-gray-100">
                                    No</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    Status</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    NPSN</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    Kabupaten</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    Kecamatan</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    Nama Sekolah</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    Status</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    Jenjang</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    Cluster</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    PJP</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    FREKUENSI</th>
                                <th
                                    class="border border-white bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">
                                    Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 0;
                        @endphp
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($sekolah as $key => $data)
                                @if ($data->LATITUDE && $data->LONGITUDE)
                                    <tr class="hover:bg-gray-200">
                                        {{-- {{ ddd($data) }} --}}
                                        <td class="border p-2 font-bold text-gray-700">{{ ++$no }}</td>
                                        <td class="border p-2 text-center font-bold text-gray-700">
                                            @if ($data->status == 'P1')
                                                <i class="fa-solid fa-medal text-3xl text-y_tersier" />
                                            @endif
                                        </td>
                                        <td class="npsn border p-2 text-gray-700">{{ $data->NPSN }}</td>
                                        <td class="kabupaten border p-2 text-gray-700">{{ $data->KAB_KOTA }}</td>
                                        <td class="kecamatan border p-2 text-gray-700">{{ $data->KECAMATAN }}</td>
                                        <td class="nama border p-2 text-gray-700">{{ $data->NAMA_SEKOLAH }}</td>
                                        <td class="status border p-2 text-gray-700">{{ $data->STATUS_SEKOLAH }}</td>
                                        <td class="jenjang border p-2 text-gray-700">{{ $data->JENJANG }}</td>
                                        <td class="cluster border p-2 text-gray-700">{{ $data->CLUSTER }}</td>
                                        <td class="border p-2 text-gray-700">{{ $data->PJP }}</td>
                                        <td class="border p-2 text-gray-700">{{ $data->FREKUENSI }}</td>
                                        <td class="border p-2 text-gray-700">
                                            <a href="{{ route('sekolah.show', $data->NPSN) }}" target="_blank"
                                                class="my-1 block text-base font-semibold text-teal-600 transition hover:text-teal-800">Detail</a>
                                            {{-- @if (Auth::user()->privilege != 'cluster') --}}
                                            <a href="{{ route('sekolah.edit', $data->NPSN) }}" target="_blank"
                                                class="my-1 block text-base font-semibold text-y_premier transition hover:text-indigo-800">Edit</a>
                                            {{-- @endif --}}
                                            @if ($data->LATITUDE && $data->LONGITUDE)
                                                <a target="_blank"
                                                    href="http://maps.google.com/maps?z=12&t=m&q=loc:{{ $data->LATITUDE }}+{{ $data->LONGITUDE }}"
                                                    class="my-1 block whitespace-nowrap text-base font-semibold text-y_sekunder transition hover:text-teal-600">Cek
                                                    Lokasi</a>
                                            @endif
                                            {{-- <form action="{{ route('direct_user.change_status',$data->id) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Ubah Status</button>
                                </form> --}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @foreach ($sekolah as $key => $data)
                                @if (!$data->LATITUDE || !$data->LONGITUDE)
                                    <tr class="hover:bg-gray-200">
                                        {{-- {{ ddd($data) }} --}}
                                        <td class="border p-2 font-bold text-gray-700">{{ ++$no }}</td>
                                        <td class="border p-2 text-center font-bold text-gray-700">
                                            @if ($data->status == 'P1')
                                                <i class="fa-solid fa-medal colsf text-3xl text-y_tersier" />
                                            @endif
                                        </td>
                                        <td class="npsn border p-2 text-gray-700">{{ $data->NPSN }}</td>
                                        <td class="kabupaten border p-2 text-gray-700">{{ $data->KAB_KOTA }}</td>
                                        <td class="kecamatan border p-2 text-gray-700">{{ $data->KECAMATAN }}</td>
                                        <td class="nama border p-2 text-gray-700">{{ $data->NAMA_SEKOLAH }}</td>
                                        <td class="status border p-2 text-gray-700">{{ $data->STATUS_SEKOLAH }}</td>
                                        <td class="jenjang border p-2 text-gray-700">{{ $data->JENJANG }}</td>
                                        <td class="cluster border p-2 text-gray-700">{{ $data->CLUSTER }}</td>
                                        <td class="border p-2 text-gray-700">{{ $data->PJP }}</td>
                                        <td class="border p-2 text-gray-700">{{ $data->FREKUENSI }}</td>
                                        <td class="border p-2 text-gray-700">
                                            <a href="{{ route('sekolah.show', $data->NPSN) }}" target="_blank"
                                                class="my-1 block text-base font-semibold text-teal-600 transition hover:text-teal-800">Detail</a>
                                            {{-- @if (Auth::user()->privilege != 'cluster') --}}
                                            <a href="{{ route('sekolah.edit', $data->NPSN) }}"
                                                class="my-1 block text-base font-semibold text-y_premier transition hover:text-indigo-800">Edit</a>
                                            {{-- @endif --}}
                                            @if ($data->LATITUDE && $data->LONGITUDE)
                                                <a target="_blank"
                                                    href="http://maps.google.com/maps?z=12&t=m&q=loc:{{ $data->LATITUDE }}+{{ $data->LONGITUDE }}"
                                                    class="my-1 block whitespace-nowrap text-base font-semibold text-y_sekunder transition hover:text-teal-600">Cek
                                                    Lokasi</a>
                                            @endif
                                            {{-- <form action="{{ route('direct_user.change_status',$data->id) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Ubah Status</button>
                                </form> --}}
                                        </td>
                                    </tr>
                                @endif
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
                    url: "{{ route('sekolah.get_kabupaten') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        provinsi: provinsi,
                        _token: "{{ csrf_token() }}"
                    }

                    ,
                    success: (data) => {
                        console.log(data)
                        $("#kabupaten").html(
                            `<option value="" selected disabled>Pilih Kabupaten/Kota</option> ` +
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
                $.ajax({
                    url: "{{ route('sekolah.get_kecamatan') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        kabupaten: kabupaten,
                        _token: "{{ csrf_token() }}"
                    }

                    ,
                    success: (data) => {
                        console.log(data)
                        $("#kecamatan").html(
                            `<option value="" selected disabled>Pilih Kecamatan</option> ` +
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
                            `<option value="" selected>Pilih Cluster</option> ` +
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
