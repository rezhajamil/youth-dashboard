@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Data Peserta Event</h4>
            </div>

            <div class="flex justify-between">
                <form class="flex flex-wrap items-center my-3 gap-x-4 gap-y-2" action="{{ route('event.index') }}" method="get">
                    <select name="event" id="event" class="px-4 pr-8 rounded-lg">
                        <option value="" selected disabled>Pilih Event</option>
                        @foreach ($event as $item)
                        <option value="{{ $item->id }}" {{ $item->id==request()->get('event')?'selected':'' }}>{{ $item->singkatan }} | {{$item->tahun}}</option>
                        @endforeach
                    </select>
                    <select name="kategori" id="kategori" class="px-4 rounded-lg">
                        <option value="" selected disabled>Pilih Kategori</option>
                        <option value="All" {{ 'All'==request()->get('kategori')?'selected':'' }}>Semua</option>
                        @foreach ($kategori as $item)
                        <option value="{{ $item->kategori }}" {{ $item->kategori==request()->get('kategori')?'selected':'' }}>{{ $item->kategori }}</option>
                        @endforeach
                    </select>
                    <div class="flex gap-x-3">
                        <button class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        @if (request()->get('kategori'))
                        <a href="{{ route('event.index') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                        @endif
                    </div>
                </form>
            </div>


            {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Direct Sales By Region</span> --}}
            {{-- <a href="{{ route('direct_user.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i class="mr-2 fa-solid fa-plus"></i> Data User Baru</a> --}}
            <div class="flex flex-wrap items-end my-3 gap-x-4 gap-y-2">
                <input type="text" name="search" id="search" placeholder="Search..." class="px-4 rounded-lg">
                <div class="flex flex-col">
                    {{-- <span class="font-bold text-gray-600">Berdasarkan</span> --}}
                    <select name="search_by" id="search_by" class="rounded-lg">
                        {{-- <option value="kategori">Berdasarkan Kategori</option> --}}
                        <option value="jenis">Berdasarkan Jenis</option>
                        <option value="kabupaten">Berdasarkan Kabupaten</option>
                        <option value="kecamatan">Berdasarkan Kecamatan</option>
                        <option value="npsn">Berdasarkan NPSN</option>
                        <option value="nama_sekolah">Berdasarkan Nama Sekolah</option>
                        <option value="nama">Berdasarkan Nama</option>
                        <option value="telp">Berdasarkan Telepon</option>
                        <option value="tim">Berdasarkan Nama Tim</option>
                    </select>
                </div>
                <div class="flex gap-x-3">
                    @foreach ($kategori as $key=>$item)
                    <div class="p-2 bg-white rounded w-fit h-fit">
                        <label class="mr-1 font-semibold select-none text-slate-600" for="filter{{ $key }}">{{ $item->kategori }}</label>
                        <input type="checkbox" class="filter" id="filter{{ $key }}" value="{{ $item->kategori }}" checked>
                    </div>
                    @endforeach
                </div>

            </div>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-2 text-sm font-bold text-center text-gray-100 uppercase bg-y_tersier">No</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Kategori</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Jenis</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Kabupaten</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Kecamatan</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">NPSN</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Nama Sekolah</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Nama Peserta</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Telp</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Tim</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Kelayakan</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Keterangan</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-y_tersier">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($peserta as $key=>$data)
                        <tr class="border-b hover:bg-gray-200">
                            <td class="p-2 text-sm font-bold text-gray-700 border-r">{{ $key+1 }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r kategori">{{ $data->kategori }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r whitespace-nowrap jenis">{{ $data->jenis }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r kabupaten">{{ $data->KAB_KOTA }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r kecamatan">{{ $data->KECAMATAN }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r npsn">{{ $data->npsn }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r whitespace-nowrap nama_sekolah">{{ $data->NAMA_SEKOLAH }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r whitespace-nowrap nama">{{ ucwords(strtolower($data->nama))}}</td>
                            <td class="p-2 text-sm text-gray-700 border-r telp">{{ $data->telp }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r tim">{{ $data->nama_tim }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r tim">
                                @if ($data->layak=='1')
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-green-200/50">
                                    <span class="text-sm font-semibold text-green-900 status" id="layak{{ $data->id }}">Layak</span>
                                </div>
                                @endif
                                @if ($data->layak=='0')
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-red-200/50">
                                    <span class="text-sm font-semibold text-red-900 whitespace-nowrap" id="layak{{ $data->id }}">Tidak Layak</span>
                                </div>
                                @endif
                            </td>
                            <td class="p-2 text-sm text-gray-700 border-r keterangan" id="keterangan{{ $data->id }}">{{ $data->keterangan }}</td>
                            @if($data->kategori=='The Stage')
                            <td class="flex p-2 text-sm text-gray-700 border-l border-r gap-x-2">
                                <a href="{{ $data->youtube }}" class="px-3 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-800 whitespace-nowrap" target="_blank">Buka Video</a>
                                {{-- @if($data->layak!='1')
                                <a href="{{ URL::to('/layak/event/'.$data->id.'?layak=1') }}" class="px-3 py-2 text-white transition-all bg-green-600 rounded hover:bg-green-800">Layak</a>
                                @endif
                                @if($data->layak!='0')
                                <a href="{{ URL::to('/layak/event/'.$data->id.'?layak=0') }}" class="px-3 py-2 text-white transition-all rounded bg-y_tersier whitespace-nowrap hover:bg-red-800 ">Tidak Layak</a>
                                @endif --}}
                                <button class="px-3 py-2 text-white transition-all bg-orange-600 rounded whitespace-nowrap hover:bg-orange-800 btn-keterangan" data-id="{{ $data->id }}">Beri Keterangan</button>
                            </td>
                            @else
                            <td class="p-2 text-sm text-gray-700 border-l"></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="fixed inset-0 flex items-center justify-center bg-black/50" id="modal-keterangan" style="display: none">
    <div class="w-1/2 px-4 py-2 bg-white rounded-md">
        <form action="{{ route("event.keterangan") }}" method="post" class="flex flex-col items-center gap-y-2">
            @csrf
            <input type="hidden" name="id" id="id-peserta" value="">
            <select name="layak" id="layak" class="w-full rounded">
                <option value="" selected disabled>Pilih Kelayakan</option>
                <option value="1">Layak</option>
                <option value="0">Tidak Layak</option>
            </select>
            <textarea class="w-full rounded" placeholder="Keterangan" name="keterangan"></textarea>
            <button type="submit" class="w-full px-3 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-800">Submit</button>
            <a class="w-full px-3 py-2 text-center text-white transition rounded bg-y_tersier hover:bg-red-800" id="cancel">Batal</a>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#search").on("input", function() {
            find();
            $(".filter").prop('checked', true);
        });

        $("#search_by").on("input", function() {
            find();
            $(".filter").prop('checked', true);
        });

        const find = () => {
            let search = $("#search").val();
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
        }

        $(".btn-keterangan").on("click", function() {
            let id = $(this).attr("data-id")
            let layak = $(`#layak${id}`).text();
            let keterangan = $(`#keterangan${id}`).text();
            $("#modal-keterangan").show();
            $("#id-peserta").val(id);

            if (layak == 'Layak') {
                console.log('a')
                $("select[name=layak]").val('1').change();
            } else if (layak == 'Tidak Layak') {
                console.log('b')
                $("select[name=layak]").val('0').change();
            } else {
                $("select[name=layak]").val('').change();
            }

            $("textarea").text(keterangan);
        })

        $("#cancel").on("click", function() {
            $("#modal-keterangan").hide();
        })

        $(".filter").on("change", function() {
            let value = $(this).val();
            console.log(value)
            $(".kategori").each(function() {
                if ($(this).text() == value) {
                    $(this).parent().toggle();
                }
            })
        })
    })

</script>
@endsection
