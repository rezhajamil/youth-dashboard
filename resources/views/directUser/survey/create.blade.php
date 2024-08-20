@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Survey</h4>

                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow w-fit sm:mx-0">
                    <form action="{{ route('survey.store') }}" method="POST" class="">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2" id="soal-container">
                            <div class="grid grid-cols-1 gap-6 col-span-full sm:grid-cols-3">
                                <div>
                                    <label class="text-gray-700" for="nama">Nama Survey</label>
                                    <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                        name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-gray-700" for="tipe">Tipe Survey</label>
                                    <select name="tipe" id="tipe"
                                        class="w-full rounded-md form-input focus:border-indigo-600" required>
                                        <option value="" selected disabled>Pilih Tipe Survey</option>
                                        <option value="DS">DS</option>
                                        <option value="Siswa">Siswa</option>
                                        <option value="Travel">Travel</option>
                                        <option value="PON">PON</option>
                                    </select>
                                    @error('tipe')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-6 col-span-full">
                                <div class="w-full">
                                    <label class="block text-gray-700" for="regional">Regional</label>
                                    <select name="regional" id="regional" class="w-full rounded-md" required>
                                        <option value="" selected disabled>Pilih Region</option>
                                        <option value="All">ALL Region</option>
                                        @foreach ($region as $item)
                                            <option value="{{ $item->regional }}"
                                                {{ old('regional') == $item->regional ? 'selected' : '' }}>
                                                {{ $item->regional }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('regional')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="branch">Branch</label>
                                    <select name="branch" id="branch" class="w-full rounded-md">
                                        <option value="All" selected>ALL Branch</option>
                                        @foreach ($branch as $item)
                                            <option value="{{ $item->branch }}"
                                                {{ old('branch') == $item->branch ? 'selected' : '' }}>
                                                {{ $item->branch }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="cluster">Cluster</label>
                                    <select name="cluster" id="cluster" class="w-full rounded-md">
                                        <option value="All" selected>ALL Cluster</option>
                                        @foreach ($cluster as $item)
                                            <option value="{{ $item->cluster }}"
                                                {{ old('cluster') == $item->cluster ? 'selected' : '' }}>
                                                {{ $item->cluster }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cluster')
                                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-gray-700" for="role">Role</label>
                                    <select name="role" id="role" class="w-full rounded-md">
                                        <option value="All" selected>ALL Role</option>
                                        @foreach ($role as $item)
                                            <option value="{{ $item->user_type }}"
                                                {{ old('role') == $item->user_type ? 'selected' : '' }}>
                                                {{ $item->user_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
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
                            <div class="grid grid-cols-1 border-b-4 col-span-full sm:grid-cols-2">
                                <div class="flex justify-between col-span-full gap-x-4">
                                    <span class="font-bold text-blue-600 underline transition-all cursor-pointer add-soal">+
                                        Tambah Soal</span>
                                    <span
                                        class="font-bold text-black underline transition-all cursor-pointer counter-soal">Jumlah
                                        Soal : </span>
                                </div>
                                <div class="grid grid-cols-4 col-span-full gap-x-4">
                                    <div class="col-span-2">
                                        <label class="text-gray-700" for="soal">Soal</label>
                                        <input class="w-full rounded-md form-input focus:border-indigo-600" type="text"
                                            name="soal[]" value="Boleh dong sebutkan Nomor hape kamu.. (Awalan '08')"
                                            required>
                                    </div>
                                    <div class="flex flex-col col-span-1">
                                        <label class="text-gray-700" for="jenis_soal">Jenis Soal</label>
                                        <select name="jenis_soal[]"
                                            class="w-full rounded-md select-jenis form-input focus:border-indigo-600">
                                            <option value="Pilgan" disabled>Pilihan Ganda</option>
                                            <option value="Isian" selected>Isian</option>
                                            <option value="Pilgan & Isian" disabled>Pilihan Ganda & Isian</option>
                                            {{-- <option value="Checklist">Checklist</option> --}}
                                            <option value="Prioritas" disabled>Prioritas</option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col col-span-1">
                                        <label class="text-gray-700" for="validasi">Jenis Validasi</label>
                                        <select name="validasi[]"
                                            class="w-full rounded-md form-input focus:border-indigo-600">
                                            <option value="" disabled>Tidak Ada</option>
                                            <option value="telp" selected>Nomor Telepon</option>
                                            <option value="nama" disabled>Nama (Bukan Angka)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="option-container col-span-full">
                                    <input type="hidden" name="jumlah_opsi[]" value="1">
                                    <div class="my-4">
                                        <div class="flex justify-end hidden gap-x-4">
                                            <span
                                                class="inline-block font-bold text-right text-green-600 underline transition-all cursor-pointer add-opsi">+
                                                Tambah Opsi</span>
                                        </div>
                                        <div class="flex">
                                            <input
                                                class="w-full border-2 border-gray-400 form-input first-letter:uppercase focus:border-indigo-600"
                                                type="text" name="opsi[]" readonly required>
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
                            <button
                                class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:bg-y_sekunder focus:outline-none">Submit</button>
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

            let soal = `
        <div class="grid grid-cols-1 border-b-4 sm:grid-cols-2 col-span-full">
            <div class="flex gap-x-4">
                <span class="font-bold text-blue-600 underline transition-all cursor-pointer add-soal">+ Tambah Soal</span>
                <span class="font-bold text-red-600 underline transition-all cursor-pointer delete-soal">- Hapus Soal</span>
            </div>
            <div class="grid grid-cols-4 gap-x-4 col-span-full">
                <div class="col-span-2">
                    <label class="text-gray-700" for="soal">Soal</label>
                    <input class="w-full rounded-md form-input focus:border-indigo-600" type="text" name="soal[]" required>
                </div>
                <div class="flex flex-col col-span-1">
                    <label class="text-gray-700" for="jenis_soal">Jenis Soal</label>
                    <select name="jenis_soal[]" class="w-full rounded-md select-jenis form-input focus:border-indigo-600">
                        <option value="Pilgan">Pilihan Ganda</option>
                        <option value="Isian">Isian</option>
                        <option value="Pilgan & Isian">Pilihan Ganda & Isian</option>
                        <option value="Prioritas">Prioritas</option>
                    </select>
                </div>
                <div class="flex flex-col col-span-1">
                    <label class="text-gray-700" for="validasi">Jenis Validasi</label>
                    <select name="validasi[]" class="w-full rounded-md form-input focus:border-indigo-600">
                        <option value="">Tidak Ada</option>
                        <option value="telp">Nomor Telepon</option>
                        <option value="nama">Nama (Bukan Angka)</option>
                    </select>
                </div>
            </div>
            <div class="option-container col-span-full">
                <input type="hidden" name="jumlah_opsi[]" value="1">
                <div class="my-4">
                    <div class="flex justify-end gap-x-4">
                        <span class="inline-block font-bold text-right text-green-600 underline transition-all cursor-pointer add-opsi">+ Tambah Opsi</span>
                    </div>
                    <div class="flex">
                        <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
                    </div>
                </div>

            </div>
        </div>
        `;

            let opsi = `
        <div class="my-4">
            <div class="flex justify-end gap-x-4">
                <span class="inline-block font-bold text-right text-green-600 underline transition-all cursor-pointer add-opsi">+ Tambah Opsi</span>
                <span class="inline-block font-bold text-right text-red-600 underline transition-all cursor-pointer delete-opsi">- Hapus Opsi</span>
            </div>
            <div class="flex">
                <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" required>
            </div>
        </div>`;

            let opsi_read = `
        <div class="my-4">
            <div class="flex justify-end gap-x-4">
                <span class="inline-block font-bold text-right text-green-600 underline transition-all cursor-pointer add-opsi">+ Tambah Opsi</span>
                <span class="inline-block font-bold text-right text-red-600 underline transition-all cursor-pointer delete-opsi">- Hapus Opsi</span>
            </div>
            <div class="flex">
                <input class="w-full border-2 border-gray-400 form-input focus:border-indigo-600 first-letter:uppercase" type="text" name="opsi[]" readonly required>
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
                $('#soal-container').append(soal);
                jumlah += 1;
                countSoal();
            })

            $(document).on('click', '.delete-soal', function() {
                $(this).parent().parent().remove();
                jumlah -= 1;
                countSoal();
            })

            $(document).on('click', '.add-opsi', function() {
                let jumlah_opsi = $(this).parent().parent().siblings("input").val();
                if ($(this).closest('.option-container').siblings('div.grid').find('.select-jenis').val() ==
                    'Isian') {
                    $(this).parent().parent().parent().append(opsi_read);
                } else {
                    $(this).parent().parent().parent().append(opsi);
                }
                $(this).parent().parent().siblings("input").val(parseInt(jumlah_opsi) + 1);
                console.log($(this).closest('.option-container').siblings('div.grid').find(
                    '.select-jenis'));
            })

            $(document).on('click', '.delete-opsi', function() {
                let jumlah_opsi = $(this).parent().parent().siblings("input").val();
                $(this).parent().parent().siblings("input").val(parseInt(jumlah_opsi) - 1);
                console.log($(this).parent().parent().siblings("input").val());
                $(this).parent().parent().remove();
            })

            $(document).on('change', '.select-jenis', function() {
                if ($(this).val() == 'Isian') {
                    $(this).parent().parent().siblings("div").children("div").children().children("input")
                        .prop('readonly', true).val('')
                } else {
                    $(this).parent().parent().siblings("div").children("div").children().children("input")
                        .prop('readonly', false).val('')
                }
                console.log();
            })

        })
    </script>
@endsection
