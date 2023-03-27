@extends('layouts.dashboard.app')
@section('body')
    <input type="hidden" id="list_sekolah" value="{{ json_encode($list_sekolah) }}">
    <input type="hidden" id="sekolah" value="{{ json_encode($sekolah) }}">
    <input type="hidden" id="site" value="{{ json_encode($site) }}">
    <input type="hidden" id="outlet" value="{{ json_encode($outlet) }}">

    <input type="hidden" name="operator" id="operator" value="{{ json_encode($operator) }}">
    <input type="hidden" name="kode_operator" id="kode_operator" value="{{ json_encode($kode_operator) }}">
    <input type="hidden" name="survey" id="survey" value="{{ json_encode($survey) }}">
    <input type="hidden" name="answer" id="answer" value="{{ json_encode($answer) }}">
    <div class="w-full sm:mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Detail {{ $sekolah->NAMA_SEKOLAH }}</h4>

                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">NPSN</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kabupaten</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Alamat</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">AO</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">PIC</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Telp PIC</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kepala Sekolah</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jumlah Siswa</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Tanggal Update</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            <tr class="hover:bg-gray-200">
                                {{-- {{ ddd($data) }} --}}
                                <td class="p-4 font-bold text-gray-700 border-b">{{ $sekolah->NPSN }}</td>
                                <td class="p-4 text-gray-700 border-b">{{ $sekolah->CITY }}</td>
                                <td class="p-4 text-gray-700 border-b">{{ $sekolah->ALAMAT }}</td>
                                <td class="p-4 text-gray-700 border-b">{{ $sekolah->ao }}</td>
                                <td class="p-4 text-gray-700 border-b">{{ $sekolah->pic }}</td>
                                <td class="p-4 text-gray-700 border-b">{{ $sekolah->telp_pic }}</td>
                                <td class="p-4 text-gray-700 border-b">{{ $sekolah->kepala_sekolah }}</td>
                                <td class="p-4 text-gray-700 border-b">{{ $sekolah->siswa }}</td>
                                <td class="p-4 text-gray-700 border-b">
                                    {{ $sekolah->update_date ? date('Y-m-d', strtotime($sekolah->update_date)) : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($site && $outlet && auth()->user()->privilege == 'superadmin')
                <div class="grid w-full grid-cols-1 mt-4 gap-y-3 gap-x-3 sm:grid-cols-3 grid-auto-rows-min grid-flow-row">
                    <div class="w-full">
                        <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Site Terdekat</h4>

                        <div class="w-full overflow-auto bg-white rounded-md shadow">
                            <table class="w-full overflow-auto text-left border-collapse">
                                <thead class="border-b">
                                    <tr>
                                        <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">ID SITE</th>
                                        <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @foreach ($site as $data)
                                        <tr class="hover:bg-gray-200">
                                            <td class="p-4 font-bold text-gray-700 border-b">{{ $data->site }}</td>
                                            <td class="p-4 text-gray-700 border-b whitespace-nowrap">{{ $data->jarak }} Km
                                            </td>
                                        </tr>
                                        @php
                                            if ($data->jarak > 1.5) {
                                                break;
                                            }
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="w-full">
                        <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Outlet Terdekat</h4>

                        <div class="w-full overflow-auto bg-white rounded-md shadow">
                            <table class="w-full overflow-auto text-left border-collapse">
                                <thead class="border-b">
                                    <tr>
                                        <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">ID Outlet
                                        </th>
                                        <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @foreach ($outlet as $data)
                                        <tr class="hover:bg-gray-200">
                                            <td class="p-4 font-bold text-gray-700 border-b">{{ $data->outlet }}</td>
                                            <td class="p-4 text-gray-700 border-b whitespace-nowrap">{{ $data->jarak }} Km
                                            </td>
                                        </tr>
                                        @php
                                            if ($data->jarak > 1.5) {
                                                break;
                                            }
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="map" style="width: 100%; height: 350px;margin-top: 16px"></div>
                </div>
            @endif
            <div class="mt-4">
                <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Kunjungan Terakhir</h4>

                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">Nama</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Telp</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Role</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Tanggal</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Waktu</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jarak</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @if ($last_visit)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-4 font-bold text-gray-700 border-b">{{ $last_visit->nama }}</td>
                                    <td class="p-4 text-gray-700 border-b">{{ $last_visit->telp }}</td>
                                    <td class="p-4 text-gray-700 border-b">{{ $last_visit->role }}</td>
                                    <td class="p-4 text-gray-700 border-b">
                                        {{ date('d-M-Y', strtotime($last_visit->date)) }}</td>
                                    <td class="p-4 text-gray-700 border-b">{{ $last_visit->waktu }}</td>
                                    <td class="p-4 text-gray-700 border-b">{{ $last_visit->jarak }} Km</td>
                                </tr>
                            @else
                                <tr class="hover:bg-gray-200">
                                    <td colspan="6" class="p-4 font-bold text-center text-gray-700 border-b">Tidak Ada
                                        Kunjungan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Survey Terakhir | Partisipan:<span
                        id="partisipan"></span></h4>
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
                                <th
                                    class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Per Sekolah</th>
                                <th
                                    class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">
                                    Per Keseluruhan</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody">
                            <tr id="load" class="font-semibold text-center bg-white">
                                <td colspan="8" class="p-4 font-bold text-center text-gray-700 border-b">Memuat Data...
                                </td>
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
            var list_sekolah = JSON.parse($("#list_sekolah").val());
            var sekolah = JSON.parse($("#sekolah").val());
            var site = JSON.parse($("#site").val());
            var outlet = JSON.parse($("#outlet").val());
            let operator = JSON.parse($('#operator').val());
            let kode_operator = JSON.parse($('#kode_operator').val());
            let survey = JSON.parse($('#survey').val());
            let answer = JSON.parse($('#answer').val());
            console.log(survey);

            var map = L.map('map').setView([parseFloat(sekolah.LATITUDE), parseFloat(sekolah.LONGITUDE)], 13);
            var iconSite = L.divIcon({
                className: 'fa-solid fa-wifi text-red-600 text-2xl'
            });
            var iconOutlet = L.divIcon({
                className: 'fa-solid fa-shop text-y_premier text-2xl'
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?foo=bar', {
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([parseFloat(sekolah.LATITUDE), parseFloat(sekolah.LONGITUDE)]).addTo(
                map).bindPopup(
                `<b><a target='_blank' href='http://maps.google.com/maps?z=12&t=m&q=loc:${sekolah.LATITUDE}+${sekolah.LONGITUDE}"'>${sekolah.NAMA_SEKOLAH}</a></b>`
            ).openPopup();

            site.map((data, i) => {
                L.marker([parseFloat(data.latitude), parseFloat(data.longitude)], {
                    icon: iconSite,
                    riseOnHover: true,
                }).addTo(
                    map).bindPopup(
                    `<a target='_blank' href='http://maps.google.com/maps?z=12&t=m&q=loc:${data.latitude}+${sekolah.longitude}"'>ID Site : ${data.site}</a>`
                );
            });

            outlet.map((data, i) => {
                L.marker([parseFloat(data.lattitude), parseFloat(data.longitude)], {
                    icon: iconOutlet,
                    riseOnHover: true,
                }).addTo(
                    map).bindPopup(
                    `<a target='_blank' href='http://maps.google.com/maps?z=12&t=m&q=loc:${data.lattitude}+${sekolah.longitude}"'>Outlet : ${data.outlet}</a>`
                );
            });

            const getResume = () => {
                if (answer.length == 0) {
                    $("#load td").html('Tidak ada Survey');
                    return;
                    console.log($("#load td"));
                }

                $("#tbody").html('');
                $("#load").show();
                $("#partisipan").html(answer.length)
                html = '';


                answer.map(data => data.pilihan = JSON.parse(data.pilihan));
                survey.validasi = JSON.parse(survey.validasi);
                survey.soal = survey.soal.filter((data, i) => survey.jenis_soal[i] != 'Isian');
                survey.jumlah_opsi = survey.jumlah_opsi.filter((data, i) => survey.jenis_soal[i] != 'Isian');
                survey.opsi = survey.opsi.filter((data, i) => data != '' && data != null);

                answer.map((data, i) => {
                    data.pilihan = data.pilihan.filter((f, f_i) => survey.jenis_soal[f_i] != 'Isian');
                });

                survey.jenis_soal = survey.jenis_soal.filter((data, i) => data != 'Isian');

                if (sekolah.length == 0) {
                    $("#load-operator").hide();
                    $("#partisipan").html('0');
                }

                list_sekolah.map((data, key) => {
                    let url = "{{ route('survey.answer.list') }}" +
                        `?session=${survey.id}&npsn=${data.NPSN}`;
                    answer = answer.filter(res => res.npsn == data.NPSN);


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
                        <td rowspan="${row}" class="p-4 font-bold text-center text-gray-700 border border-b-2 whitespace-nowrap underline hover:text-cyan-600 transition-all">
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

                        answer.map((d_answer, i_answer) => {
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

                    })
                });
                $("#tbody").html(html)
                $('#load').hide();
            }

            getResume();
        });
    </script>
@endsection
