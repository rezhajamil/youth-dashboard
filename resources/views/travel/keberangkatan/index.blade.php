@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="text-xl font-bold text-gray-600 align-baseline">Data Keberangkatan Travel</h4>

                <a href="{{ route('travel.create_keberangkatan') }}"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-plus"></i> Data Keberangkatan Baru</a>
                <div class="flex items-center my-6 gap-x-3">
                    <form action="{{ route('travel.keberangkatan') }}" method="get">
                        <input class="rounded" type="date" name="start_date" id="start_date"
                            value="{{ Request::get('start_date') ?? $startDate }}" required>
                        <span class="inline-block mx-2 font-bold">s/d</span>
                        <input class="rounded" type="date" name="end_date" id="end_date"
                            value="{{ Request::get('end_date') ?? $endDate }}" required>
                        <button type="submit"
                            class="inline-block px-4 py-2 my-2 ml-3 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-y_premier"><i
                                class="mr-2 fa-solid fa-magnifying-glass"></i>
                            Cari</button>
                    </form>
                </div>


                <div class="overflow-auto bg-white rounded-md shadow w-fit">
                    @include('components.calendar', [
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'data' => $keberangkatan,
                    ])
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

            $("#filter_status").on("input", function() {
                filter_status();
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

            const filter_status = () => {
                let filter_status = $('#filter_status').val();
                $(`.status`).each(function() {
                    let label = $(this).text();
                    if (filter_status == '') {
                        $(this).parent().parent().parent().show();
                    } else {
                        if (filter_status == label) {
                            $(this).parent().parent().parent().show();
                        } else {
                            $(this).parent().parent().parent().hide();
                        }
                    }
                });
            }
        })
    </script>
@endsection
