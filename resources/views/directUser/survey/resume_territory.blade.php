@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4 overflow-y-auto">
                <a href="{{ url()->previous() }}"
                    class="block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier w-fit hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
                <h4 class="inline-block mb-2 text-xl font-bold text-gray-600 align-baseline" id="title">
                    {{ $survey->nama }}</h4>
                {{-- <button class="px-2 py-1 ml-2 text-lg text-white transition bg-green-600 rounded-md hover:bg-green-800" id="capture"><i class="fa-regular fa-circle-down"></i></button> --}}
                <div class="flex items-center gap-x-3">
                    <form action="{{ route('survey.resume_territory', $survey->id) }}" method="get">
                        <input class="rounded" type="date" name="start_date" id="start_date"
                            value="{{ Request::get('start_date') }}" required>
                        <span class="inline-block mx-2 font-bold">s/d</span>
                        <input class="rounded" type="date" name="end_date" id="end_date"
                            value="{{ Request::get('end_date') }}" required>
                        <button type="submit"
                            class="inline-block px-4 py-2 my-2 ml-3 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-y_premier">Ganti
                            Tanggal</button>
                    </form>
                </div>
                <input type="hidden" name="operator" id="operator" value="{{ json_encode($operator) }}">
                <input type="hidden" name="kode_operator" id="kode_operator" value="{{ json_encode($kode_operator) }}">
                <input type="hidden" name="survey" id="survey" value="{{ json_encode($survey) }}">
                <input type="hidden" name="resume" id="resume" value="{{ json_encode($resume) }}">
                <input type="hidden" name="region" id="region" value="{{ json_encode($region) }}">
                <input type="hidden" name="branch" id="branch" value="{{ json_encode($branch) }}">
                <input type="hidden" name="cluster" id="cluster" value="{{ json_encode($cluster) }}">
                <input type="hidden" name="city" id="city" value="{{ json_encode($city) }}">

                <div class="mt-6 mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="region-operator-container">
                    <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-region-operator">
                        <thead class="border-b">
                            <tr class="border-b" id="row-region-operator">
                                <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase border bg-y_tersier"
                                    id="col-lainnya">Lainnya</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-region-operator">
                            <tr id="load-region-operator" class="font-semibold text-center text-white bg-tersier"
                                style="display: none">
                                <td colspan="8">Memuat Data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="branch-operator-container">
                    <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-branch-operator">
                        <thead class="border-b">
                            <tr class="border-b" id="row-branch-operator">
                                <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase border bg-y_tersier"
                                    id="col-lainnya">Lainnya</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-branch-operator">
                            <tr id="load-branch-operator" class="font-semibold text-center text-white bg-tersier"
                                style="display: none">
                                <td colspan="8">Memuat Data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="cluster-operator-container">
                    <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-cluster-operator">
                        <thead class="border-b">
                            <tr class="border-b" id="row-cluster-operator">
                                <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase border bg-y_tersier"
                                    id="col-lainnya">Lainnya</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-cluster-operator">
                            <tr id="load-cluster-operator" class="font-semibold text-center text-white bg-tersier"
                                style="display: none">
                                <td colspan="8">Memuat Data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="city-operator-container">
                    <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-city-operator">
                        <thead class="border-b">
                            <tr class="border-b" id="row-city-operator">
                                <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase border bg-y_tersier"
                                    id="col-lainnya">Lainnya</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-city-operator">
                            <tr id="load-city-operator" class="font-semibold text-center text-white bg-tersier"
                                style="display: none">
                                <td colspan="8">Memuat Data...</td>
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
            let title = $("#title").val();
            let resume = JSON.parse($('#resume').val());
            let operator = JSON.parse($('#operator').val());
            let kode_operator = JSON.parse($('#kode_operator').val());
            let survey = JSON.parse($('#survey').val());
            let region = JSON.parse($('#region').val());
            let branch = JSON.parse($('#branch').val());
            let cluster = JSON.parse($('#cluster').val());
            let city = JSON.parse($('#city').val());
            let school, pos, html, chartBar;

            console.log({
                resume,
                operator,
                kode_operator,
                survey,
                region,
                branch,
                cluster,
                city
            });

            $("#btn-excel").click(function() {
                exportTableToExcel('operator-container', `${title}`);
            });

            operator.map((data, idx) => {
                $("#row-region-operator").prepend(
                    `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier" id="col-${data.operator.toString().toLowerCase()}">${data.operator}</th>`
                );
                $("#row-branch-operator").prepend(
                    `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier" id="col-${data.operator.toString().toLowerCase()}">${data.operator}</th>`
                );
                $("#row-cluster-operator").prepend(
                    `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier" id="col-${data.operator.toString().toLowerCase()}">${data.operator}</th>`
                );
                $("#row-city-operator").prepend(
                    `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier" id="col-${data.operator.toString().toLowerCase()}">${data.operator}</th>`
                );
            })
            $("#row-region-operator").prepend(
                `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier">Region</th>`
            );
            $("#row-branch-operator").prepend(
                `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier">Branch</th>`
            );
            $("#row-cluster-operator").prepend(
                `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier">Cluster</th>`
            );
            $("#row-city-operator").prepend(
                `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier">City</th>`
            );

            function countOperator(data, territory, territoryVar) {
                data.map(data => {
                    let answer = resume.filter(res => res[territoryVar] == data[territoryVar]);
                    let territory_col = data[territoryVar].toLowerCase()
                        .replace(/\s+/g, '_') // Replace spaces with underscores
                        .replace(/[^a-z0-9_]/g, '');
                    // console.log({
                    //     dataVar: data[territoryVar],
                    //     answer,
                    // });

                    $(`#tbody-${territory}-operator`).prepend(
                        `<tr><td class='p-3 border'><span class="font-semibold text-y_premier hover:text-y_tersier">${data[territoryVar]}</span></td>` +
                        operator.toReversed().map(operator => {
                            return `<td class='text-center border' id="count-${territory}-${operator.operator.toString().toLowerCase()}-${territory_col}">0</td>`;
                        }) +
                        `<td class='text-center border' id="count-${territory}-lainnya-${territory_col}">0</td>`
                    )

                    answer.map((ans, idx) => {
                        let other_count = 0;
                        let other = false;
                        kode_operator.forEach(kode => {
                            if (kode.kode_prefix == ans
                                .telp_siswa.toString().slice(
                                    0, 4)) {
                                let col_count = $(
                                    `#count-${territory}-${kode.operator.toString().toLowerCase()}-${territory_col}`
                                );
                                // console.log({
                                //     col_count: `#count-${territory}-${kode.operator.toString().toLowerCase()}-${territory_col}`,
                                //     tbody: `#count-${territory}-${kode.operator.toString().toLowerCase()}-${territory_col}`
                                // });
                                col_count.html(parseInt(
                                        col_count.html()) +
                                    1);

                                const foundOperator = operator
                                    .find(operatorObj =>
                                        operatorObj.operator ===
                                        kode.operator);
                                foundOperator.jumlah += 1;
                                other = true;
                                return;
                            }
                        });
                        if (!other) {
                            let col_count = $(
                                `#count-${territory}-lainnya-${territory_col}`);
                            col_count.html(parseInt(col_count.html()) +
                                1);
                            other_count += 1;
                        }
                    });
                    $(`#tbody-${territory}-operator`).append("</tr>")
                })

            }

            countOperator(region, 'region', 'REGIONAL')
            countOperator(branch, 'branch', 'BRANCH')
            countOperator(cluster, 'cluster', 'CLUSTER')
            countOperator(city, 'city', 'CITY')

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



        });
    </script>
@endsection
