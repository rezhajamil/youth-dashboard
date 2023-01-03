@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="mt-4">
        <h4 class="text-xl font-bold text-gray-600">Resume/Regional</h4>
        <div class="mt-6">
            <div class="my-6 overflow-auto bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">No</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">Regional</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">Branch</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">AO</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">EO</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">MOGI</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">YBA</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">PROMOTOR</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataUsersBranch as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="px-6 py-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->regional }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->branch }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->ao }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->eo }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->mogi }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->yba }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->promotor }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->jumlah }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <h4 class="text-xl font-bold text-gray-600">Resume/Cluster</h4>
        <div class="mt-6">
            <div class="my-6 overflow-auto bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">No</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">Cluster</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">AO</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">EO</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">MOGI</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">YBA</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">PROMOTOR</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataUsersCluster as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="px-6 py-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->cluster }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->ao }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->eo }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->mogi }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->yba }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->promotor }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->jumlah }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
