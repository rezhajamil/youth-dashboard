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
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">No</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">Regional</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">Branch</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">AO</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">EO</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">ORBIT</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">YBA</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">PROMOTOR</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">BUDDIES</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">Jumlah</th>
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
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->orbit }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->yba }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->promotor }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->buddies }}</td>
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
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">No</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">Cluster</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">AO</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">EO</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">ORBIT</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">YBA</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">PROMOTOR</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">BUDDIES</th>
                            <th class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-y_premier">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataUsersCluster as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="px-6 py-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->cluster }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->ao }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->eo }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->orbit }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->yba }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->promotor }}</td>
                            <td class="px-6 py-4 text-gray-700 border-b">{{ $data->buddies }}</td>
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
