@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md w-fit hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="inline-block mb-2 text-xl font-bold text-gray-600 align-baseline" id="title">{{ $quiz->nama }}</h4>
            <button class="px-2 py-1 ml-2 text-lg text-white transition bg-green-600 rounded-md hover:bg-green-800" id="capture"><i class="fa-regular fa-circle-down"></i></button>
            <div class="overflow-auto bg-white rounded-md shadow w-fit" id="table-container">
                <table class="overflow-auto text-left bg-white border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Telp</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Hasil</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Skor</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($answer as $key=>$data)
                        <tr>
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ ucwords(strtolower($data->nama)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->telp }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->hasil }}/{{ count(json_decode($quiz->soal)) }}</td>
                            <td class="p-4 font-bold border-b text-sekunder">{{ number_format(($data->hasil/count(json_decode($quiz->soal))*100),0,".",",") }}</td>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script>
    function createPDF() {
        var sTable = document.getElementById('table-container').innerHTML;

        var style = "<style>";
        style = style + "table {width: 100%;font: 17px Calibri;}";
        style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: center;}";
        style = style + "</style>";

        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');

        win.document.write('<html><head> ');
        win.document.write(`<title>Hasil ${$('#title').text()}</title>`); // <title> FOR PDF HEADER.
        win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(sTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('</body> </html > ');

        win.document.close(); // CLOSE THE CURRENT WINDOW.

        win.print(); // PRINT THE CONTENTS.
    }

</script>
<script>
    $(document).ready(function() {
        $('#capture').click(function() {
            createPDF()
        })

    })

</script>
@endsection
