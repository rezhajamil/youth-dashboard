@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex items-center gap-x-3">
                <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 mt-2 mb-6 font-bold text-white transition-all bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
                <h4 class="mb-2 text-2xl font-bold text-indigo-600 align-baseline">{{date('M',strtotime($month))}}, {{$year}}</h4>
            </div>
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Hasil Quiz Oleh {{ $user->nama }}</h4>

            <div class="mb-10 overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-premier">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Date</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Judul</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Soal</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Hasil</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($quiz as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ date('d-M-Y',strtotime($data->date)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->nama }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ count(json_decode($data->soal)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->hasil }}</td>
                            <td class="p-4 text-gray-700 border-b">
                                @if ($data->finish)
                                <span class="font-semibold text-green-600">Selesai</span>
                                @else
                                <span class="font-semibold text-premier">Tidak Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if (count($quiz)==0)
                            <td class="p-4 font-bold text-center bg-white" colspan="6">Tidak Ada Quiz</td>
                        @endif
                    </tbody>
                </table>
            </div>

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

    })

</script>
@endsection
