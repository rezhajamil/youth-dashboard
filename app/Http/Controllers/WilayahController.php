<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function getRegion(Request $request)
    {
        $region = DB::table('territory_new')->select('regional')->distinct()->whereNotNull('regional')->orderBy('regional')->get();

        return response()->json($region);
    }

    public function getBranch(Request $request)
    {
        $branch = DB::table('territory_new')->select('branch')->distinct()->whereNotNull('branch')->where('regional', $request->regional)->orderBy('branch')->get();

        return response()->json($branch);
    }

    public function getSubBranch(Request $request)
    {
        $sub_branch = DB::table('territory_new')->select('sub_branch')->distinct()->whereNotNull('sub_branch')->where('branch', $request->branch)->orderBy('sub_branch')->get();

        return response()->json($sub_branch);
    }

    public function getCluster(Request $request)
    {
        if ($request->branch) {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', $request->branch)->orderBy('cluster')->get();
        } else if ($request->sub_branch) {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('sub_branch', $request->sub_branch)->orderBy('cluster')->get();
        }

        return response()->json($cluster);
    }

    public function getProvinsi(Request $request)
    {
        $provinsi = DB::table('territory_new')->select('provinsi')->distinct()->whereNotNull('provinsi')->where('regional', $request->regional)->orderBy('provinsi')->get();

        return response()->json($provinsi);
    }

    public function getKabupaten(Request $request)
    {
        if ($request->cluster) {
            $kabupaten = DB::table('territory_new')->select('kab_new as kabupaten')->distinct()->whereNotNull('kab_new')->where('cluster', $request->cluster)->orderBy('kab_new')->get();
        } else if ($request->provinsi) {
            $kabupaten = DB::table('territory_new')->select('kab_new as kabupaten')->distinct()->whereNotNull('kab_new')->where('provinsi', $request->provinsi)->orderBy('kab_new')->get();
        }

        return response()->json($kabupaten);
    }

    public function getKecamatan(Request $request)
    {
        $kecamatan = DB::table('territory')->select('kecamatan')->distinct()->whereNotNull('kecamatan')->where('kabupaten', $request->kabupaten)->orderBy('kecamatan')->get();

        return response()->json($kecamatan);
    }

    public function getKelurahan(Request $request)
    {
        $kelurahan = DB::table('territory')->select('desa')->distinct()->whereNotNull('desa')->where('kecamatan', $request->kecamatan)->orderBy('desa')->get();

        return response()->json($kelurahan);
    }

    public function getTap(Request $request)
    {
        $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $request->cluster)->orderBy('nama')->orderBy('nama')->get();

        return response()->json($tap);
    }
}
