@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Orbit/Direct Sales</h4>
            <form class="flex flex-wrap items-center mt-4 gap-x-4 gap-y-2" action="{{ route('sales.orbit') }}" method="get">
                <input type="date" name="date" id="date" class="px-4 rounded-lg" value="{{ request()->get('date') }}" required>
                <div class="flex gap-x-3">
                    <button class="px-4 py-2 font-bold text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-800"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                    @if (request()->get('date'))
                    <a href="{{ route('sales.orbit') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                    @endif
                </div>
            </form>

            <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Regional</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Branch</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Status</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MTD</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Last MTD</th>
                            {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_branch as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->regional }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->branch }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->status }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mtd }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->last_mtd }}</td>
                            {{-- <td class="p-4 text-gray-700 border-b"></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Cluster</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Status</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MTD</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Last MTD</th>
                            {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_cluster as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->status }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mtd }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->last_mtd }}</td>
                            {{-- <td class="p-4 text-gray-700 border-b"></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <span class="inline-block mt-6 text-lg font-semibold text-gray-600">Direct Sales Detail</span>
            @if (request()->get('date'))
            <div class="flex items-end mb-2 gap-x-4">
                <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                <div class="flex flex-col">
                    <span class="font-bold text-gray-600">Berdasarkan</span>
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="cluster">Cluster</option>
                        <option value="telp">Telepon</option>
                        <option value="nama">Nama</option>
                        <option value="status">Status</option>
                        <option value="aktif">Tanggal Aktif</option>
                    </select>
                </div>
            </div>
            @endif

            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Status</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Telepon</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Tanggal Aktif</th>
                            {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MOM</th> --}}
                            {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b cluster">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b nama">{{ $data->nama }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b status">{{ $data->status }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b telp">{{ $data->telp }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b aktif">{{ $data->sales_date }}</td>
                            {{-- <td class="p-4 text-gray-700 border-b"></td> --}}
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
            let search = $(this).val();
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
        });

    })

</script>
@endsection
