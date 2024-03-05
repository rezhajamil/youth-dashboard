@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 my-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Absensi</h4>

                <div class="my-4 flex justify-between">
                    <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('direct_user.absensi') }}"
                        method="get">
                        <select name="cluster" id="cluster"
                            {{ auth()->user()->privilege == 'superadmin' ? '' : 'required' }}>
                            <option value="" selected disabled>Pilih Cluster</option>
                            @foreach ($cluster as $item)
                                <option value="{{ $item->cluster }}"
                                    {{ request()->get('cluster') == $item->cluster ? 'selected' : '' }}>{{ $item->cluster }}
                                </option>
                            @endforeach
                        </select>
                        <select name="role" id="role" required>
                            <option value="" selected disabled>Pilih Role</option>
                            <option value="All" {{ request()->get('role') == 'All' ? 'selected' : '' }}>All</option>
                            @foreach ($role as $item)
                                <option value="{{ $item->user_type }}"
                                    {{ request()->get('role') == $item->user_type ? 'selected' : '' }}>
                                    {{ $item->user_type }}
                                </option>
                            @endforeach
                        </select>
                        <select name="month" id="month" required>
                            <option value="" selected disabled>Pilih Bulan</option>
                            @for ($i = 1; $i < 13; $i++)
                                <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <select name="year" id="year" required>
                            <option value="" selected disabled>Pilih Tahun</option>
                            @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                                <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <div class="flex gap-x-3">
                            <button
                                class="rounded-lg bg-y_premier px-4 py-2 font-bold text-white transition hover:bg-y_premier"><i
                                    class="fa-solid fa-magnifying-glass mr-2"></i>Cari</button>
                            @if (request()->get('date'))
                                <a href="{{ route('broadcast.index') }}"
                                    class="rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                        class="fa-solid fa-circle-xmark mr-2"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                    {{-- <div class="flex gap-x-3">
                    <div class="relative rounded w-fit h-fit">
                        <input type="checkbox" id="by_region" class="appearance-none">
                    </div>
                </div> --}}

                </div>

                <span class="mb-2 mt-6 inline-block text-lg font-semibold text-gray-600">Absensi :
                    {{ date('F', strtotime("$year-" . $month . '-01')) }} {{ $year }}</span>
                <div class="w-fit overflow-hidden rounded-md bg-white shadow">
                    <table class="w-fit border-collapse text-left">
                        <thead class="border-b">
                            <tr>
                                {{-- <th class="p-2 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-y_tersier">No</th> --}}
                                <th
                                    class="border-2 border-tersier bg-y_tersier p-2 text-center text-sm font-medium uppercase text-gray-100">
                                    Nama</th>
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
                            @foreach ($absensi as $key => $data)
                                @if ($data->telp != $telp)
                                    <tr class="transition hover:bg-gray-200/40">
                                        {{-- <td class="p-2 font-bold text-center text-gray-700 border-2">{{ $key+1 }}</td> --}}
                                        <td class="border-2 p-2 uppercase text-gray-700">
                                            <a href="{{ URL::to('/absensi/show/' . $data->telp . '?month=' . $month . '&year=' . $year) }}"
                                                class="transition hover:text-indigo-800">
                                                <span
                                                    class="block whitespace-nowrap font-semibold">{{ $data->nama }}</span>
                                            </a>
                                            <a href="{{ URL::to('/absensi/show/' . $data->telp . '?month=' . $month . '&year=' . $year) }}"
                                                class="transition hover:text-indigo-800">
                                                <span
                                                    class="block whitespace-nowrap text-xs font-light">{{ $data->branch }}
                                                    | {{ $data->telp }} | {{ $data->role }}</span>
                                            </a>
                                        </td>
                                        @foreach ($period as $item)
                                            <td class="border-2 p-2 text-center uppercase text-gray-700">
                                                @foreach ($absensi as $absen)
                                                    @if (date('Y-m-d', strtotime($item)) == $absen->date && $data->telp == $absen->telp)
                                                        <i class="fa-solid fa-circle-check text-3xl text-green-600"></i>
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
