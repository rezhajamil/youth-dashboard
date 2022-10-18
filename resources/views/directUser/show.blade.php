@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 mt-2 mb-6 font-bold text-white transition-all bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Hasil Quiz Oleh {{ $user->nama }}</h4>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Date</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Judul</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Soal</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Hasil</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Selesai</th>
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
                                <span class="font-semibold text-red-600">Tidak Selesai</span>
                                @endif
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

    })

</script>
@endsection
