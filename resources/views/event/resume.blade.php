@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Resume Peserta Event</h4>
            </div>

            <div class="flex justify-between">
                <form class="flex flex-wrap items-center my-3 gap-x-4 gap-y-2" action="{{ route('event.resume') }}" method="get">
                    <select name="event" id="event" class="px-4 pr-8 rounded-lg">
                        <option value="" selected disabled>Pilih Event</option>
                        @foreach ($event as $item)
                        <option value="{{ $item->id }}" {{ $item->id==request()->get('event')?'selected':'' }}>{{ $item->singkatan }} | {{$item->tahun}}</option>
                        @endforeach
                    </select>
                    {{-- <select name="kategori" id="kategori" class="px-4 rounded-lg">
                        <option value="" selected disabled>Pilih Kategori</option>
                        <option value="All" {{ 'All'==request()->get('kategori')?'selected':'' }}>Semua</option>
                        @foreach ($kategori as $item)
                        <option value="{{ $item->kategori }}" {{ $item->kategori==request()->get('kategori')?'selected':'' }}>{{ $item->kategori }}</option>
                        @endforeach
                    </select> --}}
                    <div class="flex gap-x-3">
                        <button class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        @if (request()->get('event'))
                        <a href="{{ route('event.resume') }}" class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-y_tersier">No</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Kategori</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jenis</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($peserta as $key=>$data)
                        <tr class="hover:bg-gray-200">
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 border-b kategori">{{ $data->kategori }}</td>
                            <td class="p-4 text-gray-700 border-b whitespace-nowrap jenis">{{ $data->jenis }}</td>
                            <td class="p-4 text-gray-700 border-b tim">{{ $data->jumlah }}</td>
                        </tr>
                        @endforeach
                        <tr class="font-bold bg-gray-200 hover:bg-gray-400">
                            <td colspan="3" class="p-4 font-bold text-center text-gray-700 border-b">TOTAL</td>
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $total }}</td>
                        </tr>
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
        $("#provinsi").on('input', () => {
            var provinsi = $("#provinsi").val();
            $.ajax({
                url: "{{ route('sekolah.get_kabupaten') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    provinsi: provinsi
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    console.log(data)
                    $("#kabupaten").html(
                        `<option value="" selected disabled>Pilih Kabupaten/Kota</option> ` +
                        data.map((item) => {
                            return `
                            <option value="${item.kabupaten}">${item.kabupaten}</option>
                            `
                        })
                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            })
        })

        $("#kabupaten").on('input', () => {
            var kabupaten = $("#kabupaten").val();
            $.ajax({
                url: "{{ route('sekolah.get_kecamatan') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    kabupaten: kabupaten
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    console.log(data)
                    $("#kecamatan").html(
                        `<option value="" selected disabled>Pilih Kecamatan</option> ` +
                        data.map((item) => {
                            return `
                            <option value="${item.kecamatan}">${item.kecamatan}</option>
                            `
                        })
                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            })
        })

        $("#branch").on('input', () => {
            var branch = $("#branch").val();
            console.log(branch)
            $.ajax({
                url: "{{ route('wilayah.get_cluster') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    branch: branch
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    $("#cluster").html(
                        `<option value="" selected>Pilih Cluster</option> ` +
                        data.map((item) => {
                            return `
                            <option value="${item.cluster}">${item.cluster}</option>
                            `
                        })

                    )

                }
                , error: (e) => {
                    console.log(e)
                }
            })

            let search = $("#branch").val();
            let pattern = new RegExp(search, "i");
            $(`.branch`).each(function() {
                let label = $(this).text();
                if (pattern.test(label)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        })

        $("#cluster").on("input", function() {
            let search = $("#cluster").val();
            let pattern = new RegExp(search, "i");
            $(`.cluster`).each(function() {
                let label = $(this).text();
                if (pattern.test(label)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });

        })

        $("#search").on("input", function() {
            find();
        });

        $("#search_by").on("input", function() {
            find();
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
    })

</script>
@endsection
