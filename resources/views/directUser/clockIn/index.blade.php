@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="mb-2 text-xl font-bold align-baseline text-y_premier">Clock In {{$date}}</h4>
            <div class="flex items-center mb-6 gap-x-3">
                <form action="{{route('direct_user.clock_in')}}" method="get">
                    <select name="cluster" id="cluster" required>
                            <option value="" selected disabled>Pilih Cluster</option>
                            @foreach ($list_cluster as $data)
                                <option value="{{$data->cluster}}" {{$data->cluster==$cluster?'selected':''}}>{{$data->cluster}}</option>
                            @endforeach
                    </select>
                    <input type="date" name="date" id="date" class="px-4 rounded-lg" value="{{ request()->get('date') }}" required>
                    <button type="submit" class="inline-block px-4 py-2 mt-2 mb-6 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-sky-800"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                </form>
            </div>
            
            <div class="mb-10 overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            {{-- <th rowspan="2" class="p-3 text-sm font-bold text-gray-100 uppercase border bg-y_tersier">No</th> --}}
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
                        @foreach ($clocks as $key=>$clock)
                            @if ($key==0||$clock->telp!=$clocks[$key-1]->telp)
                                <tr class="">
                                    {{-- <td rowspan="3" class="p-4 font-bold text-gray-700 border-b">{{ $key+1 }}</td> --}}
                                    <td rowspan="4" class="p-4 font-bold border border-b-4">{{ $clock->nama }}<br/>({{$clock->telp}})</td>
                                    <td class="p-4 font-semibold border">Tanggal</td>
                                    @php
                                        $count=0;
                                    @endphp
                                    @foreach ($clocks as $data)
                                        @if ($clock->telp==$data->telp)
                                            <td class="p-4 border">{{$data->date}}</td>
                                            @php $count++ @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        if($count<5){
                                            for ($i=0; $i < 5-$count; $i++) { 
                                                echo "<td class='p-4 border bg-gray-400/10'></td>";
                                            }
                                        }
                                    @endphp
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold border">Waktu</td>
                                    @php
                                        $count=0;
                                    @endphp
                                    @foreach ($clocks as $data)
                                        @if ($clock->telp==$data->telp)
                                            <td class="p-4 border">{{$data->waktu}}</td>
                                            @php $count++ @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        if($count<5){
                                            for ($i=0; $i < 5-$count; $i++) { 
                                                echo "<td class='p-4 border bg-gray-400/10'></td>";
                                            }
                                        }
                                    @endphp
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold border">Lokasi</td>
                                    @php
                                        $count=0;
                                    @endphp
                                    @foreach ($clocks as $data)
                                        @if ($clock->telp==$data->telp)
                                            <td class="p-4 border">{{$data->lokasi}}</td>
                                            @php $count++ @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        if($count<5){
                                            for ($i=0; $i < 5-$count; $i++) { 
                                                echo "<td class='p-4 border bg-gray-400/10'></td>";
                                            }
                                        }
                                    @endphp
                                </tr>
                                <tr class="border-b-4">
                                    <td class="p-4 font-semibold border">Jarak</td>
                                    @php
                                        $count=0;
                                    @endphp
                                    @foreach ($clocks as $data)
                                        @if ($clock->telp==$data->telp)
                                            <td class="p-4 border">{{str_replace('.',',',$data->jarak)}} Km</td>
                                            @php $count++ @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        if($count<5){
                                            for ($i=0; $i < 5-$count; $i++) { 
                                                echo "<td class='p-4 border bg-gray-400/10'></td>";
                                            }
                                        }
                                    @endphp
                                </tr>
                            @endif
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

    })

</script>
@endsection
