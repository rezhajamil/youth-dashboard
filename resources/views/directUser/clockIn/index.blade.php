@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="mb-2 align-baseline text-xl font-bold text-y_premier">Clock In {{ $date }}</h4>
                <div class="mb-6 flex items-center gap-x-3">
                    <form action="{{ route('direct_user.clock_in') }}" method="get">
                        <select name="cluster" id="cluster" required>
                            <option value="" selected disabled>Pilih Cluster</option>
                            @foreach ($list_cluster as $data)
                                <option value="{{ $data->cluster }}" {{ $data->cluster == $cluster ? 'selected' : '' }}>
                                    {{ $data->cluster }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="date" id="date" class="rounded-lg px-4"
                            value="{{ request()->get('date') }}" required>
                        <button type="submit"
                            class="inline-block rounded-md bg-y_premier px-4 py-2 font-bold text-white transition-all hover:bg-sky-800"><i
                                class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                    </form>
                    <a href="{{ route('direct_user.resume_clock_in') }}" target="_blank"
                        class="my-2 inline-block rounded-md bg-y_sekunder px-4 py-2 font-semibold text-white transition-all hover:bg-y_sekunder"><i
                            class="fa-solid fa-book mr-2"></i>Resume</a>
                    <a href="{{ route('direct_user.monthly_clock_in') }}" target="_blank"
                        class="my-2 inline-block rounded-md bg-y_tersier px-4 py-2 font-semibold text-white transition-all hover:bg-y_tersier"><i
                            class="fa-solid fa-calendar mr-2"></i>Monthly</a>
                    <button
                        class="ml-2 h-full rounded-md bg-green-600 px-2 py-1 text-lg text-white transition hover:bg-green-800"
                        id="capture"><i class="fa-regular fa-circle-down"></i></button>
                </div>

                <div class="mb-10 w-fit overflow-auto rounded-md bg-white shadow" id="clock-container">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b">
                            <tr>
                                {{-- <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase border bg-y_tersier">No</th> --}}
                                <th rowspan="2"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Nama</th>
                                <th rowspan="2"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Keterangan
                                </th>
                                <th colspan="5"
                                    class="border bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                    Clock In</th>
                            </tr>
                            <tr>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">I</th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">II</th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">III</th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">IV</th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">V</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($clocks as $key => $clock)
                                @if ($key == 0 || $clock->telp != $clocks[$key - 1]->telp)
                                    <tr class="">
                                        {{-- <td rowspan="3" class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td> --}}
                                        <td rowspan="5" class="border border-b-4 p-4 font-bold">
                                            {{ $clock->nama }}<br />({{ $clock->telp }})</td>
                                        <td class="border p-4 font-semibold">Tanggal</td>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($clocks as $data)
                                            @if ($clock->telp == $data->telp && $clock->label == $data->label)
                                                <td class="border p-4">{{ $data->date }}</td>
                                                @php $count++ @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            if ($count < 5) {
                                                for ($i = 0; $i < 5 - $count; $i++) {
                                                    echo "<td class='border bg-gray-400/10 p-4'></td>";
                                                }
                                            }
                                        @endphp
                                    </tr>
                                    <tr>
                                        <td class="border p-4 font-semibold">Waktu</td>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($clocks as $data)
                                            @if ($clock->telp == $data->telp && $clock->label == $data->label)
                                                <td class="border p-4">
                                                    {{ $data->waktu }}

                                                    @if ($data->label == 'MASUK')
                                                        @foreach ($clocks as $d)
                                                            @if ($data->telp == $d->telp && $data->npsn == $d->npsn && $d->label == 'KELUAR')
                                                                <br /> s/d {{ $d->waktu }}
                                                                @php
                                                                    break;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @php $count++ @endphp
                                                </td>
                                            @endif
                                        @endforeach
                                        @php
                                            if ($count < 5) {
                                                for ($i = 0; $i < 5 - $count; $i++) {
                                                    echo "<td class='border bg-gray-400/10 p-4'></td>";
                                                }
                                            }
                                        @endphp
                                    </tr>
                                    <tr>
                                        <td class="border p-4 font-semibold">Lokasi</td>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($clocks as $data)
                                            @if ($clock->telp == $data->telp && $clock->label == $data->label)
                                                <td class="border p-4">{{ $data->lokasi }}</td>
                                                @php $count++ @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            if ($count < 5) {
                                                for ($i = 0; $i < 5 - $count; $i++) {
                                                    echo "<td class='border bg-gray-400/10 p-4'></td>";
                                                }
                                            }
                                        @endphp
                                    </tr>
                                    <tr class="">
                                        <td class="border p-4 font-semibold">Jarak</td>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($clocks as $data)
                                            @if ($clock->telp == $data->telp && $clock->label == $data->label)
                                                <td class="border p-4">{{ str_replace('.', ',', $data->jarak) }} Km</td>
                                                @php $count++ @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            if ($count < 5) {
                                                for ($i = 0; $i < 5 - $count; $i++) {
                                                    echo "<td class='border bg-gray-400/10 p-4'></td>";
                                                }
                                            }
                                        @endphp
                                    </tr>
                                    <tr class="border-b-4">
                                        <td class="border p-4 font-semibold">Penjualan</td>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($clocks as $data)
                                            @if ($clock->telp == $data->telp && $clock->label == $data->label)
                                                @foreach ($sales as $sale)
                                                    @if ($data->telp == $sale->telp && $data->lokasi == $sale->poi)
                                                        <td class="border p-4">{{ str_replace('.', ',', $sale->sales) }}
                                                            MSISDN
                                                        </td>
                                                    @endif
                                                @endforeach
                                                @php $count++ @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            if ($count < 5) {
                                                for ($i = 0; $i < 5 - $count; $i++) {
                                                    echo "<td class='border bg-gray-400/10 p-4'></td>";
                                                }
                                            }
                                        @endphp
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
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
            var clockTable = document.getElementById('clock-container').innerHTML;

            var style = "<style>";
            style = style + "table {width: 100%;font: 17px Calibri;}";
            style = style + "table, th, td {border: solid 1px #B90027; border-collapse: collapse;}";
            style = style + "table, th, td {";
            style = style + "padding: 4px 4px;text-align: center;}";
            style = style + "</style>";

            // CREATE A WINDOW OBJECT.
            var win = window.open('', '', 'height=700,width=700');

            win.document.write('<html><head> ');
            win.document.write(`<title>Data Clock In</title>`); // <title> FOR PDF HEADER.
            win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
            win.document.write('</head>');
            win.document.write('<body>');
            win.document.write('<body><h4>Data Clock In</h4>');
            win.document.write(clockTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
            win.document.write('</body> </html > ');

            win.document.close(); // CLOSE THE CURRENT WINDOW.

            win.print(); // PRINT THE CONTENTS.
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#capture').click(function() {
                createPDF()
            });
        })
    </script>
@endsection
