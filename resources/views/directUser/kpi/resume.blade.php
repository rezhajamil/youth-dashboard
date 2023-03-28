@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <div class="flex items-end mb-6 gap-x-3">
                    <div class="pr-4 border-r-4 border-slate-600">
                        <form action="{{ route('direct_user.kpi') }}" method="get">
                            <input type="date" name="date" id="date" class="px-4 rounded-lg"
                                value="{{ request()->get('date') }}" required>
                            <button type="submit"
                                class="inline-block px-4 py-2 mt-2 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-sky-800"><i
                                    class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                        </form>
                    </div>
                    <input type="text" name="search" id="search" placeholder="Filter..." class="px-4 rounded-lg">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-600">Berdasarkan</span>
                        <select name="search_by" id="search_by" class="rounded-lg">
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                            <option value="nama">Nama</option>
                            <option value="telp">Telp</option>
                            <option value="role">Role</option>
                        </select>
                    </div>
                </div>

                {{-- <div class="flex flex-wrap items-end mb-2 gap-x-4">
            </div> --}}

                <span class="block mt-6 mb-2 text-lg font-semibold text-gray-600">KPI By Branch</span>
                <div class="mb-10 overflow-auto bg-white rounded-md shadow w-fit">
                    <table class="overflow-auto text-left border-collapse w-fit">
                        <thead class="border-b">
                            <tr>
                                <th rowspan="3" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">
                                    Branch</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                    Broadband</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                    Digital</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Orbit
                                </th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">
                                    Migrasi</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Trade
                                    In</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Update
                                    Data</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Update
                                    PJP Harian</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Survey
                                    Market</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">
                                    Channeling OSK & OSS</th>
                                <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Product
                                    Knowledge</th>
                            </tr>
                            <tr>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    M-1</th>
                                <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">
                                    MTD</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-screen overflow-y-auto">
                            @foreach ($resume_branch as $key => $data)
                                <tr class="">
                                    <td class="p-2 border branch whitespace-nowrap">{{ $data->branch }}</td>

                                    <td class="p-2 border">
                                        {{ $data->last_broadband ? number_format($data->last_broadband, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="p-2 border">
                                        {{ $data->broadband ? number_format($data->broadband, 0, ',', '.') : '-' }}</td>
                                    <td class="p-2 border">
                                        {{ $data->last_digital ? number_format($data->last_digital, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="p-2 border">
                                        {{ $data->digital ? number_format($data->digital, 0, ',', '.') : '-' }}</td>
                                    <td class="p-2 border">{{ $data->last_orbit ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->orbit ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->last_migrasi ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->migrasi ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->last_trade ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->trade ?? '-' }}</td>

                                    <td class="p-2 border">{{ $data->last_update_data ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->update_data ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->last_pjp ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->pjp ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->last_survey ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->survey ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->last_oss_osk ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->oss_osk ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->last_quiz ?? '-' }}</td>
                                    <td class="p-2 border">{{ $data->quiz ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col p-4 bg-white rounded shadow-sm gap-y-2 w-fit">
                    <span class="text-sm">Last Migrasi : {{ $last_migrasi->date }}</span>
                    <span class="text-sm">Last Orbit : {{ $last_orbit->date }}</span>
                    <span class="text-sm">Last Trade : {{ $last_trade->date }}</span>
                    <span class="text-sm">Last Trx Digipos : {{ $last_digipos->date }}</span>
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
        })
    </script>
@endsection
