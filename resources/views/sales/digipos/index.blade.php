@extends('layouts.dashboard.app')
@section('body')
    @php
        function convertBil($bilangan, $pow = 6)
        {
            if ($bilangan < pow(10, 9) && $bilangan >= pow(10, 6)) {
                $res = $bilangan / pow(10, $pow);
                return number_format($res, 2, ',', '.');
            } elseif ($bilangan < pow(10, 6) && $bilangan >= pow(10, 3)) {
                $res = $bilangan / pow(10, $pow);
                return number_format($res, 2, ',', '.');
            } else {
                $res = $bilangan / pow(10, $pow);
                return number_format($res, 2, ',', '.');
            }
        }

    @endphp
    <div class="mx-4 my-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Digipos</h4>

                <div class="mt-4 flex justify-between">
                    <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('sales.digipos') }}"
                        method="get">
                        <input type="date" name="date" id="date" class="rounded-lg px-4"
                            value="{{ request()->get('date') }}" required>
                        <select name="trx_type" id="trx_type" class="rounded-lg px-4">
                            <option value="ALL" selected>ALL</option>
                            @foreach ($list_trx_type as $item)
                                <option value="{{ $item->trx_type }}"
                                    {{ request()->get('trx_type') == $item->trx_type ? 'selected' : '' }}>
                                    {{ $item->trx_type }}</option>
                            @endforeach
                        </select>
                        <div class="flex gap-x-3">
                            <button
                                class="rounded-lg bg-y_premier px-4 py-2 font-bold text-white transition hover:bg-y_premier"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                            @if (request()->get('date'))
                                <a href="{{ route('sales.digipos') }}"
                                    class="rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                        class="fa-solid fa-circle-xmark mr-2"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                    <div class="flex gap-x-3">
                        <div class="h-fit w-fit rounded bg-white p-4">
                            <label for="by_branch" class="mr-1 font-semibold text-slate-600">By Branch</label>
                            <input type="checkbox" id="by_branch" checked>
                        </div>
                        <div class="h-fit w-fit rounded bg-white p-4">
                            <label for="by_cluster" class="mr-1 font-semibold text-slate-600">By Cluster</label>
                            <input type="checkbox" id="by_cluster" checked>
                        </div>
                        {{-- <div class="p-3 bg-white border rounded w-fit h-fit">
        <label for="by_detail" class="mr-1 font-semibold text-slate-600">By Detail</label>
        <input type="checkbox" id="by_detail">
    </div> --}}
                    </div>

                </div>

                <span class="mb-2 mt-6 block text-lg font-semibold text-gray-600"> By Branch</span>
                <div class="w-fit overflow-hidden rounded-md bg-white shadow" id="table-branch">
                    <table class="w-fit border-collapse text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="border bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    Branch</th>
                                <th class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    M-1</th>
                                <th class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    MTD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_branch as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border border-b p-3 font-bold text-gray-700">{{ $key + 1 }}</td>
                                    <td class="border border-b p-3 uppercase text-gray-700">{{ $data->branch }}</td>
                                    <td class="border border-b p-3 uppercase text-gray-700">
                                        {{ convertBil($data->m1) }}</td>
                                    <td class="border border-b p-3 uppercase text-gray-700">
                                        {{ convertBil($data->mtd) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="mb-2 mt-6 block text-lg font-semibold text-gray-600"> By Cluster</span>
                <div class="w-fit overflow-hidden rounded-md bg-white shadow" id="table-cluster">
                    <table class="w-fit border-collapse text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="border bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    Cluster</th>
                                <th class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    M-1</th>
                                <th class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    MTD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_cluster as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border border-b p-3 font-bold text-gray-700">{{ $key + 1 }}</td>
                                    <td class="border border-b p-3 uppercase text-gray-700">{{ $data->cluster }}</td>
                                    <td class="border border-b p-3 uppercase text-gray-700">
                                        {{ convertBil($data->m1) }}</td>
                                    <td class="border border-b p-3 uppercase text-gray-700">
                                        {{ convertBil($data->mtd) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="mt-6 inline-block text-lg font-semibold text-gray-600">Detail</span>
                <div class="mb-2 flex items-end gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="rounded-lg px-4">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                            <option value="nama">Nama</option>
                            <option value="id_digipos">ID DIGIPOS</option>
                        </select>
                    </div>
                </div>

                <div class="w-fit overflow-hidden rounded-md bg-white shadow">
                    <table class="w-fit border-collapse text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="border bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="border bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">Branch</th>
                                <th class="border bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">Cluster</th>
                                <th class="border bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">ID Digipos
                                </th>
                                <th class="border bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">Nama</th>
                                <th class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    M-1</th>
                                <th class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    MTD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border border-b p-3 font-bold text-gray-700">{{ $key + 1 }}</td>
                                    <td class="branch border border-b p-3 uppercase text-gray-700">{{ $data->branch }}</td>
                                    <td class="cluster border border-b p-3 uppercase text-gray-700">{{ $data->cluster }}
                                    </td>
                                    <td class="id_digipos border border-b p-3 uppercase text-gray-700">
                                        {{ $data->digipos_ao }}</td>
                                    <td class="nama border border-b p-3 uppercase text-gray-700">
                                        {{ $data->nama_ao }}</td>
                                    <td class="m1 border border-b p-3 uppercase text-gray-700">
                                        {{ convertBil($data->m1) }}</td>
                                    <td class="border border-b p-3 uppercase text-gray-700">
                                        {{ convertBil($data->mtd) }}</td>
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


            $("#by_region").on("change", function() {
                $("#table-region").toggle();
            })

            $("#by_cluster").on("change", function() {
                $("#table-cluster").toggle();
            })

        })
    </script>
@endsection
