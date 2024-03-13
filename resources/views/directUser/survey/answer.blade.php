@extends('layouts.dashboard.app')
@section('body')
    <section class="flex h-full min-h-screen w-full justify-center bg-premier px-4 py-4">
        <div class="h-fit w-full rounded-lg bg-white px-4 py-2 shadow-xl sm:w-3/4">
            @if ($survey)
                <span
                    class="mb-2 block w-full border-b-2 py-2 text-center text-2xl font-bold text-sekunder">{{ $survey ? $survey->nama : '' }}</span>
                @if ($answer && $answer->finish)
                    <span class="mb-2 mt-4 block w-full text-center text-xl font-bold text-tersier">Survey Telah
                        Selesai</span>
                @elseif(request()->get('npsn') && request()->get('kelas') && request()->get('telp_siswa') && !$answer->finish)
                    <form action="{{ route('survey.answer.store') }}" method="post" id="form-survey">
                        @csrf
                        <input type="hidden" name="telp" value="{{ request()->get('telp') }}">
                        <input type="hidden" name="telp_siswa" value="{{ request()->get('telp_siswa') }}">
                        <input type="hidden" name="session" value="{{ $survey->id }}">
                        @foreach (json_decode($survey->soal) as $key => $data)
                            <div class="flex flex-col gap-y-3 border-b-4 py-4">
                                <span class="font-semibold">{{ $key + 1 }}) {{ $data }}</span>
                                <label>
                                    <input type="radio" name="pilihan{{ $key }}" value="A"
                                        class="peer hidden">
                                    <div
                                        class="flex w-full border-2 font-semibold peer-checked:border-green-800 peer-checked:bg-green-600 peer-checked:text-white">
                                        <span class="inline-block border-r-2 p-4">A</span>
                                        <span
                                            class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][0] }}</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="pilihan{{ $key }}" value="B"
                                        class="peer hidden">
                                    <div
                                        class="flex w-full border-2 font-semibold peer-checked:border-green-800 peer-checked:bg-green-600 peer-checked:text-white">
                                        <span class="inline-block border-r-2 p-4">B</span>
                                        <span
                                            class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][1] }}</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="pilihan{{ $key }}" value="C"
                                        class="peer hidden">
                                    <div
                                        class="flex w-full border-2 font-semibold peer-checked:border-green-800 peer-checked:bg-green-600 peer-checked:text-white">
                                        <span class="inline-block border-r-2 p-4">C</span>
                                        <span
                                            class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][2] }}</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="pilihan{{ $key }}" value="D"
                                        class="peer hidden">
                                    <div
                                        class="flex w-full border-2 font-semibold peer-checked:border-green-800 peer-checked:bg-green-600 peer-checked:text-white">
                                        <span class="inline-block border-r-2 p-4">D</span>
                                        <span
                                            class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][3] }}</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="pilihan{{ $key }}" value="E"
                                        class="peer hidden">
                                    <div
                                        class="flex w-full border-2 font-semibold peer-checked:border-green-800 peer-checked:bg-green-600 peer-checked:text-white">
                                        <span class="inline-block border-r-2 p-4">E</span>
                                        <span
                                            class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][4] }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" id="btn-submit"
                            class="my-4 w-full rounded bg-sekunder px-6 py-2 font-semibold text-white">Selesai</button>
                    </form>
                @else
                    @if (!request()->get('npsn') && $survey->tipe == 'Siswa')
                        <form action="{{ url()->current() }}" method="get" class="my-4" x-data="{ search: false }">
                            <input class="form-input w-full rounded-md focus:border-indigo-600" type="number"
                                name="npsn" id="npsn" placeholder="Masukkan NPSN" value="{{ old('npsn') }}"
                                required>
                            <span x-on:click="search=true"
                                class="mt-1 inline-block cursor-pointer text-sm text-sekunder underline transition-all hover:text-black"><i
                                    class="fa-solid fa-magnifying-glass mr-1 text-sm text-sekunder"></i>Cari Sekolah</span>
                            <button
                                class="mx-auto my-6 block w-fit rounded bg-sekunder px-4 py-2 font-semibold text-white transition-all hover:bg-black">
                                Mulai Survey
                            </button>
                            <div class="fixed inset-0 z-20 flex h-full w-full items-center justify-center overflow-auto bg-black/80"
                                style="display:none;" id="search" x-show="search" x-transition>
                                <i class="fa-solid fa-xmark absolute right-10 top-5 z-10 cursor-pointer text-3xl text-white transition hover:text-premier"
                                    x-on:click="search=false"></i>
                                <div class="mx-4 flex w-full flex-col overflow-hidden rounded-lg bg-white sm:w-1/2">
                                    <span
                                        class="mb-4 inline-block w-full bg-premier p-4 text-center text-lg font-bold text-white">Cari
                                        Sekolah</span>
                                    <div class="flex w-full justify-center">
                                        <input type="text" class="rounded-l" name="sekolah" id="sekolah"
                                            placeholder="Ketik Nama Sekolah" class="mb-4" autofocus>
                                        <div id="submit-search"
                                            class="rounded-r bg-sekunder p-3 font-bold text-white hover:bg-slate-900">Cari
                                        </div>
                                    </div>
                                    <img src="{{ asset('images/loading.svg') }}" alt="Loading" id="loading"
                                        class="mx-auto mt-6 h-24 w-24">
                                    <div class="mt-2 flex h-64 w-full flex-col overflow-auto py-2" id="school-list">
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <span class="block w-full font-bold text-sekunder">Selamat Datang {{ $user->nama }} |
                            {{ $user->telp }}</span>
                        {!! $survey->deskripsi !!}
                        <form action="{{ URL::to('/start/survey') }}" method="get" class="my-4"
                            x-data="{ search: false }">
                            <input type="hidden" name="telp" value="{{ request()->get('telp') }}">
                            <input class="form-input w-full rounded-md focus:border-indigo-600" type="number"
                                name="npsn" id="npsn" placeholder="NPSN" value="{{ old('npsn') }}" required>
                            <span
                                class="mt-1 inline-block cursor-pointer text-sm text-sekunder underline transition-all hover:text-black"
                                x-on:click="search=true"><i
                                    class="fa-solid fa-magnifying-glass mr-1 text-sm text-sekunder"></i>Cari Sekolah</span>
                            <input class="form-input mt-4 w-full rounded-md focus:border-indigo-600" type="number"
                                name="telp_siswa" id="telp_siswa" placeholder="Telepon Siswa"
                                value="{{ old('telp_siswa') }}" required>
                            <span
                                class="mt-1 inline-block cursor-pointer text-sm text-sekunder transition-all hover:text-black">Format
                                : 081234567890</span>

                            <select name="kelas" id="kelas"
                                class="form-input mt-4 w-full rounded-md focus:border-indigo-600">
                                <option value="" selected disabled>Pilih Kelas</option>
                                <optgroup label="SD">
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option>
                                </optgroup>
                                <optgroup label="SMP">
                                    <option value="VII">VII</option>
                                    <option value="VIII">VIII</option>
                                    <option value="IX">IX</option>
                                </optgroup>
                                <optgroup label="SMA">
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </optgroup>
                            </select>
                            {{-- <input class="w-full mt-4 rounded-md form-input focus:border-indigo-600" type="text" name="kelas" id="kelas" placeholder="Kelas Siswa" value="{{ old('kelas') }}" required> --}}
                            <button
                                class="mx-auto my-6 block w-fit rounded bg-sekunder px-4 py-2 font-semibold text-white transition-all hover:bg-black">
                                Mulai Survey
                            </button>
                            <div class="fixed inset-0 z-20 flex h-full w-full items-center justify-center overflow-auto bg-black/80"
                                style="display:none;" id="search" x-show="search" x-transition>
                                <i class="fa-solid fa-xmark absolute right-10 top-5 z-10 cursor-pointer text-3xl text-white transition hover:text-premier"
                                    x-on:click="search=false"></i>
                                <div class="mx-4 flex w-full flex-col overflow-hidden rounded-lg bg-white sm:w-1/2">
                                    <span
                                        class="mb-4 inline-block w-full bg-premier p-4 text-center text-lg font-bold text-white">Cari
                                        Sekolah</span>
                                    <input type="text" class="mx-4 rounded" name="sekolah" id="sekolah"
                                        placeholder="Ketik Nama Sekolah" class="mb-4" autofocus>
                                    <img src="{{ asset('images/loading.svg') }}" alt="Loading" id="loading"
                                        class="mx-auto mt-6 h-24 w-24">
                                    <div class="mt-2 flex h-64 w-full flex-col overflow-auto py-2" id="school-list">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="my-8">
                            <span class="mb-2 block w-full text-center font-bold text-sekunder">Riwayat Survey</span>
                            <div class="overflow-auto rounded-sm">
                                <table class="mx-auto w-fit border-collapse overflow-auto border text-left">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="bg-tersier p-2 text-sm font-medium uppercase text-gray-100">NPSN
                                            </th>
                                            <th class="bg-tersier p-2 text-sm font-medium uppercase text-gray-100">Kelas
                                            </th>
                                            <th class="bg-tersier p-2 text-sm font-medium uppercase text-gray-100">Telepon
                                                Siswa</th>
                                        </tr>
                                    </thead>
                                    <tbody class="max-h-36 overflow-auto">
                                        @foreach ($history as $data)
                                            <tr class="hover:bg-gray-200">
                                                <td class="border-b p-4 font-bold text-gray-700">{{ $data->npsn }}</td>
                                                <td class="border-b p-4 font-bold text-gray-700">{{ $data->kelas }}</td>
                                                <td class="border-b p-4 font-bold text-gray-700">{{ $data->telp_siswa }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endif
            @else
                <span class="mb-2 block w-full py-2 text-center text-2xl font-bold text-premier">Tidak Ada Survey
                    Aktif</span>
            @endif
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#loading').hide();

            $('#submit-search').on('click', function() {
                $("#school-list").html()
                $('#loading').show();
                findSchool();
            })
            const findSchool = () => {
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ URL::to('/find_school') }}",
                    method: "GET",
                    dataType: "JSON",
                    data: {
                        name: $('#sekolah').val(),
                        _token: _token
                    },
                    success: (data) => {
                        console.log(data);
                        $('#school-list').html(
                            data.map((data) => {
                                return `
                                <div class="flex flex-col p-4 transition border-b-2 cursor-pointer school-item hover:bg-gray-500/50" npsn="${data.NPSN}" x-on:click="search=false">
                                    <span class="font-bold text-sekunder">${data.NAMA_SEKOLAH}</span>
                                    <span class="font-semibold text-tersier">${data.NPSN}</span>
                                </div>
                                `
                            })
                        )
                        $('#loading').hide();
                        $('.school-item').click(function() {
                            let npsn = $(this).attr('npsn');
                            // $('#search').hide();
                            $('#npsn').val(npsn);
                        })
                    },
                    error: (e) => {
                        console.log('error', e);
                    }
                })
            }
        });
    </script>
@endsection
