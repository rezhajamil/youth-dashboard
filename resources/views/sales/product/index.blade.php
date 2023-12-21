@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4 my-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Sales By Product</h4>
                <span class="text-sm">Update : {{ $update[0]->last_update }}</span>
                <div class="flex justify-between mt-4">
                    <form class="flex flex-wrap items-center mt-4 gap-x-4 gap-y-2" action="{{ route('sales.product') }}"
                        method="get">
                        <input type="date" name="date" id="date" class="px-4 rounded-lg"
                            value="{{ request()->get('date') }}" required>
                        <select name="kategori" id="kategori" class="px-8 rounded-lg" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($list_kategori as $data)
                                <option value="{{ $data->kategori }}"
                                    {{ $data->kategori == request()->get('kategori') ? 'selected' : '' }}>
                                    {{ $data->kategori }}
                                </option>
                            @endforeach
                        </select>
                        @if (auth()->user()->privilege == 'superadmin')
                            <select name="branch" id="branch" class="px-8 rounded-lg">
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
                                class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i
                                    class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                            @if (request()->get('date') || request()->get('kategori'))
                                <a href="{{ route('sales.product') }}"
                                    class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i
                                        class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
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

                <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Sales Product By Region</span>
                <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-region">
                    <table class="text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Regional</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">MTD</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">M-1</th>
                                @if (Request::get('kategori') == 'MY TELKOMSEL')
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Revenue MTD
                                    </th>
                                @endif
                                {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_branch as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-4 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->regional }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->branch }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mtd }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b">{{ $data->last_mtd }}</td>
                                    @if (Request::get('kategori') == 'MY TELKOMSEL')
                                        <td class="p-4 text-gray-700 uppercase border-b">{{ $data->revenue }}</td>
                                    @endif
                                    {{-- <td class="p-4 text-gray-700 border-b"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Sales Product By Cluster</span>
                <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-cluster">
                    <table class="text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">MTD</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">M-1</th>
                                @if (Request::get('kategori') == 'MY TELKOMSEL')
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Revenue MTD
                                    </th>
                                @endif
                                {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_cluster as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-4 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->cluster }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b">{{ $data->mtd }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b">{{ $data->last_mtd }}</td>
                                    @if (Request::get('kategori') == 'MY TELKOMSEL')
                                        <td class="p-4 text-gray-700 uppercase border-b">{{ $data->revenue }}</td>
                                    @endif
                                    {{-- <td class="p-4 text-gray-700 border-b"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="block mt-6 text-lg font-semibold text-gray-600">Sales Product Detail
                    @if (Request::get('kategori') == 'MY TELKOMSEL')
                        (Last Date : {{ $last_validasi[0]->tanggal }})
                    @endif
                </span>

                @if (request()->get('date'))
                    <div class="flex items-end mb-2 gap-x-4">
                        <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
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
                        <div class="px-4 py-2 font-bold text-white transition bg-green-600 rounded-lg hover:bg-green-600"
                            id="btn-excel"><i class="mr-2 fa-solid fa-file-excel"></i>Excel</div>
                    </div>
                @endif

                <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                    <table class="text-left border-collapse w-fit" id="table-excel">
                        <thead class="border-b">
                            <tr>
                                <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Telp</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Role</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jenis</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Detail</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">MSISDN</th>
                                @if (Request::get('kategori') != 'MYTSEL ENTRY' &&
                                        Request::get('kategori') != 'MYTSEL VALIDASI' &&
                                        Request::get('kategori') != 'BYU')
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">No Kompetitor
                                    </th>
                                @endif
                                @if (Request::get('kategori') == 'BYU')
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">POI
                                    </th>
                                @endif
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Tanggal Lapor</th>
                                @if (Request::get('kategori') == 'MYTSEL VALIDASI')
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Revenue</th>
                                @endif
                                {{-- <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">MOM</th> --}}
                                @if (Auth::user()->privilege != 'cluster')
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier action">Action
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-4 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b branch">{{ $data->branch }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b cluster">{{ $data->cluster }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b nama">{{ $data->nama }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b telp">{{ $data->telp }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b role">{{ $data->role }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b whitespace-nowrap jenis">
                                        {{ $data->jenis }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b whitespace-nowrap status">
                                        {{ $data->detail }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b msisdn">{{ $data->msisdn }}</td>
                                    @if (Request::get('kategori') != 'MYTSEL ENTRY' &&
                                            Request::get('kategori') != 'MYTSEL VALIDASI' &&
                                            Request::get('kategori') != 'BYU')
                                        <td class="p-4 text-gray-700 uppercase border-b serial">{{ $data->serial }}</td>
                                    @endif
                                    @if (Request::get('kategori') == 'BYU')
                                        <td class="p-4 text-gray-700 uppercase border-b serial">{{ $data->poi }}</td>
                                    @endif
                                    <td class="p-4 text-gray-700 uppercase border-b aktif">{{ $data->date }}</td>
                                    @if (Request::get('kategori') == 'MYTSEL VALIDASI')
                                        <td class="p-4 text-gray-700 border-b revenue">
                                            {{ $data->revenue == 'NULL' ? '0' : ($data->revenue === null ? 'Belum ada validasi' : number_format($data->revenue, 0, ',', '.')) }}
                                        </td>
                                    @endif
                                    @if (Auth::user()->privilege != 'cluster')
                                        <td class="p-4 text-gray-700 border-b action">
                                            <form action="{{ route('sales.product.destroy', $data->msisdn) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button
                                                    class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
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
                    sa = txtArea1.document.execCommand("SaveAs", true, "Sales Product.xlsx");
                } else //other browser not tested on IE 11
                    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

                return (sa);
            }
        })
    </script>
@endsection
