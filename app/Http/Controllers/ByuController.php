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

        return view('byu.stok.create', compact('cluster'));
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

        $stok = DB::table('byu_stok')->insert([
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

    public function create_distribusi()
    {
        $privilege = auth()->user()->privilege;
        $branch = auth()->user()->branch;
        $cluster = auth()->user()->cluster;

        $ds = DB::table('data_user')->where('status', 1)->orderBy('nama');
        if ($privilege == 'branch') {
            $ds = $ds->where('branch', $branch);
        } else if ($privilege == 'cluster') {
            $ds = $ds->where('cluster', $cluster);
        }
        $ds = $ds->get();

        $list_cluster = Territory::getCluster();

        return view('byu.distribusi.create', compact('ds', 'list_cluster'));
    }

    public function store_distribusi(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'id_digipos' => 'required',
            'date' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $distribusi = DB::table('byu_distribusi')->insert([
            'type' => $request->type,
            'id_digipos' => $request->id_digipos,
            'date' => $request->date,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('byu.index');
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
            'ds_redeem' => 'required',
        ]);

        $report = DB::table('byu_report')->insert([
            'cluster' => $request->cluster,
            'city' => $request->city,
            'injected' => $request->injected,
            'redeem_all' => $request->redeem_all,
            'ds_redeem' => $request->ds_redeem,
        ]);

        return redirect()->route('byu.index');
    }

    public function get_outlet(Request $request)
    {
        $outlet = DB::table('outlet_preference_new')->where('kabupaten', $request->city)->where('fisik', 'FISIK')->orderBy('nama_outlet')->get();

        return response()->json($outlet);
    }
}
