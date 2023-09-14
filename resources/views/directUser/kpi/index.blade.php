@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <div class="flex items-end mb-6 gap-x-3">
                    <div class="pr-4 border-r-4 border-slate-600">
                        <form action="{{ route('direct_user.kpi') }}" method="get">
                            <input type="date" name="date" id="date" class="px-4 rounded-lg"
                                value="{{ request()->get('date') }}" required>
                            <button type="submit"
                                class="inline-block px-4 py-2 mt-2 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-sky-800"><i
                                    class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        </form>
                    </div>
                    <input type="text" name="search" id="search" placeholder="Filter..." class="px-4 rounded-lg">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                            <option value="nama">Nama</option>
                            <option value="id_digipos">ID Digipos</option>
                            <option value="role">Role</option>
                        </select>
                    </div>
                    @if (count($detail))
                        <button id="btn-excel"
                            class="inline-block px-4 py-2 font-semibold text-white transition-all bg-teal-600 rounded-md hover:bg-teal-800"><i
                                class="mr-2 fa-solid fa-file-arrow-down"></i>Excel
                        </button>
                    @endif
                </div>

                {{-- <div class="flex flex-wrap items-end mb-2 gap-x-4">
            </div> --}}

                <div class="mb-10 overflow-auto bg-white rounded-md shadow w-fit" id="table-container">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th rowspan="2" class="p-3 font-bold text-gray-100 uppercase border bg-y_premier">No</th>
                                <th rowspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">
                                    Branch</th>
                                <th rowspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">
                                    Cluster</th>
                                <th rowspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">Nama
                                </th>
                                <th rowspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">ID
                                    Digipos
                                </th>
                                <th rowspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">Role
                                </th>

                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                    Broadband</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                    Digital</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Orbit
                                </th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                    Migrasi</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">BYU
                                </th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">My
                                    Telkomsel</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Sales</th>

                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Update
                                    Data</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Update
                                    PJP Harian</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Survey
                                    Market</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Product
                                    Knowledge</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Proses</th>

                                <th class="p-3 font-medium text-gray-100 uppercase bg-black border">Total</th>
                            </tr>
                            <tr>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['broadband']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['broadband']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['digital']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['digital']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['orbit']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['orbit']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['migrasi']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['migrasi']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['byu']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['byu']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['mytsel']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['mytsel']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $sales }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['update_data']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['update_data']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['pjp']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['pjp']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['survey']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['survey']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['quiz']['target'] }}</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $list_target['quiz']['bobot'] }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $proses }}%</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    {{ $sales + $proses }}%</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($detail as $key => $data)
                                <tr class="">
                                    <td class="p-2 font-bold border">{{ $key + 1 }}</td>
                                    <td class="p-2 border branch">{{ $data->branch }}</td>
                                    <td class="p-2 border cluster">{{ $data->cluster }}</td>
                                    <td class="p-2 border nama">{{ $data->nama }}</td>
                                    <td class="p-2 border id_digipos">{{ $data->id_digipos }}</td>
                                    <td class="p-2 border role">{{ $data->role }}</td>

                                    <td class="p-2 border">{{ $data->broadband ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_broadband ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->digital ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_digital ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->orbit ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_orbit ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->migrasi ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_migrasi ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->byu ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_byu ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->mytsel ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_mytsel ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->tot_sales }}%</td>

                                    <td class="p-2 border">{{ $data->update_data ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_update_data ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->pjp ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_pjp ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->survey ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_survey ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->quiz ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->ach_quiz ?? '-' }}%</td>
                                    <td class="p-2 border">{{ $data->tot_proses }}%</td>
                                    <td class="p-2 border">{{ $data->total }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col p-4 bg-white rounded shadow-sm gap-y-2 w-fit">
                    <span class="text-sm">Last Migrasi : {{ $last_migrasi->date }}</span>
                    <span class="text-sm">Last Orbit : {{ $last_orbit->date }}</span>
                    <span class="text-sm">Last Sales : {{ $last_sales->date }}</span>
                    <span class="text-sm">Last Trx Digipos : {{ $last_digipos->date }}</span>
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
                $(".action").hide()
                exportTableToExcel('table-container', 'Data KPI');
                $(".action").show()
            });

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
        })
    </script>
@endsection
