@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">Content Management - Category</h4>
            <a href="{{ route('category.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-y_premier rounded-md hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data Kategori Baru</a>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Role</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jenis</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Detail</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Keterangan</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Harga</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Poin</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($category as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->role }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->jenis }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->detail }}</td>
                            <td class="p-4 text-gray-700 border-b">{!! $data->keterangan !!}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->harga }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $data->poin }}</td>
                            <td class="p-4 text-gray-700 border-b">
                                {{-- <a href="{{ route('sekolah.edit',$data->NPSN) }}" class="block my-1 text-base font-semibold text-y_premier transition hover:text-indigo-800">Edit</a> --}}
                                <form action="{{ route('category.destroy',$data->id) }}" method="post">
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
