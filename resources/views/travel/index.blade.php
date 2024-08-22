@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Data Travel</h4>

                <a href="{{ route('travel.create') }}"
                    class="my-2 inline-block rounded-md bg-y_premier px-4 py-2 font-bold text-white hover:bg-y_premier"><i
                        class="fa-solid fa-plus mr-2"></i> Data Travel Baru</a>

                <div class="mb-2 flex flex-wrap items-end gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="rounded-lg px-4">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="nama">Nama</option>
                            <option value="sbp">Sbp</option>
                            <option value="id_digipos_travel">ID Digipos Travel</option>
                            <option value="id_digipos_ds">ID Digipos DS</option>
                            <option value="cluster">Cluster</option>
                        </select>
                    </div>
                </div>

                {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
                {{-- @if (Auth::user()->privilege != 'cluster')
            <a href="{{ route('direct_user.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data User Baru</a>
            @endif --}}

                <div class="w-fit overflow-auto rounded-md bg-white shadow">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-2 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Nama</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Provinsi</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Kota</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Kecamatan</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Cluster</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">SBP</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Current Status</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">ID Digipos Travel
                                </th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">ID Digipos DS</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Latitude</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Longitude</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Foto Travel</th>
                                <th class="bg-y_tersier p-2 text-sm font-medium uppercase text-gray-100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($travels as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border-b p-2 text-sm font-bold text-gray-700">{{ $key + 1 }}</td>
                                    <td class="nama border-b p-2 text-sm uppercase text-gray-700">{{ $data->nama }}</td>
                                    <td class="provinsi border-b p-2 text-sm uppercase text-gray-700">{{ $data->provinsi }}
                                    </td>
                                    <td class="kota border-b p-2 text-sm uppercase text-gray-700">{{ $data->kota }}</td>
                                    <td class="kecamatan border-b p-2 text-sm uppercase text-gray-700">
                                        {{ $data->kecamatan }}</td>
                                    <td class="cluster border-b p-2 text-sm uppercase text-gray-700">{{ $data->cluster }}
                                    </td>
                                    <td class="sbp border-b p-2 text-sm uppercase text-gray-700">{{ $data->sbp }}</td>
                                    <td class="border-b p-2 text-sm uppercase text-gray-700">
                                        {{ $data->current_status != '' ? $data->current_status : '-' }}</td>
                                    <td class="id_digipos_travel border-b p-2 text-sm uppercase text-gray-700">
                                        {{ $data->id_digipos_travel_agent != '' ? $data->id_digipos_travel_agent : '-' }}
                                    </td>
                                    <td class="id_digipos_ds border-b p-2 text-sm uppercase text-gray-700">
                                        {{ $data->id_digipos_ds != '' ? $data->id_digipos_ds : '-' }}</td>
                                    <td class="latitude border-b p-2 text-sm uppercase text-gray-700">
                                        {{ $data->latitude != '' ? $data->latitude : '-' }}</td>
                                    <td class="longitude border-b p-2 text-sm uppercase text-gray-700">
                                        {{ $data->longitude != '' ? $data->longitude : '-' }}</td>
                                    <td class="foto_travel border-b p-2 text-sm uppercase text-gray-700">
                                        <div class="flex flex-col gap-1">
                                            @foreach ($data->images as $image)
                                                <img src="{{ asset('storage/' . $image->url) }}" alt="{{ $data->nama }}"
                                                    class="my-1 h-24">
                                            @endforeach
                                        </div>
                                    <td class="border-b p-2 text-sm text-gray-700">
                                        <a href="{{ route('travel.edit', $data->id) }}"
                                            class="my-1 block text-base font-semibold text-y_premier transition hover:text-indigo-800">Edit</a>
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
            $("#search").on("input", function() {
                find();
            });

            $("#search_by").on("input", function() {
                find();
            });

            $("#filter_status").on("input", function() {
                filter_status();
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

            const filter_status = () => {
                let filter_status = $('#filter_status').val();
                $(`.status`).each(function() {
                    let label = $(this).text();
                    if (filter_status == '') {
                        $(this).parent().parent().parent().show();
                    } else {
                        if (filter_status == label) {
                            $(this).parent().parent().parent().show();
                        } else {
                            $(this).parent().parent().parent().hide();
                        }
                    }
                });

            }
        })
    </script>
@endsection
