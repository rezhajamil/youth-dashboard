@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data News</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('news.store') }}" method="POST" class="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="jenis" value="{{ request()->get('jenis') }}">
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
                            <label class="block text-gray-700" for="type">Type</label>
                            <select name="type" id="type" class="w-full rounded-md">
                                <option value="" selected disabled>Pilih Type</option>
                                <option value="IMAGE" {{ old('type')=='IMAGE'?'selected':'' }}>IMAGE</option>
                                <option value="VIDEO" {{ old('type')=='VIDEO'?'selected':'' }}>VIDEO</option>
                            </select>
                            @error('type')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        @if (request()->get('jenis')=='meeting')
                        <div class="w-full col-span-full">
                            <label class="block text-gray-700" for="judul">Judul</label>
                            <select name="judul" id="judul" class="w-full rounded-md">
                                <option value="" selected disabled>Pilih Judul</option>
                                @foreach ($meeting as $item)
                                <option value="{{ $item->judul }}" {{ old('judul')==$item->judul?'selected':'' }}>{{ $item->judul }}</option>
                                @endforeach
                            </select>
                            @error('judul')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        @if (request()->get('jenis')=='event')
                        <div class="w-full col-span-full">
                            <label class="block text-gray-700" for="judul">Judul</label>
                            <select name="judul" id="judul" class="w-full rounded-md">
                                <option value="" selected disabled>Pilih Judul</option>
                                @foreach ($event as $item)
                                <option value="{{ $item->judul }}" {{ old('judul')==$item->judul?'selected':'' }}>{{ $item->judul }}</option>
                                @endforeach
                            </select>
                            @error('judul')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        @if (request()->get('jenis')=='news')
                        <div class="w-full col-span-full">
                            <label class="block text-gray-700" for="judul">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" placeholder="" class="w-full rounded-md">
                            @error('judul')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        @if (request()->get('jenis')=='challenge')
                        <div class="w-full col-span-full">
                            <label class="block text-gray-700" for="judul">Judul</label>
                            <select name="judul" id="judul" class="w-full rounded-md">
                                <option value="" selected disabled>Pilih Judul</option>
                                @foreach ($challenge as $item)
                                <option value="{{ $item->judul }}" {{ old('judul')==$item->judul?'selected':'' }}>{{ $item->judul }}</option>
                                @endforeach
                            </select>
                            @error('judul')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="w-full">
                            <label class="block text-gray-700" for="link_meeting">Link Meeting/Register</label>
                            <input type="text" name="link_meeting" id="link_meeting" value="{{ old('link_meeting') }}" placeholder="" class="w-full rounded-md">
                            <span class="block mt-1 text-sm italic text-sekunder">Jika link meeting/register tidak ada, masukkan angka '0'</span>
                            @error('link_meeting')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-gray-700" for="alamat">Link Video</label>
                            <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="w-full rounded-md">
                            <span class="block mt-1 text-sm italic text-sekunder">Jika yang di upload bukan jenis video, maskukkan angka '0'</span>
                            @error('alamat')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col col-span-full">
                            <label class="block text-gray-700" for="keterangan">Keterangan</label>
                            <input type="hidden" name="keterangan" id="keterangan" value="{!! old('keterangan') !!}">
                            <trix-editor input="keterangan"></trix-editor>
                            @error('keterangan')
                            <span class="block text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-gray-700" for="gambar">Upload Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="w-full">
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
