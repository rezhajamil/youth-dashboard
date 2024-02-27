@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 my-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Sales By Product</h4>
                <span class="text-sm">Update : {{ $update[0]->last_update }}</span>
                <div class="mt-4 flex flex-col gap-y-3">
                    <form class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('sales.product') }}"
                        method="get">
                        <input type="date" name="date" id="date" class="rounded-lg px-4"
                            value="{{ request()->get('date') }}" required>
                        <select name="kategori" id="kategori" class="rounded-lg px-8" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($list_kategori as $data)
                                <option value="{{ $data->kategori }}"
                                    {{ $data->kategori == request()->get('kategori') ? 'selected' : '' }}>
                                    {{ $data->kategori }}
                                </option>
                            @endforeach
                        </select>
                        @if (auth()->user()->privilege == 'superadmin')
                            <select name="regional" id="regional" class="rounded-lg px-8">
                                <option value="" selected disabled>Pilih Region</option>
                                @foreach ($list_regional as $data)
                                    <option value="{{ $data->regional }}"
                                        {{ $data->regional == request()->get('regional') ? 'selected' : '' }}>
                                        {{ $data->regional }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="branch" id="branch" class="rounded-lg px-8">
                                <option value="" selected disabled>Pilih Branch</option>
                                @foreach ($list_branch as $data)
                                    <option value="{{ $data->branch }}"
                                        {{ $data->branch == request()->get('branch') ? 'selected' : '' }}>
                                        {{ $data->branch }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        <div class="flex gap-x-3">
                            <button
                                class="rounded-lg bg-y_premier px-4 py-2 font-bold text-white transition hover:bg-y_premier"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                            @if (request()->get('date') || request()->get('kategori'))
                                <a href="{{ route('sales.product') }}"
                                    class="rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                        class="fa-solid fa-circle-xmark mr-2"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                    <div class="flex gap-x-3">
                        <div class="flex h-fit w-fit flex-nowrap items-center rounded bg-white p-4">
                            <label for="by_region" class="mr-1 whitespace-nowrap font-semibold text-slate-600">By
                                Region</label>
                            <input type="checkbox" id="by_region" checked>
                        </div>
                        <div class="flex h-fit w-fit flex-nowrap items-center rounded bg-white p-4">
                            <label for="by_cluster" class="mr-1 whitespace-nowrap font-semibold text-slate-600">By
                                Cluster</label>
                            <input type="checkbox" id="by_cluster" checked>
                        </div>
                        {{-- <div class="p-4 bg-white rounded w-fit h-fit">
                        <label for="by_detail" class="mr-1 font-semibold text-slate-600">By Detail</label>
                        <input type="checkbox" id="by_detail">
                    </div> --}}
                    </div>
                </div>

                <span class="mb-2 mt-6 block text-lg font-semibold text-gray-600">Sales Product By Region</span>
                <div class="w-fit overflow-hidden rounded-md bg-white shadow" id="table-region">
                    <table class="w-fit border-collapse text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-4 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Regional</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Branch</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">MTD</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">M-1</th>
                                @if (Request::get('kategori') == 'MY TELKOMSEL')
                                    <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Revenue MTD
                                    </th>
                                @endif
                                {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_branch as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border-b p-4 font-bold text-gray-700">{{ $key + 1 }}</td>
                                    <td class="border-b p-4 uppercase text-gray-700">{{ $data->regional }}</td>
                                    <td class="border-b p-4 uppercase text-gray-700">{{ $data->branch }}</td>
                                    <td class="border-b p-4 uppercase text-gray-700">{{ $data->mtd }}</td>
                                    <td class="border-b p-4 uppercase text-gray-700">{{ $data->last_mtd }}</td>
                                    @if (Request::get('kategori') == 'MY TELKOMSEL')
                                        <td class="border-b p-4 uppercase text-gray-700">{{ $data->revenue }}</td>
                                    @endif
                                    {{-- <td class="p-4 text-gray-700 border-b"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="mb-2 mt-6 block text-lg font-semibold text-gray-600">Sales Product By Cluster</span>
                <div class="w-fit overflow-hidden rounded-md bg-white shadow" id="table-cluster">
                    <table class="w-fit border-collapse text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-4 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Cluster</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">MTD</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">M-1</th>
                                @if (Request::get('kategori') == 'MY TELKOMSEL')
                                    <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Revenue MTD
                                    </th>
                                @endif
                                {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_cluster as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border-b p-4 font-bold text-gray-700">{{ $key + 1 }}</td>
                                    <td class="border-b p-4 uppercase text-gray-700">{{ $data->cluster }}</td>
                                    <td class="border-b p-4 uppercase text-gray-700">{{ $data->mtd }}</td>
                                    <td class="border-b p-4 uppercase text-gray-700">{{ $data->last_mtd }}</td>
                                    @if (Request::get('kategori') == 'MY TELKOMSEL')
                                        <td class="border-b p-4 uppercase text-gray-700">{{ $data->revenue }}</td>
                                    @endif
                                    {{-- <td class="p-4 text-gray-700 border-b"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="mt-6 block text-lg font-semibold text-gray-600">Sales Product Detail
                    @if (Request::get('kategori') == 'MY TELKOMSEL')
                        (Last Date : {{ $last_validasi[0]->tanggal }})
                    @endif
                </span>

                @if (request()->get('date'))
                    <div class="mb-2 flex items-end gap-x-4">
                        <input type="text" name="search" id="search" placeholder="Search..." class="rounded-lg px-4">
                        <div class="flex flex-col">
                            <span class="font-bold text-gray-600">Berdasarkan</span>
                            <select name="search_by" id="search_by" class="rounded-lg">
                                <option value="cluster">Cluster</option>
                                <option value="msisdn">MSISDN</option>
                                <option value="nama">Nama</option>
                                <option value="telp">Telp</option>
                                <option value="reff">Reff Code</option>
                                <option value="status">Status</option>
                                <option value="aktif">Tanggal Lapor</option>
                            </select>
                        </div>
                        <div class="cursor-pointer rounded-lg bg-green-600 px-4 py-2 font-bold text-white transition hover:bg-green-600"
                            id="btn-excel"><i class="fa-solid fa-file-excel mr-2"></i>Excel</div>
                    </div>
                @endif

                <div class="w-fit overflow-hidden rounded-md bg-white shadow" id="table-excel-container">
                    <table class="w-fit border-collapse text-left" id="table-excel">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-4 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Branch</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Cluster</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Nama</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Telp</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Role</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Jenis</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Detail</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">MSISDN</th>
                                @if (Request::get('kategori') != 'MYTSEL ENTRY' &&
                                        Request::get('kategori') != 'MYTSEL VALIDASI' &&
                                        Request::get('kategori') != 'BYU')
                                    <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">No Kompetitor
                                    </th>
                                @endif
                                @if (Request::get('kategori') == 'BYU')
                                    <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">POI
                                    </th>
                                @endif
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Tanggal Lapor</th>
                                @if (Request::get('kategori') == 'MYTSEL VALIDASI')
                                    <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Revenue</th>
                                @endif
                                {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">MOM</th> --}}
                                @if (Auth::user()->privilege != 'cluster')
                                    <th class="action bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Action
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border-b p-4 font-bold text-gray-700">{{ $key + $sales->firstItem() }}
                                    </td>
                                    <td class="branch border-b p-4 uppercase text-gray-700">{{ $data->branch }}</td>
                                    <td class="cluster border-b p-4 uppercase text-gray-700">{{ $data->cluster }}</td>
                                    <td class="nama border-b p-4 uppercase text-gray-700">{{ $data->nama }}</td>
                                    <td class="telp border-b p-4 uppercase text-gray-700">{{ $data->telp }}</td>
                                    <td class="role border-b p-4 uppercase text-gray-700">{{ $data->role }}</td>
                                    <td class="jenis whitespace-nowrap border-b p-4 uppercase text-gray-700">
                                        {{ $data->jenis }}</td>
                                    <td class="status whitespace-nowrap border-b p-4 uppercase text-gray-700">
                                        {{ $data->detail }}</td>
                                    <td class="msisdn border-b p-4 uppercase text-gray-700">{{ $data->msisdn }}</td>
                                    @if (Request::get('kategori') != 'MYTSEL ENTRY' &&
                                            Request::get('kategori') != 'MYTSEL VALIDASI' &&
                                            Request::get('kategori') != 'BYU')
                                        <td class="serial border-b p-4 uppercase text-gray-700">{{ $data->serial }}</td>
                                    @endif
                                    @if (Request::get('kategori') == 'BYU')
                                        <td class="serial border-b p-4 uppercase text-gray-700">{{ $data->poi }}</td>
                                    @endif
                                    <td class="aktif border-b p-4 uppercase text-gray-700">{{ $data->date }}</td>
                                    @if (Request::get('kategori') == 'MYTSEL VALIDASI')
                                        <td class="revenue border-b p-4 text-gray-700">
                                            {{ $data->revenue == 'NULL' ? '0' : ($data->revenue === null ? 'Belum ada validasi' : number_format($data->revenue, 0, ',', '.')) }}
                                        </td>
                                    @endif
                                    @if (Auth::user()->privilege != 'cluster')
                                        <td class="action border-b p-4 text-gray-700">
                                            <form action="{{ route('sales.product.destroy', $data->msisdn) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button
                                                    class="my-1 block text-left text-base font-semibold text-red-600 transition hover:text-red-800">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $sales->links('components.pagination', ['data' => $sales]) }}
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    {{-- <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> --}}
    <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
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
                // var tab_text = "<table border='2px'><tr bgcolor='#B90027' style='color:#fff'>";
                // var textRange;
                // var j = 0;
                // tab = document.getElementById('table-excel'); // id of table
                // console.log(tab);

                // for (j = 0; j < tab.rows.length; j++) {
                //     tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
                //     //tab_text=tab_text+"</tr>";
                // }

                // tab_text = tab_text + "</table>";
                // tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
                // tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
                // tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

                // var ua = window.navigator.userAgent;
                // var msie = ua.indexOf("MSIE ");

                // if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer
                // {
                //     txtArea1.document.open("txt/html", "replace");
                //     txtArea1.document.write(tab_text);
                //     txtArea1.document.close();
                //     txtArea1.focus();
                //     sa = txtArea1.document.execCommand("SaveAs", true, "Sales Product.xlsx");
                // } else //other browser not tested on IE 11
                //     sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

                // return (sa);
                $(`#table-excel-container`).table2excel({
                    exclude: ".action, .tooltip-text",
                    filename: "download.xls",
                    fileext: ".xls",
                    filename: "Sales By Product" + ".xls",
                    exclude_links: true,
                    exclude_inputs: true,
                });
            }
        })
    </script>
@endsection
