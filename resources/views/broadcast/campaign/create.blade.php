@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Campaign</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('campaign.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <div class="grid grid-cols-2 gap-x-4">
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
                                <label class="block text-gray-700" for="program">Program</label>
                                <select name="program" id="program" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Program</option>
                                    @foreach ($data_program as $item)
                                    <option value="{{ $item->program }}" {{ old('program')==$item->program?'selected':'' }}>{{ $item->program }}</option>

                                    @endforeach
                                </select>
                                @error('program')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label class="block text-gray-700" for="keterangan">Keterangan</label>
                            <input type="hidden" name="keterangan" id="keterangan" value="{!! old('keterangan') !!}">
                            <trix-editor input="keterangan"></trix-editor>
                            @error('keterangan')
                            <span class="block text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:outline-none focus:bg-y_sekunder">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
