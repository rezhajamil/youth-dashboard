@extends('layouts.dashboard.app')
@section('body')
    <section class="flex justify-center w-full h-full min-h-screen px-4 py-4 bg-premier">
        <div class="w-full px-4 py-2 bg-white rounded-lg shadow-xl h-fit sm:w-3/4 ">
            <form action="{{ route('survey.answer.store') }}" method="post" id="form-survey">
                @csrf
                <input type="hidden" name="telp" value="{{ request()->get('telp') }}">
                <input type="hidden" name="telp_siswa" value="{{ request()->get('telp_siswa') }}">
                <input type="hidden" name="session" value="{{ $survey->id }}">
                @foreach (json_decode($survey->soal) as $key => $data)
                    <div class="flex flex-col py-4 border-b-4 gap-y-3">
                        <span class="font-semibold">{{ $key + 1 }}) {{ $data }}</span>
                        <label>
                            <input type="radio" name="pilihan{{ $key }}" value="A" class="hidden peer">
                            <div
                                class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                                <span class="inline-block p-4 border-r-2">A</span>
                                <span
                                    class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][0] }}</span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="pilihan{{ $key }}" value="B" class="hidden peer">
                            <div
                                class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                                <span class="inline-block p-4 border-r-2">B</span>
                                <span
                                    class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][1] }}</span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="pilihan{{ $key }}" value="C" class="hidden peer">
                            <div
                                class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                                <span class="inline-block p-4 border-r-2">C</span>
                                <span
                                    class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][2] }}</span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="pilihan{{ $key }}" value="D" class="hidden peer">
                            <div
                                class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                                <span class="inline-block p-4 border-r-2">D</span>
                                <span
                                    class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][3] }}</span>
                            </div>
                        </label>
                        <label>
                            <input type="radio" name="pilihan{{ $key }}" value="E" class="hidden peer">
                            <div
                                class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                                <span class="inline-block p-4 border-r-2">E</span>
                                <span
                                    class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi), 5)[$key][4] }}</span>
                            </div>
                        </label>
                    </div>
                @endforeach
                <button type="submit" id="btn-submit"
                    class="w-full px-6 py-2 my-4 font-semibold text-white rounded bg-sekunder">Selesai</button>
            </form>
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
                    url: "{{ URL::to('/find_school') }}",
                    method: "GET",
                    dataType: "JSON",
                    data: {
                        name: $('#sekolah').val(),
                        _token: _token
                    },
                    success: (data) => {
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
