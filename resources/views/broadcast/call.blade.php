@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Broadcast Call</h4>

            <div class="flex justify-between mt-4 ">
                <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('broadcast.call') }}" method="get">
                    <select name="program" id="program" required>
                        <option value="" selected disabled>Pilih Program</option>
                        @foreach ($dataProgram as $item)
                        <option value="{{ $item->program }}" {{ request()->get('program')==$item->program?'selected':'' }}>{{ $item->program }}</option>
                        @endforeach
                    </select>
                    <div class="flex gap-x-3">
                        <button class="px-4 py-2 font-bold text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-800"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                    </div>
                </form>
            </div>

        <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Call/By Cluster</span>
        <div class="overflow-hidden bg-white rounded-md shadow w-fit table-broadcast">
            <table class="text-left border-collapse w-fit">
                <thead class="border-b">
                    <tr>
                        <th rowspan="2" class="p-2 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                        <th rowspan="2" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Branch</th>
                        <th rowspan="2" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Cluster</th>
                        <th colspan="5" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Call</th>
                        <th colspan="4" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Respon</th>
                        {{-- <th colspan="5" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Persentase</th> --}}
                    </tr>
                    <tr>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Total</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Connect</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not Connect</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Angkat</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Tidak Diangkat</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Ditutup</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Mengira Penipuan</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Setuju Ganti Kartu</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Tidak Mau Ganti</th>
                        <!-- <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">USIM</th> -->
                        {{-- <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Send</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Not Send</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Read</th>
                        <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Respon</th> --}}
                        <!-- <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) USIM</th> -->
                    </tr>

                </thead>
                <tbody>
                    @foreach ($call as $key=>$data)
                    <tr class="transition hover:bg-gray-200/40">
                        <td class="p-2 font-bold text-gray-700 border-2">{{ $key+1 }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2 ">{{ $data->branch }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2 ">{{ $data->cluster }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->total }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->connect }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_connect }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->angkat }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_angkat }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->res_ditutup }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->res_penipuan }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->res_setuju }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2">{{ $data->res_tolak }}</td>
                        {{-- <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ $data->total>0?number_format(($data->sent/$data->total)*100,2).' %':'0%' }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ $data->total>0?number_format((($data->not_sent+$data->not_wa)/$data->total)*100,2).' %':'0%' }}</td>
                        <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ $data->sent>0?number_format(($data->read/$data->sent)*100,2).' %':'0%' }}</td>
                        @if ($data->reply>0&&$data->read>0)
                        <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->reply/$data->read)*100,2).' %' }}</td>
                        @else
                        <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">0%</td>
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
