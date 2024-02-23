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
                <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">
                    Detail {{ $sekolah->NAMA_SEKOLAH }}
                    <a href="{{ route('sekolah.edit', $sekolah->NPSN) }}" class="ml-2 text-y_premier">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </h4>

                <div class="w-fit overflow-auto rounded-md bg-white shadow">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">NPSN</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Kabupaten</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Alamat</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">AO</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            <tr class="hover:bg-gray-200">
                                <td class="t ext-gray-700 border-b p-4 font-bold">{{ $sekolah->NPSN ?? '' }}</td>
                                <td class="border-b p-4 text-gray-700">{{ $sekolah->CITY ?? '' }}</td>
                                <td class="border-b p-4 text-gray-700">{{ $sekolah->ALAMAT ?? '' }}</td>
                                <td class="border-b p-4 text-gray-700">{{ $sekolah->ao ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Profil {{ $sekolah->NAMA_SEKOLAH }}</h4>

                <div class="w-fit overflow-auto rounded-md bg-white shadow">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b">
                            <tr>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jumlah Kelas</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jumlah Siswa</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jumlah Guru</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jumlah Pegawai</th>
                                {{-- <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Tanggal Update</th> --}}
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            <tr class="hover:bg-gray-200">
                                {{-- {{ ddd($data) }} --}}
                                <td class="border-b p-4 text-gray-700">{{ $sekolah->kelas ?? '' }}</td>
                                <td class="border-b p-4 text-gray-700">{{ $sekolah->siswa ?? '' }}</td>
                                <td class="border-b p-4 text-gray-700">{{ $sekolah->guru ?? '' }}</td>
                                <td class="border-b p-4 text-gray-700">{{ $sekolah->pegawai ?? '' }}</td>
                                {{-- <td class="p-4 text-gray-700 border-b">
                                    {{ $sekolah->update_date ? date('Y-m-d', strtotime($sekolah->update_date)) : '' }}
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($sekolah->status == 'P1')
                <div class="mt-4">
                    <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Data P1 </h4>
                    <div class="w-fit overflow-auto rounded-md bg-white shadow">
                        <table class="w-fit border-collapse overflow-auto text-left">
                            <thead class="border-b">
                                <tr>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                        Kepala Sekolah
                                    </th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                        Operator Sekolah
                                    </th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                        Akses Internet
                                    </th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                        Sumber Listrik
                                    </th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Siswa Laki-laki
                                    </th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Siswa Perempuan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="max-h-screen overflow-y-auto">
                                <tr class="hover:bg-gray-200">
                                    <td class="border-b p-3 text-gray-700">{{ $sekolah->nama_kepala_sekolah ?? '' }}</td>
                                    <td class="border-b p-3 text-gray-700">{{ $sekolah->nama_operator ?? '' }}</td>
                                    <td class="border-b p-3 text-gray-700">{{ $sekolah->akses_internet ?? '' }}</td>
                                    <td class="border-b p-3 text-gray-700">{{ $sekolah->sumber_listrik ?? '' }}</td>
                                    <td class="border-b p-3 text-gray-700">{{ $sekolah->jlh_siswa_lk ?? '' }}</td>
                                    <td class="border-b p-3 text-gray-700">{{ $sekolah->jlh_siswa_pr ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if ($site && $outlet && in_array(auth()->user()->privilege, ['superadmin', 'branch']))
                <div class="grid-auto-rows-min mt-4 grid w-full grid-flow-row grid-cols-1 gap-x-3 gap-y-3 sm:grid-cols-3">
                    <div class="w-full">
                        <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Site Terdekat</h4>

                        <div class="w-full overflow-auto rounded-md bg-white shadow">
                            <table class="w-full border-collapse overflow-auto text-left">
                                <thead class="border-b">
                                    <tr>
                                        <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">ID SITE</th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @foreach ($site as $data)
                                        <tr class="hover:bg-gray-200">
                                            <td class="border-b p-4 font-bold text-gray-700">{{ $data->site }}</td>
                                            <td class="whitespace-nowrap border-b p-4 text-gray-700">{{ $data->jarak }} Km
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
                        <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Outlet Terdekat</h4>

                        <div class="w-full overflow-auto rounded-md bg-white shadow">
                            <table class="w-full border-collapse overflow-auto text-left">
                                <thead class="border-b">
                                    <tr>
                                        <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">ID Outlet
                                        </th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @foreach ($outlet as $data)
                                        <tr class="hover:bg-gray-200">
                                            <td class="border-b p-4 font-bold text-gray-700">{{ $data->outlet }}</td>
                                            <td class="whitespace-nowrap border-b p-4 text-gray-700">{{ $data->jarak }}
                                                Km
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
                <div class="flex gap-4">
                    <div class="">
                        <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">FB Share |
                            {{ $sekolah->KECAMATAN }}</h4>

                        <div class="w-fit overflow-auto rounded-md bg-white shadow">
                            <table class="w-fit border-collapse overflow-auto text-left">
                                <thead class="border-b text-center">
                                    <tr>
                                        <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">Tanggal
                                        </th>
                                        <th class="bg-red-600 p-3 text-sm font-medium uppercase text-gray-100">Telkomsel
                                        </th>
                                        <th class="bg-blue-600 p-3 text-sm font-medium uppercase text-gray-100">XL
                                        </th>
                                        <th class="bg-yellow-600 p-3 text-sm font-medium uppercase text-gray-100">Indosat
                                        </th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Tri
                                        </th>
                                        <th class="bg-purple-600 p-3 text-sm font-medium uppercase text-gray-100">Smartfren
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @if ($fb_share)
                                        @foreach ($fb_share as $data)
                                            <tr class="text-center hover:bg-gray-200">
                                                <td class="border-b p-4 font-bold text-gray-700">
                                                    {{ date('d M Y', strtotime($data->tgl)) }}
                                                </td>
                                                <td class="border-b p-4 text-gray-700">
                                                    {{ (float) str_replace(',', '.', $data->tsel) * 100 }}%
                                                </td>
                                                <td class="border-b p-4 text-gray-700">
                                                    {{ (float) str_replace(',', '.', $data->xl) * 100 }}%
                                                </td>
                                                <td class="border-b p-4 text-gray-700">
                                                    {{ (float) str_replace(',', '.', $data->isat) * 100 }}%
                                                </td>
                                                <td class="border-b p-4 text-gray-700">
                                                    {{ (float) str_replace(',', '.', $data->tri) * 100 }}%
                                                </td>
                                                <td class="border-b p-4 text-gray-700">
                                                    {{ (float) str_replace(',', '.', $data->smf) * 100 }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="hover:bg-gray-200">
                                            <td colspan="6" class="border-b p-4 text-center font-bold text-gray-700">
                                                Tidak Ada Data FB Share</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mt-4">
                <div class="flex gap-4">
                    <div class="">
                        <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Kunjungan Terakhir</h4>

                        <div class="w-fit overflow-auto rounded-md bg-white shadow">
                            <table class="w-fit border-collapse overflow-auto text-left">
                                <thead class="border-b">
                                    <tr>
                                        <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">Nama</th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Telp</th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Role</th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Tanggal
                                        </th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Waktu</th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @if ($last_visit)
                                        @foreach ($last_visit as $data)
                                            <tr class="hover:bg-gray-200">
                                                <td class="border-b p-4 font-bold text-gray-700">{{ $data->nama }}</td>
                                                <td class="border-b p-4 text-gray-700">{{ $data->telp }}</td>
                                                <td class="border-b p-4 text-gray-700">{{ $data->role }}</td>
                                                <td class="border-b p-4 text-gray-700">
                                                    {{ date('d-M-Y', strtotime($data->date)) }}</td>
                                                <td class="border-b p-4 text-gray-700">{{ $data->waktu }}</td>
                                                <td class="border-b p-4 text-gray-700">{{ $data->jarak }} Km</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="hover:bg-gray-200">
                                            <td colspan="6" class="border-b p-4 text-center font-bold text-gray-700">
                                                Tidak Ada
                                                Kunjungan</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="">
                        <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Penjualan Bulan Ini</h4>

                        <div class="w-fit overflow-auto rounded-md bg-white shadow">
                            <table class="w-fit border-collapse overflow-auto text-left">
                                <thead class="border-b">
                                    <tr>
                                        <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">Kategori
                                        </th>
                                        <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jumlah
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @if ($sales)
                                        @foreach ($sales as $data)
                                            <tr class="hover:bg-gray-200">
                                                <td class="border-b p-4 font-bold text-gray-700">{{ $data->kategori }}
                                                </td>
                                                <td class="border-b p-4 text-gray-700">{{ $data->jumlah }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="hover:bg-gray-200">
                                            <td colspan="6" class="border-b p-4 text-center font-bold text-gray-700">
                                                Tidak Ada Penjualan</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-8">
                <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Survey Terakhir | Partisipan:<span
                        id="partisipan"></span></h4>
                <div class="mb-8 w-fit overflow-auto rounded-md bg-white shadow">
                    <table class="w-fit border-collapse overflow-auto bg-white text-left" id="table-operator">
                        <thead class="border-b">
                            <tr class="border-b" id="row-operator">
                                <th class="border bg-y_tersier p-3 text-center text-sm font-bold uppercase text-gray-100"
                                    id="col-lainnya">Lainnya</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-operator">
                            <tr id="row-count-operator" class="text-center"></tr>
                            <tr id="row-percent-operator" class="text-center"></tr>
                            <tr id="load-operator" class="bg-tersier text-center font-semibold text-white">
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
            var list_sekolah = JSON.parse($("#list_sekolah").val());
            var sekolah = JSON.parse($("#sekolah").val());
            var site = JSON.parse($("#site").val());
            var outlet = JSON.parse($("#outlet").val());
            let operator = JSON.parse($('#operator').val());
            let kode_operator = JSON.parse($('#kode_operator').val());
            let survey = JSON.parse($('#survey').val());
            let answer = JSON.parse($('#answer').val());
            console.log(survey);

            const createMap = () => {
                var map = L.map('map').setView([parseFloat(sekolah.LATITUDE), parseFloat(sekolah.LONGITUDE)],
                    13);
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
            }

            operator.map(data => {
                $("#row-operator").prepend(
                    `<th class="p-3 text-sm text-center text-gray-100 uppercase border bg-y_tersier" id="col-${data.operator.toString().toLowerCase()}">${data.operator}</th>`
                );
            })

            const getResume = () => {
                if (answer.length == 0) {
                    $("#load td").html('Tidak ada Survey');
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
