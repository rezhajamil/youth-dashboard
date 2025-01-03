@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Data Direct User</h4>

                <div class="flex flex-wrap items-end mb-2 gap-x-4">
                    <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="regional">Regional</option>
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                            <option value="tap">TAP</option>
                            <option value="nama">Nama</option>
                            <option value="telp">Telp</option>
                            <option value="role">Role</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Status</span>
                        <select name="filter_status" id="filter_status" class="rounded-lg">
                            <option value="">All</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
                <a href="{{ route('direct_user.create') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data User Baru</a>
                <button id="btn-excel"
                    class="inline-block px-4 py-2 my-2 font-semibold text-white transition-all bg-teal-600 rounded-md hover:bg-teal-800">
                    <i class="mr-2 fa-solid fa-file-arrow-down"></i>Excel
                </button>

                <div class="overflow-auto bg-white rounded-md shadow w-fit" id="table-container">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Regional</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">TAP</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Telp</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Digipos</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Reff Orbit</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Link Aja</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Role</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Status</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-3 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b regional">{{ $data->regional }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b branch">{{ $data->branch }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b cluster">{{ $data->cluster }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b tap">{{ $data->tap }}</td>
                                    <td class="p-3 text-gray-700 uppercase border-b nama">{{ $data->nama }}</td>
                                    <td class="p-3 text-gray-700 border-b telp">{{ $data->telp }}</td>
                                    <td class="p-3 text-gray-700 border-b digipos">{{ $data->id_digipos }}</td>
                                    <td class="p-3 text-gray-700 border-b reff">{{ $data->reff_code }}</td>
                                    <td class="p-3 text-gray-700 border-b la">{{ $data->link_aja }}</td>
                                    <td class="p-3 text-gray-700 border-b role">{{ $data->role }}</td>
                                    <td class="p-3 text-gray-700 border-b">
                                        @if ($data->status)
                                            <div
                                                class="flex items-center justify-center px-3 py-1 rounded-full bg-green-200/50">
                                                <span class="text-sm font-semibold text-green-900 status"
                                                    status="Aktif">Aktif</span>
                                            </div>
                                            {{-- <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 rounded-full opacity-50"></span>
                                    <span class="relative">Aktif</span>
                                </span> --}}
                                        @else
                                            <div
                                                class="flex items-center justify-center px-3 py-1 rounded-full bg-red-200/50">
                                                <span class="text-sm font-semibold text-red-900 whitespace-nowrap status"
                                                    status="Tidak Aktif">Tidak Aktif</span>
                                            </div>
                                            {{-- <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-red-900">
                                    <span aria-hidden class="absolute inset-0 bg-red-200 rounded-full opacity-50"></span>
                                    <span class="relative">Tidak Aktif</span>
                                </span> --}}
                                        @endif
                                    </td>

                                    {{-- @if ($data->id > 2)
                            {{ddd($data)}}
                            @endif --}}
                                    <td class="p-3 text-gray-700 border-b">
                                        <a href="{{ route('direct_user.show', $data->id) }}"
                                            class="block my-1 text-base font-semibold transition text-emerald-600 hover:text-emerald-800">Rapor</a>
                                        <a href="{{ route('direct_user.edit', $data->id) }}"
                                            class="block my-1 text-base font-semibold transition text-y_premier hover:text-indigo-800">Edit</a>
                                        <form action="{{ route('direct_user.change_status', $data->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <button
                                                class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800 whitespace-nowrap">Ubah
                                                Status</button>
                                        </form>
                                    </td>
                                    {{-- @else
                            <td class="p-3 text-gray-700 border-b">
                                <form action="{{ route('direct_user.change_status',$data->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800 whitespace-nowrap">Ubah Status</button>
                            </form>
                            </td>
                            @endif --}}
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
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#search").on("input", function() {
                find();
            });

            $("#search_by").on("input", function() {
                find();
                filter_status();
            });

            $("#filter_status").on("input", function() {
                find();
                filter_status();
            });

            $("#btn-excel").click(function() {
                exportTableToExcel('table-container', `Data DS`);
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

            const filter_status = () => {
                let filter_status = $('#filter_status').val();
                $(`.status`).each(function() {
                    let label = $(this).attr('status');
                    console.log(label);
                    if (filter_status == '') {
                        $(this).parent().parent().parent().show();
                    } else {
                        if (filter_status == label) {
                            $(this).parent().parent().parent().show();
                        } else {
                            $(this).parent().parent().parent().hide();
                        }
                    }
                });
            }

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
        })
    </script>
@endsection
