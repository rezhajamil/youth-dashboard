<?php

namespace App\Http\Controllers;

use App\Models\Byu;
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
    public function index(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $resume = Byu::getResume($month, $year);

        return view('byu.index', compact('resume'));
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
            'cluster' => 'required',
            'city' => 'required',
            'type' => 'required',
            'id_digipos' => 'required',
            'date' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $distribusi = DB::table('byu_distribusi')->insert([
            'cluster' => $request->cluster,
            'city' => $request->city,
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
            'redeem_outlet' => 'required',
            'ds_redeem' => 'required',
        ]);

        $report = DB::table('byu_report')->insert([
            'cluster' => $request->cluster,
            'city' => $request->city,
            'injected' => $request->injected,
            'redeem_outlet' => $request->redeem_outlet,
            'ds_redeem' => $request->ds_redeem,
            'created_at' => date('Y-m-d'),
        ]);

        return redirect()->route('byu.index');
    }

    public function view_stok(Request $request)
    {
        $privilege = auth()->user()->privilege;
        $branch = auth()->user()->branch;
        $cluster = auth()->user()->cluster;

        if ($request->start_date && $request->end_date) {

            if ($privilege == 'branch') {
                $stok = DB::select("SELECT * FROM byu_stok a JOIN territory_new b on a.`cluster`=b.`cluster` WHERE branch='$branch' AND date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc, cluster,city;");
            } else if ($privilege == 'cluster') {
                $stok = DB::select("SELECT * FROM byu_stok a WHERE cluster='$cluster' AND date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc, cluster,city;");
            } else {
                $stok = DB::select("SELECT * FROM byu_stok a WHERE date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc, cluster,city;");
            }
        } else {
            $stok = [];
        }

        return view('byu.stok.view', compact('stok'));
    }

    public function view_report(Request $request)
    {
        $privilege = auth()->user()->privilege;
        $branch = auth()->user()->branch;
        $cluster = auth()->user()->cluster;

        if ($request->start_date && $request->end_date) {

            if ($privilege == 'branch') {
                $report = DB::select("SELECT * FROM byu_report a JOIN territory_new b on a.`cluster`=b.`cluster` WHERE branch='$branch' AND created_at BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY created_at desc, cluster,city;");
            } else if ($privilege == 'cluster') {
                $report = DB::select("SELECT * FROM byu_report a WHERE cluster='$cluster' AND created_at BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY created_at desc, cluster,city;");
            } else {
                $report = DB::select("SELECT * FROM byu_report a WHERE created_at BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY created_at desc, cluster,city;");
            }
        } else {
            $report = [];
        }

        return view('byu.report.view', compact('report'));
    }

    public function view_distribusi(Request $request)
    {
        $privilege = auth()->user()->privilege;
        $branch = auth()->user()->branch;
        $cluster = auth()->user()->cluster;

        if ($request->start_date && $request->end_date) {

            if ($privilege == 'branch') {
                $ds = DB::select("SELECT * FROM byu_distribusi a JOIN data_user b on a.`id_digipos`=b.`id_digipos` WHERE type='DS' AND b.branch='$branch' AND date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc;");
                $outlet = DB::select("SELECT * FROM byu_distribusi a JOIN outlet_preference_new b on a.`id_digipos`=b.`outlet_id` WHERE type='Outlet' AND b.branch='$branch' AND date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc;");
            } else if ($privilege == 'cluster') {
                $ds = DB::select("SELECT * FROM byu_distribusi a JOIN data_user b on a.`id_digipos`=b.`id_digipos` WHERE type='DS' AND b.cluster='$cluster' AND date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc;");
                $outlet = DB::select("SELECT * FROM byu_distribusi a JOIN outlet_preference_new b on a.`id_digipos`=b.`outlet_id` WHERE type='Outlet' AND b.cluster='$cluster' AND date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc;");
            } else {
                $ds = DB::select("SELECT * FROM byu_distribusi a JOIN data_user b on a.`id_digipos`=b.`id_digipos` WHERE type='DS' AND date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc;");
                $outlet = DB::select("SELECT * FROM byu_distribusi a JOIN outlet_preference_new b on a.`id_digipos`=b.`outlet_id` WHERE type='Outlet' AND date BETWEEN '$request->start_date' AND '$request->end_date' ORDER BY date desc;");
            }
        } else {
            $ds = [];
            $outlet = [];
        }


        return view('byu.distribusi.view', compact('ds', 'outlet'));
    }


    public function get_outlet(Request $request)
    {
        $outlet = DB::table('outlet_preference_new')->where('kabupaten', $request->city)->where('fisik', 'FISIK')->orderBy('nama_outlet')->get();

        return response()->json($outlet);
    }
}
