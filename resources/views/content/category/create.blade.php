@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Kategori</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('category.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <div class="w-full">
                            <label class="block text-gray-700" for="role">Role</label>
                            <select name="role" id="role" class="w-full rounded-md">
                                <option value="" selected disabled>Pilih Role</option>
                                @foreach ($user_type as $item)
                                <option value="{{ $item->user_type }}" {{ old('role')==$item->user_type?'selected':'' }}>{{ $item->user_type }}</option>

                                @endforeach
                            </select>
                            @error('role')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-gray-700" for="jenis">Jenis Sales</label>
                            <input type="text" name="jenis" id="jenis" value="{{ old('jenis') }}" class="w-full rounded-md">
                            @error('jenis')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full col-span-2">
                            <label class="block text-gray-700" for="detail">Detail Produk</label>
                            <input type="text" name="detail" id="detail" value="{{ old('detail') }}" class="w-full rounded-md">
                            @error('detail')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full col-span-1">
                            <label class="block text-gray-700" for="harga">Harga</label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga') }}" class="w-full rounded-md">
                            @error('harga')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full col-span-1">
                            <label class="block text-gray-700" for="poin">Poin</label>
                            <input type="number" name="poin" id="poin" value="{{ old('poin') }}" class="w-full rounded-md">
                            @error('poin')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="flex flex-col col-span-2">
                            <label class="block text-gray-700" for="keterangan">Keterangan</label>
                            <input type="hidden" name="keterangan" id="keterangan" value="{!! old('keterangan') !!}">
                            <trix-editor input="keterangan"></trix-editor>
                            @error('keterangan')
                            <span class="block text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="w-full px-4 py-2 font-bold text-white bg-indigo-800 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
