<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BroadCastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $m1 = date('Y-m-01', strtotime($request->date));
        $mtd = date('Y-m-d', strtotime($request->date));
        $last_m1 = date('Y-m-01', strtotime('-1 month', strtotime($request->date)));
        $last_mtd = $this->convDate($mtd);
        $program = $request->program;
        $dataProgram = DB::table('new_after_broadcast')->select('program')->distinct()->get();
        $branch = Auth::user()->privilege == "branch" ? "and data_user.branch='" . Auth::user()->branch . "'" : '';
        $broadcast = DB::select("SELECT 
            `data_user`.nama, `data_user`.cluster, `data_user`.role,
            COUNT(`new_after_broadcast`.msisdn) As 'total', 
            COUNT(IF(`new_after_broadcast`.send='Terkirim',1,Null))AS 'sent', 
            COUNT(IF(`new_after_broadcast`.send='Tidak Terkirim',1,Null))AS 'not_sent',
            COUNT(IF(`new_after_broadcast`.send='Bukan Nomor Wa',1,Null))AS 'not_wa',
            COUNT(IF(`new_after_broadcast`.baca='Dibaca',1,Null))AS 'read',
            COUNT(IF(`new_after_broadcast`.baca='Tidak dibaca',1,Null))AS 'not_read',
            COUNT(IF(`new_after_broadcast`.respon='Dibalas',1,Null))AS 'reply',
            COUNT(IF(`new_after_broadcast`.respon='Tidak dibalas',1,Null))AS 'not_reply'
                                    
            FROM `new_after_broadcast` JOIN `data_user` ON `data_user`.telp = `new_after_broadcast`.telp
            WHERE `new_after_broadcast`.program='" . $program . "'  
            " . $branch . "
            AND `new_after_broadcast`.date BETWEEN '" . $m1 . "' AND '" . $mtd . "'
            GROUP BY  `data_user`.nama, `data_user`.cluster, `data_user`.role
            ORDER BY `data_user`.cluster,`data_user`.role,`data_user`.nama  ;");

        return view('broadcast.index', compact('dataProgram', 'broadcast'));
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

    public function convDate($tanggal)
    {
        $now = date("Y-m-d", strtotime($tanggal));
        $hari = date("d", strtotime($now));
        $last = date("Y-m-t", strtotime($now));

        if ($last == $tanggal) {
            return date(
                "Y-m-d",
                strtotime($tanggal . "last day of previous month")
            );
        } else {
            if ($hari > 28 && date("m", strtotime($now)) == 3) {
                return date(
                    "Y-m-d",
                    strtotime($tanggal . "last day of previous month")
                );
            } else {
                return date("Y-m-d", strtotime($now . "-1 Months"));
            }
        }
    }
}
