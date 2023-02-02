@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Notification</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('notification.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
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

                        <div class="w-full col-span-2">
                            <label class="block text-gray-700" for="judul">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="w-full rounded-md">
                            @error('judul')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col col-span-2">
                            <label class="block text-gray-700" for="message">Pesan</label>
                            <input type="hidden" name="message" id="message" value="{!! old('message') !!}">
                            <trix-editor input="message"></trix-editor>
                            @error('message')
                            <span class="block text-sm italic text-red-600">{{ $message }}</span>
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
