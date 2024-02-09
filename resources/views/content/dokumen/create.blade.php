@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Tambah Data Dokumen</h4>

                <div class="mx-auto mt-4 w-fit overflow-auto rounded-md bg-white px-6 py-4 shadow sm:mx-0">
                    <form action="{{ route('dokumen.store') }}" method="POST" class="">
                        @csrf
                        <div class="mt-4 grid grid-cols-4 gap-6">
                            <div class="flex flex-col">
                                <label class="block text-gray-700" for="judul">Judul Dokumen</label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                                    placeholder="Judul" class="rounded">
                                @error('judul')
                                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-gray-700" for="jenis">Jenis Dokumen</label>
                                <select name="jenis" id="jenis" class="rounded">
                                    <option value="dokumen">Dokumen</option>
                                    <option value="sertifikat">Sertifikat</option>
                                </select>
                                @error('jenis')
                                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-gray-700" for="url">URL Dokumen</label>
                                <input type="url" name="url" id="url" value="{{ old('url') }}"
                                    placeholder="Url" class="rounded">
                                @error('url')
                                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label class="block text-gray-700" for="role">Role Akses Dokumen</label>
                                <select name="role" id="role" class="rounded">
                                    <option value="all">All</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full flex flex-col">
                                <label class="block text-gray-700" for="deskripsi">Deskripsi Dokumen</label>
                                <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="rounded">{!! old('deskripsi') !!}</textarea>
                                @error('deskripsi')
                                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button
                                class="w-full rounded-md bg-y_sekunder px-4 py-2 font-bold text-white hover:bg-y_premier focus:bg-y_premier focus:outline-none">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection
