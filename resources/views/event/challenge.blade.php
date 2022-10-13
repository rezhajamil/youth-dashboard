@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Challenge Digisquad</h4>
            </div>
            <div class="flex flex-wrap items-end my-3 gap-x-4 gap-y-2">
                <div class="flex flex-col">
                    {{-- <span class="font-bold text-gray-600">Berdasarkan</span> --}}
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="">Semua Judul</option>
                        @foreach ($judul as $item)
                        <option value="{{ $item->challenge }}">{{ $item->challenge }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-2 text-sm font-bold text-center text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Judul</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Nama</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Telp</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Poin</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Tanggal</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Approver</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Status</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Link</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($challenge as $key=>$data)
                        <tr class="border-b hover:bg-gray-200">
                            <td class="p-2 text-sm font-bold text-gray-700 border-r">{{ $key+1 }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r judul">{{ $data->challenge }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r whitespace-nowrap nama">{{ ucwords(strtolower($data->nama)) }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r telp">{{ $data->telp }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r poin">{{ $data->poin }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r date">{{ $data->date }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r approver">{{ $data->approver }}</td>
                            <td class="p-3 text-gray-700 border-r">
                                @if ($data->status)
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-green-200/50">
                                    <span class="text-sm font-semibold text-green-900 status">Aktif</span>
                                </div>
                                @else
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-red-200/50">
                                    <span class="text-sm font-semibold text-red-900 whitespace-nowrap status">Tidak Aktif</span>
                                </div>
                                @endif
                            </td>
                            <td class="p-2 text-sm border-r">
                                <a href="{{ $data->link }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-orange-600 underline transition hover:text-orange-800 hover:underline">Buka Link</a>
                            </td>
                            <td class="p-2 text-sm border-r">
                                @if (!$data->approver)
                                <a href="{{ route('event.approve',$data->id) }}" class="px-3 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-800 whitespace-nowrap">Approve</a>
                                @endif
                                <a href="{{ route('event.challenge_status',$data->id) }}" class="px-3 py-2 text-white transition rounded bg-emerald-600 hover:bg-emerald-800 whitespace-nowrap">Ubah Status</a>
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
