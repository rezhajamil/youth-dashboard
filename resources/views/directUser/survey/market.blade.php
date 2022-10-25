@extends('layouts.dashboard.app')
@section('body')
<section class="flex justify-center w-full h-full min-h-screen px-4 py-4 bg-premier">
    <div class="w-full px-4 py-2 bg-white rounded-lg shadow-xl h-fit sm:w-3/4 ">
        @if($survey && !request()->get('finish'))
        <span class="block w-full py-2 text-2xl font-bold text-center text-sekunder">{{ $survey?$survey->nama:'' }}</span>
        <span class="block w-full py-2 mb-2 text-lg font-bold text-center border-b-2 text-tersier">{{ $sekolah?$sekolah->NAMA_SEKOLAH:'' }}</span>
        <form action="{{ route('survey.answer.store') }}" method="post" id="form-survey">
            @csrf
            <input type="hidden" name="npsn" value="{{ request()->get('npsn') }}">
            <input type="hidden" name="kelas" value="{{ request()->get('kelas') }}">
            <input type="hidden" name="session" value="{{ $survey->id }}">
            @php
            $opsi=0;
            @endphp
            @foreach ($survey->soal as $key=>$data)
            <div class="flex flex-col py-4 border-b-4 gap-y-3">
                <span class="font-semibold">{{ $key+1 }}) {{ $data }}</span>
                @if ($survey->jenis_soal[$key]=="Pilgan" || $survey->jenis_soal[$key]=="Pilgan & Isian")
                @php
                $str="A";
                @endphp
                @for ($i = 0; $i < $survey->jumlah_opsi[$key]; $i++)
                    <label>
                        <input type="radio" name="jawaban_{{ $key }}[]" value="{{ $survey->opsi[$opsi+$i] }}" class="hidden peer {{ $survey->jenis_soal[$key]=="Pilgan & Isian"?'pi':'' }} {{ $survey->jenis_soal[$key]=="Pilgan & Isian" && $i==$survey->jumlah_opsi[$key]-1 ? 'other':'' }}" data-soal="{{ $key }}" required>

                        <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                            <span class="inline-block p-4 border-r-2">{{ $str }}</span>
                            <span class="inline-block w-full p-4">{{ $survey->opsi[$opsi+$i] }}</span>
                        </div>
                    </label>
                    @php
                    ++$str;
                    @endphp
                    @endfor
                    @if ($survey->jenis_soal[$key]=="Pilgan & Isian")
                    <label>
                        <input type="text" name="jawaban_{{ $key }}[]" data-soal="{{ $key }}" disabled required placeholder="Lainnya" class="flex w-full font-semibold border-2 placeholder:opacity-70 other-isian">
                    </label>
                    @endif
                    @elseif($survey->jenis_soal[$key]=="Isian")
                    @for ($i = 0; $i < $survey->jumlah_opsi[$key]; $i++)
                        <label>
                            <input type="text" name="jawaban_{{ $key }}[]" required placeholder="{{ $data }}" class="flex w-full font-semibold border-2 placeholder:opacity-70 peer-checked:text-white peer-checked:bg-green-600 peer-checked:border-green-800">
                        </label>
                        @endfor
                        @elseif($survey->jenis_soal[$key]=="Checklist")
                        @for ($i = 0; $i < $survey->jumlah_opsi[$key]; $i++)
                            <label class="flex gap-x-4">
                                <input type="checkbox" name="jawaban_{{ $key }}[]" value="{{ $survey->opsi[$opsi+$i] }}" class="hidden peer">
                                <div class="flex w-full font-semibold border-2 peer-checked:text-white peer-checked:bg-teal-600 peer-checked:border-teal-800">
                                    <span class="inline-block p-4 border-r-2"><i class="fa-solid fa-check"></i></span>
                                    <span class="inline-block w-full p-4">{{ $survey->opsi[$opsi+$i] }}</span>
                                </div>
                                {{-- <span class="inline-block w-full p-4">{{ $survey->opsi[$opsi+$i] }}</span> --}}
                            </label>
                            @endfor
                            @elseif($survey->jenis_soal[$key]=="Prioritas")
                            <div class="grid grid-cols-2 gap-4">
                                @for ($i = 0; $i < 8; $i++) <label class="flex flex-col col-span-1 gap-y-2">
                                    <span class="font-bold">Favorit Ke-{{ $i+1 }}</span>
                                    <select name="jawaban_{{ $key }}[]" data-soal="{{ $key }}" class="prioritas" id="prior_{{ $key.'_'.$i }}">
                                        <option value="" selected disabled class="opt-title">Pilih Urutan No.{{ $i+1 }}</option>
                                        @for ($j = 0; $j < $survey->jumlah_opsi[$key]; $j++)
                                            <option value="{{ $survey->opsi[$opsi+$j] }}">{{ $survey->opsi[$opsi+$j] }}</option>
                                            @endfor
                                    </select>

                                    </label>

                                    @endfor
                            </div>
                            @endif
            </div>
            @php
            $opsi+=intval($survey->jumlah_opsi[$key]);
            @endphp
            @endforeach
            <button type="submit" id="btn-submit" class="w-full px-6 py-2 my-4 font-semibold text-white rounded bg-sekunder">Selesai</button>
        </form>

        @elseif(request()->get('finish'))
        <div class="flex flex-col gap-y-4">
            <span class="block w-full py-2 mb-2 text-4xl font-bold text-center text-green-800">Survey Telah Selesai</span>
            <i class="text-6xl text-center text-green-800 fa-solid fa-circle-check"></i>
        </div>
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
        var prioritas = [];

        $(document).on('change', '.pi', function() {
            let soal = $(this).attr('data-soal');
            if ($(this).hasClass('other')) {
                $(`input.other-isian[data-soal=${soal}]`).prop('disabled', (i, v) => v = false);
            } else {
                $(`input.other-isian[data-soal=${soal}]`).prop('disabled', (i, v) => v = true);
            }
            $(`input.other-isian[data-soal=${soal}]`).val("");
        })

        $('.prioritas').each(function() {
            var theValue = $(this).val();
            $(this).data("value", theValue);
        });

        $(document).on('change', '.prioritas', function() {
            let id = $(this).attr('id');
            let soal = $(this).attr('data-soal');
            let value = $(this).val();
            let previousValue = $(this).data("value");
            prioritas.push(value + `_${soal}`);
            prioritas = prioritas.filter(e => e != previousValue + `_${soal}`);
            $(this).data("value", value);

            console.log(prioritas);
            $(`.prioritas[data-soal=${soal}] option`).each(function() {
                if ($(this).id != id) {
                    if (prioritas.includes($(this).val() + `_${soal}`)) {
                        // $(this).prop('disabled', (i, v) => v = true);
                        $(this).hide();
                    } else {
                        // $(this).prop('disabled', (i, v) => v = false);
                        $(this).show();
                    }
                }
            })
        })

    });

</script>
@endsection
