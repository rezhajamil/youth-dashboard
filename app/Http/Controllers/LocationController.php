<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{

    public function taps(){
        $taps=DB::table('taps')->orderBy('region_channel','desc')->orderBy('cluster')->orderBy('provinsi')->orderBy('kabupaten')->orderBy('kecamatan')->orderBy('kelurahan')->orderBy('nama')->get();

        return view('location.taps.index',compact('taps'));
    }

    public function edit_taps($id){
        $tap=DB::table('taps')->find($id);
        $cluster=DB::table('territory_new')->select('cluster')->distinct()->get();
        return view('location.taps.edit',compact('tap','cluster'));
    }
    
    public function update_taps(Request $request,$id){
        $tap=DB::table('taps')->find($id);

        DB::table('taps')->update([
            "cluster"=>$request->cluster
        ]);

        return redirect()->route('location.taps');
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
