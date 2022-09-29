@extends('layouts.dashboard.app')
@section('body')
<section class="flex justify-center w-full h-full min-h-screen px-4 py-4 bg-premier">
    <div class="w-full px-4 py-2 bg-white rounded-lg shadow-xl h-fit sm:w-3/4 ">
        @if($survey)
        <span class="block w-full py-2 mb-2 text-2xl font-bold text-center border-b-2 text-sekunder">{{ $survey?$survey->nama:'' }}</span>
        @if ($answer && $answer->finish)
        <span class="block w-full mt-4 mb-2 text-xl font-bold text-center text-tersier">Survey Telah Selesai</span>
        @elseif(request()->get('npsn')&&request()->get('kelas')&&request()->get('telp_siswa')&& !$answer->finish)
        <form action="{{ route('survey.answer.store') }}" method="post" id="form-survey">
            @csrf
            <input type="hidden" name="telp" value="{{ request()->get('telp') }}">
            <input type="hidden" name="telp_siswa" value="{{ request()->get('telp_siswa') }}">
            <input type="hidden" name="session" value="{{ $survey->id }}">
            @foreach (json_decode($survey->soal) as $key=>$data)
            <div class="flex flex-col py-4 border-b-4 gap-y-3">
                <span class="font-semibold">{{ $key+1 }}) {{ $data }}</span>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="A" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">A</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][0] }}</span>
                    </div>
                </label>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="B" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">B</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][1] }}</span>
                    </div>
                </label>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="C" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">C</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][2] }}</span>
                    </div>
                </label>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="D" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">D</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][3] }}</span>
                    </div>
                </label>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="E" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">E</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][4] }}</span>
                    </div>
                </label>
            </div>
            @endforeach
            <button type="submit" id="btn-submit" class="w-full px-6 py-2 my-4 font-semibold text-white rounded bg-sekunder">Selesai</button>
        </form>
        @else
        <span class="block w-full font-bold text-sekunder">Selamat Datang {{ $user->nama }} | {{ $user->telp }}</span>
        {!! $survey->deskripsi !!}
        <form action="{{ URL::to("/start/survey") }}" method="get" class="my-4" x-data="{search:false}">
            <input type="hidden" name="telp" value="{{ request()->get('telp') }}">
            <input class="w-full rounded-md form-input focus:border-indigo-600" type="number" name="npsn" id="npsn" placeholder="NPSN" value="{{ old('npsn') }}" required>
            <span class="inline-block mt-1 text-sm underline transition-all cursor-pointer text-sekunder hover:text-black" x-on:click="search=true"><i class="mr-1 text-sm fa-solid fa-magnifying-glass text-sekunder"></i>Cari Sekolah</span>
            <input class="w-full mt-4 rounded-md form-input focus:border-indigo-600" type="number" name="telp_siswa" id="telp_siswa" placeholder="Telepon Siswa" value="{{ old('telp_siswa') }}" required>
            <span class="inline-block mt-1 text-sm transition-all cursor-pointer text-sekunder hover:text-black">Format : 081234567890</span>

            <select name="kelas" id="kelas" class="w-full mt-4 rounded-md form-input focus:border-indigo-600">
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
            <button class="block px-4 py-2 mx-auto my-6 font-semibold text-white transition-all rounded bg-sekunder w-fit hover:bg-black">
                Mulai Survey
            </button>
            <div class="fixed inset-0 z-20 flex items-center justify-center w-full h-full overflow-auto bg-black/80" style="display:none;" id="search" x-show="search" x-transition>
                <i class="absolute z-10 text-3xl text-white transition cursor-pointer fa-solid fa-xmark top-5 right-10 hover:text-premier" x-on:click="search=false"></i>
                <div class="flex flex-col w-full mx-4 overflow-hidden bg-white rounded-lg sm:w-1/2">
                    <span class="inline-block w-full p-4 mb-4 text-lg font-bold text-center text-white bg-premier">Cari Sekolah</span>
                    <input type="text" class="mx-4 rounded" name="sekolah" id="sekolah" placeholder="Ketik Nama Sekolah" class="mb-4" autofocus>
                    <img src="{{ asset('images/loading.svg') }}" alt="Loading" id="loading" class="w-24 h-24 mx-auto mt-6">
                    <div class="flex flex-col w-full h-64 py-2 mt-2 overflow-auto" id="school-list">
                    </div>
                </div>
            </div>
        </form>
        <div class="my-8">
            <span class="block w-full mb-2 font-bold text-center text-sekunder">Riwayat Survey</span>
            <div class="overflow-auto rounded-sm">
                <table class="mx-auto overflow-auto text-left border border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-2 text-sm font-medium text-gray-100 uppercase bg-tersier">NPSN</th>
                            <th class="p-2 text-sm font-medium text-gray-100 uppercase bg-tersier">Kelas</th>
                            <th class="p-2 text-sm font-medium text-gray-100 uppercase bg-tersier">Telepon Siswa</th>
                        </tr>
                    </thead>
                    <tbody class="overflow-auto max-h-36">
                        @foreach ($history as $data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $data->npsn }}</td>
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $data->kelas }}</td>
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $data->telp_siswa }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @else
        <span class="block w-full py-2 mb-2 text-2xl font-bold text-center text-premier">Tidak Ada Survey Aktif</span>
        @endif
    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#loading').hide();

        $('#sekolah').on('input', function() {
            $('#loading').show();
            findSchool();
        })
        const findSchool = () => {
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ URL::to('/find_school') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    name: $('#sekolah').val()
                    , _token: _token
                }
                , success: (data) => {
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
                }
                , error: (e) => {
                    console.log('error', e);
                }
            })
        }

    });

</script>
@endsection
