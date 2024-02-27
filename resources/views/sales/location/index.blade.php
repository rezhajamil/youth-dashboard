@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 my-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Sales By Location</h4>
                {{-- <span class="text-sm">Update : {{ $update[0]->last_update }}</span> --}}
                <div class="mt-4 flex justify-between">
                    <form class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('sales.location') }}"
                        method="get">
                        <input type="date" name="date" id="date" class="rounded-lg px-4"
                            value="{{ request()->get('date') }}" required>
                        <select name="jenis" id="jenis" class="rounded-lg px-8" required>
                            <option value="" selected disabled>Pilih Jenis</option>
                            @foreach ($list_jenis as $data)
                                <option value="{{ $data->jenis }}"
                                    {{ $data->jenis == request()->get('jenis') ? 'selected' : '' }}>
                                    {{ $data->jenis }}
                                </option>
                            @endforeach
                        </select>
                        <select name="location" id="location" class="rounded-lg px-8">
                            <option value="" selected disabled>Pilih Location</option>
                            <option value="{{ request()->get('location') }}"
                                {{ request()->get('location') ? 'selected' : '' }}>
                                {{ request()->get('location') }}
                            </option>
                        </select>
                        <div class="flex gap-x-3">
                            <button
                                class="rounded-lg bg-y_premier px-4 py-2 font-bold text-white transition hover:bg-y_premier"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                            @if (request()->get('date') || request()->get('kategori'))
                                <a href="{{ route('sales.location') }}"
                                    class="rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                        class="fa-solid fa-circle-xmark mr-2"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- 
                <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Sales Location By Kategori</span>
                <div class="overflow-hidden bg-white rounded-md shadow w-fit" id="table-category">
                    <table class="text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kategori</th>
                                @foreach (array_unique(array_column($sales_kategori, 'date')) as $date)
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">
                                        {{ date('d M', strtotime($date)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (array_unique(array_column($sales_kategori, 'kategori')) as $key => $kategori)
                                <tr class="hover:bg-gray-200">
                                    <th class="p-4 font-bold text-gray-700 border-b">{{ $kategori }}</th>
                                    @foreach (array_unique(array_column($sales_kategori, 'date')) as $date)
                                        @php
                                            $entry = current(
                                                array_filter($sales_kategori, function ($item) use ($date, $kategori) {
                                                    return $item->date == $date && $item->kategori == $kategori;
                                                }),
                                            );
                                            $mtd = $entry ? $entry->mtd : '-'; // MTD value if entry exists
                                        @endphp
                                        <td class="p-4 text-gray-700 uppercase border-b">{{ $mtd }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}

                <span class="mt-6 block text-lg font-semibold text-gray-600">Sales Location Detail </span>

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
                            </select>
                        </div>
                        <button id="button"
                            class="mx-3 inline-block rounded-md bg-teal-600 px-4 py-2 font-semibold text-white transition-all hover:bg-teal-800"><i
                                class="fa-solid fa-file-arrow-down mr-2"></i>Excel</button>
                    </div>
                @endif

                <div class="w-fit overflow-hidden rounded-md bg-white shadow">
                    <table class="w-fit border-collapse text-left" id="table-data">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-4 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Branch</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Cluster</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Nama</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Telp</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Role</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Jenis</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Kategori</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Detail</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">POI</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Jarak</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Status</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">MSISDN</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Serial</th>
                                <th class="bg-y_tersier p-4 text-sm font-medium uppercase text-gray-100">Tanggal Lapor</th>
                                {{-- @if (Auth::user()->privilege != 'cluster')
                                    <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier action">Action
                                    </th>
                                @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="border-b p-4 font-bold text-gray-700">{{ $key + 1 }}</td>
                                    <td class="branch border-b p-4 uppercase text-gray-700">{{ $data->branch }}</td>
                                    <td class="cluster border-b p-4 uppercase text-gray-700">{{ $data->cluster }}</td>
                                    <td class="nama border-b p-4 uppercase text-gray-700">{{ $data->nama }}</td>
                                    <td class="telp border-b p-4 uppercase text-gray-700">{{ $data->telp }}</td>
                                    <td class="role border-b p-4 uppercase text-gray-700">{{ $data->role }}</td>
                                    <td class="jenis whitespace-nowrap border-b p-4 uppercase text-gray-700">
                                        {{ $data->jenis }}</td>
                                    <td class="kategori whitespace-nowrap border-b p-4 uppercase text-gray-700">
                                        {{ $data->kategori }}</td>
                                    <td class="detail whitespace-nowrap border-b p-4 uppercase text-gray-700">
                                        {{ $data->detail }}</td>
                                    <td class="poi whitespace-nowrap border-b p-4 uppercase text-gray-700">
                                        {{ $data->poi }}</td>
                                    <td class="jarak whitespace-nowrap border-b p-4 uppercase text-gray-700">
                                        {{ $data->jarak }} Km</td>
                                    <td class="status whitespace-nowrap border-b p-4 uppercase text-gray-700">
                                        {{ $data->status }}</td>
                                    <td class="msisdn border-b p-4 uppercase text-gray-700">{{ $data->msisdn }}</td>
                                    <td class="border-b p-4 uppercase text-gray-700">{{ $data->serial }}</td>
                                    <td class="aktif border-b p-4 uppercase text-gray-700">{{ $data->date }}</td>

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


            $("#jenis, #date").on('change', () => {
                var jenis = $("#jenis").val();
                var date = $("#date").val();
                console.log({
                    jenis,
                    date
                });
                $.ajax({
                    url: "{{ route('sales.get_location') }}",
                    method: "GET",
                    dataType: "JSON",
                    data: {
                        privilege: "{{ auth()->user()->privilege }}",
                        branch: "{{ auth()->user()->branch }}",
                        cluster: "{{ auth()->user()->cluster }}",
                        jenis: jenis,
                        date: date,
                        _token: "{{ csrf_token() }}"
                    }

                    ,
                    success: (data) => {
                        console.log(data);
                        $("#location").html(
                            "<option value='' selected disabled>Pilih Location</option>" +
                            data.map((item) => {
                                return `
                            <option value="${item.location}">${item.location}</option>
                            `
                            })

                        )
                    },
                    error: (e) => {
                        console.log(e)
                        console.log('error');
                    }
                });

            })
        })
    </script>
@endsection
