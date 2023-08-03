<?php

namespace App\Http\Controllers;

use App\Models\Territory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ByuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('byu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cluster = Territory::getCluster();

        return view('byu.distribusi.create', compact('cluster'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cluster' => 'required',
            'city' => 'required',
            'date' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $distribusi = DB::table('byu_distribusi')->insert([
            'cluster' => $request->cluster,
            'city' => $request->city,
            'date' => $request->date,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('byu.index');
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

    public function create_report()
    {
        $cluster = Territory::getCluster();

        return view('byu.report.create', compact('cluster'));
    }

    public function store_report(Request $request)
    {
        $request->validate([
            'cluster' => 'required',
            'city' => 'required',
            'injected' => 'required',
            'redeem_all' => 'required',
            'outlet_st' => 'required',
            'st_outlet' => 'required',
            'ds_redeem' => 'required',
            'st_ds' => 'required',
        ]);

        $report = DB::table('byu_report')->insert([
            'cluster' => $request->cluster,
            'city' => $request->city,
            'injected' => $request->injected,
            'redeem_all' => $request->redeem_all,
            'outlet_st' => $request->outlet_st,
            'st_outlet' => $request->st_outlet,
            'ds_redeem' => $request->ds_redeem,
            'st_ds' => $request->st_ds,
        ]);

        return redirect()->route('byu.index');
    }
}
