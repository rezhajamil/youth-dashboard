@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4 my-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Campaign</h4>
            <a href="{{ route('campaign.create') }}" class="inline-block px-4 py-2 my-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-800"><i class="mr-2 fa-solid fa-plus"></i> Data Campaign Baru</a>
            {{-- <span class="inline-block mt-6 mb-2 text-lg font-semibold text-gray-600">Campaign</span> --}}
            <div class="overflow-hidden bg-white rounded-md shadow w-fit">
                <table class="text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th class="p-4 text-sm font-bold text-gray-100 uppercase bg-premier">No</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">BRANCH</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">DATE</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">PROGRAM</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">CAMPAIGN</th>
                            <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-premier">ACTION</th>

                            {{-- <th class="p-4 text-sm font-medium text-center text-gray-100 uppercase border-tersier bg-premier">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaign as $key=>$data)
                        <tr class="transition hover:bg-gray-200/40">
                            <td class="p-4 font-bold text-gray-700">{{ $key+1 }}</td>
                            <td class="p-4 text-gray-700 uppercase whitespace-nowrap ">{{ $data->branch }}</td>
                            <td class="p-4 text-gray-700 uppercase ">{{ date('d-M-Y',strtotime($data->date)) }}</td>
                            <td class="p-4 text-gray-700 uppercase ">{{ $data->program }}</td>
                            <td class="p-4 text-gray-700 ">{!! $data->campain !!}</td>
                            <td class="p-4 text-gray-700 uppercase ">
                                <form action="{{ route('campaign.destroy',$data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="block my-1 text-base font-semibold text-left text-red-600 transition hover:text-red-800">Hapus</button>
                                </form>
                            </td>
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

    })

</script>
@endsection
