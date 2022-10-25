@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Survey</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('survey.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2" id="soal-container">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 col-span-full">
                            <div>
                                <label class="text-gray-700" for="nama">Nama Survey</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="tipe">Tipe Survey</label>
                                <select name="tipe" id="tipe" class="w-full rounded-md form-input focus:border-indigo-600">
                                    <option value="" selected disabled>Pilih Tipe Survey</option>
                                    <option value="DS">DS</option>
                                    <option value="Siswa">Siswa</option>
                                </select>
                                @error('tipe')
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
                                <div class="flex flex-col col-span-1">
                                    <label class="text-gray-700" for="jenis_soal">Jenis Soal</label>
                                    <select name="jenis_soal[]" class="w-full rounded-md form-input focus:border-indigo-600">
                                        <option value="pilihan_ganda">Pilihan Ganda</option>
                                        <option value="checklist">Checklist</option>
                                        <option value="prioritas">Prioritas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="option-container col-span-full">
                                <div class="my-4">
                                    <input type="hidden" name="jumlah_opsi" value="1">
                                    <div class="flex justify-end gap-x-4">
                                        <span class="inline-block font-bold text-right text-green-600 underline transition-all cursor-pointer add-checklist">+ Tambah Checklist</span>
                                    </div>
                                    <div class="flex">
                                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="checklist[]" required>
                                    </div>
                                </div>
                                {{-- <div class="my-2">
                                    <div class="flex">
                                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">A</label>
                                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <div class="flex">
                                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">B</label>
                                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <div class="flex">
                                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">C</label>
                                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <div class="flex">
                                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">D</label>
                                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <div class="flex">
                                        <label class="p-2 font-bold text-center text-white bg-gray-400 border-2 border-gray-400" for="opsi">E</label>
                                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                                    </div>
                                </div> --}}
                            </div>
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
@section('script')
<script>
    $(document).ready(function() {
        var jumlah = 1;

        let pilgan = `
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
                <div class="flex flex-col col-span-1">
                    <label class="text-gray-700" for="jenis_soal">Jenis Soal</label>
                    <select name="jenis_soal[]" class="w-full rounded-md form-input focus:border-indigo-600">
                        <option value="pilihan_ganda">Pilihan Ganda</option>
                        <option value="checklist">Checklist</option>
                        <option value="prioritas">Prioritas</option>
                    </select>
                </div>
            </div>
            <div class="option-container">
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
        `;

        let checklist = `
        <div class="my-4">
            <div class="flex justify-end gap-x-4">
                <span class="inline-block font-bold text-right text-green-600 underline transition-all cursor-pointer add-checklist">+ Tambah Checklist</span>
                <span class="inline-block font-bold text-right text-red-600 underline transition-all cursor-pointer delete-checklist">- Hapus Checklist</span>
            </div>
            <div class="flex">
                <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="checklist[]" required>
            </div>
        </div>`;


        $(document).on('change', "select[name='jenis_soal[]']", function() {
            switch ($(this).val()) {
                case 'pilihan_ganda':
                    console.log($(this).parent().parent().parent().next().find('.option-container'))
                    $(this).parent().parent().parent().next().find('.option-container').html(pilgan)
                    break;
                case 'checklist':
                    console.log($(this).closest())
                    $(this).parent().parent().next().find('.option-container').html(checklist)
                    break;

                default:
                    break;
            }
        })

        const countSoal = () => {
            $('.counter-soal').text(`Jumlah Soal : ${jumlah}`)
            console.log(jumlah)
        }

        countSoal();
        $(document).on('click', '.add-soal', function() {
            $('#soal-container').append(pilgan);
            jumlah += 1;
            countSoal();
        })

        $(document).on('click', '.delete-soal', function() {
            $(this).parent().parent().remove();
            jumlah -= 1;
            countSoal();
        })

        $(document).on('click', '.add-checklist', function() {
            $(this).parent().parent().append(checklist);
        })

        $(document).on('click', '.delete-checklist', function() {
            $(this).parent().parent().remove();
        })




    })

</script>
@endsection
