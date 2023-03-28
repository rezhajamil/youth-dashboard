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
    <div class="w-full mx-4 my-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Digipos</h4>

                <div class="flex justify-between mt-4 ">
                    {{-- <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('sales.migrasi') }}" method="get">
                        <input type="date" name="date" id="date" class="px-4 rounded-lg" value="{{ request()->get('date') }}" required>
                        <div class="flex gap-x-3">
                            <button class="px-4 py-2 font-bold text-white transition bg-y_premier rounded-lg hover:bg-y_premier"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                            @if (request()->get('date'))
                            <a href="{{ route('sales.migrasi') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                            @endif
                        </div>
                        </form> --}}
                    <div class="flex gap-x-3">
                        <div class="p-4 bg-white rounded w-fit h-fit">
                            <label for="by_region" class="mr-1 font-semibold text-slate-600">By Region</label>
                            <input type="checkbox" id="by_region" checked>
                        </div>
                        <div class="p-4 bg-white rounded w-fit h-fit">
                            <label for="by_cluster" class="mr-1 font-semibold text-slate-600">By Cluster</label>
                            <input type="checkbox" id="by_cluster" checked>
                        </div>
                        {{-- <div class="p-3 bg-white border rounded w-fit h-fit">
        <label for="by_detail" class="mr-1 font-semibold text-slate-600">By Detail</label>
        <input type="checkbox" id="by_detail">
    </div> --}}
                    </div>

                </div>

                <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600" By Region</span>
                    <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-region">
                        <table class="text-left border-collapse w-fit">
                            <thead class="border-b">
                                <tr>
                                    <th rowspan="2"
                                        class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier border">No</th>
                                    <th rowspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        Regional</th>
                                    <th rowspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        Branch</th>
                                    <th colspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        Omset</th>
                                    <th colspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        Rech Reg</th>
                                    <th colspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        Rech Vas</th>
                                    <th colspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        Digital</th>
                                    <th colspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        CVM</th>
                                    <th colspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        Voice</th>
                                    <th colspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        NSB</th>
                                    <th colspan="2"
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        Ketengan</th>
                                    {{-- <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">Action</th> --}}
                                </tr>
                                <tr>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        MTD</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        M-1</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        MTD</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        M-1</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        MTD</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        M-1</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        MTD</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        M-1</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        MTD</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        M-1</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        MTD</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        M-1</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        MTD</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        M-1</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        MTD</th>
                                    <th
                                        class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                        M-1</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales_branch as $key => $data)
                                    <tr class="hover:bg-gray-200">
                                        <td class="p-3 font-bold text-gray-700 border border-b">{{ $key + 1 }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b ">{{ $data->region }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b ">{{ $data->branch }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->omset_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->omset_last_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->rech_reg_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->rech_reg_last_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->rech_vas_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->rech_vas_last_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->digital_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->digital_last_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->cvm_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->cvm_last_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->voice_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->voice_last_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->nsb_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->nsb_last_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->ketengan_mtd) }}</td>
                                        <td class="p-3 text-gray-700 uppercase border border-b">
                                            {{ convertBil($data->ketengan_last_mtd) }}</td>
                                        {{-- <td class="p-3 text-gray-700 border border-b"></td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600" By Cluster</span>
                        <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-cluster">
                            <table class="text-left border-collapse w-fit">
                                <thead class="border-b">
                                    <tr>
                                        <th rowspan="2"
                                            class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier border">No
                                        </th>
                                        <th rowspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            Cluster</th>
                                        <th colspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            Omset</th>
                                        <th colspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            Rech Reg</th>
                                        <th colspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            Rech Vas</th>
                                        <th colspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            Digital</th>
                                        <th colspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            CVM</th>
                                        <th colspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            Voice</th>
                                        <th colspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            NSB</th>
                                        <th colspan="2"
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            Ketengan</th>
                                        {{-- <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">Action</th> --}}
                                    </tr>
                                    <tr>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            MTD</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            M-1</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            MTD</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            M-1</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            MTD</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            M-1</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            MTD</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            M-1</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            MTD</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            M-1</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            MTD</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            M-1</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            MTD</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            M-1</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            MTD</th>
                                        <th
                                            class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                            M-1</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales_cluster as $key => $data)
                                        <tr class="hover:bg-gray-200">
                                            <td class="p-3 font-bold text-gray-700 border border-b">{{ $key + 1 }}
                                            </td>
                                            <td class="p-3 text-gray-700 uppercase border border-b ">{{ $data->cluster }}
                                            </td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->omset_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->omset_last_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->rech_reg_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->rech_reg_last_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->rech_vas_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->rech_vas_last_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->digital_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->digital_last_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->cvm_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->cvm_last_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->voice_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->voice_last_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->nsb_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->nsb_last_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->ketengan_mtd) }}</td>
                                            <td class="p-3 text-gray-700 uppercase border border-b">
                                                {{ convertBil($data->ketengan_last_mtd) }}</td>
                                            {{-- <td class="p-3 text-gray-700 border border-b"></td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <span class="inline-block mt-6 text-lg font-semibold text-gray-600" Detail</span>
                            <div class="flex items-end mb-2 gap-x-4">
                                <input type="text" name="search" id="search" placeholder="Search..."
                                    class="px-4 rounded-lg">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-600">Berdasarkan</span>
                                    <select name="search_by" id="search_by" class="rounded-lg">
                                        <option value="cluster">Cluster</option>
                                        <option value="nama">Nama</option>
                                        <option value="outlet">Outlet</option>
                                        <option value="role">Role</option>
                                    </select>
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                                <table class="text-left border-collapse w-fit">
                                    <thead class="border-b">
                                        <tr>
                                            <th rowspan="2"
                                                class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier border">
                                                No</th>
                                            <th rowspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Cluster</th>
                                            <th rowspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Outled ID</th>
                                            <th rowspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Fisik</th>
                                            <th rowspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Nama</th>
                                            <th rowspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Role</th>
                                            <th colspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Omset</th>
                                            <th colspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Rech Reg</th>
                                            <th colspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Rech Vas</th>
                                            <th colspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Digital</th>
                                            <th colspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                CVM</th>
                                            <th colspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Voice</th>
                                            <th colspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                NSB</th>
                                            <th colspan="2"
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                Ketengan</th>
                                            {{-- <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">Action</th> --}}
                                        </tr>
                                        <tr>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                MTD</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                M-1</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                MTD</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                M-1</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                MTD</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                M-1</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                MTD</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                M-1</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                MTD</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                M-1</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                MTD</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                M-1</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                MTD</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                M-1</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                MTD</th>
                                            <th
                                                class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier border">
                                                M-1</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $key => $data)
                                            <tr class="hover:bg-gray-200">
                                                <td class="p-3 font-bold text-gray-700 border border-b">
                                                    {{ $key + 1 }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b cluster">
                                                    {{ $data->cluster }}
                                                </td>
                                                <td class="p-3 text-gray-700 uppercase border border-b outlet">
                                                    {{ $data->outlet_id }}
                                                </td>
                                                <td class="p-3 text-gray-700 uppercase border border-b outlet">
                                                    {{ $data->fisik }}
                                                </td>
                                                <td class="p-3 text-gray-700 uppercase border border-b nama">
                                                    {{ $data->nama }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b role">
                                                    {{ $data->role }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->omset_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->omset_last_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->rech_reg_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->rech_reg_last_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->rech_vas_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->rech_vas_last_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->digital_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->digital_last_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->cvm_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->cvm_last_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->voice_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->voice_last_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->nsb_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->nsb_last_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->ketengan_mtd) }}</td>
                                                <td class="p-3 text-gray-700 uppercase border border-b">
                                                    {{ convertBil($data->ketengan_last_mtd) }}</td>
                                                {{-- <td class="p-3 text-gray-700 border border-b"></td> --}}
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
