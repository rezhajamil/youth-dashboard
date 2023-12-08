@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Sertifikat</h4>

                <div class="px-6 py-4 mx-auto mt-4 overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                    <form action="{{ route('sertifikat.store') }}" method="POST" class="">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 mt-4">
                            <div class="flex flex-col">
                                <label class="block text-gray-700" for="judul">Judul Sertifikat</label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                                    placeholder="Judul">
                                @error('judul')
                                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-gray-700" for="url">URL Sertifikat</label>
                                <input type="url" name="url" id="url" value="{{ old('url') }}"
                                    placeholder="Url">
                                @error('url')
                                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-gray-700" for="deskripsi">Deskripsi Sertifikat</label>
                                <textarea name="deskripsi" id="deskripsi" cols="30" rows="10">{!! old('deskripsi') !!}</textarea>
                                @error('deskripsi')
                                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button
                                class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_sekunder hover:bg-y_premier focus:outline-none focus:bg-y_premier">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection
