@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Absen</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('event.absen.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <div class="w-full">
                            <label class="block text-gray-700" for="pertemuan">Role</label>
                            <select name="pertemuan" id="pertemuan" class="w-full rounded-md">
                                <option value="" selected disabled>Pilih Pertemuan</option>
                                @foreach ($pertemuan as $item)
                                <option value="{{ $item->judul }}" {{ old('pertemuan')==$item->judul?'selected':'' }}>{{ $item->judul }}</option>
                                @endforeach
                            </select>
                            @error('pertemuan')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-gray-700" for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-md">
                            @error('email')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-gray-700" for="telp">Telp</label>
                            <input type="number" name="telp" id="telp" value="{{ old('telp') }}" class="w-full rounded-md">
                            @error('telp')
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
