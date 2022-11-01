@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
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
            </div>
            <input type="hidden" name="sekolah" id="sekolah" value="{{ json_encode($sekolah) }}">
            <input type="hidden" name="survey" id="survey" value="{{ json_encode($survey) }}">
            <input type="hidden" name="resume" id="resume" value="{{ json_encode($resume) }}">
            <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="result-container">
                <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-data">
                    <thead class="border-b">
                        <tr class="border-b">
                            <th rowspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">No</th>
                            <th rowspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Sekolah</th>
                            <th rowspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Soal</th>
                            <th colspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Opsi</th>
                            <th colspan="1" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto" id="tbody">
                        <tr id="load" class="font-semibold text-center text-white bg-tersier">
                            <td colspan="6">Memuat Data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
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
                    <a href="${url}" target="_blank" class="block w-full h-full">
                        ${data.NAMA_SEKOLAH}
                    </a>    
                    </td>
                    `;
                    survey.soal.map((soal, i_soal) => {
                        let choice = [];
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
                        })


                        for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[i_soal]); index++) {
                            let res = 0;
                            if (survey.jenis_soal[i_soal] != 'Prioritas') {
                                let count = choice.filter(data => data == survey.opsi[index]).length;
                                pr = 0;

                                html += `
                                ${index>pos?'<tr>':''}
                                <td colspan="2" class="p-4 text-white border border-b whitespace-nowrap bg-tersier">${survey.opsi[index]}</td>
                                <td class="p-4 text-center text-gray-700 border border-b whitespace-nowrap">${count}</td>
                                </tr>
                                `;
                            } else {
                                html += `
                                    ${index>pos?'<tr>':''}
                                    <td colspan="1" rowspan="${pr}" class="p-4 text-white border border-b whitespace-nowrap bg-sekunder">${survey.opsi[index]}</td>`;
                                for (let i = 1; i <= pr; i++) {
                                    let count = choice.filter(data => {
                                        return data[i - 1] == survey.opsi[index];
                                    }).length;

                                    html += `
                                    <td colspan="1" class="p-2 text-center text-white border border-b bg-sekunder whitespace-nowrap">${i}</td>
                                    <td class="p-4 text-center text-gray-700 border border-b whitespace-nowrap">${count}</td>
                                    </tr>
                                    `;
                                }
                            }
                        }
                        pos += parseInt(survey.jumlah_opsi[i_soal]);

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

        $("#btn-excel").click(function() {
            exportTableToExcel('table-data', `${title}`);
        })

    });

</script>
@endsection
