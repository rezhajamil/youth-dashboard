@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">{{ $quiz->nama }}</h4>
            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Telp</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Hasil</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Skor</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($answer as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->cluster }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->nama }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->telp }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->hasil }}/{{ count(json_decode($quiz->soal)) }}</td>
                            <td class="p-4 border-b font-bold text-sekunder">{{ number_format($data->hasil/count(json_decode($quiz->soal)*100),0,".",",") }}</td>
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
