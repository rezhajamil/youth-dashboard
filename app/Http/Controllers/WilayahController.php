<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function getRegion(Request $request)
    {
        $region = DB::table('wilayah')->select('regional')->distinct()->whereNotNull('regional')->get();

        return response()->json($region);
    }

    public function getBranch(Request $request)
    {
        $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->where('regional', $request->regional)->get();

        return response()->json($branch);
    }

    public function getCluster(Request $request)
    {
        $cluster = DB::table('wilayah')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', $request->branch)->get();

        return response()->json($cluster);
    }

    public function getTap(Request $request)
    {
        $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $request->cluster)->orderBy('nama')->get();

        return response()->json($tap);
    }
}
