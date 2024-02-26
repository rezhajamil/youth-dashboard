@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="mb-2 align-baseline text-xl font-bold text-y_premier">FB Share Territory | {{ $mtd }}
                </h4>
                <div class="mb-6 flex items-center gap-x-3">
                    <form action="{{ route('survey.fb_share') }}" method="get">
                        <select name="kabupaten" id="kabupaten" class="rounded-md" required>
                            <option value="" selected disabled>Pilih Kabupaten</option>
                            @foreach ($list_kabupaten as $data)
                                <option value="{{ $data->kabupaten }}"
                                    {{ $data->kabupaten == $kabupaten ? 'selected' : '' }}>
                                    {{ $data->kabupaten }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="inline-block rounded-md bg-y_premier px-4 py-2 font-bold text-white transition-all hover:bg-sky-800"><i
                                class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                    </form>
                </div>

                <div class="mb-10 w-fit overflow-auto rounded-md bg-white shadow" id="clock-container">
                    <table class="w-fit border-collapse overflow-auto text-left">
                        <thead class="border-b text-center">
                            <tr>
                                <th rowspan="2"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Kecamatan
                                </th>
                                <th colspan="5"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">FB Share
                                </th>
                                <th rowspan="2"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">W-1
                                </th>
                                <th rowspan="2"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">W-2
                                </th>
                                <th rowspan="2"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">W-3
                                </th>
                                <th rowspan="2"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Status
                                </th>
                                <th rowspan="2"
                                    class="border bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Action
                                </th>
                            </tr>
                            <tr>
                                <th class="border bg-red-600 p-3 text-sm font-medium uppercase text-gray-100">Telkomsel
                                </th>
                                <th class="border bg-blue-600 p-3 text-sm font-medium uppercase text-gray-100">XL
                                </th>
                                <th class="border bg-yellow-600 p-3 text-sm font-medium uppercase text-gray-100">Indosat
                                </th>
                                <th class="border bg-pink-600 p-3 text-sm font-medium uppercase text-gray-100">Tri
                                </th>
                                <th class="border bg-purple-600 p-3 text-sm font-medium uppercase text-gray-100">Smartfren
                                </th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto text-center">
                            @foreach ($fb_share as $data)
                                @php $score=0; @endphp

                                <tr class="hover:bg-gray-200">
                                    <td class="whitespace-nowrap border p-2 font-bold text-gray-700">{{ $data->district }}
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        {{ $data->tsel * 100 }}%
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        {{ $data->xl * 100 }}%
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        {{ $data->isat * 100 }}%
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        {{ $data->tri * 100 }}%
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        {{ $data->smf * 100 }}%
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        <div class="flex items-center gap-2">
                                            @if ($data->tsel >= $data->w1)
                                                <i class="fa-solid fa-caret-up font-bold text-green-600"></i>
                                                @php $score+=1 @endphp
                                            @else
                                                <i class="fa-solid fa-caret-down font-bold text-red-600"></i>
                                                @php $score-=1 @endphp
                                            @endif
                                            <span
                                                class="{{ $data->tsel > $data->w1 ? 'text-green-600' : 'text-red-600' }} font-semibold">{{ round(abs($data->tsel - $data->w1), 4) * 100 }}%</span>
                                        </div>
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        <div class="flex items-center gap-2">
                                            @if ($data->w1 >= $data->w2)
                                                <i class="fa-solid fa-caret-up font-bold text-green-600"></i>
                                                @php $score+=1 @endphp
                                            @else
                                                <i class="fa-solid fa-caret-down font-bold text-red-600"></i>
                                                @php $score-=1 @endphp
                                            @endif
                                            <span
                                                class="{{ $data->w1 > $data->w2 ? 'text-green-600' : 'text-red-600' }} font-semibold">{{ round(abs($data->w1 - $data->w2), 4) * 100 }}%</span>
                                        </div>
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        <div class="flex items-center gap-2">
                                            @if ($data->w2 >= $data->w3)
                                                <i class="fa-solid fa-caret-up font-bold text-green-600"></i>
                                                @php $score+=1 @endphp
                                            @else
                                                <i class="fa-solid fa-caret-down font-bold text-red-600"></i>
                                                @php $score-=1 @endphp
                                            @endif
                                            <span
                                                class="{{ $data->w2 > $data->w3 ? 'text-green-600' : 'text-red-600' }} font-semibold">{{ round(abs($data->w2 - $data->w3), 4) * 100 }}%</span>
                                        </div>
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        @if ($score > 0)
                                            <i class="fa-solid fa-circle-exclamation font-bold text-green-600"></i>
                                        @else
                                            <i class="fa-solid fa-circle-exclamation font-bold text-red-600"></i>
                                        @endif
                                    </td>
                                    <td class="border p-2 text-gray-700">
                                        <a href="{{ route('survey.fb_share_detail', ['kecamatan' => $data->district]) }}"
                                            target="_blank"
                                            class="my-1 block text-base font-semibold text-teal-600 transition hover:text-teal-800">Detail</a>
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
