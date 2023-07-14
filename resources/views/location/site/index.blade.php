@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Data Site</h4>

                {{-- <a href="{{ route('location.site.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data SITE Baru</a> --}}

                <div class="flex justify-between my-3">
                    <form class="flex flex-wrap items-center my-3 gap-x-4 gap-y-2" action="{{ route('location.site') }}"
                        method="get">
                        <select name="kategori" id="kategori" class="px-8 rounded-lg">
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->kategori }}"
                                    {{ $item->kategori == request()->get('kategori') ? 'selected' : '' }}>
                                    {{ $item->kategori }}
                                </option>
                            @endforeach
                        </select>
                        <select name="architype" id="architype" class="px-8 rounded-lg">
                            <option value="" selected disabled>Pilih Architype</option>
                            @foreach ($architype as $item)
                                <option value="{{ $item->architype }}"
                                    {{ $item->architype == request()->get('architype') ? 'selected' : '' }}>
                                    {{ $item->architype }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="page" value="{{ request()->get('page') }}">
                        <div class="flex gap-x-3">
                            <button
                                class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i
                                    class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                            @if (request()->get('kategori') || request()->get('architype'))
                                <a href="{{ route('location.site') }}"
                                    class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i
                                        class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="flex flex-wrap items-end mb-2 gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="regional">Regional</option>
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                            <option value="kabupaten">Kabupaten</option>
                            <option value="site_id">Site ID</option>
                            <option value="kategori">Kategori</option>
                            <option value="architype">Architype</option>
                            <option value="class">Class</option>
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
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kabupaten</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">ID SITE</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kategori</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Architype</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Class</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Longitude</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Latitude</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($site as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border-b">{{ $key + $site->firstItem() }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b regional">{{ $data->regional }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b branch">{{ $data->branch }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b cluster">{{ $data->cluster }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b kabupaten">{{ $data->kabupaten }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b site_id">{{ $data->site_id }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b kategori">{{ $data->kategori }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b architype">{{ $data->architype }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b class">{{ $data->class }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b longitude">{{ $data->longitude }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b latitude">{{ $data->latitude }}</td>
                                    <td class="p-3 text-gray-700 border-b">
                                        <a href="{{ route('location.site.show', $data->id) }}"
                                            class="block my-1 text-base font-semibold transition text-y_premier hover:text-emerald-800">Detail</a>
                                        {{-- <a href="{{ route('location.site.edit', $data->id) }}"
                                            class="block my-1 text-base font-semibold transition text-y_premier hover:text-indigo-800">Edit</a> --}}
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

                    {{ $site->links('components.pagination', ['data' => $site]) }}
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
