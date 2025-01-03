@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Data TAPS</h4>
                <a href="{{ route('location.taps.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data TAPS Baru</a>
                <div class="flex flex-wrap items-end mb-2 gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="regional">Regional</option>
                            <option value="cluster">Cluster</option>
                            <option value="provinsi">Provinsi</option>
                            <option value="kabupaten">Kabupaten</option>
                            <option value="kecamatan">Kecamatan</option>
                            <option value="kelurahan">Kelurahan</option>
                            <option value="nama">Nama</option>
                            <option value="mitra">Mitra</option>
                        </select>
                    </div>
                </div>

                {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
                {{-- @if (Auth::user()->privilege != 'cluster')
            <a href="{{ route('direct_user.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data User Baru</a>
            @endif --}}

                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Regional</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Provinsi</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kabupaten</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kecamatan</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kelurahan</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Mitra</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Longitude</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Latitude</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taps as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b regional">{{ $data->region_channel }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border-b cluster">{{ $data->cluster }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b provinsi">{{ $data->provinsi }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b kabupaten">{{ $data->kabupaten }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b kecamatan">{{ $data->kecamatan }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b kelurahan">{{ $data->kelurahan }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b nama">{{ $data->nama }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b mitra">{{ $data->mitra_ad_cluster }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border-b longitude">{{ $data->longitude }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b latitude">{{ $data->latitude }}</td>
                                    <td class="p-3 text-gray-700 border-b">
                                        <a href="{{ route('location.taps.edit', $data->id) }}"
                                            class="block my-1 text-base font-semibold transition text-y_premier hover:text-indigo-800">Edit</a>
                                        @if ($data->latitude && $data->longitude)
                                            <a target="_blank"
                                                href="http://maps.google.com/maps?z=12&t=m&q=loc:{{ $data->latitude }}+{{ $data->longitude }}"
                                                class="block my-1 text-base font-semibold transition text-y_sekunder hover:text-teal-600">Cek
                                                Lokasi</a>
                                        @endif
                                    </td>
                                    {{-- @else
                            <td class="p-3 text-gray-700 border-b">
                                <form action="{{ route('direct_user.change_status',$data->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800 whitespace-nowrap">Ubah Status</button>
                            </form>
                            </td>
                            @endif --}}
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
