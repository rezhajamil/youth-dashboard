@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <div class="flex items-center gap-x-3">
                    <a href="{{ url()->previous() }}"
                        class="inline-block rounded-md bg-y_premier px-4 py-2 font-bold text-white transition-all hover:bg-y_premier"><i
                            class="fa-solid fa-arrow-left mr-2"></i> Kembali</a>
                    <form class="h-fit" action="{{ route('direct_user.show', $user->id) }}" method="get">
                        <select name="month" id="month" required>
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
                        </select>
                        <button type="submit"
                            class="inline-block rounded-md bg-orange-600 px-4 py-2 font-bold text-white transition-all hover:bg-orange-800">Ganti
                            Tanggal</button>
                    </form>
                    <button class="ml-2 rounded-md bg-green-600 px-2 py-1 text-lg text-white transition hover:bg-green-800"
                        id="capture"><i class="fa-regular fa-circle-down"></i></button>
                </div>

                <input type="hidden" id="title" value="{{ "Rapor $user->nama | Bulan $month, Tahun $year" }}">

                <div class="my-4 flex gap-x-3">
                    <h4 class="mb-2 align-baseline text-2xl font-bold text-y_premier">Bulan {{ $month }}, Tahun
                        {{ $year }}</h4>
                </div>

                <div id="report-container">
                    <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Hasil Quiz Oleh {{ $user->nama }}
                    </h4>

                    <div class="mb-10 w-fit overflow-auto rounded-md bg-white shadow">
                        <table class="w-fit border-collapse overflow-auto text-left">
                            <thead class="border-b">
                                <tr>
                                    <th class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">No</th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Date</th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Judul</th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Soal</th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Hasil</th>
                                    <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Selesai</th>
                                </tr>
                            </thead>
                            <tbody class="max-h-screen overflow-y-auto">
                                @foreach ($quiz as $key => $data)
                                    <tr class="hover:bg-gray-200">
                                        {{-- {{ ddd($data) }} --}}
                                        <td class="border-b p-4 font-bold text-gray-700">{{ $key + 1 }}</td>
                                        <td class="border-b p-4 text-gray-700">{{ date('d-M-Y', strtotime($data->date)) }}
                                        </td>
                                        <td class="border-b p-4 text-gray-700">{{ $data->nama }}</td>
                                        <td class="border-b p-4 text-gray-700">{{ count(json_decode($data->soal)) }}</td>
                                        <td class="border-b p-4 text-gray-700">{{ $data->hasil }}</td>
                                        <td class="border-b p-4 text-gray-700">
                                            @if ($data->finish)
                                                <span class="font-semibold text-green-600">Selesai</span>
                                            @else
                                                <span class="font-semibold text-premier">Tidak Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($quiz) == 0)
                                    <td class="bg-white p-4 text-center font-bold" colspan="6">Tidak Ada Quiz</td>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <h4 class="mb-2 align-baseline text-xl font-bold text-gray-600">Absensi Oleh {{ $user->nama }}</h4>
                    <div class="w-fit overflow-hidden rounded-md bg-white shadow">
                        <table class="w-fit border-collapse text-left">
                            <thead class="border-b">
                                <tr>
                                    <th
                                        class="border-2 bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                        Info</th>
                                    @foreach ($period as $data)
                                        <th
                                            class="whitespace-nowrap border-2 bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                            {{ date('d', strtotime($data)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="transition hover:bg-gray-200/40">
                                    <td class="border-2 p-2 uppercase text-gray-700">
                                        <span class="block whitespace-nowrap font-semibold">Kehadiran</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="border-2 p-2 text-center text-xl uppercase text-green-600">
                                            @foreach ($absensi as $absen)
                                                @if (date('Y-m-d', strtotime($item)) == $absen->date)
                                                    <i class="fa-solid fa-circle-check check"></i>
                                                    <span class="hadir" style="display: none">Hadir</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="transition hover:bg-gray-200/40">
                                    <td class="border-2 p-2 uppercase text-gray-700">
                                        <span class="block whitespace-nowrap font-semibold">Jarak (Km)</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="border-2 p-2 text-center text-gray-700">
                                            @foreach ($absensi as $absen)
                                                @if (date('Y-m-d', strtotime($item)) == $absen->date)
                                                    <span
                                                        class="block whitespace-nowrap">{{ number_format($absen->jarak, 0, ',', '.') }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="transition hover:bg-gray-200/40">
                                    <td class="border-2 p-2 uppercase text-gray-700">
                                        <span class="block whitespace-nowrap font-semibold">Time In (Wib)</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="border-2 p-2 text-center text-gray-700">
                                            @foreach ($absensi as $absen)
                                                @if (date('Y-m-d', strtotime($item)) == $absen->date)
                                                    <span
                                                        class="block whitespace-nowrap">{{ date('H:i:s', strtotime($absen->time_in)) }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="transition hover:bg-gray-200/40">
                                    <td class="border-2 p-2 uppercase text-gray-700">
                                        <span class="block whitespace-nowrap font-semibold">Jarak Keluar (Km)</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="border-2 p-2 text-center text-gray-700">
                                            @foreach ($absensi as $absen)
                                                @if (date('Y-m-d', strtotime($item)) == $absen->date)
                                                    <span
                                                        class="block whitespace-nowrap">{{ number_format($absen->jarak_keluar, 0, ',', '.') }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="transition hover:bg-gray-200/40">
                                    <td class="border-2 p-2 uppercase text-gray-700">
                                        <span class="block whitespace-nowrap font-semibold">Time Out (Wib)</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="border-2 p-2 text-center text-gray-700">
                                            @foreach ($absensi as $absen)
                                                @if (date('Y-m-d', strtotime($item)) == $absen->date)
                                                    {{-- <span class="block whitespace-nowrap">{{ $absen->time_out }}</span> --}}
                                                    <span
                                                        class="block whitespace-nowrap">{{ date('H:i:s', strtotime($absen->time_out)) }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="transition hover:bg-gray-200/40">
                                    <td class="border-2 p-2 uppercase text-gray-700">
                                        <span class="block whitespace-nowrap font-semibold">Durasi</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="border-2 p-2 text-center text-gray-700">
                                            @foreach ($absensi as $absen)
                                                @if (date('Y-m-d', strtotime($item)) == $absen->date)
                                                    {{-- @if ($absen->time_out == '0')
                                    <span class="block whitespace-nowrap">-</span>
                                    @else
                                    <span class="block whitespace-nowrap">{{ $absen->time_out!='0' }}</span>
                                    @endif --}}
                                                    <span
                                                        class="block whitespace-nowrap">{{ gmdate('H:i:s', strtotime($absen->time_out) - strtotime($absen->time_in)) }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4 class="mb-2 mt-6 align-baseline text-xl font-bold text-gray-600">KPI {{ $user->nama }}</h4>
                    <div class="w-fit overflow-hidden rounded-md bg-white shadow">
                        <table class="w-fit border-collapse overflow-auto text-left">
                            <thead class="border-b">
                                <tr>
                                    <th rowspan="2" class="border bg-y_premier p-3 font-bold uppercase text-gray-100">No
                                    </th>
                                    <th rowspan="2" class="border bg-y_premier p-3 font-medium uppercase text-gray-100">
                                        Branch</th>
                                    <th rowspan="2" class="border bg-y_premier p-3 font-medium uppercase text-gray-100">
                                        Cluster</th>
                                    <th rowspan="2" class="border bg-y_premier p-3 font-medium uppercase text-gray-100">
                                        Nama
                                    </th>
                                    <th rowspan="2"
                                        class="border bg-y_premier p-3 font-medium uppercase text-gray-100">ID
                                        Digipos
                                    </th>
                                    <th rowspan="2"
                                        class="border bg-y_premier p-3 font-medium uppercase text-gray-100">Role
                                    </th>

                                    <th colspan="2"
                                        class="border bg-y_tersier p-3 font-medium uppercase text-gray-100">
                                        Broadband</th>
                                    <th colspan="2"
                                        class="border bg-y_tersier p-3 font-medium uppercase text-gray-100">
                                        Digital</th>
                                    <th colspan="2"
                                        class="border bg-y_tersier p-3 font-medium uppercase text-gray-100">Sales
                                        Acquisition</th>
                                    <th class="border bg-y_tersier p-3 font-medium uppercase text-gray-100">Sales</th>

                                    <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">
                                        Update
                                        Data</th>
                                    <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">
                                        Update
                                        PJP Harian</th>
                                    <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">
                                        Survey
                                        Market</th>
                                    <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">
                                        My
                                        Telkomsel</th>
                                    <th colspan="2" class="border bg-tersier p-3 font-medium uppercase text-gray-100">
                                        Product
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
                                @foreach ($kpi as $key => $data)
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

                    <h4 class="mb-2 mt-6 align-baseline text-xl font-bold text-gray-600">Clock In {{ $user->nama }}</h4>
                    <div class="w-fit overflow-hidden rounded-md bg-white shadow">
                        <table class="w-fit border-collapse text-left">
                            <thead class="border-b">
                                <tr>
                                    <th
                                        class="border-2 bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                        Tanggal</th>
                                    <th
                                        class="border-2 bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                        Waktu</th>
                                    <th
                                        class="border-2 bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                        Lokasi</th>
                                    <th
                                        class="border-2 bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                        Jarak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clocks as $clock)
                                    <tr class="transition hover:bg-gray-200/40">
                                        <td class="border-2 p-2 uppercase text-gray-700">
                                            <span class="block whitespace-nowrap">{{ $clock->date }}</span>
                                        </td>
                                        <td class="border-2 p-2 uppercase text-gray-700">
                                            <span class="block whitespace-nowrap">{{ $clock->waktu }}</span>
                                        </td>
                                        <td class="border-2 p-2 uppercase text-gray-700">
                                            <span class="block whitespace-nowrap">{{ $clock->lokasi }}</span>
                                        </td>
                                        <td class="border-2 p-2 uppercase text-gray-700">
                                            <span class="block whitespace-nowrap">{{ $clock->jarak }}
                                                Km</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>
    <script>
        function createPDF() {
            var reportTable = document.getElementById('report-container').innerHTML;

            var style = "<style>";
            style = style + "table {width: 100%;font: 17px Calibri;}";
            style = style + "table, th, td {border: solid 1px #B90027; border-collapse: collapse;}";
            style = style + "table, th, td {";
            style = style + "padding: 4px 4px;text-align: center;}";
            style = style + "</style>";

            // CREATE A WINDOW OBJECT.
            var win = window.open('', '', 'height=700,width=700');

            win.document.write('<html><head> ');
            win.document.write(`<title>${$("#title").val()}</title>`); // <title> FOR PDF HEADER.
            win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
            win.document.write('</head>');
            win.document.write('<body>');
            win.document.write(`<body><h4>${$("#title").val()}</h4>`);
            win.document.write(reportTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
            win.document.write('</body> </html > ');

            win.document.close(); // CLOSE THE CURRENT WINDOW.

            win.print(); // PRINT THE CONTENTS.
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#capture').click(function() {
                $(".check").hide()
                $(".hadir").show()
                createPDF()
                $(".check").show()
                $(".hadir").hide()
            });
        })
    </script>
@endsection
