@extends('layouts.dashboard.app')
@section('body')
    <section class="flex h-full min-h-screen w-full justify-center bg-premier px-4 py-4">
        <div class="h-fit w-full rounded-lg bg-white px-4 py-2 shadow-xl sm:w-3/4">
            @if ($survey && !request()->get('finish'))
                <span
                    class="block w-full py-2 text-center text-2xl font-bold text-sekunder">{{ $survey ? $survey->nama : '' }}</span>
                <span
                    class="mb-1 block w-full border-b-2 py-2 text-center text-lg font-bold text-tersier">{{ $sekolah ? $sekolah->NAMA_SEKOLAH : '' }}</span>
                <span
                    class="{{ request()->get('kelas') ? 'border-b-2' : '' }} mb-2 block w-full py-2 text-center text-base font-bold text-tersier">{{ request()->get('kelas') ? 'Kelas ' . request()->get('kelas') : '' }}</span>
                <form action="{{ route('survey.answer.store') }}" method="post" id="form-survey">
                    @csrf
                    <input type="hidden" name="npsn" value="{{ request()->get('npsn') }}">
                    <input type="hidden" name="kelas" value="{{ request()->get('kelas') }}">
                    <input type="hidden" name="telp" value="{{ request()->get('telp') }}">
                    <input type="hidden" name="session" value="{{ $survey->id }}">
                    <input type="hidden" name="jumlah_soal" value="{{ count($survey->soal) }}">
                    <input type="hidden" name="url" value="{{ $url }}">
                    @php
                        $opsi = 0;
                    @endphp
                    @foreach ($survey->soal as $key => $data)
                        <div class="flex flex-col gap-y-3 border-b-4 py-4">
                            <span class="font-semibold">{{ $key + 1 }}) {{ $data }}</span>
                            @if ($survey->jenis_soal[$key] == 'Pilgan' || $survey->jenis_soal[$key] == 'Pilgan & Isian')
                                @php
                                    $str = 'A';
                                @endphp
                                @for ($i = 0; $i < $survey->jumlah_opsi[$key]; $i++)
                                    <label>
                                        <input type="radio" name="jawaban_{{ $key }}[]"
                                            value="{{ $survey->opsi[$opsi + $i] }}"
                                            class="{{ $survey->jenis_soal[$key] == 'Pilgan & Isian' ? 'pi' : '' }} {{ $survey->jenis_soal[$key] == 'Pilgan & Isian' && $i == $survey->jumlah_opsi[$key] - 1 ? 'other' : '' }} peer hidden"
                                            data-soal="{{ $key }}" required>

                                        <div
                                            class="flex w-full border-2 font-semibold peer-checked:border-green-800 peer-checked:bg-green-600 peer-checked:text-white">
                                            <span class="inline-block border-r-2 p-4">{{ $str }}</span>
                                            <span class="inline-block w-full p-4">{{ $survey->opsi[$opsi + $i] }}</span>
                                        </div>
                                    </label>
                                    @php
                                        ++$str;
                                    @endphp
                                @endfor
                                @if ($survey->jenis_soal[$key] == 'Pilgan & Isian')
                                    <label>
                                        <input type="text" name="jawaban_{{ $key }}[]"
                                            data-soal="{{ $key }}" disabled required placeholder="Lainnya"
                                            class="other-isian flex w-full border-2 font-semibold placeholder:opacity-70">
                                    </label>
                                @endif
                            @elseif($survey->jenis_soal[$key] == 'Isian')
                                @for ($i = 0; $i < $survey->jumlah_opsi[$key]; $i++)
                                    <label>
                                        <input type="{{ $survey->validasi[$key] == 'telp' ? 'number' : 'text' }}"
                                            name="jawaban_{{ $key }}[]" required
                                            placeholder="{{ $data }}"
                                            data-validasi="{{ $survey->validasi[$key] }}"
                                            class="flex w-full border-2 font-semibold placeholder:text-sm placeholder:opacity-70 peer-checked:border-green-800 peer-checked:bg-green-600 peer-checked:text-white">
                                    </label>
                                @endfor
                            @elseif($survey->jenis_soal[$key] == 'Checklist')
                                @for ($i = 0; $i < $survey->jumlah_opsi[$key]; $i++)
                                    <label class="flex gap-x-4">
                                        <input type="checkbox" name="jawaban_{{ $key }}[]"
                                            value="{{ $survey->opsi[$opsi + $i] }}" class="peer hidden">
                                        <div
                                            class="flex w-full border-2 font-semibold peer-checked:border-teal-800 peer-checked:bg-teal-600 peer-checked:text-white">
                                            <span class="inline-block border-r-2 p-4"><i
                                                    class="fa-solid fa-check"></i></span>
                                            <span class="inline-block w-full p-4">{{ $survey->opsi[$opsi + $i] }}</span>
                                        </div>
                                        {{-- <span class="inline-block w-full p-4">{{ $survey->opsi[$opsi+$i] }}</span> --}}
                                    </label>
                                @endfor
                            @elseif($survey->jenis_soal[$key] == 'Prioritas')
                                <div class="grid grid-cols-2 gap-4">
                                    @for ($i = 0; $i < $survey->jumlah_opsi[$key]; $i++)
                                        <label class="col-span-1 flex flex-col gap-y-2">
                                            <span class="font-bold">Favorit Ke-{{ $i + 1 }}</span>
                                            <select name="jawaban_{{ $key }}[]" data-soal="{{ $key }}"
                                                class="prioritas" id="prior_{{ $key . '_' . $i }}">
                                                <option value="" selected disabled class="opt-title">Pilih Urutan
                                                    No.{{ $i + 1 }}</option>
                                                @for ($j = 0; $j < $survey->jumlah_opsi[$key]; $j++)
                                                    <option value="{{ $survey->opsi[$opsi + $j] }}">
                                                        {{ $survey->opsi[$opsi + $j] }}</option>
                                                @endfor
                                            </select>

                                        </label>
                                    @endfor
                                </div>
                            @endif
                        </div>
                        @php
                            $opsi += intval($survey->jumlah_opsi[$key]);
                        @endphp
                    @endforeach
                    <button type="submit" id="btn-submit"
                        class="my-4 w-full rounded bg-sekunder px-6 py-2 font-semibold text-white">Selesai</button>
                </form>
            @elseif(request()->get('finish'))
                <div class="my-4 flex flex-col gap-y-4">
                    <span class="mb-2 block w-full py-2 text-center text-xl font-bold text-green-800">Survey <br>
                        {{ $sekolah->NAMA_SEKOLAH ?? '' }} <br> pada {{ date('d-m-Y') }} <br> Sudah
                        Selesai</span>
                    <span class="mb-2 block w-full py-2 text-center text-xl font-bold text-green-800">Makasih yaa sudah
                        mengikuti survey kami :)</span>
                    <i class="fa-solid fa-circle-check text-center text-6xl text-green-800"></i>
                </div>
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


            $('#btn-submit').on('click', function() {
                let soal = $('input[name=jumlah_soal]').val();

                // for (let index = 0; index < soal; index++) {
                //     let value = $(`input[name='jawaban_${index}[]']`).val();
                //     console.log($(`input[name='jawaban_${index}[]']`))
                //     if (!value) {
                //         alert('Harap menjawab semua pertanyaan sebelum mengirim jawaban');
                //         break;
                //     }
                // }

                // for (let index = 0; index < 16; index++) {
                //     let value = $(`input[name='jawaban_${index}[]' ]`).val();
                //     // console.log($(`input[name='jawaban_${index}[]' ]`)); 
                //     if (!value) {
                //         console.log($(`input[name=jawaban_${index}]`));
                //         alert('Harap menjawab semua pertanyaan sebelum mengirim jawaban');
                //         break;
                //     }
                // }
                for (let index = 0; index < soal; index++) {
                    let name = `jawaban_${index}[]`;
                    let fill = false;
                    let valid = false;
                    let validasi = $(`input[name='${name}']`).attr('data-validasi');
                    let value = $(`input[name='${name}']`).val();

                    $('form').serializeArray().map(data => {
                        if (data.name == name) {
                            fill = true;
                            if (!validasi) {
                                valid = true;
                            }
                        }
                    })

                    if (!fill) {
                        event.preventDefault();
                        alert('Harap menjawab semua pertanyaan sebelum mengirim jawaban');
                        break;
                    } else if (!valid) {
                        if (validasi == 'telp') {
                            if (value.slice(0, 2) != '08') {
                                event.preventDefault();
                                alert('Format Nomor Telepon Salah (Awalan Bukan 08)');
                                break;
                            } else if (value.length < 10 || value.length > 13) {
                                event.preventDefault();
                                alert('Nomor Telepon harus berisi 10-13 digit angka');
                                break;
                            }
                        } else if (validasi == 'nama') {
                            let valid = false;
                            // var letters = /^[A-Za-z]+$/;
                            // console.log($(`input[name='${name}']`))
                            // console.log(/[0-9]/.test(value))

                            $(`input[name='${name}']`).each(function() {
                                if (/[0-9]/.test($(this).val())) {
                                    event.preventDefault();
                                    alert('Nama harus berisikan huruf saja');
                                    return false;
                                    // break;
                                } else {
                                    valid = true;
                                }
                            })

                            if (!valid) {
                                break;
                            }
                        }

                    }
                }

                // console.log($('form').serializeArray())



            })

        });
    </script>
@endsection
