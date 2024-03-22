@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <div class="mb-6 flex items-end gap-x-3">
                    <div class="border-r-4 border-slate-600 pr-4">
                        <form action="{{ route('direct_user.kpi') }}" method="get">
                            <input type="date" name="date" id="date" class="rounded-lg px-4"
                                value="{{ request()->get('date') }}" required>
                            @if (request()->get('role'))
                                <input type="hidden" name="role" value="{{ request()->get('role') }}" />
                            @endif
                            <button type="submit"
                                class="mt-2 inline-block rounded-md bg-y_premier px-4 py-2 font-bold text-white transition-all hover:bg-sky-800"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                        </form>
                    </div>
                    <input type="text" name="search" id="search" placeholder="Filter..." class="rounded-lg px-4">
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
                            class="inline-block rounded-md bg-teal-600 px-4 py-2 font-semibold text-white transition-all hover:bg-teal-800"><i
                                class="fa-solid fa-file-arrow-down mr-2"></i>Excel
                        </button>
                    @endif
                </div>

                {{-- <div class="flex flex-wrap items-end mb-2 gap-x-4">
            </div> --}}

                <div class="mb-10 w-fit overflow-auto rounded-md bg-white shadow" id="table-container">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b">
                            <tr>
                                <th rowspan="2" class="border bg-y_premier p-3 font-bold uppercase text-gray-100">No</th>
                                <th rowspan="2" class="border bg-y_premier p-3 font-medium uppercase text-gray-100">
                                    Branch</th>
                                <th rowspan="2" class="border bg-y_premier p-3 font-medium uppercase text-gray-100">
                                    Cluster</th>
                                <th rowspan="2" class="border bg-y_premier p-3 font-medium uppercase text-gray-100">Nama
                                </th>
                                <th rowspan="2" class="border bg-y_premier p-3 font-medium uppercase text-gray-100">ID
                                    Digipos
                                </th>
                                <th rowspan="2" class="border bg-y_premier p-3 font-medium uppercase text-gray-100">Role
                                </th>

                                <th colspan="2" class="border bg-y_tersier p-3 font-medium uppercase text-gray-100">
                                    Broadband</th>
                                <th colspan="2" class="border bg-y_tersier p-3 font-medium uppercase text-gray-100">
                                    Digital</th>
                                <th colspan="2" class="border bg-y_tersier p-3 font-medium uppercase text-gray-100">Sales
                                    Acquisition</th>
                                <th class="border bg-y_tersier p-3 font-medium uppercase text-gray-100">Sales</th>

                                <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">Update
                                    Data</th>
                                <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">Update
                                    PJP Harian</th>
                                <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">Survey
                                    Market</th>
                                <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">My
                                    Telkomsel</th>
                                <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">Product
                                    Knowledge</th>
                                <th class="border bg-tersier p-3 font-medium uppercase text-gray-100">Proses</th>

                                <th class="border bg-black p-3 font-medium uppercase text-gray-100">Total</th>
                            </tr>
                            <tr>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['broadband']['target'] }}</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['broadband']['bobot'] }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['digital']['target'] }}</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['digital']['bobot'] }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['sales_acquisition']['target'] }}</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['sales_acquisition']['bobot'] }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $sales }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['update_data']['target'] }}</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['update_data']['bobot'] }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['pjp']['target'] }}</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['pjp']['bobot'] }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['survey']['target'] }}</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['survey']['bobot'] }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['mytsel']['target'] }}</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['mytsel']['bobot'] }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['quiz']['target'] }}</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $list_target['quiz']['bobot'] }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $proses }}%</th>
                                <th class="border bg-slate-400 p-3 font-medium uppercase text-gray-100">
                                    {{ $sales + $proses }}%</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($detail as $key => $data)
                                <tr class="">
                                    <td class="border p-2 font-bold">{{ $key + 1 }}</td>
                                    <td class="branch border p-2">{{ $data->branch }}</td>
                                    <td class="cluster border p-2">{{ $data->cluster }}</td>
                                    <td class="nama border p-2">{{ $data->nama }}</td>
                                    <td class="id_digipos border p-2">{{ $data->id_digipos }}</td>
                                    <td class="role border p-2">{{ $data->role }}</td>

                                    <td class="border p-2">{{ $data->broadband ?? '-' }}</td>
                                    <td class="border p-2">{{ $data->ach_broadband ?? '-' }}%</td>
                                    <td class="border p-2">{{ $data->digital ?? '-' }}</td>
                                    <td class="border p-2">{{ $data->ach_digital ?? '-' }}%</td>
                                    <td class="border p-2">{{ $data->sales_acquisition ?? '-' }}</td>
                                    <td class="border p-2">{{ $data->ach_sales_acquisition ?? '-' }}%</td>
                                    <td class="border p-2">{{ $data->tot_sales }}%</td>

                                    <td class="border p-2">{{ $data->update_data ?? '-' }}</td>
                                    <td class="border p-2">{{ $data->ach_update_data ?? '-' }}%</td>
                                    <td class="border p-2">{{ $data->pjp ?? '-' }}</td>
                                    <td class="border p-2">{{ $data->ach_pjp ?? '-' }}%</td>
                                    <td class="border p-2">{{ $data->survey ?? '-' }}</td>
                                    <td class="border p-2">{{ $data->ach_survey ?? '-' }}%</td>
                                    <td class="border p-2">{{ $data->mytsel ?? '-' }}</td>
                                    <td class="border p-2">{{ $data->ach_mytsel ?? '-' }}%</td>
                                    <td class="border p-2">{{ $data->quiz ?? '-' }}</td>
                                    <td class="border p-2">{{ $data->ach_quiz ?? '-' }}%</td>
                                    <td class="border p-2">{{ $data->tot_proses }}%</td>
                                    <td class="border p-2">{{ $data->total }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex w-fit flex-col gap-y-2 rounded bg-white p-4 shadow-sm">
                    <span class="text-sm">Last Sales : {{ $last_sales->date }}</span>
                    <span class="text-sm">Last Trx Digipos : {{ $last_digipos->date }}</span>
                    <span class="text-sm">Last Acquisition : {{ $last_acquisition->date }}</span>
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
