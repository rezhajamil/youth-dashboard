@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Broadcast Program</h4>
            <span class="text-sm">Update : {{ $update_broadcast[0]->last_update }}</span>

            <div class="flex justify-between mt-4 ">
                <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('broadcast.index') }}" method="get">
                    <input type="date" name="date" id="date" class="px-4 rounded-lg" value="{{ request()->get('date') }}" required>
                    <select name="program" id="program" required>
                        <option value="" selected disabled>Pilih Program</option>
                        @foreach ($dataProgram as $item)
                        <option value="{{ $item->program }}" {{ request()->get('program')==$item->program?'selected':'' }}>{{ $item->program }}</option>
                        @endforeach
                    </select>
                    <div class="flex gap-x-3">
                        <button class="px-4 py-2 font-bold text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-800"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        @if (request()->get('date'))
                        <a href="{{ route('broadcast.index') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                        @endif
                    </div>
                </form>
                {{-- <div class="flex gap-x-3">
                    <div class="relative rounded w-fit h-fit">
                        <input type="checkbox" id="by_region" class="appearance-none">
                    </div>
                </div> --}}

            </div>

            <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Broadcast/By Direct Sales</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-2 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                            <th rowspan="2" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Cluster</th>
                            <th rowspan="2" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Nama</th>
                            <th rowspan="2" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Role</th>
                            <th colspan="5" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Broadcast</th>
                            <th colspan="4" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Result</th>
                            <th colspan="4" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Persentase</th>

                            {{-- <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th> --}}
                        </tr>
                        <tr>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Total</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">All Not Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not WA</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Read</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not Read</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Respon</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not Respon</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Not Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Read</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Respon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $sum_total=0;
                        $sum_sent=0;
                        $sum_not_sent=0;
                        $sum_not_wa=0;
                        $sum_read=0;
                        $sum_not_read=0;
                        $sum_reply=0;
                        $sum_not_reply=0;

                        @endphp
                        @foreach ($broadcast as $key=>$data)
                        @php
                        $sum_total+=$data->total;
                        $sum_sent+=$data->sent;
                        $sum_not_sent+=$data->not_sent;
                        $sum_not_wa+=$data->not_wa;
                        $sum_read+=$data->read;
                        $sum_not_read+=$data->not_read;
                        $sum_reply+=$data->reply;
                        $sum_not_reply+=$data->not_reply;
                        @endphp
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-2 font-bold text-gray-700 border-2">{{ $key+1 }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 ">{{ $data->cluster }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 ">{{ $data->nama }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->role }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->total }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->sent }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_sent+$data->not_wa }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_sent }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_wa }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->read }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_read }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->reply }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_reply }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->sent/$data->total)*100,2).' %' }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format((($data->not_sent+$data->not_wa)/$data->total)*100,2).' %' }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->read/$data->sent)*100,2).' %' }}</td>
                            @if ($data->reply>0&&$data->read>0)
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->reply/$data->read)*100,2).' %' }}</td>
                            @else
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">0%</td>
                            @endif

                            {{-- <td class="p-2 text-gray-700 border-b"></td> --}}
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="p-2 font-bold text-white uppercase border-2 border-l-tersier bg-tersier">Grand Total</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_total }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_sent }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_sent+$sum_not_wa }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_sent }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_wa }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_read }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_read }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_reply }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_reply }}</td>
                            @if ($sum_total)
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ number_format(($sum_sent/$sum_total)*100,2).' %' }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">{{ number_format((($sum_not_sent+$sum_not_wa)/$sum_total)*100,2).' %' }}</td>
                            @else
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">0%</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">0%</td>
                            @endif
                            @if ($sum_sent>0)
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">{{ number_format(($sum_read/$sum_sent)*100,2).' %' }}</td>
                            @else
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">0%</td>
                            @endif
                            @if ($sum_reply>0&&$sum_read>0)
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap border-r-tersier">{{ number_format(($sum_reply/$sum_read)*100,2).' %' }}</td>
                            @else
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap border-r-tersier">0%</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>

            <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Broadcast/By Program</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-2 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                            <th rowspan="2" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Nama Program</th>
                            <th colspan="5" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Broadcast</th>
                            <th colspan="4" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Result</th>
                            <th colspan="4" class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Persentase</th>

                            {{-- <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th> --}}
                        </tr>
                        <tr>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Total</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">All Not Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not WA</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Read</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not Read</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Respon</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Not Respon</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Not Send</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Read</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">(%) Respon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $sum_total=0;
                        $sum_sent=0;
                        $sum_not_sent=0;
                        $sum_not_wa=0;
                        $sum_read=0;
                        $sum_not_read=0;
                        $sum_reply=0;
                        $sum_not_reply=0;

                        @endphp
                        @foreach ($program_list as $key=>$data)
                        @php
                        $sum_total+=$data->total;
                        $sum_sent+=$data->sent;
                        $sum_not_sent+=$data->not_sent;
                        $sum_not_wa+=$data->not_wa;
                        $sum_read+=$data->read;
                        $sum_not_read+=$data->not_read;
                        $sum_reply+=$data->reply;
                        $sum_not_reply+=$data->not_reply;
                        @endphp
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-2 font-bold text-gray-700 border-2">{{ $key+1 }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 ">{{ $data->program }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->total }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->sent }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_sent+$data->not_wa }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_sent }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_wa }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->read }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_read }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->reply }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2">{{ $data->not_reply }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->sent/$data->total)*100,2).' %' }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format((($data->not_sent+$data->not_wa)/$data->total)*100,2).' %' }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->read/($data->sent!=0?$data->sent:1))*100,2).' %' }}</td>
                            @if ($data->reply>0&&$data->read>0)
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->reply/$data->read)*100,2).' %' }}</td>
                            @else
                            <td class="p-2 text-gray-700 uppercase border-2 whitespace-nowrap">0%</td>
                            @endif

                            {{-- <td class="p-2 text-gray-700 border-b"></td> --}}
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="p-2 font-bold text-white uppercase border-2 border-l-tersier bg-tersier">Grand Total</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_total }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_sent }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_sent+$sum_not_wa }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_sent }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_wa }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_read }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_read }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_reply }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ $sum_not_reply }}</td>
                            @if ($sum_total)
                            <td class="p-2 text-white uppercase border-2 bg-tersier">{{ number_format(($sum_sent/$sum_total)*100,2).' %' }}</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">{{ number_format((($sum_not_sent+$sum_not_wa)/$sum_total)*100,2).' %' }}</td>
                            @else
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">0%</td>
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">0%</td>
                            @endif
                            @if ($sum_sent>0)
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">{{ number_format(($sum_read/$sum_sent)*100,2).' %' }}</td>
                            @else
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap">0%</td>
                            @endif
                            @if ($sum_reply>0&&$sum_read>0)
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap border-r-tersier">{{ number_format(($sum_reply/$sum_read)*100,2).' %' }}</td>
                            @else
                            <td class="p-2 text-white uppercase border-2 bg-tersier whitespace-nowrap border-r-tersier">0%</td>
                            @endif
                        </tr>
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
