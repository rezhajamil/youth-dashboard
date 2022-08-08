@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Campaign</h4>

            <div class="flex flex-wrap items-end mb-2 gap-x-4">
                <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                <div class="flex flex-col">
                    <span class="font-bold text-gray-600">Berdasarkan</span>
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="branch">Branch</option>
                        <option value="program">Program</option>
                        <option value="posisi">Posisi</option>
                        <option value="keterangan">Keterangan</option>
                    </select>
                </div>
            </div>

            {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Campaign</span> --}}
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-premier">No</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">Branch</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">Cluster</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">Nama</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">Outlet ID</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">SF Code</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">Site Terdekat</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">Jarak</th>

                            {{-- <th class="p-4 text-sm font-medium text-center text-gray-100 uppercase border-tersier bg-premier">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($all_outlet as $key=>$data)
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-4 font-bold text-gray-700">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 uppercase whitespace-nowrap branch">{{ $data->branch }}</td>
                            <td class="p-4 text-gray-700 uppercase whitespace-nowrap cluster">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 uppercase nama">{{ $data->namaoutlet }}</td>
                            <td class="p-4 text-gray-700 uppercase nama">{{ $data->outlet_id }}</td>
                            <td class="p-4 text-gray-700 uppercase nama">{{ $data->sf_code }}</td>
                            <td class="p-4 text-gray-700 uppercase nama">{{ $data->site_id }}</td>
                            <td class="p-4 text-gray-700 uppercase nama">{{ $data->jarak }}</td>
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
<script>
    $(document).ready(function() {
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
