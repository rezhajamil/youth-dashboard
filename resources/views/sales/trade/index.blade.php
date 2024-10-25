@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Report Trade In Buddies</h4>

                <div class="flex flex-wrap items-end mb-2 gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="regional">Regional</option>
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                            <option value="nama">Nama</option>
                            <option value="user_id">User ID</option>
                            <option value="msisdn">Msisdn</option>
                        </select>
                    </div>
                </div>

                <button id="btn-excel"
                    class="inline-block px-4 py-2 my-2 font-semibold text-white transition-all bg-teal-600 rounded-md hover:bg-teal-800">
                    <i class="mr-2 fa-solid fa-file-arrow-down"></i>Excel
                </button>

                <div class="overflow-auto bg-white rounded-md shadow w-fit" id="table-container">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Regional</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">City</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">User ID</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Role</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">TAP</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Agent ID</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">MSISDN</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kompetitor</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Paket</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $d)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border-b whitespace-nowrap">{{ $key + 1 }}
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border-b regional whitespace-nowrap">
                                        {{ $d->regional }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b branch whitespace-nowrap">
                                        {{ $d->branch }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b cluster whitespace-nowrap">
                                        {{ $d->cluster }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b city whitespace-nowrap">
                                        {{ $d->city }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b nama whitespace-nowrap">
                                        {{ $d->user_name }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b user_id whitespace-nowrap">
                                        {{ $d->user_id }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b role whitespace-nowrap">
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border-b tap whitespace-nowrap">
                                    </td>
                                    <td class="p-3 text-gray-700 uppercase border-b agent_id whitespace-nowrap">
                                        {{ $d->agent_id }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b msisdn whitespace-nowrap">
                                        {{ $d->msisdn }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b kompetitor whitespace-nowrap">
                                        {{ $d->kompetitor }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b paket whitespace-nowrap">
                                        {{ $d->paket }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b date whitespace-nowrap">
                                        {{ $d->date }}</td>
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

            $("#btn-excel").click(function() {
                exportTableToExcel('table-container', `Report Trade In Buddies`);
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

            function exportTableToExcel(tableID, filename = '') {
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById(tableID);
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

                // Specify file name
                filename = filename ? filename + '.xls' : 'excel_data.xls';

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
