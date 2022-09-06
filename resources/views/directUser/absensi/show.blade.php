@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">

            <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Detail Absensi</h4>

            <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Absensi : {{ $absensi[0]->nama }} | {{ $absensi[0]->telp }}</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Info</th>
                            @foreach ($period as $data)
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 whitespace-nowrap border-tersier bg-premier">{{ date('d',strtotime($data)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-2 text-gray-700 uppercase border-2 ">
                                <span class="block font-semibold whitespace-nowrap">Kehadiran</span>
                            </td>
                            @foreach ($period as $item)
                            <td class="p-2 text-center text-gray-700 uppercase border-2 ">
                                @foreach ($absensi as $absen)
                                @if (date('Y-m-d',strtotime($item))==$absen->date)
                                <i class="text-3xl text-green-600 fa-solid fa-circle-check"></i>
                                @endif
                                @endforeach
                            </td>
                            @endforeach
                        </tr>
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-2 text-gray-700 uppercase border-2 ">
                                <span class="block font-semibold whitespace-nowrap">Jarak (Km)</span>
                            </td>
                            @foreach ($period as $item)
                            <td class="p-2 text-center text-gray-700 border-2 ">
                                @foreach ($absensi as $absen)
                                @if (date('Y-m-d',strtotime($item))==$absen->date)
                                <span class="block whitespace-nowrap">{{ number_format($absen->jarak,0,",",".") }}</span>
                                @endif
                                @endforeach
                            </td>
                            @endforeach
                        </tr>
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-2 text-gray-700 uppercase border-2 ">
                                <span class="block font-semibold whitespace-nowrap">Time In (Wib)</span>
                            </td>
                            @foreach ($period as $item)
                            <td class="p-2 text-center text-gray-700 border-2 ">
                                @foreach ($absensi as $absen)
                                @if (date('Y-m-d',strtotime($item))==$absen->date)
                                <span class="block whitespace-nowrap">{{ date('H:i:s',strtotime($absen->time_in)) }}</span>
                                @endif
                                @endforeach
                            </td>
                            @endforeach
                        </tr>
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-2 text-gray-700 uppercase border-2 ">
                                <span class="block font-semibold whitespace-nowrap">Jarak Keluar (Km)</span>
                            </td>
                            @foreach ($period as $item)
                            <td class="p-2 text-center text-gray-700 border-2 ">
                                @foreach ($absensi as $absen)
                                @if (date('Y-m-d',strtotime($item))==$absen->date)
                                <span class="block whitespace-nowrap">{{ number_format($absen->jarak_keluar,0,",",".") }}</span>
                                @endif
                                @endforeach
                            </td>
                            @endforeach
                        </tr>
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-2 text-gray-700 uppercase border-2 ">
                                <span class="block font-semibold whitespace-nowrap">Time Out (Wib)</span>
                            </td>
                            @foreach ($period as $item)
                            <td class="p-2 text-center text-gray-700 border-2 ">
                                @foreach ($absensi as $absen)
                                @if (date('Y-m-d',strtotime($item))==$absen->date)
                                {{-- <span class="block whitespace-nowrap">{{ $absen->time_out }}</span> --}}
                                <span class="block whitespace-nowrap">{{ date('H:i:s',strtotime($absen->time_out)) }}</span>
                                @endif
                                @endforeach
                            </td>
                            @endforeach
                        </tr>
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-2 text-gray-700 uppercase border-2 ">
                                <span class="block font-semibold whitespace-nowrap">Durasi</span>
                            </td>
                            @foreach ($period as $item)
                            <td class="p-2 text-center text-gray-700 border-2 ">
                                @foreach ($absensi as $absen)
                                @if (date('Y-m-d',strtotime($item))==$absen->date)
                                {{-- @if ($absen->time_out=='0')
                                <span class="block whitespace-nowrap">-</span>
                                @else
                                <span class="block whitespace-nowrap">{{ $absen->time_out!='0' }}</span>
                                @endif --}}
                                <span class="block whitespace-nowrap">{{ gmdate("H:i:s",strtotime($absen->time_out)-strtotime($absen->time_in)) }}</span>
                                @endif
                                @endforeach
                            </td>
                            @endforeach
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
