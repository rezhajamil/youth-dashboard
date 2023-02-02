@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Content Management - Schedule</h4>
            <a href="{{ route('schedule.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-y_premier rounded-md hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data Schedule Baru</a>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Date</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Time</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jenis</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Judul</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Pembicara</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Poin</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Minus</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Absen</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($schedule as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ date('d-M-Y',strtotime($data->date)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->time }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->jenis }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->judul }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->pembicara }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->poin }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->minus }}</td>
                            <td class="p-4 text-gray-700 border-b">
                                @if ($data->status)
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-green-200/50">
                                    <span class="text-sm font-semibold text-green-900">ON</span>
                                </div>
                                @else
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-red-200/50">
                                    <span class="text-sm font-semibold text-red-900">OFF</span>
                                </div>
                                @endif
                            </td>
                            <td class="p-4 text-gray-700 border-b">
                                {{-- <a href="{{ route('sekolah.edit',$data->NPSN) }}" class="block my-1 text-base font-semibold text-y_premier transition hover:text-indigo-800">Edit</a> --}}
                                <form action="{{ route('schedule.change_status',$data->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button class="block my-1 text-base font-semibold text-left text-blue-600 transition hover:text-blue-800">Ubah Absen</button>
                                </form>
                                <form action="{{ route('schedule.destroy',$data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
                                </form>
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
