@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <div class="flex items-center mb-6 gap-x-3">
                <form action="{{route('direct_user.kpi')}}" method="get">
                    <input type="date" name="date" id="date" class="px-4 rounded-lg" value="{{ request()->get('date') }}" required>
                    <button type="submit" class="inline-block px-4 py-2 mt-2 mb-6 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-sky-800"><i class="mr-2 fa-solid fa-magnifying-glass"></i>Cari</button>
                </form>
            </div>
            
            <div class="mb-10 overflow-auto bg-white rounded-md shadow w-fit">
                <table class="overflow-auto text-left border-collapse w-fit">
                    <thead class="border-b">
                        <tr>
                            <th rowspan="3" class="p-3 font-bold text-gray-100 uppercase border bg-y_premier">No</th>
                            <th rowspan="3" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">Branch</th>
                            <th rowspan="3" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">Cluster</th>
                            <th rowspan="3" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">Nama</th>
                            <th rowspan="3" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">Telp</th>
                            <th rowspan="3" class="p-3 font-medium text-gray-100 uppercase border bg-y_premier">Role</th>

                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Broadband</th>
                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Digital</th>
                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Orbit</th>
                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Migrasi</th>
                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Trade In</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-y_tersier">Sales</th>

                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Update Data</th>
                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Update PJP Harian</th>
                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Survey Market</th>
                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Channeling OSK & OSS</th>
                            <th colspan="2" class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Product Knowledge</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-tersier">Proses</th>

                            <th class="p-3 font-medium text-gray-100 uppercase bg-black border">Total</th>
                        </tr>
                        <tr>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['broadband']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['broadband']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['digital']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['digital']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['orbit']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['orbit']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['migrasi']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['migrasi']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['trade']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['trade']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$sales}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['update_data']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['update_data']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['pjp']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['pjp']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['survey']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['survey']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['oss_osk']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['oss_osk']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['quiz']['target']}}</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$list_target['quiz']['bobot']}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$proses}}%</th>
                            <th class="p-3 font-medium text-gray-100 uppercase border bg-slate-400">{{$sales+$proses}}%</th>
                        </tr>
                    </thead>
                    <tbody class="max-h-screen overflow-y-auto">
                        @foreach ($detail as $key=>$data)
                        <tr class="">
                            <td class="p-2 font-bold border">{{$key+1}}</td>
                            <td class="p-2 border">{{$data->branch}}</td>
                            <td class="p-2 border">{{$data->cluster}}</td>
                            <td class="p-2 border">{{$data->nama}}</td>
                            <td class="p-2 border">{{$data->telp}}</td>
                            <td class="p-2 border">{{$data->role}}</td>
                            
                            <td class="p-2 border">{{$data->broadband??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_broadband??'-'}}%</td>
                            <td class="p-2 border">{{$data->digital??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_digital??'-'}}%</td>
                            <td class="p-2 border">{{$data->orbit??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_orbit??'-'}}%</td>
                            <td class="p-2 border">{{$data->migrasi??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_migrasi??'-'}}%</td>
                            <td class="p-2 border">{{$data->trade??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_trade??'-'}}%</td>
                            <td class="p-2 border">{{$data->tot_sales}}%</td>
                            
                            <td class="p-2 border">{{$data->update_data??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_update_data??'-'}}%</td>
                            <td class="p-2 border">{{$data->pjp??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_pjp??'-'}}%</td>
                            <td class="p-2 border">{{$data->survey??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_survey??'-'}}%</td>
                            <td class="p-2 border">{{$data->oss_osk??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_oss_osk??'-'}}%</td>
                            <td class="p-2 border">{{$data->quiz??'-'}}</td>
                            <td class="p-2 border">{{$data->ach_quiz??'-'}}%</td>
                            <td class="p-2 border">{{$data->tot_proses}}%</td>
                            <td class="p-2 border">{{$data->total}}%</td>
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

    })

</script>
@endsection
