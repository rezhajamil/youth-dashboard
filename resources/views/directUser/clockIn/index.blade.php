@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="mb-2 text-xl font-bold align-baseline text-y_premier">Clock In Bulan {{$month}}, Tahun {{$year}}</h4>
            <div class="flex items-center mb-6 gap-x-3">
                <form action="{{route('direct_user.clock_in')}}" method="get">
                    <select name="cluster" id="cluster" required>
                            <option value="" selected disabled>Pilih Cluster</option>
                            @foreach ($list_cluster as $data)
                                <option value="{{$data->cluster}}" {{$data->cluster==$cluster?'selected':''}}>{{$data->cluster}}</option>
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
                    <button type="submit" class="inline-block px-4 py-2 mt-2 mb-6 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-sky-800">Ganti Tanggal</button>
                </form>
            </div>
            
            <div class="mb-10 overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase border bg-y_tersier">No</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase border bg-y_tersier">Nama</th>
                            <th rowspan="2" class="p-3 text-sm font-medium text-gray-100 uppercase border bg-y_tersier">Keterangan</th>
                            <th colspan="5" class="p-3 text-sm font-medium text-center text-gray-100 uppercase border bg-y_tersier">Clock In</th>
                        </tr>
                        <tr>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase border bg-y_tersier">I</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase border bg-y_tersier">II</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase border bg-y_tersier">III</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase border bg-y_tersier">IV</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase border bg-y_tersier">V</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
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

    })

</script>
@endsection
