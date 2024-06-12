@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Report Trade In Buddies</h4>

                <div class="mb-2 flex flex-wrap items-end gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="rounded-lg px-4">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="regional">Regional</option>
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                            <option value="nama">Nama</option>
                            <option value="user_id">User ID</option>
                            <option value="user_id">User ID</option>
                            <option value="msisdn">Msisdn</option>
                        </select>
                    </div>
                </div>

                <button id="btn-excel"
                    class="my-2 inline-block rounded-md bg-teal-600 px-4 py-2 font-semibold text-white transition-all hover:bg-teal-800">
                    <i class="fa-solid fa-file-arrow-down mr-2"></i>Excel
                </button>

                <div class="w-fit overflow-auto rounded-md bg-white shadow" id="table-container">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">No</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Regional</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Branch</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Cluster</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">City</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Nama</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">User ID</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Agent ID</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">MSISDN</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Kompetitor</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Paket</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $d)
                                <tr class="hover:bg-gray-200">
                                    <td class="whitespace-nowrap border-b p-3 font-bold text-gray-700">{{ $key + 1 }}
                                    </td>
                                    <td class="regional whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->regional }}</td>
                                    <td class="branch whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->branch }}</td>
                                    <td class="cluster whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->cluster }}</td>
                                    <td class="city whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->city }}</td>
                                    <td class="nama whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->user_name }}</td>
                                    <td class="user_id whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->user_id }}</td>
                                    <td class="agent_id whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->agent_id }}</td>
                                    <td class="msisdn whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->msisdn }}</td>
                                    <td class="kompetitor whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->kompetitor }}</td>
                                    <td class="paket whitespace-nowrap border-b p-3 uppercase text-gray-700">
                                        {{ $d->paket }}</td>
                                    <td class="date whitespace-nowrap border-b p-3 uppercase text-gray-700">
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
