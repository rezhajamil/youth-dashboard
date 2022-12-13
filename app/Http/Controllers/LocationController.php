<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{

    public function taps()
    {
        $taps = DB::table('taps')->orderBy('region_channel', 'desc')->orderBy('cluster')->orderBy('provinsi')->orderBy('kabupaten')->orderBy('kecamatan')->orderBy('kelurahan')->orderBy('nama')->get();

        return view('location.taps.index', compact('taps'));
    }

    public function edit_taps($id)
    {
        $tap = DB::table('taps')->find($id);
        $cluster = DB::table('territory_new')->select('cluster')->distinct()->get();
        return view('location.taps.edit', compact('tap', 'cluster'));
    }

    public function update_taps(Request $request, $id)
    {
        $tap = DB::table('taps')->find($id);

        DB::table('taps')->update([
            "cluster" => $request->cluster
        ]);

        return redirect()->route('location.taps');
    }

    public function poi()
    {
        $poi = DB::table('list_poi')->where('status', '1')->orderBy('regional', 'desc')->orderBy('branch')->orderBy('cluster')->orderBy('kabupaten')->orderBy('poi_name')->get();
        $location = DB::table('list_poi')->select('location')->distinct()->get();

        return view('location.poi.index', compact('poi', 'location'));
    }

    public function create_poi()
    {
        $region = DB::table('territory_new')->select('regional')->orderBy('regional', 'desc')->distinct()->get();
        $location = DB::table('list_poi')->select('location')->distinct()->get();
        $keterangan = DB::table('list_poi')->select('keterangan_poi')->distinct()->get();
        $jenis = DB::table('list_poi')->select('jenis_poi')->distinct()->get();

        return view('location.poi.create', compact('region', 'location', 'keterangan', 'jenis'));
    }

    public function store_poi(Request $request)
    {
        $request->validate([
            'regional' => 'required',
            'branch' => 'required',
            'sub_branch' => 'required',
            'cluster' => 'required',
            'kabupaten' => 'required',
            'location' => 'required',
            'keterangan_poi' => 'required',
            'jenis_poi' => 'required',
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $poi = DB::table('list_poi')->insert([
            'area' => 'SUMATERA',
            'regional' => $request->regional,
            'branch' => $request->branch,
            'sub_branch' => $request->sub_branch,
            'cluster' => $request->cluster,
            'kabupaten' => $request->kabupaten,
            'location' => $request->location,
            'keterangan_poi' => $request->keterangan_poi,
            'jenis_poi' => $request->jenis_poi,
            'poi_name' => ucwords($request->name),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => '1',
        ]);

        return redirect()->route('location.poi');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}