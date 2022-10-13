@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Poin History Digisquad</h4>
            </div>
            <div class="flex flex-wrap items-end my-3 gap-x-4 gap-y-2">
                <div class="flex flex-col">
                    {{-- <span class="font-bold text-gray-600">Berdasarkan</span> --}}
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenis as $item)
                        <option value="{{ $item->jenis }}">{{ $item->jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-2 text-sm font-bold text-center text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Tanggal</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Jenis</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Keterangan</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Nama</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Email</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Telp</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($poin as $key=>$data)
                        <tr class="border-b hover:bg-gray-200">
                            <td class="p-2 text-sm font-bold text-gray-700 border-r">{{ $key+1 }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r date">{{ date('d-M-Y',strtotime($data->tanggal)) }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r jenis">{{ $data->jenis }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r keterangan">{{ $data->keterangan }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r whitespace-nowrap nama">{{ ucwords(strtolower($data->nama)) }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r email">{{ $data->email }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r telp">{{ $data->telp }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r poin">{{ $data->jumlah }}</td>
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
        // $("#search").on("input", function() {
        //     find();
        //     $(".filter").prop('checked', true);
        // });

        $("#search_by").on("input", function() {
            find();
        });

        const find = () => {
            let searchBy = $('#search_by').val();
            let pattern = new RegExp(searchBy, "i");
            $(`.judul`).each(function() {
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
