@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="mb-2 align-baseline text-xl font-bold text-y_premier">FB Share | {{ $kecamatan }} |
                    {{ $mtd }}
                </h4>

                <div class="mb-10 w-fit overflow-auto rounded-md bg-white shadow" id="clock-container">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b text-center">
                            <tr>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">No
                                </th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">NPSN
                                </th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Nama Sekolah
                                </th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Clock In
                                    Terakhir
                                </th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Nama DS
                                </th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Jumlah Siswa
                                </th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Market Share
                                </th>
                                <th class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto text-center">
                            @foreach ($detail as $idx => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="whitespace-nowrap border p-2 font-bold text-gray-700">
                                        {{ $idx + 1 }}
                                    </td>
                                    <td class="whitespace-nowrap border p-2 text-gray-700">
                                        {{ $data->npsn }}
                                    </td>
                                    <td class="whitespace-nowrap border p-2 text-gray-700">
                                        {{ $data->nama_sekolah }}
                                    </td>
                                    <td class="whitespace-nowrap border p-2 text-gray-700">
                                        {{ $data->clockin }}
                                    </td>
                                    <td class="whitespace-nowrap border p-2 text-gray-700">
                                        {{ ucwords(strtolower($data->ds)) }}
                                    </td>
                                    <td class="whitespace-nowrap border p-2 text-gray-700">
                                        {{ $data->jumlah_siswa }}
                                    </td>
                                    <td
                                        class="{{ $data->survey < 50 ? 'text-red-600' : 'text-gray-700' }} whitespace-nowrap border p-2">
                                        {{ round($data->survey, 0) }}%
                                        @if ($data->survey < 50)
                                            <span class="ml-2 text-red-600">
                                                <i class="fa-solid fa-circle-exclamation font-bold text-red-600"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        <a href="{{ route('sekolah.show', $data->npsn) }}" target="_blank"
                                            class="my-1 block whitespace-nowrap text-base font-semibold text-teal-600 transition hover:text-teal-800">Detail
                                            Sekolah</a>
                                    </td>
                                </tr>
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
