@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4 my-4">
        <div class="flex flex-col">
            <div class="mt-2">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">ByU</h4>

                <a href="{{ route('byu.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data Distribusi</a>
                <a href="{{ route('byu.report.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_sekunder hover:bg-y_sekunder"><i
                        class="mr-2 fa-solid fa-plus"></i> Data Report</a>

                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th rowspan="2"
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    Region
                                </th>
                                <th rowspan="2"
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    Branch
                                </th>
                                <th rowspan="2"
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    Cluster
                                </th>
                                <th colspan="9"
                                    class="p-3 text-sm font-semibold text-center text-gray-800 uppercase border border-white bg-y_kuartener/80">
                                    Distribution
                                    Mgt.
                                </th>
                                <th colspan="4"
                                    class="p-3 text-sm font-semibold text-center text-gray-800 uppercase border border-white bg-y_kuartener/80">
                                    Outlet
                                    Mgt.
                                </th>
                                <th colspan="4"
                                    class="p-3 text-sm font-semibold text-center text-gray-800 uppercase border border-white bg-y_kuartener/80">
                                    DS
                                    Mgt.
                                </th>
                            </tr>
                            <tr>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Target Distribusi ByU
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Actual Distribusi
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    ST All <br> (Qty)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Injected<br> (Qty)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-gray-800 uppercase border border-white bg-yellow-300/60">
                                    Not Injected<br> (Qty)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Stock Gudang<br> (Target Dist. - ST)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    %Inject To Target Distribusi
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    Redeem All
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
                                    Jlh DS
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    DS Redeem
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase border border-white bg-premier">
                                    ST DS<br> (Qty)
                                </th>
                                <th
                                    class="p-3 text-sm font-semibold text-center text-white uppercase bg-gray-500 border border-white">
                                    Ach Redeem / DS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($users as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border border-b border-white">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border border-b border-white regional">{{ $data->regional }}</td>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    @endsection
