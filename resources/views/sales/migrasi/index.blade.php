@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Migrasi 4G/Direct Sales</h4>

            <div class="flex justify-between mt-4 ">
                <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('sales.migrasi') }}" method="get">
                    <input type="date" name="date" id="date" class="px-4 rounded-lg" value="{{ request()->get('date') }}" required>
                    <div class="flex gap-x-3">
                        <button class="px-4 py-2 font-bold text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-800"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        @if (request()->get('date'))
                        <a href="{{ route('sales.migrasi') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                        @endif
                    </div>
                </form>
                <div class="flex px-6 gap-x-3">
                    <div class="p-4 bg-white rounded w-fit h-fit">
                        <label for="by_region" class="mr-1 font-semibold text-slate-600">By Region</label>
                        <input type="checkbox" id="by_region" checked>
                    </div>
                    <div class="p-4 bg-white rounded w-fit h-fit">
                        <label for="by_cluster" class="mr-1 font-semibold text-slate-600">By Cluster</label>
                        <input type="checkbox" id="by_cluster" checked>
                    </div>
                    {{-- <div class="p-4 bg-white rounded w-fit h-fit">
                        <label for="by_detail" class="mr-1 font-semibold text-slate-600">By Detail</label>
                        <input type="checkbox" id="by_detail">
                    </div> --}}
                </div>

            </div>

            <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-region">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Regional</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Branch</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MTD</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">M-1</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MOM</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">DS MTD</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">DS M-1</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">DS MOM</th>
                            {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_branch as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->regional }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->branch }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mtd }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->last_mtd }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mom }}%</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->ds_mtd }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->last_ds_mtd }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->ds_mom }}%</td>
                            {{-- <td class="p-4 text-gray-700 border-b"></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Cluster</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-cluster">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MTD</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">M-1</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MOM</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">DS MTD</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">DS M-1</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">DS MOM</th>
                            {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_cluster as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mtd }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->last_mtd }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mom }}%</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->ds_mtd }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->last_ds_mtd }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->ds_mom }}%</td>
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
                        <option value="tap">TAP</option>
                        <option value="nama">Nama</option>
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
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">TAP</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MTD</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">M-1</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">MOM</th>
                            {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b cluster">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b tap">{{ $data->tap }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b nama">{{ $data->nama }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mtd }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->last_mtd }}</td>
                            <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mom }}%</td>
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

        $("#by_region").on("change", function() {
            $("#table-region").toggle();
        })

        $("#by_cluster").on("change", function() {
            $("#table-cluster").toggle();
        })

    })

</script>
@endsection
