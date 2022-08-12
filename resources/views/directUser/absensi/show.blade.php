@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Detail Absensi</h4>

            <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Absensi : {{ $absensi[0]->nama }} | {{ $absensi[0]->telp }}</span>
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-2 text-sm font-bold text-gray-100 uppercase border-2 border-tersier bg-premier">No</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 border-tersier bg-premier">Nama</th>
                            @foreach ($period as $data)
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase border-2 whitespace-nowrap border-tersier bg-premier">{{ date('d',strtotime($data)) }}</th>
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
                            <td class="p-2 font-bold text-center text-gray-700 border-2">{{ $key+1 }}</td>
                            <td class="p-2 text-gray-700 uppercase border-2 ">
                                <a href="{{ route('direct_user.absensi.show',$data->telp) }}" class="transition hover:text-indigo-800">
                                    <span class="block font-semibold whitespace-nowrap">{{ $data->nama }}</span>
                                </a>
                                <a href="{{ route('direct_user.absensi.show',$data->telp) }}" class="transition hover:text-indigo-800">
                                    <span class="block text-xs font-light">{{ $data->telp }}</span>
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
