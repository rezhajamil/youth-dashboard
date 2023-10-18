@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4 my-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Migrasi 4G/Direct Sales</h4>
                <span class="text-sm">Update : {{ $update[0]->last_update }}</span>

                <div class="flex justify-between mt-4 ">
                    <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('sales.migrasi') }}"
                        method="get">
                        <input type="date" name="date" id="date" class="px-4 rounded-lg"
                            value="{{ request()->get('date') }}" required>
                        <div class="flex gap-x-3">
                            <button
                                class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i
                                    class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                            @if (request()->get('date'))
                                <a href="{{ route('sales.migrasi') }}"
                                    class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i
                                        class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                                <div class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-600"
                                    id="btn-excel"><i class="mr-2 fa-solid fa-file-excel"></i>Excel</div>
                            @endif
                        </div>
                    </form>
                    <div class="flex px-6 gap-x-3">
                        <div class="p-3 bg-white rounded w-fit h-fit">
                            <label for="by_region" class="mr-1 font-semibold text-slate-600">By Region</label>
                            <input type="checkbox" id="by_region" checked>
                        </div>
                        <div class="p-3 bg-white rounded w-fit h-fit">
                            <label for="by_cluster" class="mr-1 font-semibold text-slate-600">By Cluster</label>
                            <input type="checkbox" id="by_cluster" checked>
                        </div>
                        {{-- <div class="p-3 bg-white rounded w-fit h-fit">
                        <label for="by_detail" class="mr-1 font-semibold text-slate-600">By Detail</label>
                        <input type="checkbox" id="by_detail">
                    </div> --}}
                    </div>

                </div>

                <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span>
                <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-region">
                    <table class="text-left border-collapse w-fit">
                        <thead class="border">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase border border-white bg-y_tersier">
                                    No</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Regional</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet MOM</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS MOM</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total MOM</th>
                                {{-- <th class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_region as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border ">{{ $data->regional }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->mtd - $data->ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">
                                        {{ $data->last_mtd - $data->last_ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->outlet_mom }}%</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->last_ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->ds_mom }}%</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->last_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->mom }}%</td>
                                    {{-- <td class="p-3 text-gray-700 border"></td> --}}
                                </tr>
                            @endforeach
                            <tr class="font-bold bg-gray-200">
                                <td colspan="2" class="p-3 text-center text-gray-700 uppercase border border-white ">AREA
                                </td>
                                <td class="p-3 text-gray-700 uppercase border border-white">
                                    {{ $sales_area->mtd - $sales_area->ds_mtd }}
                                </td>
                                <td class="p-3 text-gray-700 uppercase border border-white">
                                    {{ $sales_area->last_mtd - $sales_area->last_ds_mtd }}</td>
                                <td class="p-3 text-gray-700 uppercase border border-white">{{ $sales_area->outlet_mom }}%
                                </td>
                                <td class="p-3 text-gray-700 border border-white">{{ $sales_area->ds_mtd }}</td>
                                <td class="p-3 text-gray-700 border border-white">{{ $sales_area->last_ds_mtd }}</td>
                                <td class="p-3 text-gray-700 border border-white">{{ $sales_area->ds_mom }}%</td>
                                <td class="p-3 text-gray-700 border border-white">{{ $sales_area->mtd }}</td>
                                <td class="p-3 text-gray-700 border border-white">{{ $sales_area->last_mtd }}</td>
                                <td class="p-3 text-gray-700 border border-white">{{ $sales_area->mom }}%</td>
                                {{-- <td class="p-3 text-gray-700 border"></td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>

                <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Branch</span>
                <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-region">
                    <table class="text-left border-collapse w-fit">
                        <thead class="border">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase border border-white bg-y_tersier">
                                    No</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Regional</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Branch</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet MOM</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS MOM</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total MOM</th>
                                {{-- <th class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_branch as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border ">{{ $data->regional }}</td>
                                    <td class="p-3 text-gray-700 uppercase border ">{{ $data->branch }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->mtd - $data->ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">
                                        {{ $data->last_mtd - $data->last_ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->outlet_mom }}%</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->last_ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->ds_mom }}%</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->last_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->mom }}%</td>
                                    {{-- <td class="p-3 text-gray-700 border"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Cluster</span>
                <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-cluster">
                    <table class="text-left border-collapse w-fit">
                        <thead class="border">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase border border-white bg-y_tersier">
                                    No</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Cluster</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet MOM</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS MOM</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total MOM</th>
                                {{-- <th class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_cluster as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border ">{{ $data->cluster }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->mtd - $data->ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">
                                        {{ $data->last_mtd - $data->last_ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->outlet_mom }}%</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->last_ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->ds_mom }}%</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->last_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->mom }}%</td>
                                    {{-- <td class="p-3 text-gray-700 border"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="inline-block mt-6 text-lg font-semibold text-gray-600">Direct Sales Detail</span>
                @if (request()->get('date'))
                    <div class="flex items-end mb-2 gap-x-4">
                        <input type="text" name="search" id="search" placeholder="Search..."
                            class="px-4 rounded-lg">
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
                        <thead class="border">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase border border-white bg-y_tersier">
                                    No</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Cluster</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    TAP</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Nama</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    MOM</th>
                                {{-- <th class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $key => $data)
                                {{-- {{ ddd($data->last_mtd) }} --}}
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border cluster">{{ $data->cluster }}</td>
                                    <td class="p-3 text-gray-700 uppercase border tap">{{ $data->tap }}</td>
                                    <td class="p-3 text-gray-700 uppercase border nama">{{ $data->nama }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->last_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->mom }}%</td>
                                    {{-- <td class="p-3 text-gray-700 border"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="overflow-hidden bg-white rounded-md shadow w-fit" style="display: none">
                    <table class="text-left border-collapse w-fit" id="table-excel">
                        <thead class="border">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase border border-white bg-y_tersier">
                                    No</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Regional</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Branch</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_tersier">
                                    Cluster</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_premier">
                                    Outlet MOM</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-y_sekunder">
                                    DS MOM</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total MTD</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total M-1</th>
                                <th
                                    class="p-3 text-sm font-medium text-gray-100 uppercase border border-white bg-slate-600">
                                    Total MOM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_full as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border ">{{ $data->regional }}</td>
                                    <td class="p-3 text-gray-700 uppercase border ">{{ $data->branch }}</td>
                                    <td class="p-3 text-gray-700 uppercase border ">{{ $data->cluster }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->mtd - $data->ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">
                                        {{ $data->last_mtd - $data->last_ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 uppercase border">{{ $data->outlet_mom }}%</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->last_ds_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->ds_mom }}%</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->last_mtd }}</td>
                                    <td class="p-3 text-gray-700 border">{{ $data->mom }}%</td>
                                    {{-- <td class="p-3 text-gray-700 border"></td> --}}
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
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
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

            $("#btn-excel").click(function() {
                fnExcelReport()
            })

            function fnExcelReport() {
                var tab_text = "<table border='2px'><tr bgcolor='#B90027' style='color:#fff'>";
                var textRange;
                var j = 0;
                tab = document.getElementById('table-excel'); // id of table
                console.log(tab);

                for (j = 0; j < tab.rows.length; j++) {
                    tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
                    //tab_text=tab_text+"</tr>";
                }

                tab_text = tab_text + "</table>";
                tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
                tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
                tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

                var ua = window.navigator.userAgent;
                var msie = ua.indexOf("MSIE ");

                if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer
                {
                    txtArea1.document.open("txt/html", "replace");
                    txtArea1.document.write(tab_text);
                    txtArea1.document.close();
                    txtArea1.focus();
                    sa = txtArea1.document.execCommand("SaveAs", true, "Migrasi.xlsx");
                } else //other browser not tested on IE 11
                    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

                return (sa);
            }

        })
    </script>
@endsection
