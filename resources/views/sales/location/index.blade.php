@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4 my-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Sales By Location</h4>
                {{-- <span class="text-sm">Update : {{ $update[0]->last_update }}</span> --}}
                <div class="flex justify-between mt-4">
                    <form class="flex flex-wrap items-center mt-4 gap-x-4 gap-y-2" action="{{ route('sales.location') }}"
                        method="get">
                        <input type="date" name="date" id="date" class="px-4 rounded-lg"
                            value="{{ request()->get('date') }}" required>
                        <select name="location" id="location" class="px-8 rounded-lg" required>
                            <option value="" selected disabled>Pilih Location</option>
                            @foreach ($list_location as $data)
                                <option value="{{ $data->location }}"
                                    {{ $data->location == request()->get('location') ? 'selected' : '' }}>
                                    {{ $data->location }}
                                </option>
                            @endforeach
                        </select>
                        <div class="flex gap-x-3">
                            <button
                                class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i
                                    class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                            @if (request()->get('date') || request()->get('kategori'))
                                <a href="{{ route('sales.location') }}"
                                    class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i
                                        class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <span class="block mt-6 text-lg font-semibold text-gray-600">Sales Location Detail </span>

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
                            </select>
                        </div>
                        <button id="button"
                            class="inline-block px-4 py-2 mx-3 font-semibold text-white transition-all bg-teal-600 rounded-md hover:bg-teal-800"><i
                                class="mr-2 fa-solid fa-file-arrow-down"></i>Excel</button>
                    </div>
                @endif

                <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                    <table class="text-left border-collapse w-fit" id="table-data">
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
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Tanggal Lapor</th>
                                {{-- @if (Auth::user()->privilege != 'cluster')
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier action">Action
                                    </th>
                                @endif --}}
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
                                    <td class="p-4 text-gray-700 uppercase border-b aktif">{{ $data->date }}</td>

                                    {{-- @if (Auth::user()->privilege != 'cluster')
                                        <td class="p-4 text-gray-700 border-b action">
                                            <form action="{{ route('sales.location.destroy', $data->msisdn) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button
                                                    class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
                                            </form>
                                        </td>
                                    @endif --}}
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

            function fnExcelReport() {
                var tab_text = "<table border='2px'><tr bgcolor='#B90027' style='color:#fff'>";
                var textRange;
                var j = 0;
                tab = document.getElementById('table-data'); // id of table

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
                    sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xlss");
                } else //other browser not tested on IE 11
                    console.log(tab_text);
                sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

                return (sa);
            }

            $('#button').click(function() {
                $(".action").hide()
                fnExcelReport();
                $(".action").show()
            })


        })
    </script>
@endsection
