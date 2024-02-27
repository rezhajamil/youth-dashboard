@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Data Site</h4>

                {{-- <a href="{{ route('location.site.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data SITE Baru</a> --}}

                <div class="my-3 flex justify-between">
                    <form class="my-3 flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('location.site') }}"
                        method="get">
                        <select name="kategori" id="kategori" class="rounded-lg px-8">
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->kategori }}"
                                    {{ $item->kategori == request()->get('kategori') ? 'selected' : '' }}>
                                    {{ $item->kategori }}
                                </option>
                            @endforeach
                        </select>
                        <select name="architype" id="architype" class="rounded-lg px-8">
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
                                class="rounded-lg bg-y_premier px-4 py-2 font-bold text-white transition hover:bg-y_premier"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                            @if (request()->get('kategori') || request()->get('architype'))
                                <a href="{{ route('location.site') }}"
                                    class="rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                        class="fa-solid fa-circle-xmark mr-2"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="mb-2 flex flex-wrap items-end gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="rounded-lg px-4">
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

                <div class="w-fit overflow-auto rounded-md bg-white shadow">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Regional</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Branch</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Cluster</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Kabupaten</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">ID SITE</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Kategori</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Architype</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Class</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Longitude</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Latitude</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($site as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border-b p-3 font-bold text-gray-700">{{ $key + $site->firstItem() }}</td>
                                    <td class="regional border-b p-3 uppercase text-gray-700">{{ $data->regional }}</td>
                                    <td class="branch border-b p-3 uppercase text-gray-700">{{ $data->branch }}</td>
                                    <td class="cluster border-b p-3 uppercase text-gray-700">{{ $data->cluster }}</td>
                                    <td class="kabupaten border-b p-3 uppercase text-gray-700">{{ $data->kabupaten }}</td>
                                    <td class="site_id border-b p-3 uppercase text-gray-700">{{ $data->site_id }}</td>
                                    <td class="kategori border-b p-3 uppercase text-gray-700">{{ $data->kategori }}</td>
                                    <td class="architype border-b p-3 uppercase text-gray-700">{{ $data->architype }}</td>
                                    <td class="class border-b p-3 uppercase text-gray-700">{{ $data->class }}</td>
                                    <td class="longitude border-b p-3 uppercase text-gray-700">{{ $data->longitude }}</td>
                                    <td class="latitude border-b p-3 uppercase text-gray-700">{{ $data->latitude }}</td>
                                    <td class="border-b p-3 text-gray-700">
                                        <a href="{{ route('location.site.show', $data->id) }}"
                                            class="my-1 block text-base font-semibold text-y_premier transition hover:text-emerald-800">Detail</a>
                                        {{-- <a href="{{ route('location.site.edit', $data->id) }}"
                                            class="block my-1 text-base font-semibold transition text-y_premier hover:text-indigo-800">Edit</a> --}}
                                        @if ($data->latitude && $data->longitude)
                                            <a target="_blank"
                                                href="http://maps.google.com/maps?z=12&t=m&q=loc:{{ $data->latitude }}+{{ $data->longitude }}"
                                                class="my-1 block text-base font-semibold text-y_sekunder transition hover:text-teal-600">Cek
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
