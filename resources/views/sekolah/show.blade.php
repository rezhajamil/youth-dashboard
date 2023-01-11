@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="mb-2 text-xl font-bold text-gray-600 align-baseline">{{$sekolah->NAMA_SEKOLAH}}</h4>

            <div class="mb-10 overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-3 text-sm font-bold text-gray-100 uppercase bg-premier">NPSN</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Kabupaten</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Alamat</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">PIC</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Telp PIC</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Kepala Sekolah</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Jumlah Siswa</th>
                            <th class="p-3 text-sm font-medium text-gray-100 uppercase bg-premier">Tanggal Update</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        <tr class="hover:bg-gray-200">
                            {{-- {{ ddd($data) }} --}}
                            <td class="p-4 font-bold text-gray-700 border-b">{{ $sekolah->NPSN }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $sekolah->CITY }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $sekolah->ALAMAT }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $sekolah->pic }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $sekolah->telp_pic }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $sekolah->kepala_sekolah }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $sekolah->siswa }}</td>
                            <td class="p-4 text-gray-700 border-b">{{ $sekolah->update_date?date('Y-m-d',strtotime($sekolah->update_date)):'' }}</td>
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

    })

</script>
@endsection
