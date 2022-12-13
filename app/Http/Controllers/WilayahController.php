<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function getRegion(Request $request)
    {
        $region = DB::table('territory_new')->select('regional')->distinct()->whereNotNull('regional')->get();

        return response()->json($region);
    }

    public function getBranch(Request $request)
    {
        $branch = DB::table('territory_new')->select('branch')->distinct()->whereNotNull('branch')->where('regional', $request->regional)->get();

        return response()->json($branch);
    }

    public function getSubBranch(Request $request)
    {
        $sub_branch = DB::table('territory_new')->select('sub_branch')->distinct()->whereNotNull('sub_branch')->where('branch', $request->branch)->get();

        return response()->json($sub_branch);
    }

    public function getCluster(Request $request)
    {
        if($request->branch){
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', $request->branch)->get();
        }else if($request->sub_branch){
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('sub_branch', $request->sub_branch)->get();
        }

        return response()->json($cluster);
    }

    public function getKabupaten(Request $request)
    {
        $kabupaten = DB::table('territory_new')->select('kab_new as kabupaten')->distinct()->whereNotNull('kab_new')->where('cluster', $request->cluster)->get();

        return response()->json($kabupaten);
    }

    public function getTap(Request $request)
    {
        $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $request->cluster)->orderBy('nama')->get();

        return response()->json($tap);
    }
}
