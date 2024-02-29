@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <a href="{{ url()->previous() }}"
                    class="my-2 block w-fit rounded-md bg-y_premier px-4 py-2 font-bold text-white hover:bg-y_premier"><i
                        class="fa-solid fa-arrow-left mr-2"></i> Kembali</a>
                <h4 class="mb-2 inline-block align-baseline text-xl font-bold text-gray-600" id="title">
                    {{ $quiz->nama }}</h4>
                <button class="ml-2 rounded-md bg-green-600 px-2 py-1 text-lg text-white transition hover:bg-green-800"
                    id="capture"><i class="fa-regular fa-circle-down"></i></button>
                @if (!request()->get('jenis') && request()->get('jenis') != 'event')
                    <div class="my-4 w-fit overflow-auto rounded-md bg-white shadow" id="resume-container">
                        <table class="resume w-fit border-collapse overflow-auto bg-white text-left">
                            <thead class="resume border-b">
                                <tr>
                                    <th class="resume bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">No</th>
                                    <th class="resume bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Regional
                                    </th>
                                    <th class="resume bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Branch
                                    </th>
                                    <th class="resume bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Cluster
                                    </th>
                                    <th class="resume bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                        Partisipan</th>
                                    <th class="resume bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Dari
                                    </th>
                                    <th class="resume bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">%
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="resume max-h-screen overflow-y-auto">
                                @foreach ($resume as $key => $data)
                                    @if ($data->cluster != 'test')
                                        <tr>
                                            {{-- {{ ddd($data) }} --}}
                                            <td class="resume border-b p-4 font-bold text-gray-700">{{ $key + 1 }}</td>
                                            <td class="resume border-b p-4 text-gray-700">{{ $data->regional }}</td>
                                            <td class="resume border-b p-4 text-gray-700">{{ $data->branch }}</td>
                                            <td class="resume border-b p-4 text-gray-700">{{ $data->cluster }}</td>
                                            <td class="resume border-b p-4 text-gray-700">{{ $data->partisipan }}</td>
                                            <td class="resume border-b p-4 text-gray-700">{{ $data->total }}</td>
                                            <td class="resume border-b p-4 text-gray-700">
                                                {{ number_format(($data->partisipan / $data->total) * 100, 0) }}%</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="my-3 flex flex-wrap items-end gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="rounded-lg px-4">
                    <div class="flex flex-col">
                        {{-- <span class="font-bold text-gray-600">Berdasarkan</span> --}}
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="nama">Berdasarkan Nama</option>
                            <option value="telp">Berdasarkan Telepon</option>
                            <option value="role">Berdasarkan Role</option>
                        </select>
                    </div>
                </div>

                <div class="w-fit overflow-auto rounded-md bg-white shadow" id="result-container">
                    <table class="w-fit border-collapse overflow-auto bg-white text-left">
                        <thead class="border-b">
                            <tr>
                                <th rowspan="2" class="bg-y_tersier p-3 text-sm font-bold uppercase text-gray-100">No
                                </th>
                                @if (request()->get('jenis') == 'event')
                                    {{-- <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">NPSN</th> --}}
                                @else
                                    <th rowspan="2" class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                        Cluster</th>
                                @endif
                                <th rowspan="2" class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Nama
                                </th>
                                <th rowspan="2" class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Telp
                                </th>
                                @if (request()->get('jenis') == 'event')
                                    <th rowspan="2" class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                        Email</th>
                                @else
                                    <th rowspan="2" class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                        Role</th>
                                @endif
                                <th colspan="2"
                                    class="bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">Hasil
                                </th>
                                <th rowspan="2" class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Skor
                                </th>
                                <th rowspan="2" class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">
                                    Durasi
                                </th>
                                @if (auth()->user()->privilege == 'superadmin' || !$quiz->status)
                                    <th rowspan="2"
                                        class="action bg-y_tersier p-3 text-center text-sm font-medium uppercase text-gray-100">
                                        Action</th>
                                @endif
                            </tr>
                            <tr>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Benar</th>
                                <th class="bg-y_tersier p-3 text-sm font-medium uppercase text-gray-100">Soal</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($answer as $key => $data)
                                <tr>
                                    <td class="border-b p-4 font-bold text-gray-700">{{ $key + 1 }}</td>
                                    @if (request()->get('jenis') == 'event')
                                        {{-- <td class="p-4 text-gray-700 border-b cluster">{{ $data->npsn }}</td> --}}
                                    @else
                                        <td class="cluster border-b p-4 text-gray-700">{{ $data->cluster }}</td>
                                    @endif
                                    <td class="nama border-b p-4 text-gray-700">{{ ucwords(strtolower($data->nama)) }}</td>
                                    <td class="telp border-b p-4 text-gray-700">{{ $data->telp }}</td>
                                    @if (request()->get('jenis') == 'event')
                                        <td class="cluster border-b p-4 text-gray-700">{{ $data->email }}</td>
                                    @else
                                        <td class="cluster border-b p-4 text-gray-700">{{ $data->role }}</td>
                                    @endif
                                    <td class="border-b p-4 text-gray-700">{{ $data->hasil }}</td>
                                    <td class="border-b p-4 text-gray-700">{{ count(json_decode($quiz->soal)) }}</td>
                                    <td class="border-b p-4 font-bold text-sekunder">
                                        {{ number_format(($data->hasil / count(json_decode($quiz->soal))) * 100, 0, '.', ',') }}
                                    </td>
                                    <td class="border-b p-4 text-gray-700">
                                        {{ $data->durasi ? $data->durasi . ' detik' : 'Tidak Selesai' }} </td>
                                    @if ($data->pilihan && (auth()->user()->privilege == 'superadmin' || !$quiz->status))
                                        <td class="action border-b p-4 font-bold text-sekunder"><a
                                                href="{{ route('quiz.show_answer', $data->id) }}"
                                                class="whitespace-nowrap rounded bg-orange-600 px-3 py-2 font-semibold text-white transition-all hover:bg-orange-800">Lihat
                                                Jawaban</a></td>
                                    @else
                                        <td class="action border-b p-4 font-bold text-sekunder"></td>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>
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
