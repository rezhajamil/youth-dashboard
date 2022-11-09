@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4 overflow-y-auto">
            <a href="{{ url()->previous() }}" class="block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md w-fit hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="inline-block mb-2 text-xl font-bold text-gray-600 align-baseline" id="title">{{ $survey->nama }}</h4>
            {{-- <button class="px-2 py-1 ml-2 text-lg text-white transition bg-green-600 rounded-md hover:bg-green-800" id="capture"><i class="fa-regular fa-circle-down"></i></button> --}}
            <div class="flex my-4 gap-x-4">
                <select name="filter" id="filter" class="block rounded">
                    <option value="" disabled>Pilih Sekolah</option>
                    <option value="">Semua</option>
                    @foreach ($sekolah as $key=>$data)
                    <option value="{{ $data->NAMA_SEKOLAH }}" {{ $key==0?'selected':'' }}>{{ $data->NAMA_SEKOLAH }}</option>
                    @endforeach
                </select>
                {{-- <button id="btn-excel" class="px-2 py-3 text-white transition-all bg-green-600 rounded hover:bg-green-800">Download as Excel</button> --}}
                <button id="btn-grafik" class="px-4 py-2 text-white transition-all bg-red-600 rounded hover:bg-red-800"><i class="mr-2 fa-solid fa-chart-column"></i>Grafik</button>
            </div>
            <input type="hidden" name="sekolah" id="sekolah" value="{{ json_encode($sekolah) }}">
            <input type="hidden" name="survey" id="survey" value="{{ json_encode($survey) }}">
            <input type="hidden" name="resume" id="resume" value="{{ json_encode($resume) }}">

            <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="result-container">
                <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-data">
                    <thead class="border-b">
                        <tr class="border-b">
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">No</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Sekolah</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Soal</th>
                            <th rowspan="2" colspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Opsi</th>
                            <th rowspan="2" colspan="1" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Jumlah</th>
                            <th colspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Persentase</th>
                        </tr>
                        <tr>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Per Sekolah</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Per Keseluruhan</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto" id="tbody">
                        <tr id="load" class="font-semibold text-center text-white bg-tersier">
                            <td colspan="8">Memuat Data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="grafik-container" class="absolute inset-0 z-30 flex items-center justify-center p-4 overflow-auto h-fit bg-black/70" style="display: none">
                <div class="w-full p-4 overflow-auto bg-white rounded-lg">
                    <div class="flex justify-end">
                        <button class="text-xl font-bold transition-all text-premier hover:text-red-900">X</button>
                    </div>
                    <div class="grid min-w-full grid-cols-2 gap-6" id="grafik-grid">
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#btn-excel").click(function() {
            exportTableToExcel('table-data', `${title}`);
        });

        $("#btn-grafik").click(function() {
            $("#grafik-container").show();
        });

        $("#grafik-container button").click(function() {
            $("#grafik-container").hide();
        });

        const createChart = (canvas, title, label, data) => {
            console.log(data);
            let chartBar = new Chart(canvas, {
                type: 'bar'
                , data: {
                    labels: label
                    , datasets: data
                }
                , options: {
                    responsive: true
                    , backgroundColor: [
                        'rgba(255, 99, 132, 0.4)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 0.4)'
                        , 'rgba(75, 192, 192, 0.4)'
                        , 'rgba(153, 102, 255, 0.4)'
                        , 'rgba(255, 159, 64, 0.4)'
                    ]
                    , borderColor: [
                        'rgba(255, 99, 132, 1)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 1)'
                        , 'rgba(75, 192, 192, 1)'
                        , 'rgba(153, 102, 255, 1)'
                        , 'rgba(255, 159, 64, 1)'
                    ]
                    , borderWidth: 1
                    , scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                    , plugins: {
                        title: {
                            display: true
                            , text: title
                        }
                        , legend: {
                            display: false
                        }
                        // , subtitle: {
                        // display: true
                        // , text: date
                        // , }
                        // , datalabels: {
                        // display: true
                        // , backgroundColor: 'rgba(255,255,255,.6)'
                        // , borderRadius: 3
                        // , font: {
                        // weight: 'bold'
                        // , size: 10
                        // , }
                        // , formatter: function(value, context) {
                        // return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        // }
                        // }
                    }
                , }
                // , plugins: [ChartDataLabels]
            , });
        }


        let title = $("#title").val();
        let filter = $("#filter").val();
        let resume = JSON.parse($('#resume').val());
        let sekolah = JSON.parse($('#sekolah').val());
        let survey = JSON.parse($('#survey').val());
        let school, pos, html;

        resume.map(data => data.pilihan = JSON.parse(data.pilihan));
        survey.validasi = JSON.parse(survey.validasi);
        survey.soal = survey.soal.filter((data, i) => survey.jenis_soal[i] != 'Isian');
        survey.jumlah_opsi = survey.jumlah_opsi.filter((data, i) => survey.jenis_soal[i] != 'Isian');
        survey.opsi = survey.opsi.filter((data, i) => data != '');

        resume.map((data, i) => {
            data.pilihan = data.pilihan.filter((f, f_i) => survey.jenis_soal[f_i] != 'Isian');
        });

        survey.jenis_soal = survey.jenis_soal.filter((data, i) => data != 'Isian');

        $("#filter").change(function() {
            getResume($(this).val());
        })

        const getResume = (filter) => {
            $("#tbody").html('');
            $("#grafik-grid").html('');
            html = '';
            $("#load").show();
            let pattern = new RegExp(filter, "i");
            sekolah.map((data, key) => {
                let url = "{{ route('survey.answer.list')}}" + `?session=${survey.id}&npsn=${data.NPSN}`;
                let answer = resume.filter(res => res.npsn == data.NPSN);
                // console.log(answer);
                // school = key;
                if (pattern.test(data.NAMA_SEKOLAH)) {
                    pos = 0;
                    row = 0;
                    pr = 0;

                    survey.soal.map((soal, i_soal) => {
                        if (survey.jenis_soal[i_soal] == 'Prioritas') {
                            for (let index = 0; index < survey.jumlah_opsi[i_soal]; index++) {
                                row += parseInt(survey.jumlah_opsi[i_soal]);
                            }
                        } else {
                            row += parseInt(survey.jumlah_opsi[i_soal]);
                        }
                    });

                    html += `
                    <tr>
                    <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 border border-b-2 border-r-2">${key+1}</td>
                    <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 border border-b-2 whitespace-nowrap">
                    <a href="${url}" target="_blank">
                        ${data.NAMA_SEKOLAH}
                    </a>    
                    </td>
                    `;
                    survey.soal.map((soal, i_soal) => {
                        let choice = [];
                        let choice_all = [];
                        let dataset = [{
                            // label: []
                            data: []
                        }];
                        let label = [];
                        $("#grafik-grid").append(`<div class="col-span-1"><canvas id="grafik-${i_soal}"></canvas></div>`);


                        for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[i_soal]); index++) {
                            if (survey.jenis_soal[i_soal] == 'Prioritas') {
                                pr += 1;
                            } else {
                                break;
                            }
                        }

                        html += `
                        ${i_soal>0?'<tr>':''}
                        <td rowspan="${survey.jenis_soal[i_soal] != 'Prioritas'?parseInt(survey.jumlah_opsi[i_soal]):parseInt(survey.jumlah_opsi[i_soal])*pr}" class="p-4 text-gray-700 text-xl border border-b-${i_soal>0?4:2}">${soal}</td>
                        `;

                        answer.map((d_answer, i_answer) => {
                            choice.push(d_answer.pilihan[i_soal]);
                        });

                        resume.map((d_answer, i_answer) => {
                            choice_all.push(d_answer.pilihan[i_soal]);
                        });


                        for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[i_soal]); index++) {
                            let res = 0;
                            if (survey.jenis_soal[i_soal] != 'Prioritas') {
                                let count = choice.filter(data => data == survey.opsi[index]).length;
                                let count_all = choice_all.filter(data => data == survey.opsi[index]).length;

                                if (count > 0) {
                                    label.push(survey.opsi[index]);
                                    // dataset[0].label.push(survey.opsi[index]);
                                    dataset[0].data.push(count);
                                }

                                pr = 0;

                                html += `
                                ${index>pos?'<tr>':''}
                                <td colspan="2" class="p-4 text-white border border-b whitespace-nowrap bg-tersier">${survey.opsi[index]}</td>
                                <td class="p-4 font-bold text-center text-gray-700 border border-b whitespace-nowrap">${count}</td>
                                <td class="p-4 text-center text-gray-700 border border-b whitespace-nowrap">${((count/choice.length)*100).toFixed(1)}%</td>
                                <td class="p-4 text-center text-gray-700 border border-b whitespace-nowrap">${((count_all/choice_all.length)*100).toFixed(1)}%</td>
                                </tr>
                                `;
                            } else {
                                html += `
                                    ${index>pos?'<tr>':''}
                                    <td colspan="1" rowspan="${pr}" class="p-4 text-white border border-b whitespace-nowrap bg-sekunder">${survey.opsi[index]}</td>`;

                                for (let j = 1; j <= survey.jumlah_opsi[i_soal]; j++) {
                                    label.push(j);
                                }

                                for (let i = 1; i <= pr; i++) {
                                    let count = choice.filter(data => {
                                        return data[i - 1] == survey.opsi[index];
                                    }).length;

                                    let count_all = choice_all.filter(data => {
                                        return data[i - 1] == survey.opsi[index];
                                    }).length;

                                    // dataset[0].label = [];
                                    if (count > 0) {
                                        // label.push(`#${i}`);
                                        // dataset[0].label.push(survey.opsi[index]);
                                        // dataset[0].label.push(survey.opsi[index]);
                                        dataset[0].data.push(count);
                                    }

                                    html += `
                                    <td colspan="1" class="p-2 text-center text-white border border-b bg-sekunder whitespace-nowrap">#${i}</td>
                                    <td class="p-4 font-bold text-center text-gray-700 border border-b whitespace-nowrap">${count}</td>
                                    <td class="p-4 text-center text-gray-700 border border-b whitespace-nowrap">${((count/choice.length)*100).toFixed(1)}%</td>
                                    <td class="p-4 text-center text-gray-700 border border-b whitespace-nowrap">${((count_all/choice_all.length)*100).toFixed(1)}%</td>
                                    </tr>
                                    `;
                                }
                            }
                        }
                        pos += parseInt(survey.jumlah_opsi[i_soal]);

                        createChart($(`#grafik-${i_soal}`), soal, label, dataset);

                    })

                }
            });
            $("#tbody").html(html)
            $('#load').hide();
        }

        getResume(filter);

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
