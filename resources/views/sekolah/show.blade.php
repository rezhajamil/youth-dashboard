@extends('layouts.dashboard.app')
@section('body')
    <input type="hidden" id="sekolah" value="{{ json_encode($sekolah) }}">
    <input type="hidden" id="site" value="{{ json_encode($site) }}">
    <input type="hidden" id="outlet" value="{{ json_encode($outlet) }}">
    <div class="w-full sm:mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Detail {{ $sekolah->NAMA_SEKOLAH }}</h4>

                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-premier">NPSN</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Kabupaten</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Alamat</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">AO</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">PIC</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Telp PIC</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Kepala Sekolah</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Jumlah Siswa</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Tanggal Update</th>
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
                <div class="grid w-full grid-cols-1 mt-4 gap-y-3 gap-x-3 sm:grid-cols-3">
                    <div class="w-full">
                        <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Site Terdekat</h4>

                        <div class="w-full overflow-auto bg-white rounded-md shadow">
                            <table class="w-full overflow-auto text-left border-collapse">
                                <thead class="border-b">
                                    <tr>
                                        <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-premier">ID SITE</th>
                                        <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @foreach ($site as $data)
                                        <tr class="hover:bg-gray-200">
                                            <td class="p-4 font-bold text-gray-700 border-b">{{ $data->site }}</td>
                                            <td class="p-4 text-gray-700 border-b">{{ $data->jarak }} Km</td>
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
                                        <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-premier">ID Outlet</th>
                                        <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-screen overflow-y-auto">
                                    @foreach ($outlet as $data)
                                        <tr class="hover:bg-gray-200">
                                            <td class="p-4 font-bold text-gray-700 border-b">{{ $data->outlet }}</td>
                                            <td class="p-4 text-gray-700 border-b">{{ $data->jarak }} Km</td>
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
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-premier">Nama</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Telp</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Role</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Tanggal</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Waktu</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Jarak</th>
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
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var sekolah = JSON.parse($("#sekolah").val());
            var site = JSON.parse($("#site").val());
            var outlet = JSON.parse($("#outlet").val());
            console.log(sekolah);

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
                // L.circle([parseFloat(data.lattitude), parseFloat(data.longitude)], {
                //     color: '#B90027',
                //     fillColor: '#B90027',
                //     fillOpacity: 0.5,
                //     radius: 30,
                //     className: 'fa-solid fa-wifi text-white text-2xl'
                // }).addTo(map).bindPopup(
                //     `<a target='_blank' href='http://maps.google.com/maps?z=12&t=m&q=loc:${data.lattitude}+${sekolah.longitude}"'>Outlet : ${data.outlet}</a>`
                // );

                L.marker([parseFloat(data.lattitude), parseFloat(data.longitude)], {
                    icon: iconOutlet,
                    riseOnHover: true,
                }).addTo(
                    map).bindPopup(
                    `<a target='_blank' href='http://maps.google.com/maps?z=12&t=m&q=loc:${data.lattitude}+${sekolah.longitude}"'>Outlet : ${data.outlet}</a>`
                );
            });
        });
    </script>
@endsection
