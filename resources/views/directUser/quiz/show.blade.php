@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">

            <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Detail Quiz</h4>

            <span class="inline-block mt-6 mb-2 text-xl font-semibold text-gray-600">{{ $quiz->nama }}</span>
            <span class="block mb-2 text-sm text-gray-600 font-base">Waktu : {{ $quiz->time }} Menit | Jumlah Soal : {{ count(json_decode($quiz->soal)) }}</span>
            <span class="block mb-2 text-gray-600 underline font-base">Deskripsi</span>
            {!! $quiz->deskripsi !!}
            <div class="w-full px-4 py-2 mt-6 overflow-hidden bg-white rounded-md shadow">
                @foreach (json_decode($quiz->soal) as $key=>$data)
                <div class="flex flex-col py-4 border-b-4 gap-y-3">
                    <span class="font-semibold">{{ $key+1 }}) {{ $data }}</span>
                    <div class="flex w-full font-semibold  border-2 {{ json_decode($quiz->jawaban)[$key]=='A'?'text-white bg-green-600  border-green-800':'' }}">
                        <span class="inline-block p-4 border-r-2 {{ json_decode($quiz->jawaban)[$key]=='A'?'border-green-800':'' }}">A</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][0] }}</span>
                    </div>
                    <div class="flex w-full font-semibold  border-2 {{ json_decode($quiz->jawaban)[$key]=='B'?'text-white bg-green-600  border-green-800':'' }}">
                        <span class="inline-block p-4 border-r-2 {{ json_decode($quiz->jawaban)[$key]=='B'?'border-green-800':'' }}">B</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][1] }}</span>
                    </div>
                    <div class="flex w-full font-semibold  border-2 {{ json_decode($quiz->jawaban)[$key]=='C'?'text-white bg-green-600  border-green-800':'' }}">
                        <span class="inline-block p-4 border-r-2 {{ json_decode($quiz->jawaban)[$key]=='C'?'border-green-800':'' }}">C</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][2] }}</span>
                    </div>
                    <div class="flex w-full font-semibold  border-2 {{ json_decode($quiz->jawaban)[$key]=='D'?'text-white bg-green-600  border-green-800':'' }}">
                        <span class="inline-block p-4 border-r-2 {{ json_decode($quiz->jawaban)[$key]=='D'?'border-green-800':'' }}">D</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][3] }}</span>
                    </div>
                    <div class="flex w-full font-semibold  border-2 {{ json_decode($quiz->jawaban)[$key]=='E'?'text-white bg-green-600  border-green-800':'' }}">
                        <span class="inline-block p-4 border-r-2 {{ json_decode($quiz->jawaban)[$key]=='E'?'border-green-800':'' }}">E</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][4] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#search").on("input", function() {
            let search = $(this).val();
            let searchBy = $('#search_by').val();
            let pattern = new RegExp(search, "i");
            $(`.${searchBy}`).each(function() {
                let label = $(this).text();
                if (pattern.test(label)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        });

    })

</script>
@endsection
