@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Absensi</h4>

            <div class="flex justify-between my-4 ">
                <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('direct_user.absensi') }}" method="get">
                    <select name="cluster" id="cluster" {{auth()->user()->privilege=='superadmin'?'':'required'}}>
                        <option value="" selected disabled>Pilih Cluster</option>
                        @foreach ($cluster as $item)
                        <option value="{{ $item->cluster }}" {{ request()->get('cluster')==$item->cluster?'selected':'' }}>{{ $item->cluster }}</option>
                        @endforeach
                    </select>
                    <select name="role" id="role" required>
                        <option value="" selected disabled>Pilih Role</option>
                        @foreach ($role as $item)
                        <option value="{{ $item->user_type }}" {{ request()->get('role')==$item->user_type?'selected':'' }}>{{ $item->user_type }}</option>
                        @endforeach
                    </select>
                    <select name="month" id="month" required>
                        <option value="" selected disabled>Pilih Bulan</option>
                        @for ($i = 1; $i < 13; $i++) <option value="{{ $i }}" {{ date('n')==$i?'selected':'' }}>{{ $i }}</option>
                            @endfor
                    </select>
                    <select name="year" id="year" required>
                        <option value="" selected disabled>Pilih Tahun</option>
                        @for ($i = date('Y')-2; $i <= date('Y'); $i++) <option value="{{ $i }}" {{ date('Y')==$i?'selected':'' }}>{{ $i }}</option>
                            @endfor
                    </select>
                    <div class="flex gap-x-3">
                        <button class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        @if (request()->get('date'))
                        <a href="{{ route('broadcast.index') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                        @endif
                    </div>
                </form>
                {{-- <div class="flex gap-x-3">
                    <div class="relative rounded w-fit h-fit">
                        <input type="checkbox" id="by_region" class="appearance-none">
                    </div>
                </div> --}}

            </div>

            <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Absensi : {{ date('F',strtotime('2022-'.$month.'-01')) }} {{ $year }}</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            {{-- <th class="p-2 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-y_tersier">No</th> --}}
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-y_tersier">Nama</th>
                            @foreach ($period as $data)
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 whitespace-nowrap border-tersier bg-y_tersier">{{ date('d',strtotime($data)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $telp=''
                        @endphp
                        @foreach ($absensi as $key=>$data)
                        @if ($data->telp!=$telp)
                        <tr class="transition hover:bg-gray-200/40">
                            {{-- <td class="p-2 font-bold text-center text-gray-700 border-2">{{ $key+1 }}</td> --}}
                            <td class="p-2 text-gray-700 uppercase border-2 ">
                                <a href="{{ URL::to('/absensi/show/'.$data->telp.'?month='.$month.'&year='.$year) }}" class="transition hover:text-indigo-800">
                                    <span class="block font-semibold whitespace-nowrap">{{ $data->nama }}</span>
                                </a>
                                <a href="{{ URL::to('/absensi/show/'.$data->telp.'?month='.$month.'&year='.$year) }}" class="transition hover:text-indigo-800">
                                    <span class="block text-xs font-light whitespace-nowrap">{{ $data->branch }} | {{ $data->telp }}</span>
                                </a>
                            </td>
                            @foreach ($period as $item)
                            <td class="p-2 text-center text-gray-700 uppercase border-2 ">
                                @foreach ($absensi as $absen)
                                @if (date('Y-m-d',strtotime($item))==$absen->date && $data->telp==$absen->telp)
                                <i class="text-3xl text-green-600 fa-solid fa-circle-check"></i>
                                @endif
                                @endforeach
                            </td>
                            @endforeach
                        </tr>
                        @endif
                        @php
                        $telp=$data->telp
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
