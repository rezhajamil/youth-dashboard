@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Quiz</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('quiz.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2" id="soal-container">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 col-span-full">
                            <div>
                                <label class="text-gray-700" for="nama">Nama Quiz</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="time">Waktu (Menit)</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number" name="time" value="{{ old('time') }}" required>
                                @error('time')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="jenis">Jenis</label>
                                <select class="w-full rounded-md form-input focus:border-indigo-600" name="jenis" required>
                                    <option value="" selected disabled>Pilih Jenis</option>
                                    <option value="Youth Apps">Youth Apps</option>
                                    <option value="Event">Event</option>
                                </select>
                                @error('jenis')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col col-span-full">
                            <label class="block text-gray-700" for="deskripsi">Deskripsi</label>
                            <input type="hidden" name="deskripsi" id="deskripsi" value="{!! old('deskripsi') !!}">
                            <trix-editor input="deskripsi"></trix-editor>
                            @error('deskripsi')
                            <span class="block text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 border-b-4 sm:grid-cols-2 col-span-full">
                            <div class="flex justify-between gap-x-4 col-span-full">
                                <span class="font-bold text-blue-600 underline transition-all cursor-pointer add-soal">+ Tambah Soal</span>
                                <span class="font-bold text-black underline transition-all cursor-pointer counter-soal">Jumlah Soal : </span>
                            </div>
                            <div class="grid grid-cols-4 gap-x-4 col-span-full">
                                <div class="col-span-3">
                                    <label class="text-gray-700" for="soal">Soal</label>
                                    <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="soal[]" required>
                                </div>
                                <div class="col-span-1">
                                    <label class="text-gray-700" for="jawaban">Jawaban</label>
                                    <select name="jawaban[]" id="jawaban" class="w-full rounded-md" required>
                                        <option value="" selected disabled>Pilih Jawaban</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                    </select>
                                </div>
                            </div>
                            <div class="my-2 col-span-full">
                                <div class="flex">
                                    <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">A</label>
                                    <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                </div>
                            </div>
                            <div class="my-2 col-span-full">
                                <div class="flex">
                                    <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">B</label>
                                    <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                </div>
                            </div>
                            <div class="my-2 col-span-full">
                                <div class="flex">
                                    <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">C</label>
                                    <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                </div>
                            </div>
                            <div class="my-2 col-span-full">
                                <div class="flex">
                                    <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">D</label>
                                    <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                </div>
                            </div>
                            <div class="my-2 col-span-full">
                                <div class="flex">
                                    <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">E</label>
                                    <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                </div>
                            </div>
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
@section('script')
<script>
    $(document).ready(function() {
        var jumlah = 1;
        const countSoal = () => {
            $('.counter-soal').text(`Jumlah Soal : ${jumlah}`)
            console.log(jumlah)
        }

        countSoal();
        $(document).on('click', '.add-soal', function() {
            $('#soal-container').append(`
            <div class="grid grid-cols-1 border-b-4 sm:grid-cols-2 col-span-full">
                <div class="flex gap-x-4">
                    <span class="font-bold text-blue-600 underline transition-all cursor-pointer add-soal">+ Tambah Soal</span>
                    <span class="font-bold text-red-600 underline transition-all cursor-pointer delete-soal">- Hapus Soal</span>
                </div>
                <div class="grid grid-cols-4 gap-x-4 col-span-full">
                    <div class="col-span-3">
                        <label class="text-gray-700" for="soal">Soal</label>
                        <input class="w-full rounded-md form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="soal[]" required>
                    </div>
                    <div class="col-span-1">
                        <label class="text-gray-700" for="jawaban">Jawaban</label>
                        <select name="jawaban[]" id="jawaban" class="w-full rounded-md" required>
                            <option value="" selected disabled>Pilih Jawaban</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>
                </div>
                <div class="my-2 col-span-full">
                    <div class="flex">
                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">A</label>
                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                    </div>
                </div>
                <div class="my-2 col-span-full">
                    <div class="flex">
                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">B</label>
                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                    </div>
                </div>
                <div class="my-2 col-span-full">
                    <div class="flex">
                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">C</label>
                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                    </div>
                </div>
                <div class="my-2 col-span-full">
                    <div class="flex">
                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">D</label>
                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                    </div>
                </div>
                <div class="my-2 col-span-full">
                    <div class="flex">
                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">E</label>
                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                    </div>
                </div>
            </div>
            `);
            jumlah += 1;
            countSoal();
        })

        $(document).on('click', '.delete-soal', function() {
            $(this).parent().parent().remove();
            jumlah -= 1;
            countSoal();
        })

    })

</script>
@endsection
