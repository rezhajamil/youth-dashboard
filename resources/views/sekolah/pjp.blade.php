@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Data PJP</h4>
            </div>

            {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
            <a href="{{ route('sekolah.pjp.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-plus"></i> Data PJP Baru</a>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Regional</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Branch</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">NPSN</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama Sekolah</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Telp</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Frekuensi</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($pjp as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-3 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-3 text-gray-700 border-b regional">{{ $data->REGIONAL }}</td>
                            <td class="p-3 text-gray-700 border-b branch">{{ $data->BRANCH }}</td>
                            <td class="p-3 text-gray-700 border-b cluster">{{ $data->CLUSTER }}</td>
                            <td class="p-3 text-gray-700 border-b npsn">{{ $data->npsn }}</td>
                            <td class="p-3 text-gray-700 border-b nama_sekolah">{{ $data->NAMA_SEKOLAH }}</td>
                            <td class="p-3 text-gray-700 border-b kecamatan">{{ $data->telp }}</td>
                            <td class="p-3 text-gray-700 border-b kecamatan">{{ $data->frekuensi }}</td>
                            <td class="p-3 text-gray-700 border-b kecamatan whitespace-nowrap">{{ date('d-m-Y H:i',strtotime($data->date)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
