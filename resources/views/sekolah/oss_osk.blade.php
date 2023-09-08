@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <div class="flex justify-between mb-4">
                    <h4 class="text-xl font-bold text-gray-600 align-baseline">Resume OSS OSK</h4>
                </div>

                {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
                {{-- <a href="{{ route('direct_user.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data User Baru</a> --}}

                <div class="mb-8 overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Branch</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($resume as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-4 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-4 text-gray-700 border-b npsn">{{ $data->BRANCH }}</td>
                                    <td class="p-4 text-gray-700 border-b npsn">{{ $data->CLUSTER }}</td>
                                    <td class="p-4 text-gray-700 border-b provinsi">{{ $data->jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between mb-4">
                    <h4 class="text-xl font-bold text-gray-600 align-baseline">Data OSS OSK</h4>
                </div>

                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kecamatan</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">NPSN</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama Sekolah</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">ID Outlet</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama Outlet</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jarak
                                    Sekolah-Outlet</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama DS</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Telp PIC</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($sekolah as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-4 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-4 text-gray-700 border-b npsn">{{ $data->CLUSTER }}</td>
                                    <td class="p-4 text-gray-700 border-b provinsi">{{ $data->kecamatan }}</td>
                                    <td class="p-4 text-gray-700 border-b kabupaten">{{ $data->npsn }}</td>
                                    <td class="p-4 text-gray-700 border-b kecamatan">{{ $data->nama_sekolah }}</td>
                                    <td class="p-4 text-gray-700 border-b nama">{{ $data->outlet_id }}</td>
                                    <td class="p-4 text-gray-700 border-b nama">{{ $data->nama_outlet }}</td>
                                    <td class="p-4 text-gray-700 border-b nama">{{ $data->jarak }} Km</td>
                                    <td class="p-4 text-gray-700 border-b status">{{ $data->nama }}</td>
                                    <td class="p-4 text-gray-700 border-b status">{{ $data->{'telp pic'} }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
