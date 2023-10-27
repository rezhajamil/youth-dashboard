@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4 my-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Hasil Input Stok ByU Legacy</h4>

                <div class="flex justify-between mt-4 flex-nowrap">
                    <form class="flex items-center flex-nowrap gap-x-4 gap-y-2" action="{{ route('byu.stok.view') }}"
                        method="get">
                        <input type="date" name="start_date" id="start_date" class="px-4 rounded-lg"
                            value="{{ request()->get('start_date') }}" required>
                        <span class="">s/d</span>
                        <input type="date" name="end_date" id="end_date" class="px-4 rounded-lg"
                            value="{{ request()->get('end_date') }}" required>
                        <div class="flex items-center gap-x-3">
                            <button
                                class="px-4 py-2 font-bold text-white transition rounded-lg h-fit whitespace-nowrap bg-y_premier hover:bg-y_premier"><i
                                    class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                            @if (request()->get('start_date'))
                                <a href="{{ route('byu.stok.view') }}"
                                    class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg h-fit whitespace-nowrap hover:bg-gray-800"><i
                                        class="mr-2 fa-solid fa-circle-xmark"></i>Reset
                                </a>
                                <button id="btn-excel"
                                    class="inline-block px-4 py-2 my-2 font-semibold text-white transition-all bg-teal-600 rounded-md h-fit whitespace-nowrap hover:bg-teal-800">
                                    <i class="mr-2 fa-solid fa-file-arrow-down"></i>Excel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="my-4 overflow-hidden bg-white rounded-md shadow w-fit" id="table-container">
                    <table class="text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Tanggal</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Region</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">City</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stok as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->date }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->regional }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->branch }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->cluster }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->city }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b">{{ $data->jumlah }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-300">
                                <td class="font-bold text-center uppercase border border-white " colspan="5">Total</td>
                                <td class="p-4 font-bold text-gray-700 uppercase border-b">{{ $total }}</td>
                            </tr>
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
                exportTableToExcel('table-container', `Hasil Input Stok ByU Legacy`);
            });

            function exportTableToExcel(tableID, filename = '') {
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById(tableID);
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

                // Specify file name
                filename = filename ? filename + '.xlsx' : 'excel_data.xlsx';

                // Create download link element
                downloadLink = document.createElement("a");

                document.body.appendChild(downloadLink);

                if (navigator.msSaveOrOpenBlob) {
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob(blob, filename);
                } else {
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                    // Setting the file name
                    downloadLink.download = filename;

                    //triggering the function
                    downloadLink.click();
                }
            }
        })
    </script>
@endsection
