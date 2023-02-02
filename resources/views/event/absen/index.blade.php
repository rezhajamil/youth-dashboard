@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Absensi Digisquad</h4>
            </div>
            <a href="{{ route('event.absen.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-y_premier rounded-md hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data Absensi</a>
            <div class="flex flex-wrap items-end my-3 gap-x-4 gap-y-2">
                <div class="flex flex-col">
                    {{-- <span class="font-bold text-gray-600">Berdasarkan</span> --}}
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="">Semua Judul</option>
                        @foreach ($judul as $item)
                        <option value="{{ $item->judul }}">{{ $item->judul }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-2 text-sm font-bold text-center text-gray-100 uppercase bg-y_tersier">No</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Judul</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Nama</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Telp</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($absen as $key=>$data)
                        <tr class="border-b hover:bg-gray-200">
                            <td class="p-2 text-sm font-bold text-gray-700 border-r">{{ $key+1 }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r judul">{{ $data->judul }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r whitespace-nowrap nama">{{ ucwords(strtolower($data->nama)) }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r telp">{{ $data->telp }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r poin">{{ $data->poin }}</td>
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
