@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Data Keberangkatan Travel</h4>

                <a href="{{ route('travel.create_keberangkatan') }}"
                    class="my-2 inline-block rounded-md bg-y_premier px-4 py-2 font-bold text-white hover:bg-y_premier"><i
                        class="fa-solid fa-plus mr-2"></i> Data Keberangkatan Baru</a>
                <div class="my-6 flex items-center gap-x-3">
                    <form action="{{ route('travel.keberangkatan') }}" method="get">
                        <input class="rounded" type="date" name="start_date" id="start_date"
                            value="{{ Request::get('start_date') ?? $startDate }}" required>
                        <span class="mx-2 inline-block font-bold">s/d</span>
                        <input class="rounded" type="date" name="end_date" id="end_date"
                            value="{{ Request::get('end_date') ?? $endDate }}" required>
                        @if ($region)
                            <select class="mx-2 rounded" name="region" id="region">
                                <option value="" selected>Pilih Region</option>
                                @foreach ($region as $item)
                                    <option value="{{ $item->regional }}"
                                        {{ $item->regional == Request::get('region') ? 'selected' : '' }}>
                                        {{ $item->regional }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="mx-2 rounded" name="branch" id="branch">
                                <option value="" selected>Pilih Branch</option>
                                @if (Request::get('branch'))
                                    <option value="{{ Request::get('branch') }}" selected>{{ Request::get('branch') }}
                                    </option>
                                @endif
                            </select>
                            <select class="mx-2 rounded" name="cluster" id="cluster">
                                <option value="" selected>Pilih Cluster</option>
                                @if (Request::get('cluster'))
                                    <option value="{{ Request::get('cluster') }}" selected>{{ Request::get('cluster') }}
                                    </option>
                                @endif
                            </select>
                        @endif
                        <button type="submit"
                            class="my-2 ml-3 inline-block rounded-md bg-y_premier px-4 py-2 font-bold text-white transition-all hover:bg-y_premier"><i
                                class="fa-solid fa-magnifying-glass mr-2"></i>
                            Cari
                        </button>
                        @if (Request::get('region'))
                            <a href="{{ route('travel.keberangkatan') }}"
                                class="h-fit whitespace-nowrap rounded-lg bg-gray-600 px-4 py-2 font-bold text-white transition hover:bg-gray-800"><i
                                    class="fa-solid fa-circle-xmark mr-2"></i>Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="w-fit overflow-auto rounded-md bg-white shadow">
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

            $("#region").on('input', () => {
                var regional = $("#region").val();
                console.log(regional)
                $.ajax({
                    url: "{{ route('wilayah.get_branch') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        regional: regional,
                        _token: "{{ csrf_token() }}"
                    }

                    ,
                    success: (data) => {
                        $("#branch").html(
                            "<option disabled selected>Pilih Branch</option>" +
                            data.map((item) => {
                                return `
                            <option value="${item.branch}">${item.branch}</option>
                            `
                            })

                        )
                    },
                    error: (e) => {
                        console.log(e)
                    }
                })
            })

            $("#branch").on('input', () => {
                var branch = $("#branch").val();
                console.log(branch)
                $.ajax({
                    url: "{{ route('wilayah.get_cluster') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        branch: branch,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#cluster").html(
                            "<option disabled selected>Pilih Cluster</option>" +
                            data.map((item) => {
                                return `
                    <option value="${item.cluster}">${item.cluster}</option>
                    `
                            })

                        )

                    },
                    error: (e) => {
                        console.log(e)
                    }
                })
            })

        })
    </script>
@endsection
