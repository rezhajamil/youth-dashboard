@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4 my-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Hasil Input Report ByU</h4>

                <div class="flex justify-between mt-4 ">
                    <form class="flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('byu.report.view') }}"
                        method="get">
                        <input type="date" name="start_date" id="start_date" class="px-4 rounded-lg"
                            value="{{ request()->get('start_date') }}" required>
                        <span class="">s/d</span>
                        <input type="date" name="end_date" id="end_date" class="px-4 rounded-lg"
                            value="{{ request()->get('end_date') }}" required>
                        <div class="flex gap-x-3">
                            <button
                                class="px-4 py-2 font-bold text-white transition rounded-lg bg-y_premier hover:bg-y_premier"><i
                                    class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                            @if (request()->get('start_date'))
                                <a href="{{ route('byu.report.view') }}"
                                    class="px-4 py-2 font-bold text-white transition bg-gray-600 rounded-lg hover:bg-gray-800"><i
                                        class="mr-2 fa-solid fa-circle-xmark"></i>Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="my-4 overflow-hidden bg-white rounded-md shadow w-fit" id="table-region">
                    <table class="text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Tanggal</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Cluster</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">City</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Injected</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Redeem Outlet</th>
                                <th class="p-4 text-sm font-medium text-gray-100 uppercase bg-y_tersier">Redeem DS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report as $key => $data)
                                <tr class="hover:bg-gray-200">
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->created_at }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->cluster }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->city }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b ">{{ $data->injected }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b">{{ $data->redeem_outlet }}</td>
                                    <td class="p-4 text-gray-700 uppercase border-b">{{ $data->ds_redeem }}</td>
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

            $("#by_region").on("change", function() {
                $("#table-region").toggle();
            })

            $("#by_cluster").on("change", function() {
                $("#table-cluster").toggle();
            })

        })
    </script>
@endsection
