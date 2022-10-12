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
        $branch = Auth::user()->privilege == "branch" ? "and branch='" . Auth::user()->branch . "'" : '';
        $dataUsersCluster = DB::select(
            "select cluster,
            count(if(role='AO',1,NULL)) as 'ao',
            count(if(role='EO',1,NULL)) as 'eo',
            count(if(role='MOGI',1,NULL)) as 'mogi',
            count(if(role='YBA',1,NULL)) as 'yba',
            count(role) as 'jumlah'
            from data_user
            where not role='' 
            " . $branch . "
            and status='1'
            GROUP by 1
            Order by cluster DESC
            ",
            [1]
        );

        $dataUsersBranch = DB::select(
            "select regional,branch,
            count(if(role='AO',1,NULL)) as 'ao',
            count(if(role='EO',1,NULL)) as 'eo',
            count(if(role='MOGI',1,NULL)) as 'mogi',
            count(if(role='YBA',1,NULL)) as 'yba',
            count(role) as 'jumlah'
            from data_user
            where not role='' 
            " . $branch . "
            and status='1'
            GROUP by 1,2
            Order by regional,branch
            ",
            [1]
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
