@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md w-fit hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="inline-block mb-2 text-xl font-bold text-gray-600 align-baseline" id="title">{{ $survey->nama }}</h4>
            {{-- <button class="px-2 py-1 ml-2 text-lg text-white transition bg-green-600 rounded-md hover:bg-green-800" id="capture"><i class="fa-regular fa-circle-down"></i></button> --}}

            <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit" id="result-container">
                <table class="overflow-auto text-left bg-white border-collapse w-fit">
                    <thead class="border-b">
                        <tr class="border-b">
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Soal</th>
                            <th colspan="5" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Opsi</th>
                        </tr>
                        <tr class="border-b">
                            <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase bg-red-600 border">A</th>
                            <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase bg-red-600 border">B</th>
                            <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase bg-red-600 border">C</th>
                            <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase bg-red-600 border">D</th>
                            <th class="p-3 text-sm font-bold text-center text-gray-100 uppercase bg-red-600 border">E</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($hasil as $key=>$data)
                        <tr>
                            <td class="p-4 font-bold text-gray-700 border border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data['A'] }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data['B'] }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data['C'] }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data['D'] }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data['E'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


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
                        <tr class="border-b">
                            <th rowspan="2" class="p-3 text-sm font-bold text-center text-gray-100 uppercase bg-red-600 border">No</th>
                            <th colspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">DS</th>
                            <th colspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Siswa</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Action</th>
                        </tr>
                        <tr class="">
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Cluster</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Telp</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Nama</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Sekolah</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Kelas</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase bg-red-600 border">Telp</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($answer as $key=>$data)
                        <tr>
                            <td class="p-4 font-bold text-gray-700 border border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data->telp }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data->nama }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data->NAMA_SEKOLAH }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data->kelas }}</td>
                            <td class="p-4 text-gray-700 border border-b">{{ $data->telp_siswa }}</td>
                            @if($data->pilihan)
                            <td class="p-4 font-bold border border-b text-sekunder"><a href="{{ route('survey.show_answer',$data->id) }}" class="px-3 py-2 font-semibold text-white transition-all bg-orange-600 rounded whitespace-nowrap hover:bg-orange-800">Lihat Jawaban</a></td>
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
            createPDF()
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
