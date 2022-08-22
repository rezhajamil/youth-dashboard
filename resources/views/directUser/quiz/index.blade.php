@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Quiz</h4>
            @if (Auth::user()->privilege=='superadmin')
            <a href="{{ route('quiz.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-plus"></i> Data Quiz Baru</a>
            @endif

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Date</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Nama</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Waktu</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Deskripsi</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Status</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($session as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ date('d-M-Y',strtotime($data->date)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->nama }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->time }} Menit</td>
                            <td class="p-4 text-gray-700 border-b">{!! $data->deskripsi !!}</td>
                            <td class="p-4 text-gray-700 border-b">
                                @if ($data->status)
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-green-200/50">
                                    <span class="text-sm font-semibold text-green-900">Aktif</span>
                                </div>
                                @else
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-red-200/50">
                                    <span class="text-sm font-semibold text-red-900 whitespace-nowrap">Tidak Aktif</span>
                                </div>
                                @endif
                            </td>

                            <td class="p-4 text-gray-700 border-b">
                                <a href="{{ route('quiz.show',$data->id) }}" class="block my-1 text-base font-semibold text-indigo-600 transition hover:text-indigo-800">Lihat</a>
                                @if (!$data->status)
                                <form action="{{ route('quiz.change_status',$data->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button class="block my-1 text-base font-semibold text-left text-green-600 transition hover:text-green-800">Aktifkan</button>
                                </form>
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
