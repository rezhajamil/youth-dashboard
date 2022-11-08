@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md w-fit hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="inline-block mb-2 text-xl font-bold text-gray-600 align-baseline" id="title">{{ $survey->nama }}</h4>
            {{-- <button class="px-2 py-1 ml-2 text-lg text-white transition bg-green-600 rounded-md hover:bg-green-800" id="capture"><i class="fa-regular fa-circle-down"></i></button> --}}
            <input type="hidden" name="sekolah" id="sekolah" value="{{ json_encode($sekolah) }}">
            <input type="hidden" name="survey" id="survey" value="{{ json_encode($survey) }}">
            <input type="hidden" name="answer" id="answer" value="{{ json_encode($answer) }}">
            <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="result-container">
                <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-data">
                    <thead class="border-b" id="thead">
                        {{-- <tr class="border-b">
                            <th rowspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">No</th>
                            <th rowspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Sekolah</th>
                            <th rowspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Soal</th>
                            <th colspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Opsi</th>
                            <th colspan="1" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Jumlah</th>
                        </tr> --}}
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
        let answer = JSON.parse($('#answer').val());
        let sekolah = JSON.parse($('#sekolah').val());
        let survey = JSON.parse($('#survey').val());
        let header, body;
        let pos_head = 0;

        answer.map(data => data.pilihan = JSON.parse(data.pilihan));

        const getResult = () => {
            // $("#tbody").html('');
            header = '';
            body = '';
            $("#load").show();

            header += `
            <tr class="border-b">
                <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">No</th>
                <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Telp</th>
            `;

            survey.soal.map((data, i) => {
                header += `
                <th colspan="${survey.jenis_soal[i]=='Prioritas'?survey.jumlah_opsi[i]:1}" rowspan="${survey.jenis_soal[i]=='Prioritas'?1:2}" class="p-3 text-sm font-bold text-center text-gray-100 border bg-sekunder whitespace-nowrap">${data}</th>
                ${i==survey.soal.length-1??'</tr>'}
                `;
            });

            header += '<tr>';
            survey.jenis_soal.map((data, i) => {
                if (data == 'Prioritas') {
                    for (let index = 1; index <= survey.jumlah_opsi[i]; index++) {
                        header += `
                        <th class="p-3 text-sm font-bold text-center text-gray-100 border bg-tersier">#${index}</th>
                        `;
                    }
                }
            });
            header += '</tr>';

            // sekolah.map((data, key) => {
            //     let url = "{{ route('survey.answer.list')}}" + `?session=${survey.id}&npsn=${data.NPSN}`;
            //     let answer = resume.filter(res => res.npsn == data.NPSN);
            //     // console.log(answer);
            //     // school = key;
            //     pos = 0;
            //     row = 0;
            //     pr = 0;

            //     survey.soal.map((soal, i_soal) => {
            //         if (survey.jenis_soal[i_soal] == 'Prioritas') {
            //             for (let index = 0; index < survey.jumlah_opsi[i_soal]; index++) {
            //                 row += parseInt(survey.jumlah_opsi[i_soal]);
            //             }
            //         } else {
            //             row += parseInt(survey.jumlah_opsi[i_soal]);
            //         }
            //     });

            //     // body += `
            //     //     <tr>
            //     //     <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 border border-b-2 border-r-2">${key+1}</td>
            //     //     <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 border border-b-2 whitespace-nowrap">
            //     //     <a href="${url}" target="_blank" class="block w-full h-full">
            //     //         ${data.NAMA_SEKOLAH}
            //     //     </a>    
            //     //     </td>
            //     //     `;
            //     // survey.soal.map((soal, i_soal) => {
            //     //     let choice = [];
            //     //     for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[i_soal]); index++) {
            //     //         if (survey.jenis_soal[i_soal] == 'Prioritas') {
            //     //             pr += 1;
            //     //         } else {
            //     //             break;
            //     //         }
            //     //     }

            //     //     body += `
            //     //         ${i_soal>0?'<tr>':''}
            //     //         <td rowspan="${survey.jenis_soal[i_soal] != 'Prioritas'?parseInt(survey.jumlah_opsi[i_soal]):parseInt(survey.jumlah_opsi[i_soal])*pr}" class="p-4 text-gray-700 text-xl border border-b-${i_soal>0?4:2}">${soal}</td>
            //     //         `;

            //     //     answer.map((d_answer, i_answer) => {
            //     //         choice.push(d_answer.pilihan[i_soal]);
            //     //     })


            //     //     for (let index = pos; index < pos + parseInt(survey.jumlah_opsi[i_soal]); index++) {
            //     //         let res = 0;
            //     //         if (survey.jenis_soal[i_soal] != 'Prioritas') {
            //     //             let count = choice.filter(data => data == survey.opsi[index]).length;
            //     //             pr = 0;

            //     //             body += `
            //     //                 ${index>pos?'<tr>':''}
            //     //                 <td colspan="2" class="p-4 text-white border border-b whitespace-nowrap bg-tersier">${survey.opsi[index]}</td>
            //     //                 <td class="p-4 text-center text-gray-700 border border-b whitespace-nowrap">${count}</td>
            //     //                 </tr>
            //     //                 `;
            //     //         } else {
            //     //             body += `
            //     //                     ${index>pos?'<tr>':''}
            //     //                     <td colspan="1" rowspan="${pr}" class="p-4 text-white border border-b whitespace-nowrap bg-sekunder">${survey.opsi[index]}</td>`;
            //     //             for (let i = 1; i <= pr; i++) {
            //     //                 let count = choice.filter(data => {
            //     //                     return data[i - 1] == survey.opsi[index];
            //     //                 }).length;

            //     //                 body += `
            //     //                     <td colspan="1" class="p-2 text-center text-white border border-b bg-sekunder whitespace-nowrap">${i}</td>
            //     //                     <td class="p-4 text-center text-gray-700 border border-b whitespace-nowrap">${count}</td>
            //     //                     </tr>
            //     //                     `;
            //     //             }
            //     //         }
            //     //     }
            //     //     pos += parseInt(survey.jumlah_opsi[i_soal]);

            //     // })

            // });

            answer.map((data, key) => {
                console.log(data)
                body += `<tr>
                <td class="p-4 font-bold text-center text-gray-700 border border-b-2 border-r-2">${key+1}</td>
                <td class="p-4 font-bold text-center text-gray-700 border border-b-2 border-r-2">${data.telp_siswa}</td>
                `;
                data.pilihan.map((pil, i_pil) => {
                    if (survey.jenis_soal[i_pil] != 'Prioritas') {
                        if (survey.jenis_soal[i_pil] == 'Pilgan & Isian' && pil.length > 1) {
                            body += `
                            <td class="p-4 text-gray-700 border border-b-2 border-r-2">
                                <p class="mb-2">${pil[0]}</p>
                                <p class="font-bold">${pil[1]}</p>
                            </td>
                            `;
                        } else {
                            body += `
                            <td class="p-4 text-gray-700 border border-b-2 border-r-2">${pil.join(",")}</td>
                            `;
                        }
                    } else {
                        for (let index = 0; index < survey.jumlah_opsi[i_pil]; index++) {
                            body += `
                            <td class="p-4 text-gray-700 border border-b-2 border-r-2">${pil[index]??''}</td>
                            `;
                        }
                    }
                });
                body += "</tr>";
            })

            $("#thead").html(header)
            $("#tbody").html(body)
            $('#load').hide();
        }

        getResult();

    });

</script>
@endsection
