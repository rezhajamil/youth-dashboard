@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">

            <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-y_premier rounded-md hover:bg-y_premier"><i class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Detail Survey</h4>

            <span class="inline-block mt-6 mb-2 text-xl font-semibold text-gray-600">{{ $survey->nama }}</span>
            <span class="block mb-2 text-sm text-gray-600 font-base">Jumlah Soal : {{ count(json_decode($survey->soal)) }}</span>
            <span class="block mb-2 text-gray-600 underline font-base">Deskripsi</span>
            {!! $survey->deskripsi !!}
            <div class="w-full px-4 py-2 mt-6 overflow-hidden bg-white rounded-md shadow">
                @foreach (json_decode($survey->soal) as $key=>$data)
                <div class="flex flex-col py-4 border-b-4 gap-y-3">
                    <span class="font-semibold">{{ $key+1 }}) {{ $data }}</span>
                    <div class="flex w-full font-semibold border-2">
                        <span class="inline-block p-4 border-r-2">A</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][0] }}</span>
                    </div>
                    <div class="flex w-full font-semibold border-2">
                        <span class="inline-block p-4 border-r-2">B</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][1] }}</span>
                    </div>
                    <div class="flex w-full font-semibold border-2">
                        <span class="inline-block p-4 border-r-2">C</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][2] }}</span>
                    </div>
                    <div class="flex w-full font-semibold border-2">
                        <span class="inline-block p-4 border-r-2">D</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][3] }}</span>
                    </div>
                    <div class="flex w-full font-semibold border-2">
                        <span class="inline-block p-4 border-r-2">E</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($survey->opsi),5)[$key][4] }}</span>
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
