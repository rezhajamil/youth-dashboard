@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <div class="flex justify-between mb-4">
                    <h4 class="text-xl font-bold text-gray-600 align-baseline">Data Kunjungan</h4>
                </div>

                {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
                <a href="{{ route('sekolah.pjp.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data Kunjungan</a>
                <button id="capture"
                    class="px-3 py-2 font-semibold text-white rounded h-fit bg-emerald-500 hover:bg-teal-800"><i
                        class="mr-2 fa-solid fa-circle-down"></i>PDF</button>
                <button id="btn-excel"
                    class="px-3 py-2 font-semibold text-white bg-green-800 rounded h-fit hover:bg-emerald-800"><i
                        class="mr-2 fa-solid fa-file-arrow-down"></i>Excel
                </button>
                <div class="flex items-end mb-4 gap-x-3">
                    <input type="text" name="search" id="search" placeholder="Filter..."
                        class="px-4 rounded-lg h-fit">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="kategori">Kategori</option>
                            <option value="regional">Regional</option>
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                            <option value="npsn">NPSN</option>
                            <option value="nama_sekolah">Nama Sekolah</option>
                            <option value="nama">Nama AO</option>
                            <option value="telp">Telp</option>
                            <option value="hari">Hari</option>
                            <option value="frekuensi">Frekuensi</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-auto bg-white rounded-md shadow w-fit" id="pjp-container">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kategori</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Regional</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">NPSN</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama Sekolah
                                </th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama Event</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama AO</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Hari</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Frekuensi</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Waktu</th>
                                @if (Auth::user()->privilege == 'superadmin' || Auth::user()->privilege == 'branch')
                                    <th class="p-3 text-sm font-medium text-gray-100 uppercase action bg-y_tersier">
                                        Action
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($pjp as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b kategori">{{ $data->kategori }}</td>
                                    <td class="p-3 text-gray-700 border-b regional">{{ $data->regional }}</td>
                                    <td class="p-3 text-gray-700 border-b branch">{{ $data->branch }}</td>
                                    <td class="p-3 text-gray-700 border-b cluster">{{ $data->cluster }}</td>
                                    <td class="p-3 text-gray-700 border-b npsn">{{ $data->npsn }}</td>
                                    <td class="p-3 text-gray-700 border-b nama_sekolah whitespace-nowrap">
                                        {{ $data->NAMA_SEKOLAH ?? '-' }}</td>
                                    <td class="p-3 text-gray-700 border-b event">{{ $data->event ?? '-' }}</td>
                                    <td class="p-3 text-gray-700 border-b nama whitespace-nowrap">{{ $data->nama }}
                                    </td>
                                    <td class="p-3 text-gray-700 border-b hari">{{ $data->hari }}</td>
                                    <td class="p-3 text-gray-700 border-b frekuensi">{{ $data->frekuensi }}</td>
                                    @if ($data->date_start || $data->date_end)
                                        <td class="p-3 text-gray-700 border-b whitespace-nowrap">
                                            {{ date('d-m-Y', strtotime($data->date_start)) }} <span
                                                class="font-bold">s/d</span>
                                            {{ date('d-m-Y', strtotime($data->date_end)) }}
                                        </td>
                                    @else
                                        <td class="p-3 text-gray-700 border-b whitespace-nowrap"></td>
                                    @endif
                                    <td class="p-3 text-gray-700 border-b action whitespace-nowrap">
                                        {{-- <a href="{{ route('sekolah.pjp.edit',$data->id) }}" class="block my-1 text-base font-semibold text-blue-600 transition hover:text-blue-800">Edit</a> --}}
                                        <form action="{{ route('sekolah.pjp.destroy', $data->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button
                                                class="block my-1 text-base font-semibold text-left text-red-600 transition whitespace-nowrap hover:text-red-800">Hapus</button>
                                        </form>
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
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function createPDF() {
            var pjpTable = document.getElementById('pjp-container').innerHTML;

            var style = "<style>";
            style = style + "table {width: 100%;font: 17px Calibri;}";
            style = style + "table, th, td {border: solid 1px #B90027; border-collapse: collapse;}";
            style = style + "table, th, td {";
            style = style + "padding: 4px 4px;text-align: center;}";
            style = style + "</style>";

            // CREATE A WINDOW OBJECT.
            var win = window.open('', '', 'height=700,width=700');

            win.document.write('<html><head> ');
            win.document.write(`<title>Data Kunjungan</title>`); // <title> FOR PDF HEADER.
            win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
            win.document.write('</head>');
            win.document.write('<body>');
            win.document.write('<body><h4>Data Kunjungan</h4>');
            win.document.write(pjpTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
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
            });

            $("#search").on("input", function() {
                find();
            });

            $("#search_by").on("input", function() {
                find();
            });

            $("#btn-excel").click(function() {
                exportTableToExcel('pjp-container', `Data PJP`);
            });

            function exportTableToExcel(tableID, filename = '') {
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById(tableID);
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

                // Specify file name
                filename = filename ? filename + '.xls' : 'excel_data.xls';

                // Create download link element
                downloadLink = document.createElement("a");

                document.body.appendChild(downloadLink);

                if (navigator.msSaveOrOpenBlob) {
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob(blob, filename);
                } else {
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                    // Setting the file name
                    downloadLink.download = filename;

                    //triggering the function
                    downloadLink.click();
                }
            }

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
