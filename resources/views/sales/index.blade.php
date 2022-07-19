@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="mt-4">
        <h4 class="text-gray-600 font-bold text-xl">Migrasi 4G/Direct Sales</h4>
        <div class="mt-6">
            <form class="flex gap-x-4 items-center" action="{{ route('sales.index') }}" method="get">
                <input type="date" name="date_from" id="date-from" class="px-4 rounded-lg" value="{{ request()->get('date_from') }}" required>
                <span class="text-gray-600 font-bold text-lg">s/d</span>
                <input type="date" name="date_to" id="date-to" class="px-4 rounded-lg" value="{{ request()->get('date_to') }}" required>
                <button class="bg-indigo-600 rounded-lg text-white transition hover:bg-indigo-800 font-bold px-4 py-2"><i class="fa-solid mr-2 fa-magnifying-glass"></i>Cari</button>
                @if (request()->get('date_from')&&request()->get('date_to'))
                <a href="{{ route('sales.index') }}" class="bg-red-600 rounded-lg text-white transition hover:bg-red-800 font-bold px-4 py-2"><i class="fa-solid mr-2 fa-circle-xmark"></i>Reset</a>
                @endif
            </form>
            @if (request()->get('date_from')&&request()->get('date_to'))
            <div class="flex gap-x-4 items-end mt-4">
                <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                <div class="flex flex-col">
                    <span class="text-gray-600 font-bold">Berdasarkan</span>
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="cluster">Cluster</option>
                        <option value="tap">TAP</option>
                        <option value="nama">Nama</option>
                    </select>
                </div>
            </div>
            @endif
            <div class="bg-white shadow rounded-md overflow-hidden my-6">
                <table class="text-left w-full border-collapse">
                    <thead class="border-b">
                        <tr>
                            <th class="py-3 px-5 bg-indigo-600 font-medium uppercase text-sm text-gray-100">No</th>
                            <th class="py-3 px-5 bg-indigo-600 font-medium uppercase text-sm text-gray-100">Cluster</th>
                            <th class="py-3 px-5 bg-indigo-600 font-medium uppercase text-sm text-gray-100">TAP</th>
                            <th class="py-3 px-5 bg-indigo-600 font-medium uppercase text-sm text-gray-100">Nama</th>
                            <th class="py-3 px-5 bg-indigo-600 font-medium uppercase text-sm text-gray-100">Digipos</th>
                            {{-- <th class="py-3 px-5 bg-indigo-600 font-medium uppercase text-sm text-gray-100">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="py-4 px-6 border-b text-gray-700 font-bold">{{ $key+1 }}</td>
                            <td class="py-4 px-6 border-b text-gray-700 cluster">{{ $data->cluster }}</td>
                            <td class="py-4 px-6 border-b text-gray-700 tap">{{ $data->tap }}</td>
                            <td class="py-4 px-6 border-b text-gray-700 nama uppercase">{{ $data->nama }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->digipos }}</td>
                            {{-- <td class="py-4 px-6 border-b text-gray-700"></td> --}}
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
            let search = $(this).val();
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
        });

    })

</script>
@endsection
