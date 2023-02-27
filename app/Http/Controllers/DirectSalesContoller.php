<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectSalesContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branch = Auth::user()->privilege == "branch" ? "and branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == 'cluster' ? "and cluster='" . Auth::user()->cluster . "'" : '');
        $dataUsersCluster = DB::select(
            "select cluster,
            count(if(role='AO',1,NULL)) as 'ao',
            count(if(role='EO',1,NULL)) as 'eo',
            count(if(role='YBA',1,NULL)) as 'yba',
            count(if(role='PROMOTOR',1,NULL)) as 'promotor',
            count(if(role='ORBIT',1,NULL)) as 'orbit',
            count(if(role='BUDDIES',1,NULL)) as 'buddies',
            count(role) as 'jumlah'
            from data_user
            where not role='' AND NOT role='TYES' AND NOT role='Pilih Type User' AND NOT role='ORBIT'
            " . $branch . "
            and status='1'
            GROUP by 1
            Order by cluster DESC
            "
        );

        $dataUsersBranch = DB::select(
            "select regional,branch,
            count(if(role='AO',1,NULL)) as 'ao',
            count(if(role='EO',1,NULL)) as 'eo',
            count(if(role='YBA',1,NULL)) as 'yba',
            count(if(role='PROMOTOR',1,NULL)) as 'promotor',
            count(if(role='ORBIT',1,NULL)) as 'orbit',
            count(if(role='BUDDIES',1,NULL)) as 'buddies',
            count(role) as 'jumlah'
            from data_user
            where not role='' AND NOT role='TYES' AND NOT role='Pilih Type User' AND NOT role='ORBIT'
            " . $branch . "
            and status='1'
            GROUP by 1,2
            Order by regional,branch
            "
        );

        // ddd($dataUsers);
        return view('directSales.index', compact('dataUsersCluster', 'dataUsersBranch'));
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
