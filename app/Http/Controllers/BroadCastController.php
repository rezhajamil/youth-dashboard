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
        $update_broadcast = DB::select('select max(date) as last_update from new_after_broadcast;');
        $m1 = date('Y-m-01', strtotime($request->date));
        $mtd = date('Y-m-d', strtotime($request->date));
        $last_m1 = date('Y-m-01', strtotime('-1 month', strtotime($request->date)));
        $last_mtd = $this->convDate($mtd);
        $program = $request->program;
        $dataProgram = DB::table('new_after_broadcast')->select('program')->distinct()->get();
        $branch_broadcast = Auth::user()->privilege == "branch" ? "and data_user.branch='" . Auth::user()->branch . "'" : '';
        $branch_program = Auth::user()->privilege == "branch" ? "data_user.branch ='" . Auth::user()->branch . "' AND" : '';
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
            " . $branch_broadcast . "
            AND `new_after_broadcast`.date BETWEEN '" . $m1 . "' AND '" . $mtd . "'
            GROUP BY  1,2,3
            ORDER BY `data_user`.cluster,`data_user`.role,`data_user`.nama  ;");

        $program_list = DB::select("SELECT 
            new_after_broadcast.`program`,
            COUNT(`new_after_broadcast`.msisdn) As 'total', 
            COUNT(IF(`new_after_broadcast`.send='Terkirim',1,Null))AS 'sent', 
            COUNT(IF(`new_after_broadcast`.send='Tidak Terkirim',1,Null))AS 'not_sent',
            COUNT(IF(`new_after_broadcast`.send='Bukan Nomor Wa',1,Null))AS 'not_wa',
            COUNT(IF(`new_after_broadcast`.baca='Dibaca',1,Null))AS 'read',
            COUNT(IF(`new_after_broadcast`.baca='Tidak dibaca',1,Null))AS 'not_read',
            COUNT(IF(`new_after_broadcast`.respon='Dibalas',1,Null))AS 'reply',
            COUNT(IF(`new_after_broadcast`.respon='Tidak dibalas',1,Null))AS 'not_reply'
                                    
            FROM `new_after_broadcast` JOIN `data_user` ON `data_user`.telp = `new_after_broadcast`.telp
            WHERE 
            " . $branch_program . "
            `new_after_broadcast`.date BETWEEN '" . $m1 . "' AND '" . $mtd . "'
            GROUP BY  1
            ORDER BY 1  ;");

        return view('broadcast.index', compact('dataProgram', 'broadcast', 'update_broadcast', 'program_list'));
    }

    public function campaign()
    {
        $branch_campaign = Auth::user()->privilege == "branch" ? "Where new_list_campain.branch ='" . Auth::user()->branch . "'" : '';

        $campaign = DB::select("SELECT
                    new_list_campain.id,
                    new_list_campain.date,
                    new_list_campain.branch,
                    new_list_campain.program, 
                    new_list_wording.campain, 
                    new_list_campain.status,
                    new_list_campain.posisi

					FROM `new_list_campain` 
					JOIN `new_list_wording` 
                    ON new_list_wording.id=new_list_campain.id
					" . $branch_campaign . "
					ORDER by new_list_campain.branch, new_list_campain.date DESC");

        return view('broadcast.campaign.index', compact('campaign'));
    }

    public function create_campaign()
    {
        $data_program = DB::table('new_after_broadcast')->select('program')->distinct()->get();
        $user_type = DB::table('user_type')->select('user_type')->distinct()->where('status', '1')->orderBy('user_type')->get();
        return view('broadcast.campaign.create', compact('user_type', 'data_program'));
    }

    public function store_campaign(Request $request)
    {
        $id = DB::select("SELECT `id` FROM `new_list_campain` order by id DESC LIMIT 1");
        $id = $id[0]->id;
        $request->validate([
            'role' => 'required',
            'program' => 'required',
            'keterangan' => 'required',
        ]);

        $campain = DB::table('new_list_campain')->insert([
            'id' => $id + 1,
            'program' => $request->program,
            'posisi' => $request->role,
            'date' => date("Y-m-d"),
            'branch' => Auth::user()->branch,
            'regional' => Auth::user()->regional,
            'status' => '1',
        ]);

        $wording = DB::table('new_list_wording')->insert([
            'id' => $id + 1,
            'program' => $request->program,
            'campain' => $request->keterangan,
            'posisi' => $request->role,
            'branch' => Auth::user()->branch,
        ]);

        return redirect()->route('campaign.index');
    }

    public function destroy_campaign($id)
    {
        $query = "DELETE a.*, b.* FROM new_list_campain a JOIN new_list_wording b ON a.id = b.id WHERE a.id = '$id'";

        $campaign = DB::delete($query);

        return back();
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
