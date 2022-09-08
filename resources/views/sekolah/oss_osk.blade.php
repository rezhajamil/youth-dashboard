@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Data OSS OSK</h4>
            </div>

            {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
            {{-- <a href="{{ route('direct_user.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-plus"></i> Data User Baru</a> --}}

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Cluster</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Kecamatan</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">NPSN</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama Sekolah</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">ID Outlet</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Telp</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($sekolah as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b npsn">{{ $data->CLUSTER }}</td>
                            <td class="p-4 text-gray-700 border-b provinsi">{{ $data->kecamatan }}</td>
                            <td class="p-4 text-gray-700 border-b kabupaten">{{ $data->npsn }}</td>
                            <td class="p-4 text-gray-700 border-b kecamatan">{{ $data->nama_sekolah }}</td>
                            <td class="p-4 text-gray-700 border-b nama">{{ $data->outlet_id }}</td>
                            <td class="p-4 text-gray-700 border-b status">{{ $data->telp }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
