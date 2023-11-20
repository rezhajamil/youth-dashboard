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
                    <form action="{{ route('survey.answer.resume', $survey->id) }}" method="get">
                        {{-- <select name="month" id="month" required>
                            <option value="" selected disabled>Pilih Bulan</option>
                            @for ($i = 1; $i < 13; $i++)
                                <option value="{{ $i }}"
                                    {{ request()->get('month') == $i ? 'selected' : (date('n') == $i && !request()->get('month') ? 'selected' : '') }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <select name="year" id="year" required>
                            <option value="" selected disabled>Pilih Tahun</option>
                            @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                                <option value="{{ $i }}"
                                    {{ request()->get('year') == $i ? 'selected' : (date('Y') == $i && !request()->get('year') ? 'selected' : '') }}>
                                    {{ $i }}</option>
                            @endfor
                        </select> --}}
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
                <div class="flex items-center my-4 mt-2 gap-x-2">
                    <select name="filter" id="filter" class="block rounded">
                        <option value="" selected disabled>Pilih City</option>
                        @foreach ($city as $key => $data)
                            <option value="{{ $data->city }}">
                                {{ $data->city }}</option>
                        @endforeach
                    </select>
                    {{-- <select name="filter" id="filter" class="block rounded">
                        <option value="" disabled>Pilih Sekolah</option>
                        <option value="">Semua</option>
                        @foreach ($sekolah as $key => $data)
                            <option value="{{ $data->NAMA_SEKOLAH }}" {{ $key == 0 ? 'selected' : '' }}>
                                {{ $data->NAMA_SEKOLAH }}</option>
                        @endforeach
                    </select> --}}
                    {{-- <button id="btn-excel" class="px-2 py-3 text-white transition-all bg-green-600 rounded hover:bg-green-800">Download as Excel</button> --}}
                    <button id="btn-grafik"
                        class="px-4 py-2 text-white transition-all rounded bg-y_tersier hover:bg-red-800"><i
                            class="mr-2 fa-solid fa-chart-column"></i>Grafik</button>
                    <button id="btn-excel"
                        class="inline-block px-4 py-2 my-2 font-semibold text-white transition-all bg-teal-600 rounded-md hover:bg-teal-800"><i
                            class="mr-2 fa-solid fa-file-arrow-down"></i>Excel</button>
                    <a href="{{ route('survey.resume_territory', $survey->id) }}" target="_blank"
                        class="inline-block px-4 py-2 my-2 font-semibold text-white transition-all rounded-md bg-y_sekunder hover:bg-y_sekunder"><i
                            class="mr-2 fa-solid fa-book"></i>Resume</a>
                </div>
                <input type="hidden" name="sekolah" id="sekolah" value="{{ json_encode($sekolah) }}">
                <input type="hidden" name="operator" id="operator" value="{{ json_encode($operator) }}">
                <input type="hidden" name="kode_operator" id="kode_operator" value="{{ json_encode($kode_operator) }}">
                <input type="hidden" name="survey" id="survey" value="{{ json_encode($survey) }}">
                <input type="hidden" name="resume" id="resume" value="{{ json_encode($resume) }}">

                <span class="font-semibold">Jumlah Partisipan : <span id="partisipan"></span></span>
                <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="operator-container">
                    <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-operator">
                        <thead class="border-b">
                            <tr class="border-b" id="row-operator">
                                <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase border bg-y_tersier"
                                    id="col-lainnya">Lainnya</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-operator">
                            {{-- <tr id="row-count-operator" class="text-center"></tr> --}}
                            {{-- <tr id="row-percent-operator" class="text-center"></tr> --}}
                            <tr id="load-operator" class="font-semibold text-center text-white bg-tersier"
                                style="display: none">
                                <td colspan="8">Memuat Data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="result-container">
                    <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-data">
                        <thead class="border-b">
                            <tr class="border-b">
                                <th rowspan="2"
                                    class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    No</th>
                                <th rowspan="2"
                                    class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Sekolah</th>
                                <th rowspan="2"
                                    class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Soal</th>
                                <th rowspan="2" colspan="2"
                                    class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Opsi</th>
                                <th rowspan="2" colspan="1"
                                    class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Jumlah</th>
                                <th colspan="2"
                                    class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Persentase</th>
                            </tr>
                            <tr>
                                <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Per Sekolah</th>
                                <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Per Keseluruhan</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody">
                            <tr id="load" class="font-semibold text-center text-white bg-tersier">
                                <td colspan="8">Memuat Data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="grafik-container"
                    class="absolute inset-0 z-30 flex items-center justify-center p-4 overflow-auto h-fit bg-black/70"
                    style="display: none">
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
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            let title = $("#title").val();
            let filter = $("#filter").val();
            let resume = JSON.parse($('#resume').val());
            let sekolah = JSON.parse($('#sekolah').val());
            let operator = JSON.parse($('#operator').val());
            let kode_operator = JSON.parse($('#kode_operator').val());
            let survey = JSON.parse($('#survey').val());
            let school, pos, html, chartBar;

            $("#btn-excel").click(function() {
                exportTableToExcel('operator-container', `${title}`);
            });

            $("#btn-grafik").click(function() {
                $("#grafik-container").show();
            });

            $("#grafik-container button").click(function() {
                $("#grafik-container").hide();
            });

            const createChart = (canvas, title, label, data) => {
                // console.log(data);
                chartBar = new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: data
                    },
                    options: {
                        responsive: true,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)', 'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 0.4)', 'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)', 'rgba(255, 159, 64, 0.4)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: title
                            },
                            legend: {
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
                        },
                    }
                    // , plugins: [ChartDataLabels]
                    ,
                });
            }

            resume.map(data => data.pilihan = JSON.parse(data.pilihan));
            survey.validasi = JSON.parse(survey.validasi);
            survey.soal = survey.soal.filter((data, i) => survey.jenis_soal[i] != 'Isian');
            survey.jumlah_opsi = survey.jumlah_opsi.filter((data, i) => survey.jenis_soal[i] != 'Isian');
            survey.opsi = survey.opsi.filter((data, i) => data != '' && data != null);

            resume.map((data, i) => {
                data.pilihan = data.pilihan.filter((f, f_i) => survey.jenis_soal[f_i] != 'Isian');
            });

            survey.jenis_soal = survey.jenis_soal.filter((data, i) => data != 'Isian');

            operator.map((data, idx) => {
                $("#row-operator").prepend(
                    `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier" id="col-${data.operator.toString().toLowerCase()}">${data.operator}</th>`
                );
            })
            $("#row-operator").prepend(
                `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier">Sekolah</th>
                <th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier">Kecamatan</th>`
            );

            $("#filter").change(function() {
                // $("#row-count-operator").html('');
                // $("#row-percent-operator").html('');
                $("#load").show();
                $("#tbody").html("")
                $("#tbody-operator").html("")
                let other_count = 0;

                $.ajax({
                    url: "{{ URL::to('/get_resume_school') }}",
                    method: "GET",
                    dataType: "JSON",
                    data: {
                        city: $(this).val(),
                        // month: $("#month").val(),
                        // year: $("#year").val(),
                        start_date: $("#start_date").val(),
                        end_date: $("#end_date").val(),
                    },
                    success: (data) => {

                        console.log({
                            data
                        });

                        operator.map(data => {
                            data.jumlah = 0;
                        })
                        data.map((data) => {
                            let answer = resume.filter(res => res.npsn == data.NPSN);

                            $("#tbody-operator").prepend(
                                `<tr>
                                    <td class='p-3 border'><span class="font-semibold underline cursor-pointer resume-sekolah text-y_premier hover:text-y_tersier">${data.NAMA_SEKOLAH}</span></td>
                                    <td class='p-3 border'><span class="font-semibold text-y_premier hover:text-y_tersier">${data.KECAMATAN}</span></td>` +
                                operator.toReversed().map(operator => {
                                    return `<td class='text-center border' id="count-${operator.operator.toString().toLowerCase()}-${data.NPSN}">0</td>`;
                                }) +
                                `<td class='text-center border' id="count-lainnya-${data.NPSN}">0</td>`
                            )


                            // operator.map(operator => {
                            //     $("#tbody-operator").append(
                            //         `<td class='border' id="count-${operator.operator.toString().toLowerCase()}-${data.NPSN}">0</td>`
                            //     )
                            //     // $("#row-percent-operator").prepend(
                            //     //     `<td class='font-bold border' id="percent-${data.operator.toString().toLowerCase()}">0%</td>`
                            //     // )
                            // });
                            // $("#tbody-operator").append(
                            //     `<td class='border' id="count-lainnya-${data.NPSN}">0</td>`
                            // );
                            // $("#row-percent-operator").append(
                            //     `<td class='font-bold border' id="percent-lainnya">0%</td>`
                            // );

                            answer.map((ans, idx) => {
                                let other = false;
                                kode_operator.forEach(kode => {
                                    if (kode.kode_prefix == ans
                                        .telp_siswa.toString().slice(
                                            0, 4)) {
                                        let col_count = $(
                                            `#count-${kode.operator.toString().toLowerCase()}-${data.NPSN}`
                                        );
                                        // let col_percent = $(
                                        //     `#percent-${kode.operator.toString().toLowerCase()}-${data.NPSN}`
                                        // );
                                        col_count.html(parseInt(
                                                col_count.html()) +
                                            1);

                                        const foundOperator = operator
                                            .find(operatorObj =>
                                                operatorObj.operator ===
                                                kode.operator);
                                        foundOperator.jumlah += 1;
                                        // col_percent.html(
                                        //     `${parseInt(((col_count.html()/resume.length).toFixed(2))*100)}%`
                                        // );
                                        // console.log([kode.operator,ans.telp_siswa.toString().slice(0,4)]);
                                        other = true;
                                        return;
                                    }
                                });
                                if (!other) {
                                    let col_count = $(
                                        `#count-lainnya-${data.NPSN}`);
                                    // let col_percent = $(`#percent-lainnya`);
                                    col_count.html(parseInt(col_count.html()) +
                                        1);
                                    // const foundOperator = operator
                                    //     .find(operatorObj =>
                                    //         operatorObj.operator ===
                                    //         kode.operator);
                                    other_count += 1;
                                    // col_percent.html(
                                    //     `${parseInt(((col_count.html()/resume.length).toFixed(2))*100)}%`
                                    // );
                                }
                            });
                            $("#tbody-operator").append("</tr>")
                        })

                        console.log({
                            operator
                        });

                        console.log({
                            other_count
                        });
                        $("#tbody-operator").prepend(
                            `<tr class='text-white bg-y_premier'><td colspan='2' class='p-3 text-center border'><span class="font-semibold">TOTAL</span></td>` +
                            operator.toReversed().map(operator => {
                                return `<td class='text-center border' id="total-${operator.operator.toString().toLowerCase()}-${data.NPSN}">${operator.jumlah}</td>`;
                            }) +
                            `<td class='text-center border' id="total-lainnya-${data.NPSN}">${other_count}</td>`
                        )

                        $("#load-operator").hide();
                    },
                    error: (e) => {
                        console.log('error', e);
                    }
                })
            })

            $(document).on("click", ".resume-sekolah", function() {
                console.log($(this).text());
                $("#tbody-operator").html("")
                getResume($(this).text());
            })


            const getResume = (filter) => {
                $("#tbody").html('');
                $("#grafik-grid").html('');
                $("#row-count-operator").html('');
                $("#row-percent-operator").html('');
                $("#load").show();
                html = '';

                sekolah.filter(res => res.NAMA_SEKOLAH == filter);

                if (sekolah.length == 0) {
                    $("#load-operator").hide();
                    $("#partisipan").html('0');
                }

                operator.map(data => {
                    $("#row-count-operator").prepend(
                        `<td class='border' id="count-${data.operator.toString().toLowerCase()}">0</td>`
                    )
                    $("#row-percent-operator").prepend(
                        `<td class='font-bold border' id="percent-${data.operator.toString().toLowerCase()}">0%</td>`
                    )
                });
                $("#row-count-operator").append(`<td class='border' id="count-lainnya">0</td>`);
                $("#row-percent-operator").append(`<td class='font-bold border' id="percent-lainnya">0%</td>`);

                sekolah.map((data, key) => {
                    let url = "{{ route('survey.answer.list') }}" +
                        `?session=${survey.id}&npsn=${data.NPSN}`;
                    let answer = resume.filter(res => res.npsn == data.NPSN);

                    if (filter == '') {
                        pos = 0;
                        row = 0;
                        pr = 0;

                        $("#partisipan").text(resume.length);

                        answer.map((ans, idx) => {
                            let other = false;
                            kode_operator.forEach(kode => {
                                if (kode.kode_prefix == ans.telp_siswa.toString().slice(
                                        0, 4)) {
                                    let col_count = $(
                                        `#count-${kode.operator.toString().toLowerCase()}`
                                    );
                                    let col_percent = $(
                                        `#percent-${kode.operator.toString().toLowerCase()}`
                                    );
                                    col_count.html(parseInt(col_count.html()) + 1);
                                    col_percent.html(
                                        `${parseInt(((col_count.html()/resume.length).toFixed(2))*100)}%`
                                    );
                                    // console.log([kode.operator,ans.telp_siswa.toString().slice(0,4)]);
                                    other = true;
                                    return;
                                }
                            });
                            if (!other) {
                                let col_count = $(`#count-lainnya`);
                                let col_percent = $(`#percent-lainnya`);
                                col_count.html(parseInt(col_count.html()) + 1);
                                col_percent.html(
                                    `${parseInt(((col_count.html()/resume.length).toFixed(2))*100)}%`
                                );
                            }
                        });

                        // operator.map(data=>{
                        //     $("#row-percent-operator").prepend(`<td class='font-bold border' id="percent-${data.operator.toString().toLowerCase()}">${parseInt((($(`#count-${data.operator.toString().toLowerCase()}`).html()/resume.length))*100)}%</td>`)
                        // });
                        // $("#row-percent-operator").append(`<td class='font-bold border' id="percent-lainnya">${parseInt(($('#count-lainnya').html()/resume.length)*100)}%</td>`);

                        $("#load-operator").hide();

                        survey.soal.map((soal, i_soal) => {
                            if (survey.jenis_soal[i_soal] == 'Prioritas') {
                                for (let index = 0; index < survey.jumlah_opsi[
                                        i_soal]; index++) {
                                    row += parseInt(survey.jumlah_opsi[i_soal]);
                                }
                            } else {
                                row += parseInt(survey.jumlah_opsi[i_soal]);
                            }
                        });

                        html += `
                        <tr>
                        <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 border border-b-2 border-r-2">${key+1}</td>
                        <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 underline transition-all border border-b-2 whitespace-nowrap hover:text-cyan-600">
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
                            $("#grafik-grid").append(
                                `<div class="col-span-1"><canvas id="grafik-${i_soal}"></canvas></div>`
                            );

                            for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[
                                    i_soal]); index++) {
                                if (survey.jenis_soal[i_soal] == 'Prioritas') {
                                    pr += 1;
                                } else {
                                    break;
                                }
                            }

                            html +=
                                `${i_soal>0?'<tr>':''} <td rowspan="${survey.jenis_soal[i_soal] != 'Prioritas'?parseInt(survey.jumlah_opsi[i_soal]):parseInt(survey.jumlah_opsi[i_soal])*pr}" class="p-4 text-gray-700 text-xl border border-b-${i_soal>0?4:2}">${soal}</td>`;

                            resume.map((d_answer, i_answer) => {
                                choice.push(d_answer.pilihan[i_soal]);
                            });

                            resume.map((d_answer, i_answer) => {
                                choice_all.push(d_answer.pilihan[i_soal]);
                            });


                            for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[
                                    i_soal]); index++) {
                                let res = 0;
                                if (survey.jenis_soal[i_soal] != 'Prioritas') {
                                    let count = choice.filter(data => data == survey.opsi[
                                        index]).length;
                                    let count_all = choice_all.filter(data => data == survey
                                        .opsi[index]).length;

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
                                    html +=
                                        `
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

                            // createChart($(`#grafik-${i_soal}`), soal, label, dataset);

                        })

                    } else if (filter == data.NAMA_SEKOLAH) {
                        pos = 0;
                        row = 0;
                        pr = 0;

                        $("#partisipan").text(answer.length);

                        answer.map((ans, idx) => {
                            let other = false;
                            kode_operator.forEach(kode => {
                                if (kode.kode_prefix == ans.telp_siswa.toString().slice(
                                        0, 4)) {
                                    let col_count = $(
                                        `#count-${kode.operator.toString().toLowerCase()}`
                                    );
                                    let col_percent = $(
                                        `#percent-${kode.operator.toString().toLowerCase()}`
                                    );
                                    col_count.html(parseInt(col_count.html()) + 1);
                                    col_percent.html(
                                        `${parseInt((col_count.html()/answer.length)*100)}%`
                                    );
                                    // console.log([kode.operator,ans.telp_siswa.toString().slice(0,4)]);
                                    other = true;
                                    return;
                                }
                            });
                            if (!other) {
                                let col_count = $(`#count-lainnya`);
                                let col_percent = $(`#percent-lainnya`);
                                col_count.html(parseInt(col_count.html()) + 1);
                                col_percent.html(
                                    `${parseInt((col_count.html()/answer.length)*100)}%`);
                            }
                        });

                        // operator.map(data=>{
                        //     $("#row-percent-operator").prepend(`<td class='font-bold border' id="percent-${data.operator.toString().toLowerCase()}">${parseInt(($(`#count-${data.operator.toString().toLowerCase()}`).html()/answer.length)*100)}%</td>`)
                        // });
                        // $("#row-percent-operator").append(`<td class='font-bold border' id="percent-lainnya">${parseInt(($('#count-lainnya').html()/answer.length)*100)}%</td>`);

                        $("#load-operator").hide();

                        survey.soal.map((soal, i_soal) => {
                            if (survey.jenis_soal[i_soal] == 'Prioritas') {
                                for (let index = 0; index < survey.jumlah_opsi[
                                        i_soal]; index++) {
                                    row += parseInt(survey.jumlah_opsi[i_soal]);
                                }
                            } else {
                                row += parseInt(survey.jumlah_opsi[i_soal]);
                            }
                        });
                        html += ` <tr>
                        <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 border border-b-2 border-r-2">${key+1}</td>
                        <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 underline transition-all border border-b-2 whitespace-nowrap hover:text-cyan-600">
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
                            $("#grafik-grid").append(
                                `<div class="col-span-1"><canvas id="grafik-${i_soal}"></canvas></div>`
                            );

                            for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[
                                    i_soal]); index++) {
                                if (survey.jenis_soal[i_soal] == 'Prioritas') {
                                    pr += 1;
                                } else {
                                    break;
                                }
                            }

                            html += ` ${i_soal>0?'<tr>':''}
                                <td rowspan="${survey.jenis_soal[i_soal] != 'Prioritas'?parseInt(survey.jumlah_opsi[i_soal]):parseInt(survey.jumlah_opsi[i_soal])*pr}" class="p-4 text-gray-700 text-xl border border-b-${i_soal>0?4:2}">${soal}</td>
                                `;

                            answer.map((d_answer, i_answer) => {
                                choice.push(d_answer.pilihan[i_soal]);
                            });

                            resume.map((d_answer, i_answer) => {
                                choice_all.push(d_answer.pilihan[i_soal]);
                            });


                            for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[
                                    i_soal]); index++) {
                                let res = 0;
                                if (survey.jenis_soal[i_soal] != 'Prioritas') {
                                    let count = choice.filter(data => data == survey.opsi[
                                        index]).length;
                                    let count_all = choice_all.filter(data => data == survey
                                        .opsi[index]).length;

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
                                    html +=
                                        `
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
