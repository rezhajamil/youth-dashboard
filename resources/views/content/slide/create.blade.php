@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Challenge</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('slide.store') }}" method="POST" class="" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <div class="w-full">
                            <label class="block text-gray-700" for="role">Role</label>
                            <select name="role" id="role" class="w-full rounded-md">
                                <option value="" selected disabled>Pilih Role</option>
                                <option value="TYES">TYES</option>
                                <option value="Frontline Outlet">Frontline Outlet</option>
                            </select>
                            @error('role')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full col-span-1">
                            <label class="block text-gray-700" for="judul">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="w-full rounded-md">
                            @error('judul')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-gray-700" for="gambar">Gambar</label>
                            <input type="file" name="gambar" id="gambar" value="{{ old('gambar') }}" class="w-full" accept="image/*">
                            @error('gambar')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="w-full px-4 py-2 font-bold text-white bg-y_premier rounded-md hover:bg-y_sekunder focus:outline-none focus:bg-y_sekunder">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
