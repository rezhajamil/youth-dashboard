@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4 overflow-y-auto">
                <a href="{{ url()->previous() }}"
                    class="my-2 block w-fit rounded-md bg-y_premier px-4 py-2 font-bold text-white hover:bg-y_premier"><i
                        class="fa-solid fa-arrow-left mr-2"></i> Kembali</a>
                <h4 class="mb-2 inline-block align-baseline text-xl font-bold text-gray-600" id="title">
                    Resume Clock In</h4>
                {{-- <button class="px-2 py-1 ml-2 text-lg text-white transition bg-green-600 rounded-md hover:bg-green-800" id="capture"><i class="fa-regular fa-circle-down"></i></button> --}}
                <div class="flex items-center gap-x-3">
                    <form action="{{ route('direct_user.resume_clock_in') }}" method="get">
                        <input type="date" name="date" id="date" class="rounded-lg px-4"
                            value="{{ request()->get('date') }}" required>
                        <button type="submit"
                            class="my-2 ml-3 inline-block rounded-md bg-y_premier px-4 py-2 font-bold text-white transition-all hover:bg-y_premier">Pilih
                            Tanggal</button>
                    </form>
                </div>

                <div class="mb-8 mt-6 w-fit overflow-auto rounded-md bg-white shadow" id="regional-resume-container">
                    <table class="w-fit border-collapse overflow-auto bg-white text-left" id="table-regional-resume">
                        <thead class="border-b">
                            <tr class="border-b" id="row-regional-resume">
                                <th class="w-[210px] border bg-y_tersier p-3 text-center text-sm uppercase text-gray-100">
                                    Region
                                </th>
                                <th class="w-[210px] border bg-y_tersier p-3 text-center text-sm uppercase text-gray-100">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-regional-resume">
                            @foreach ($data_regional as $data)
                                <tr id="load-regional-resume" class="text-center font-semibold">
                                    <td class="border p-2">{{ $data->regional }}</td>
                                    <td class="border p-2">{{ $data->jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mb-8 mt-6 w-fit overflow-auto rounded-md bg-white shadow" id="branch-resume-container">
                    <table class="w-fit border-collapse overflow-auto bg-white text-left" id="table-branch-resume">
                        <thead class="border-b">
                            <tr class="border-b" id="row-branch-resume">
                                <th class="w-[210px] border bg-y_tersier p-3 text-center text-sm uppercase text-gray-100">
                                    Region
                                </th>
                                <th class="w-[210px] border bg-y_tersier p-3 text-center text-sm uppercase text-gray-100">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-branch-resume">
                            @foreach ($data_branch as $data)
                                <tr id="load-branch-resume" class="text-center font-semibold">
                                    <td class="border p-2">{{ $data->branch }}</td>
                                    <td class="border p-2">{{ $data->jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mb-8 mt-6 w-fit overflow-auto rounded-md bg-white shadow" id="cluster-resume-container">
                    <table class="w-fit border-collapse overflow-auto bg-white text-left" id="table-cluster-resume">
                        <thead class="border-b">
                            <tr class="border-b" id="row-cluster-resume">
                                <th class="w-[210px] border bg-y_tersier p-3 text-center text-sm uppercase text-gray-100">
                                    Region
                                </th>
                                <th class="w-[210px] border bg-y_tersier p-3 text-center text-sm uppercase text-gray-100">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto" id="tbody-cluster-resume">
                            @foreach ($data_cluster as $data)
                                <tr id="load-cluster-resume" class="text-center font-semibold">
                                    <td class="border p-2">{{ $data->cluster }}</td>
                                    <td class="border p-2">{{ $data->jumlah }}</td>
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
        $(document).ready(function() {});
    </script>
@endsection
