@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="mt-4">
        <h4 class="text-gray-600 font-bold text-xl">Resume/Regional</h4>
        <div class="mt-6">
            <div class="bg-white shadow rounded-md overflow-hidden my-6">
                <table class="text-left w-full border-collapse">
                    <thead class="border-b">
                        <tr>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">No</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">Regional</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">Branch</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">Cluster</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">AO</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">EO</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">MOGI</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">YBA</th>
                            <th class="py-3 px-5 bg-indigo-800 font-medium uppercase text-sm text-gray-100">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataUsers as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="py-4 px-6 border-b text-gray-700 font-bold">{{ $key+1 }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->regional }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->branch }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->cluster }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->ao }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->eo }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->mogi }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->yba }}</td>
                            <td class="py-4 px-6 border-b text-gray-700">{{ $data->jumlah }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
