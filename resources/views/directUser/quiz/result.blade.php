@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md w-fit hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="inline-block mb-2 text-xl font-bold text-gray-600 align-baseline" id="title">{{ $quiz->nama }}</h4>
            <button class="px-2 py-1 ml-2 text-lg text-white transition bg-green-600 rounded-md hover:bg-green-800" id="capture"><i class="fa-regular fa-circle-down"></i></button>
            @if (!request()->get('jenis')&&request()->get('jenis')!='event')
            <div class="my-4 overflow-auto bg-white rounded-md shadow w-fit" id="resume-container">
                <table class="overflow-auto text-left bg-white border-collapse w-fit resume">
                    <thead class="border-b resume">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600 resume">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600 resume">Regional</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600 resume">Branch</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600 resume">Cluster</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600 resume">Partisipan</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600 resume">Dari</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto resume">
                        @foreach ($resume as $key=>$data)
                        @if ($data->cluster!='test')
                        <tr>
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b resume">{{ $key }}</td>
                            <td class="p-4 text-gray-700 border-b resume">{{ $data->regional }}</td>
                            <td class="p-4 text-gray-700 border-b resume">{{ $data->branch }}</td>
                            <td class="p-4 text-gray-700 border-b resume">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 border-b resume">{{ $data->partisipan }}</td>
                            <td class="p-4 text-gray-700 border-b resume">{{ $data->total }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <div class="flex flex-wrap items-end my-3 gap-x-4">
                <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                <div class="flex flex-col">
                    {{-- <span class="font-bold text-gray-600">Berdasarkan</span> --}}
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="nama">Berdasarkan Nama</option>
                        <option value="telp">Berdasarkan Telepon</option>
                        <option value="role">Berdasarkan Role</option>
                    </select>
                </div>
            </div>

            <div class="overflow-auto bg-white rounded-md shadow w-fit" id="result-container">
                <table class="overflow-auto text-left bg-white border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            @if(request()->get('jenis')=='event')
                            {{-- <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">NPSN</th> --}}
                            @else
                            <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            @endif
                            <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Telp</th>
                            @if(request()->get('jenis')=='event')
                            <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Email</th>
                            @else
                            <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Role</th>
                            @endif
                            <th colspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Hasil</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Skor</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 action">Action</th>
                        </tr>
                        <tr>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Benar</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Soal</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($answer as $key=>$data)
                        <tr>
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            @if(request()->get('jenis')=='event')
                            {{-- <td class="p-4 text-gray-700 border-b cluster">{{ $data->npsn }}</td> --}}
                            @else
                            <td class="p-4 text-gray-700 border-b cluster">{{ $data->cluster }}</td>
                            @endif
                            <td class="p-4 text-gray-700 border-b nama">{{ ucwords(strtolower($data->nama)) }}</td>
                            <td class="p-4 text-gray-700 border-b telp">{{ $data->telp }}</td>
                            @if(request()->get('jenis')=='event')
                            <td class="p-4 text-gray-700 border-b cluster">{{ $data->email }}</td>
                            @else
                            <td class="p-4 text-gray-700 border-b cluster">{{ $data->role }}</td>
                            @endif
                            <td class="p-4 text-gray-700 border-b">{{ $data->hasil }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ count(json_decode($quiz->soal)) }}</td>
                            <td class="p-4 font-bold border-b text-sekunder">{{ number_format(($data->hasil/count(json_decode($quiz->soal))*100),0,".",",") }}</td>
                            @if($data->pilihan)
                            <td class="p-4 font-bold border-b text-sekunder action"><a href="{{ route('quiz.show_answer',$data->id) }}" class="px-3 py-2 font-semibold text-white transition-all bg-orange-600 rounded whitespace-nowrap hover:bg-orange-800">Lihat Jawaban</a></td>
                            @endif
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
        var resumeTable = document.getElementById('resume-container').innerHTML;
        var resultTable = document.getElementById('result-container').innerHTML;


        var style = "<style>";
        style = style + "table {width: 100%;font: 17px Calibri;}";
        style = style + "table.resume, th.resume, td.resume {border: solid 1px #B90027; border-collapse: collapse;}";
        style = style + "table, th, td {border: solid 1px #ccc; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: center;}";
        style = style + "</style>";

        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');

        win.document.write('<html><head> ');
        win.document.write(`<title>Hasil ${$('#title').text()}</title>`); // <title> FOR PDF HEADER.
        win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write('<body><h4>Resume Quiz</h4>');
        win.document.write(resumeTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('<br/>');
        win.document.write('<br/>');
        win.document.write('<br/>');
        win.document.write('<br/>');
        win.document.write('<br/>');
        win.document.write('<h4>Skor Quiz</h4>');
        win.document.write(resultTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('</body> </html > ');

        win.document.close(); // CLOSE THE CURRENT WINDOW.

        win.print(); // PRINT THE CONTENTS.
    }

</script>
<script>
    $(document).ready(function() {
        $('#capture').click(function() {
            $(".action").hide();
            createPDF()
            $(".action").show();
        })

        $("#search").on("input", function() {
            find();
        });

        $("#search_by").on("input", function() {
            find();
        });

        const find = () => {
            let search = $("#search").val();
            let searchBy = $('#search_by').val();
            let pattern = new RegExp(search, "i");
            $(`.${searchBy}`).each(function() {
                let label = $(this).text();
                if (pattern.test(label)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        }


    })

</script>
@endsection
