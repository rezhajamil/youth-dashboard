@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Schedule</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('schedule.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                        <div class="grid grid-cols-3 col-span-2 gap-4">
                            <div class="w-full">
                                <label class="block text-gray-700" for="role">Jenis</label>
                                <select name="jenis" id="jenis" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Jenis</option>
                                    <option value="Web Binar">Web Binar</option>
                                    <option value="Event">Event</option>
                                </select>
                                @error('jenis')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="date">Tanggal Pertemuan</label>
                                <input type="date" name="date" id="date" value="{{ old('date') }}" class="w-full rounded-md">
                                @error('date')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700" for="time">Jam</label>
                                <input type="time" name="time" id="time" value="{{ old('time') }}" class="w-full rounded-md">
                                @error('time')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full col-span-2">
                            <label class="block text-gray-700" for="judul">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="w-full rounded-md">
                            @error('judul')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full col-span-2">
                            <label class="block text-gray-700" for="pembicara">Pembicara</label>
                            <input type="text" name="pembicara" id="pembicara" value="{{ old('pembicara') }}" class="w-full rounded-md">
                            @error('pembicara')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full col-span-2">
                            <label class="block text-gray-700" for="mc">MC</label>
                            <input type="text" name="mc" id="mc" value="{{ old('mc') }}" class="w-full rounded-md">
                            @error('mc')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-gray-700" for="poin">Poin</label>
                            <input type="number" name="poin" id="poin" value="{{ old('poin') }}" class="w-full rounded-md">
                            @error('poin')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-gray-700" for="minus">Minus</label>
                            <input type="number" name="minus" id="minus" value="{{ old('minus') }}" class="w-full rounded-md">
                            @error('minus')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
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
