@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <div class="flex items-center gap-x-3">
                    <a href="{{ url()->previous() }}"
                        class="inline-block px-4 py-2 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-y_premier"><i
                            class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
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
                            class="inline-block px-4 py-2 font-bold text-white transition-all bg-orange-600 rounded-md hover:bg-orange-800">Ganti
                            Tanggal</button>
                    </form>
                    <button class="px-2 py-1 ml-2 text-lg text-white transition bg-green-600 rounded-md hover:bg-green-800"
                        id="capture"><i class="fa-regular fa-circle-down"></i></button>
                </div>

                <input type="hidden" id="title" value="{{ "Rapor $user->nama | Bulan $month, Tahun $year" }}">

                <div class="flex my-4 gap-x-3">
                    <h4 class="mb-2 text-2xl font-bold align-baseline text-y_premier">Bulan {{ $month }}, Tahun
                        {{ $year }}</h4>
                </div>

                <div id="report-container">
                    <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Hasil Quiz Oleh {{ $user->nama }}
                    </h4>

                    <div class="mb-10 overflow-auto bg-white rounded-md shadow w-fit">
                        <table class="overflow-auto text-left border-collapse w-fit">
                            <thead class="border-b">
                                <tr>
                                    <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                    <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Date</th>
                                    <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Judul</th>
                                    <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Soal</th>
                                    <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Hasil</th>
                                    <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Selesai</th>
                                </tr>
                            </thead>
                            <tbody class="max-h-screen overflow-y-auto">
                                @foreach ($quiz as $key => $data)
                                    <tr class="hover:bg-gray-200">
                                        {{-- {{ ddd($data) }} --}}
                                        <td class="p-4 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                        <td class="p-4 text-gray-700 border-b">{{ date('d-M-Y', strtotime($data->date)) }}
                                        </td>
                                        <td class="p-4 text-gray-700 border-b">{{ $data->nama }}</td>
                                        <td class="p-4 text-gray-700 border-b">{{ count(json_decode($data->soal)) }}</td>
                                        <td class="p-4 text-gray-700 border-b">{{ $data->hasil }}</td>
                                        <td class="p-4 text-gray-700 border-b">
                                            @if ($data->finish)
                                                <span class="font-semibold text-green-600">Selesai</span>
                                            @else
                                                <span class="font-semibold text-premier">Tidak Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($quiz) == 0)
                                    <td class="p-4 font-bold text-center bg-white" colspan="6">Tidak Ada Quiz</td>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Absensi Oleh {{ $user->nama }}</h4>
                    <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                        <table class="text-left border-collapse w-fit">
                            <thead class="border-b">
                                <tr>
                                    <th
                                        class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 bg-y_tersier">
                                        Info</th>
                                    @foreach ($period as $data)
                                        <th
                                            class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 whitespace-nowrap bg-y_tersier">
                                            {{ date('d', strtotime($data)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="transition hover:bg-gray-200/40">
                                    <td class="p-2 text-gray-700 uppercase border-2 ">
                                        <span class="block font-semibold whitespace-nowrap">Kehadiran</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="p-2 text-xl text-center text-green-600 uppercase border-2">
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
                                    <td class="p-2 text-gray-700 uppercase border-2 ">
                                        <span class="block font-semibold whitespace-nowrap">Jarak (Km)</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="p-2 text-center text-gray-700 border-2 ">
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
                                    <td class="p-2 text-gray-700 uppercase border-2 ">
                                        <span class="block font-semibold whitespace-nowrap">Time In (Wib)</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="p-2 text-center text-gray-700 border-2 ">
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
                                    <td class="p-2 text-gray-700 uppercase border-2 ">
                                        <span class="block font-semibold whitespace-nowrap">Jarak Keluar (Km)</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="p-2 text-center text-gray-700 border-2 ">
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
                                    <td class="p-2 text-gray-700 uppercase border-2 ">
                                        <span class="block font-semibold whitespace-nowrap">Time Out (Wib)</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="p-2 text-center text-gray-700 border-2 ">
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
                                    <td class="p-2 text-gray-700 uppercase border-2 ">
                                        <span class="block font-semibold whitespace-nowrap">Durasi</span>
                                    </td>
                                    @foreach ($period as $item)
                                        <td class="p-2 text-center text-gray-700 border-2 ">
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

                    <h4 class="mt-6 mb-2 text-xl font-bold text-gray-600 align-baseline">KPI {{ $user->nama }}</h4>
                    <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                        <table class="overflow-auto text-left border-collapse w-fit">
                            <thead class="border-b">
                                <tr>
                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                        Broadband</th>
                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                        Digital</th>
                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                        Orbit
                                    </th>
                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                        Migrasi</th>
                                    <th colspan="2"
                                        class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                        Trade In</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Sales</th>

                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">
                                        Update Data</th>
                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">
                                        Update PJP Harian</th>
                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">
                                        Survey Market</th>
                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">
                                        Channeling OSK & OSS</th>
                                    <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">
                                        Product Knowledge</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Proses</th>

                                    <th class="p-3 font-medium text-gray-100 uppercase bg-black border">Total</th>
                                </tr>
                                <tr>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['broadband']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['broadband']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['digital']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['digital']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['orbit']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['orbit']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['migrasi']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['migrasi']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['trade']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['trade']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $sales }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['update_data']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['update_data']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['pjp']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['pjp']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['survey']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['survey']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['oss_osk']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['oss_osk']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['quiz']['target'] }}</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $list_target['quiz']['bobot'] }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $proses }}%</th>
                                    <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                        {{ $sales + $proses }}%</th>
                                </tr>
                            </thead>
                            <tbody class="max-h-screen overflow-y-auto">
                                @foreach ($kpi as $key => $data)
                                    <tr class="">
                                        <td class="p-2 border">{{ $data->broadband ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_broadband ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->digital ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_digital ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->orbit ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_orbit ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->migrasi ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_migrasi ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->trade ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_trade ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->tot_sales }}%</td>

                                        <td class="p-2 border">{{ $data->update_data ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_update_data ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->pjp ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_pjp ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->survey ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_survey ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->oss_osk ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_oss_osk ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->quiz ?? '-' }}</td>
                                        <td class="p-2 border">{{ $data->ach_quiz ?? '-' }}%</td>
                                        <td class="p-2 border">{{ $data->tot_proses }}%</td>
                                        <td class="p-2 border">{{ $data->total }}%</td>
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
