@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex justify-between mb-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Challenge Digisquad</h4>
            </div>
            <div class="flex flex-wrap items-end my-3 gap-x-4 gap-y-2">
                <div class="flex flex-col">
                    {{-- <span class="font-bold text-gray-600">Berdasarkan</span> --}}
                    <select name="search_by" id="search_by" class="rounded-lg">
                        <option value="">Semua Judul</option>
                        @foreach ($judul as $item)
                        <option value="{{ $item->challenge }}">{{ $item->challenge }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-2 text-sm font-bold text-center text-gray-100 uppercase bg-red-600">No</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Judul</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Nama</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Telp</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Poin</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Tanggal</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Approver</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Keterangan</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Link</th>
                            <th class="p-2 text-sm font-medium text-center text-gray-100 uppercase bg-red-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($challenge as $key=>$data)
                        <tr class="border-b hover:bg-gray-200">
                            <td class="p-2 text-sm font-bold text-gray-700 border-r">{{ $key+1 }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r judul">{{ $data->challenge }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r whitespace-nowrap nama">{{ ucwords(strtolower($data->nama)) }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r telp">{{ $data->telp }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r poin">{{ $data->poin }}</td>
                            <td class="p-2 text-sm text-gray-700 border-r date">{{ $data->date }}</td>
                            <td class="p-3 text-gray-700 border-r">
                                @if ($data->approver=='1')
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-green-200/50">
                                    <span class="text-sm font-semibold text-green-900 approver">Diterima</span>
                                </div>
                                @elseif($data->approver=='0')
                                <div class="flex items-center justify-center px-3 py-1 rounded-full bg-red-200/50">
                                    <span class="text-sm font-semibold text-red-900 whitespace-nowrap approver">Ditolak</span>
                                </div>
                                @else
                                -
                                @endif
                            </td>
                            <td class="p-2 text-sm text-gray-700 border-r keterangan">{{ $data->keterangan }}</td>
                            <td class="p-2 text-sm border-r">
                                <a href="{{ $data->link }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-orange-600 underline transition hover:text-orange-800 hover:underline">Buka Link</a>
                            </td>
                            <td class="flex p-2 text-sm text-gray-700 border-l border-r gap-x-2">
                                <button class="px-3 py-2 text-white transition-all bg-orange-600 rounded whitespace-nowrap hover:bg-orange-800 btn-keterangan" data-id="{{ $data->id }}" data-telp="{{ $data->telp }}" data-poin="{{ $data->poin }}" data-judul="{{ $data->challenge }}">Beri Approval</button>
                            </td>
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
        <form action="{{ route("event.keterangan_challenge") }}" method="post" class="flex flex-col items-center gap-y-2">
            @csrf
            <input type="hidden" name="id" id="id-peserta" value="">
            <input type="hidden" name="telp" id="telp" value="">
            <input type="hidden" name="poin" id="poin" value="">
            <input type="hidden" name="judul" id="judul" value="">
            <select name="approver" id="approver" class="w-full rounded">
                <option value="" selected disabled>Pilih Approval</option>
                <option value="1">Diterima</option>
                <option value="0">Ditolak</option>
            </select>
            <textarea class="w-full rounded" placeholder="Keterangan" name="keterangan"></textarea>
            <button type="submit" class="w-full px-3 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-800">Submit</button>
            <a class="w-full px-3 py-2 text-center text-white transition bg-red-600 rounded hover:bg-red-800" id="cancel">Batal</a>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        // $("#search").on("input", function() {
        //     find();
        //     $(".filter").prop('checked', true);
        // });

        $("#search_by").on("input", function() {
            find();
        });

        const find = () => {
            let searchBy = $('#search_by').val();
            let pattern = new RegExp(searchBy, "i");
            $(`.judul`).each(function() {
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
            let telp = $(this).attr("data-telp")
            let poin = $(this).attr("data-poin")
            let judul = $(this).attr("data-judul")
            let layak = $(`#layak${id}`).text();
            let keterangan = $(`#keterangan${id}`).text();
            $("#modal-keterangan").show();
            $("#id-peserta").val(id);
            $("#telp").val(telp);
            $("#poin").val(poin);
            $("#judul").val(judul);

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

    })

</script>
@endsection
