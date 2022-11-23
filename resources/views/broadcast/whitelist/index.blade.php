@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            @if(Auth::user()->privilege != "cluster")
            <a href="{{ route('whitelist.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-plus"></i> Data Whitelist Baru</a>
            {{-- <span class="text-sm">Update : {{ $update_broadcast[0]->last_update }}</span> --}}
            @endif
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Broadcast Program</h4>

            <div class="flex justify-between mt-4 ">
                <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('whitelist.index') }}" method="get">
                    <select name="program" id="program">
                        <option value="" selected disabled>Pilih Program</option>
                        @foreach ($dataProgram as $item)
                        <option value="{{ $item->program }}" {{ request()->get('program')==$item->program?'selected':'' }}>{{ $item->program }}</option>
                        @endforeach
                    </select>
                    <select name="program_call" id="program_call">
                        <option value="" selected disabled>Pilih Program Call</option>
                        @foreach ($dataProgramCall as $item)
                        <option value="{{ $item->program }}" {{ request()->get('program_call')==$item->program?'selected':'' }}>{{ $item->program }}</option>
                        @endforeach
                    </select>
                    <div class="flex gap-x-3">
                        <button class="px-4 py-2 font-bold text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-800"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        @if (request()->get('program'))
                        <a href="{{ route('whitelist.index') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                        @endif
                    </div>
                </form>
                <div class="flex px-6 gap-x-3">
                    <div class="p-4 bg-white rounded w-fit h-fit">
                        <label for="broadcast" class="mr-1 font-semibold text-slate-600">Broadcast</label>
                        <input type="checkbox" id="broadcast" checked>
                    </div>
                    <div class="p-4 bg-white rounded w-fit h-fit">
                        <label for="call" class="mr-1 font-semibold text-slate-600">Call</label>
                        <input type="checkbox" id="call" checked>
                    </div>
                    {{-- <div class="p-4 bg-white rounded w-fit h-fit">
                        <label for="by_detail" class="mr-1 font-semibold text-slate-600">By Detail</label>
                        <input type="checkbox" id="by_detail">
                    </div> --}}
                </div>

            </div>

            <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Whitelist By Branch</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit table-broadcast">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Branch</th>
                            <th colspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Whitelist</th>
                            <th colspan="4" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Broadcast</th>
                            <th colspan="4" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Taker</th>

                            {{-- <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th> --}}
                        </tr>
                        <tr>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Total</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Diambil</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Terpakai</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sudah</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Belum</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Ach</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sisa</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Usim</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whitelist_branch as $key=>$data)
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-3 font-bold text-gray-700 border-2">{{ $key+1 }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->branch }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->wl }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->diambil }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->diambil/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sudah }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->belum }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->sudah/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sisa }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->usim }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->usim/$data->wl)*100,2).' %' }}</td>
                            {{-- <td class="p-3 text-gray-700 border-b"></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Whitelist By Cluster</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit table-broadcast">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Branch</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Cluster</th>
                            <th colspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Whitelist</th>
                            <th colspan="4" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Broadcast</th>
                            <th colspan="4" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Taker</th>

                            {{-- <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th> --}}
                        </tr>
                        <tr>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Total</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Diambil</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Terpakai</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sudah</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Belum</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Ach</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sisa</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Usim</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whitelist_cluster as $key=>$data)
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-3 font-bold text-gray-700 border-2">{{ $key+1 }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->branch }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->cluster }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->wl }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->diambil }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->diambil/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sudah }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->belum }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->sudah/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sisa }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->usim }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->usim/$data->wl)*100,2).' %' }}</td>
                            {{-- <td class="p-3 text-gray-700 border-b"></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Whitelist Detail</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit table-broadcast">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Branch</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Cluster</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Nama</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Telp</th>
                            <th colspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Whitelist</th>
                            <th colspan="4" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Broadcast</th>
                            @if(Auth::user()->privilege == "branch")
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th>
                            @endif

                            {{-- <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th> --}}
                        </tr>
                        <tr>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Total</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Diambil</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Terpakai</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sudah</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Belum</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Ach</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whitelist as $key=>$data)
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-3 font-bold text-gray-700 border-2">{{ $key+1 }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->branch }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->cluster }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->nama }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->telp }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->wl }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->diambil }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->diambil/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sudah }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->belum }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->sudah/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sisa }}</td>
                            @if(Auth::user()->privilege == "branch")
                            <td class="p-3 text-gray-700 border-b">
                                <form action="{{ route('whitelist.release',$data->telp) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button class="block my-1 text-base font-semibold text-left text-green-600 transition hover:text-green-800">Release Whitelist</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h4 class="inline-block mt-16 text-xl font-bold text-gray-600 align-baseline">Call Program</h4>

            <span class="block mt-2 mb-2 text-lg font-semibold text-gray-600">Whitelist Call By Branch</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit table-call">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Branch</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Cluster</th>
                            <th colspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Whitelist</th>
                            <th colspan="4" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Broadcast</th>

                            {{-- <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th> --}}
                        </tr>
                        <tr>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Total</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Diambil</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Terpakai</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sudah</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Belum</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Ach</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whitelist_branch_call as $key=>$data)
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-3 font-bold text-gray-700 border-2">{{ $key+1 }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->branch }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->cluster }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->wl }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->diambil }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->diambil/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sudah }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->belum }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->sudah/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sisa }}</td>

                            {{-- <td class="p-3 text-gray-700 border-b"></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">Whitelist Call Detail</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit table-call">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Branch</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Cluster</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Nama</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Telp</th>
                            <th colspan="3" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Whitelist</th>
                            <th colspan="4" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Broadcast</th>
                            @if(Auth::user()->privilege == "branch")
                            <th rowspan="2" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th>
                            @endif

                            {{-- <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Action</th> --}}
                        </tr>
                        <tr>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Total</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Diambil</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Terpakai</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sudah</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Belum</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">% Ach</th>
                            <th class="p-3 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-sekunder">Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whitelist_call as $key=>$data)
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-3 font-bold text-gray-700 border-2">{{ $key+1 }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->branch }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->cluster }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->nama }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->telp }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->wl }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->diambil }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->diambil/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sudah }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->belum }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 whitespace-nowrap">{{ number_format(($data->sudah/$data->wl)*100,2).' %' }}</td>
                            <td class="p-3 text-gray-700 uppercase border-2 ">{{ $data->sisa }}</td>
                            @if(Auth::user()->privilege == "branch")
                            <td class="p-3 text-gray-700 border-b">
                                <form action="{{ route('whitelist.release',$data->telp) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button class="block my-1 text-base font-semibold text-left text-green-600 transition hover:text-green-800">Release Whitelist</button>
                                </form>
                            </td>
                            @endif
                        </tr>
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

        $("#broadcast").on("change", function() {
            $(".table-broadcast").toggle();
        })

        $("#call").on("change", function() {
            $(".table-call").toggle();
        })


    })

</script>
@endsection
