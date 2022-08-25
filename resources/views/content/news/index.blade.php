@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Content Management - News - Meeting</h4>
            <a href="{{ route('news.create',['jenis'=>'meeting']) }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800">
                <i class="mr-2 fa-solid fa-plus"></i>
                Data Meeting Baru
            </a>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Date</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Type</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Judul</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">View</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($news as $key=>$data)
                        @if ($data->jenis=='Meeting')
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ date('d-M-Y',strtotime($data->date)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->type }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->judul }}</td>
                            <td class="p-4 text-gray-700 border-b"><img src="{{ asset('storage/'.$data->gambar) }}" alt="{{ $data->gambar }}" class="object-contain w-24 h-24"></td>
                            <td class="p-4 text-gray-700 border-b">
                                <form action="{{ route('news.destroy',$data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="mt-8">
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Content Management - News - Event</h4>
            <a href="{{ route('news.create',['jenis'=>'event']) }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800">
                <i class="mr-2 fa-solid fa-plus"></i>
                Data Event Baru
            </a>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Date</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Type</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Judul</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">View</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($news as $key=>$data)
                        @if ($data->jenis=='Event')
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ date('d-M-Y',strtotime($data->date)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->type }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->judul }}</td>
                            <td class="p-4 text-gray-700 border-b"><img src="{{ asset('storage/'.$data->gambar) }}" alt="{{ $data->gambar }}" class="object-contain w-24 h-24"></td>
                            <td class="p-4 text-gray-700 border-b">
                                <form action="{{ route('news.destroy',$data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="mt-8">
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Content Management - News - News</h4>
            <a href="{{ route('news.create',['jenis'=>'news']) }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800">
                <i class="mr-2 fa-solid fa-plus"></i>
                Data News Baru
            </a>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Date</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Type</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Judul</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">View</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($news as $key=>$data)
                        @if ($data->jenis=='News')
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ date('d-M-Y',strtotime($data->date)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->type }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->judul }}</td>
                            <td class="p-4 text-gray-700 border-b"><img src="{{ asset('storage/'.$data->gambar) }}" alt="{{ $data->gambar }}" class="object-contain w-24 h-24"></td>
                            <td class="p-4 text-gray-700 border-b">
                                <form action="{{ route('news.destroy',$data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="mt-8">
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Content Management - News - Challenge</h4>
            <a href="{{ route('news.create',['jenis'=>'challenge']) }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800">
                <i class="mr-2 fa-solid fa-plus"></i>
                Data Challenge Baru
            </a>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Date</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Type</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Judul</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">View</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-red-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($news as $key=>$data)
                        @if ($data->jenis=='Challenge')
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ date('d-M-Y',strtotime($data->date)) }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->type }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->judul }}</td>
                            <td class="p-4 text-gray-700 border-b"><img src="{{ asset('storage/'.$data->gambar) }}" alt="{{ $data->gambar }}" class="object-contain w-24 h-24"></td>
                            <td class="p-4 text-gray-700 border-b">
                                <form action="{{ route('news.destroy',$data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
                                </form>
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
