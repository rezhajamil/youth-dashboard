@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 my-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Monthly Clock In</h4>

                <div class="my-4 flex justify-between">
                    <form class="flex flex-wrap items-center gap-x-4 gap-y-2"
                        action="{{ route('direct_user.monthly_clock_in') }}" method="get">
                        <select name="cluster" id="cluster">
                            <option value="" selected disabled>Pilih Cluster</option>
                            @foreach ($list_cluster as $item)
                                <option value="{{ $item->cluster }}"
                                    {{ request()->get('cluster') == $item->cluster ? 'selected' : '' }}>{{ $item->cluster }}
                                </option>
                            @endforeach
                        </select>
                        <select name="month" id="month" required>
                            <option value="" selected disabled>Pilih Bulan</option>
                            @for ($i = 1; $i < 13; $i++)
                                <option value="{{ $i }}" {{ ($month ?? date('n')) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <select name="year" id="year" required>
                            <option value="" selected disabled>Pilih Tahun</option>
                            @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                                <option value="{{ $i }}" {{ ($year ?? date('Y')) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <div class="flex gap-x-3">
                            <button
                                class="rounded-lg bg-y_premier px-4 py-2 font-bold text-white transition hover:bg-y_premier"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                            @if (request()->get('cluster'))
                                <a href="{{ route('direct_user.monthly_clock_in') }}"
                                    class="rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                        class="fa-solid fa-circle-xmark mr-2"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <span class="mb-2 mt-6 inline-block text-lg font-semibold text-gray-600">ClockIn :
                    {{ date('F', strtotime("$year-" . $month . '-01')) }} {{ $year }}</span>
                <div class="w-fit overflow-hidden rounded-md bg-white shadow">
                    <table class="w-fit border-collapse text-left">
                        <thead class="border-b">
                            <tr>
                                <th
                                    class="border-2 border-tersier bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                    Nama</th>
                                <th
                                    class="border-2 border-tersier bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                    Telp</th>
                                @foreach ($period as $data)
                                    <th
                                        class="whitespace-nowrap border-2 border-tersier bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                        {{ date('d', strtotime($data)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $telp = '';
                            @endphp
                            @foreach ($clock as $key => $data)
                                @if ($data->telp != $telp)
                                    <tr class="transition hover:bg-gray-200/40">
                                        {{-- <td class="p-2 font-bold text-center text-gray-700 border-2">{{ $key+1 }}</td> --}}
                                        <td class="border-2 p-2 uppercase text-gray-700">
                                            <span class="block whitespace-nowrap">{{ $data->nama }}</span>
                                        </td>
                                        <td class="border-2 p-2 uppercase text-gray-700">
                                            <span class="block whitespace-nowrap">{{ $data->telp }}</span>
                                        </td>
                                        @foreach ($period as $item)
                                            <td class="border-2 p-2 text-center uppercase text-gray-700">
                                                @foreach ($clock as $d_clock)
                                                    @if (date('Y-m-d', strtotime($item)) == $d_clock->date && $data->telp == $d_clock->telp)
                                                        <a href="{{ route('direct_user.clock_in', ['cluster' => request()->get('cluster'), 'date' => date('Y-m-d', strtotime($item))]) }}"
                                                            class="transition hover:text-orange-600 hover:underline">
                                                            <span
                                                                class="block whitespace-nowrap">{{ $d_clock->jumlah }}</span>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                                @php
                                    $telp = $data->telp;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
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
