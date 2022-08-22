@extends('layouts.dashboard.app')
@section('body')
<section class="w-full h-full py-4 px-4 flex justify-center min-h-screen bg-premier">
    <div class="bg-white rounded-lg shadow-xl px-4 py-2 w-full sm:w-3/4 ">
        <span class="block w-full text-center font-bold text-2xl mb-2 text-sekunder py-2 border-b-2">{{ $quiz->nama }}</span>
        @if ($answer)
        @if (strtotime(date('Y-m-d H:i:s'))-strtotime($answer->time_start)>($quiz->time*60) || $answer->finish)
        <span class="block w-full mt-4 mb-2 font-bold text-xl text-center text-tersier">Quiz Telah Selesai</span>
        <span class="block w-full font-bold text-center text-tersier">Hasil Quiz Anda : {{ $answer->hasil }}/{{ count(json_decode($quiz->soal)) }}</span>
        <div class="bg-sekunder rounded-full p-4 px-7 my-8 w-fit mx-auto">
            <span class="block w-full text-center font-bold text-2xl text-white py-2">{{ number_format(($answer->hasil/count(json_decode($quiz->soal)))*100,0,".",",") }}</span>
        </div>
        @else
        <form action="{{ route('quiz.answer.store') }}" method="post" id="form-quiz">
            @csrf
            <input type="hidden" name="telp" value="{{ request()->get('telp') }}">
            <input type="hidden" name="session" value="{{ $id }}">
            @foreach (json_decode($quiz->soal) as $key=>$data)
            <div class="flex flex-col py-4 border-b-4 gap-y-3">
                <span class="font-semibold">{{ $key+1 }}) {{ $data }}</span>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="A" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">A</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][0] }}</span>
                    </div>
                </label>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="B" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">B</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][1] }}</span>
                    </div>
                </label>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="C" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">C</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][2] }}</span>
                    </div>
                </label>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="D" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">D</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][3] }}</span>
                    </div>
                </label>
                <label>
                    <input type="radio" name="pilihan{{ $key }}" value="E" class="hidden peer">
                    <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        <span class="inline-block p-4 border-r-2">E</span>
                        <span class="inline-block w-full p-4">{{ array_chunk(json_decode($quiz->opsi),5)[$key][4] }}</span>
                    </div>
                </label>
            </div>
            @endforeach
            <button type="submit" id="btn-submit" class="bg-sekunder rounded text-white font-semibold px-6 py-2 my-4 w-full">Selesai</button>
        </form>
        <div class="fixed bottom-2 bg-tersier mx-auto text-white text-xs inset-x-0 w-fit rounded-full px-4 py-2">
            <i class="fa-regular fa-clock"></i>
            <span id="timer"></span>
        </div>
        {{-- <input type="hidden" id="time-start" value="{{ date('M d, Y H:i:s', strtotime($answer->time_start)) }}"> --}}
        <input type="hidden" id="time-end" value="{{ date('M d, Y H:i:s', strtotime("+".$quiz->time." minutes", strtotime($answer->time_start))) }}">
        @endif
        @else
        <span class="block w-full font-bold text-sekunder">Selamat Datang {{ $user->nama }} | {{ $user->telp }}</span>
        <span class="block w-full my-2 font-semibold text-tersier">Waktu Mengerjakan Quiz : {{ $quiz->time }} Menit</span>
        {!! $quiz->deskripsi !!}
        <a href="{{ URL::to('/start/quiz/'.$id.'?telp='.request()->get('telp')) }}" class="bg-sekunder rounded my-6 block w-fit hover:bg-black transition-all text-white font-semibold mx-auto px-4 py-2">
            Mulai Quiz
        </a>
        @endif
    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        // var time_start = $("#time-start").val();
        var time_end = $("#time-end").val();

        // var count_start = new Date(`${time_start}`).getTime();
        var count_end = new Date(`${time_end}`).getTime();
        // Update the count down every 1 second

        var timer = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            // var distance = count_end - now;
            var distance = count_end - now;
            console.log(now, count_end);
            console.log(distance);
            // Time calculations for days, hours, minutes and seconds
            // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            $("#timer").html(minutes + ":" + seconds);

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(timer);
                $("#timer").html("Waktu Habis");
                // $("#form-quiz").submit(function() {
                //     location.reload();
                // });
                $("#btn-submit").click();
            }

        }, 1000);
    });

</script>
@endsection
