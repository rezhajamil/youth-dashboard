@extends('layouts.dashboard.app')
@section('body')
    @php
        function ach($a, $b, $n = 1, $x = 100)
        {
            if ($b != 0) {
                $res = number_format((intval($a) / intval($b)) * $x, $n, ',', '.');
            } else {
                $res = number_format(0, $n, ',', '.');
            }
        
            return $res;
        }
    @endphp
    <div class="w-full mx-4 my-4">
        <div class="flex flex-col">
            <div class="mt-2">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">ByU</h4>

                <a href="{{ route('byu.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_tersier hover:bg-y_tersier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data Stok ByU</a>
                <a href="{{ route('byu.distribusi.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data Distribusi</a>
                <a href="{{ route('byu.report.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_sekunder hover:bg-y_sekunder"><i
                        class="mr-2 fa-solid fa-plus"></i> Data Report</a>

                <form action="{{ route('byu.index') }}" method="get" class="my-6">
                    <select name="month" id="month" required>
                        <option value="" selected disabled>Pilih Bulan</option>
                        @for ($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}" {{ request()->get('month') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" id="year" required>
                        <option value="" selected disabled>Pilih Tahun</option>
                        @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ request()->get('year') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <button class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i
                            class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                </form>
                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th rowspan="3"
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    Region
                                </th>
                                <th rowspan="3"
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    Cluster
                                </th>
                                <th rowspan="3"
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    City
                                </th>
                                <th colspan="8"
                                    class="p-3 text-sm font-semibold text-center text-gray-800 uppercase border border-white bg-y_kuartener/80">
                                    Distribution
                                    Mgt.
                                </th>
                                <th colspan="6"
                                    class="p-3 text-sm font-semibold text-center text-gray-800 uppercase border border-white bg-y_kuartener/80">
                                    Outlet
                                    Mgt.
                                </th>
                                <th colspan="5"
                                    class="p-3 text-sm font-semibold text-center text-gray-800 uppercase border border-white bg-y_kuartener/80">
                                    DS
                                    Mgt.
                                </th>
                            </tr>
                            <tr>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    A
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    B
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    C
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    D
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    E
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    F
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    G
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    H
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    I
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    J
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    K
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    L
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    M
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    N
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    O
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    P
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    Q
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    R
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    S
                                </th>
                            </tr>
                            <tr>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Target Distribusi ByU
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Actual Distribusi HQ to TAP
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Injected <br> (Qty)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    ST All <br> (Qty) <br> (L+P)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Stock Gudang<br> (A-D)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    %Inject To Target Distribusi
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Redeem All <br> (M+Q)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    %Redeem To Inject
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Target Outlet ST
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Outlet ST
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    %Ach Outlet ST
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    ST Outlet<br> (Qty)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Outlet Redeem<br> (Qty)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    %Redeem Outlet
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Jlh DS
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    ST DS <br> (Qty)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    DS Redeem
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    %Redeem DS
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Ach Redeem / DS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resume as $key => $data)
                                <tr class="hover:bg-gray-200 {{ $key % 2 ? 'bg-gray-100' : '' }}">
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white regional">
                                        {{ $data->regional }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white branch">
                                        {{ $data->cluster }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white city">
                                        {{ $data->city }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->target_distribusi ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->target_distribusi ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->injected ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->st_all ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ intval($data->target_distribusi) - intval($data->st_all) }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ ach($data->injected, $data->target_distribusi) }}%
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->redeem_all ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ ach($data->redeem_all, $data->injected) }}%
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->target_outlet_st ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->outlet_st ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ ach($data->outlet_st, $data->target_outlet_st) }}%
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->st_outlet ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->outlet_redeem ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ ach($data->outlet_redeem, $data->st_outlet) ?? 0 }}%
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->jlh_ds ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->st_ds ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ $data->ds_redeem ?? 0 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ ach($data->ds_redeem, $data->st_ds) }}%
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white">
                                        {{ ach($data->ds_redeem, $data->jlh_ds, 0, 1) }}
                                    </td>
                                </tr>

                                @if ($resume[$key]->regional == 'SUMBAGUT' && $resume[$key + 1]->regional == 'SUMBAGTENG')
                                    <tr class="bg-gray-600">
                                        <td colspan="3"
                                            class="p-3 text-center text-white uppercase border border-b border-white regional">
                                            SUMBAGUT TOTAL
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['target_distribusi'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['target_distribusi'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['injected'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['st_all'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ intval($sumbagut['target_distribusi']) - intval($sumbagut['st_all']) }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ ach($sumbagut['injected'], $sumbagut['target_distribusi']) }}%
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['redeem_all'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ ach($sumbagut['redeem_all'], $sumbagut['injected']) }}%
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['target_outlet_st'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['outlet_st'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ ach($sumbagut['outlet_st'], $sumbagut['target_outlet_st']) }}%
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['st_outlet'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['outlet_redeem'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ ach($sumbagut['outlet_redeem'], $sumbagut['st_outlet']) ?? 0 }}%
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['jlh_ds'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['st_ds'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ $sumbagut['ds_redeem'] ?? 0 }}
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ ach($sumbagut['ds_redeem'], $sumbagut['st_ds']) }}%
                                        </td>
                                        <td class="p-3 text-white uppercase border border-b border-white">
                                            {{ ach($sumbagut['ds_redeem'], $sumbagut['jlh_ds'], 0, 1) }}
                                        </td>
                                    </tr>
                                @else
                                    @if ($resume[$key]->regional == 'SUMBAGTENG' && $resume[$key + 1]->regional == 'SUMBAGSEL')
                                        <tr class="bg-gray-600">
                                            <td colspan="3"
                                                class="p-3 text-center text-white uppercase border border-b border-white regional">
                                                SUMBAGTENG TOTAL
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['target_distribusi'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['target_distribusi'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['injected'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['st_all'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ intval($sumbagteng['target_distribusi']) - intval($sumbagteng['st_all']) }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ ach($sumbagteng['injected'], $sumbagteng['target_distribusi']) }}%
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['redeem_all'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ ach($sumbagteng['redeem_all'], $sumbagteng['injected']) }}%
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['target_outlet_st'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['outlet_st'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ ach($sumbagteng['outlet_st'], $sumbagteng['target_outlet_st']) }}%
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['st_outlet'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['outlet_redeem'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ ach($sumbagteng['outlet_redeem'], $sumbagteng['st_outlet']) ?? 0 }}%
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['jlh_ds'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['st_ds'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ $sumbagteng['ds_redeem'] ?? 0 }}
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ ach($sumbagteng['ds_redeem'], $sumbagteng['st_ds']) }}%
                                            </td>
                                            <td class="p-3 text-white uppercase border border-b border-white">
                                                {{ ach($sumbagteng['ds_redeem'], $sumbagteng['jlh_ds'], 0, 1) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            <tr class="bg-gray-600">
                                <td colspan="3"
                                    class="p-3 text-center text-white uppercase border border-b border-white regional">
                                    SUMBAGSEL TOTAL
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['target_distribusi'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['target_distribusi'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['injected'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['st_all'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ intval($sumbagsel['target_distribusi']) - intval($sumbagsel['st_all']) }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($sumbagsel['injected'], $sumbagsel['target_distribusi']) }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['redeem_all'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($sumbagsel['redeem_all'], $sumbagsel['injected']) }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['target_outlet_st'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['outlet_st'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($sumbagsel['outlet_st'], $sumbagsel['target_outlet_st']) }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['st_outlet'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['outlet_redeem'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($sumbagsel['outlet_redeem'], $sumbagsel['st_outlet']) ?? 0 }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['jlh_ds'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['st_ds'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $sumbagsel['ds_redeem'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($sumbagsel['ds_redeem'], $sumbagsel['st_ds']) }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($sumbagsel['ds_redeem'], $sumbagsel['jlh_ds'], 0, 1) }}
                                </td>
                            </tr>
                            <tr class="bg-gray-600">
                                <td colspan="3"
                                    class="p-3 text-center text-white uppercase border border-b border-white regional">
                                    AREA TOTAL
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['target_distribusi'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['target_distribusi'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['injected'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['st_all'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ intval($area['target_distribusi']) - intval($area['st_all']) }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($area['injected'], $area['target_distribusi']) }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['redeem_all'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($area['redeem_all'], $area['injected']) }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['target_outlet_st'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['outlet_st'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($area['outlet_st'], $area['target_outlet_st']) }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['st_outlet'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['outlet_redeem'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($area['outlet_redeem'], $area['st_outlet']) ?? 0 }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['jlh_ds'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['st_ds'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ $area['ds_redeem'] ?? 0 }}
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($area['ds_redeem'], $area['st_ds']) }}%
                                </td>
                                <td class="p-3 text-white uppercase border border-b border-white">
                                    {{ ach($area['ds_redeem'], $area['jlh_ds'], 0, 1) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    @endsection
