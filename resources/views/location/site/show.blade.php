@extends('layouts.dashboard.app')
@section('body')
    <input type="hidden" id="site" value="{{ json_encode($site) }}">
    <input type="hidden" id="sekolah" value="{{ json_encode($sekolah) }}">
    <input type="hidden" id="outlet" value="{{ json_encode($outlet) }}">

    <input type="hidden" name="operator" id="operator" value="{{ json_encode($operator) }}">
    <input type="hidden" name="kode_operator" id="kode_operator" value="{{ json_encode($kode_operator) }}">
    <input type="hidden" name="survey" id="survey" value="{{ json_encode($survey) }}">
    <input type="hidden" name="answer" id="answer" value="{{ json_encode($answer) }}">

    <div class="w-full sm:mx-4">
        <div class="flex flex-col">
            @if ($sekolah && $outlet && auth()->user()->privilege == 'superadmin')
                <div class="grid w-full grid-flow-row grid-cols-1 mt-4 gap-y-3 gap-x-3 sm:grid-cols-3 grid-auto-rows-min">
                    <div class="w-full">
                        <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Sekolah Terdekat</h4>

                        <div class="w-full overflow-auto bg-white rounded-md shadow">
                            <table class="w-full overflow-auto text-left border-collapse">
                                <thead class="border-b">
                                    <tr>
                                        <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">Nama</th>
                                        <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @foreach ($sekolah as $data)
                                        <tr class="hover:bg-gray-200">
                                            <td class="p-4 font-bold text-gray-700 border-b">{{ $data->sekolah }}</td>
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
                                        <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">Nama Outlet
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
            <div class="mt-8">
                <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Survey Terakhir | Partisipan:<span
                        id="partisipan"></span></h4>
                <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left bg-white border-collapse w-fit" id="table-operator">
                        <thead class="border-b">
                            <tr class="border-b" id="row-operator">
                                <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase border bg-y_tersier"
                                    id="col-lainnya">Lainnya</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-operator">
                            <tr id="row-count-operator" class="text-center"></tr>
                            <tr id="row-percent-operator" class="text-center"></tr>
                            <tr id="load-operator" class="font-semibold text-center text-white bg-tersier">
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
    <script>
        $(document).ready(function() {
            var site = JSON.parse($("#site").val());
            var sekolah = JSON.parse($("#sekolah").val());
            var outlet = JSON.parse($("#outlet").val());
            let operator = JSON.parse($('#operator').val());
            let kode_operator = JSON.parse($('#kode_operator').val());
            let survey = JSON.parse($('#survey').val());
            let answer = JSON.parse($('#answer').val());
            console.log({
                operator,
                kode_operator,
                survey,
                answer
            });
            const createMap = () => {
                var map = L.map('map').setView([parseFloat(site.latitude), parseFloat(site.longitude)],
                    13);
                var iconSite = L.divIcon({
                    className: 'fa-solid fa-wifi text-red-600 text-2xl'
                });
                var iconSekolah = L.divIcon({
                    className: 'fa-solid fa-school text-indigo-600 text-2xl'
                });
                var iconOutlet = L.divIcon({
                    className: 'fa-solid fa-shop text-y_premier text-2xl'
                });

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?foo=bar', {
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                var marker = L.marker([parseFloat(site.latitude), parseFloat(site.longitude)]).addTo(
                    map).bindPopup(
                    `<b><a target='_blank' href='http://maps.google.com/maps?z=12&t=m&q=loc:${site.latitude}+${site.longitude}"'>${site.site_id}</a></b>`
                ).openPopup();

                sekolah.map((data, i) => {
                    L.marker([parseFloat(data.LATITUDE), parseFloat(data.LONGITUDE)], {
                        icon: iconSekolah,
                        riseOnHover: true,
                    }).addTo(
                        map).bindPopup(
                        `<a target='_blank' href='http://maps.google.com/maps?z=12&t=m&q=loc:${data.LATITUDE}+${data.LONGITUDE}"'>Sekolah : ${data.sekolah}</a>`
                    );

                });

                outlet.map((data, i) => {
                    L.marker([parseFloat(data.lattitude), parseFloat(data.longitude)], {
                        icon: iconOutlet,
                        riseOnHover: true,
                    }).addTo(
                        map).bindPopup(
                        `<a target='_blank' href='http://maps.google.com/maps?z=12&t=m&q=loc:${data.lattitude}+${data.longitude}"'>Outlet : ${data.outlet}</a>`
                    );
                });
            }
            operator.map(data => {
                $("#row-operator").prepend(
                    `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier" id="col-${data.operator.toString().toLowerCase()}">${data.operator}</th>`
                );
            })

            const getResume = () => {
                if (answer.length == 0) {
                    console.log(answer.length);
                    $("#load-operator td").html('Tidak ada Survey');
                    return;
                    console.log($("#load td"));
                }

                $("#row-count-operator").html('');
                $("#row-percent-operator").html('');
                $("#tbody").html('');
                $("#load").show();
                $("#partisipan").html(answer.length)
                html = '';

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

                console.log({
                    answer: answer
                });
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
            }

            getResume();
            createMap();
        });
    </script>
@endsection
