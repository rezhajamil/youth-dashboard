@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">List Dokumen</h4>
                @if (auth()->user()->privilege == 'superadmin')
                    <a href="{{ route('dokumen.create') }}"
                        class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                            class="mr-2 fa-solid fa-plus"></i> Data Dokumen Baru</a>
                @endif

                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Judul</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Deskripsi</th>
                                <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($dokumen as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    {{-- {{ ddd($data) }} --}}
                                    <td class="p-4 font-bold text-gray-700 border-b">{{ $key + 1 }}</td>
                                    <td class="p-4 text-gray-700 border-b">{{ $data->judul }}</td>
                                    <td class="p-4 text-gray-700 border-b">
                                        <p>{!! $data->deskripsi !!}</p>
                                    </td>
                                    <td class="p-4 text-gray-700 border-b">
                                        <a href="{{ $data->url }}" target="_blank"
                                            class="block my-1 text-base font-semibold transition text-y_premier hover:text-indigo-800">Buka
                                            Link</a>
                                        @if (auth()->user()->privilege == 'superadmin')
                                            <form action="{{ route('dokumen.destroy', $data->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button
                                                    class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
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
