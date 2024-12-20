@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                @if (Auth::user()->privilege == 'superadmin')
                    <a href="{{ route('quiz.create') }}"
                        class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                            class="mr-2 fa-solid fa-plus"></i> Data Quiz Baru</a>
                @endif
                <h4 class="mt-6 mb-2 text-xl font-bold text-gray-600 align-baseline">Quiz | Youth Apps</h4>
                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Date</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Waktu</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Deskripsi</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Status</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($session as $key => $data)
                                <tr class="border-b hover:bg-gray-200">
                                    {{-- {{ ddd($data) }} --}}
                                    <td class="p-4 font-bold text-gray-700">{{ $key + 1 }}</td>
                                    <td class="p-4 text-gray-700">{{ date('d-M-Y', strtotime($data->date)) }}</td>
                                    <td class="p-4 text-gray-700">{{ $data->nama }}</td>
                                    <td class="p-4 text-gray-700">{{ $data->time }} Menit</td>
                                    <td class="p-4 text-gray-700">{!! $data->deskripsi !!}</td>
                                    <td class="p-4 text-gray-700">
                                        @if ($data->status)
                                            <div
                                                class="flex items-center justify-center px-3 py-1 rounded-full bg-green-200/50">
                                                <span class="text-sm font-semibold text-green-900">Aktif</span>
                                            </div>
                                        @else
                                            <div
                                                class="flex items-center justify-center px-3 py-1 rounded-full bg-red-200/50">
                                                <span class="text-sm font-semibold text-red-900 whitespace-nowrap">Tidak
                                                    Aktif</span>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-4 text-gray-700 gap-x-3">
                                        <div class="">
                                            @if ($data->jenis == 'Youth Apps' && (auth()->user()->privilege == 'superadmin' || !$data->status))
                                                <a href="{{ route('quiz.show', $data->id) }}"
                                                    class="block my-1 text-base font-semibold transition text-y_premier hover:text-indigo-800">Lihat</a>
                                            @endif
                                            <a href="{{ route('quiz.answer.list', $data->id) }}"
                                                class="block my-1 text-base font-semibold text-orange-600 transition hover:text-orange-800">Hasil</a>
                                            @if (auth()->user()->privilege == 'superadmin')
                                                <form action="{{ route('quiz.change_status', $data->id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button
                                                        class="block my-1 text-base font-semibold text-left text-green-600 transition whitespace-nowrap hover:text-green-800">Ubah
                                                        Status</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <h4 class="mt-10 mb-2 text-xl font-bold text-gray-600 align-baseline">Quiz | Event</h4>
                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Date</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Nama</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Waktu</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Deskripsi</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Status</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($session as $key => $data)
                                @if ($data->jenis == 'Event')
                                    <tr class="border-b hover:bg-gray-200">
                                        {{-- {{ ddd($data) }} --}}
                                        <td class="p-4 font-bold text-gray-700">{{ $key + 1 }}</td>
                                        <td class="p-4 text-gray-700">{{ date('d-M-Y', strtotime($data->date)) }}</td>
                                        <td class="p-4 text-gray-700">{{ $data->nama }}</td>
                                        <td class="p-4 text-gray-700">{{ $data->time }} Menit</td>
                                        <td class="p-4 text-gray-700">{!! $data->deskripsi !!}</td>
                                        <td class="p-4 text-gray-700">
                                            @if ($data->status)
                                                <div
                                                    class="flex items-center justify-center px-3 py-1 rounded-full bg-green-200/50">
                                                    <span class="text-sm font-semibold text-green-900">Aktif</span>
                                                </div>
                                            @else
                                                <div
                                                    class="flex items-center justify-center px-3 py-1 rounded-full bg-red-200/50">
                                                    <span class="text-sm font-semibold text-red-900 whitespace-nowrap">Tidak
                                                        Aktif</span>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="p-4 text-gray-700 gap-x-3">
                                            <div class="">
                                                <a href="{{ route('quiz.show', $data->id) }}"
                                                    class="block my-1 text-base font-semibold transition text-y_premier hover:text-indigo-800">Lihat</a>
                                                <a href="{{ URL::to("/answer_list/quiz/{$data->id}?jenis=event") }}"
                                                    class="block my-1 text-base font-semibold text-orange-600 transition hover:text-orange-800">Hasil</a>
                                                <form action="{{ route('quiz.change_status', $data->id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button
                                                        class="block my-1 text-base font-semibold text-left text-green-600 transition whitespace-nowrap hover:text-green-800">Ubah
                                                        Status</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
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
