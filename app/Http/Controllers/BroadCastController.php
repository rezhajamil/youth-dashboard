<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
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
        $dataProgram = DB::table('new_list_program')->select('program')->distinct()->get();
        $branch_broadcast = Auth::user()->privilege == "branch" ? "and data_user.branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "and data_user.cluster='" . Auth::user()->cluster . "'" : '');
        $branch_program = Auth::user()->privilege == "branch" ? "data_user.branch ='" . Auth::user()->branch . "' AND" : (Auth::user()->privilege == "branch" ? "data_user.branch ='" . Auth::user()->branch . "' AND" : '');
        $branch_broadcast_cluster = Auth::user()->privilege == "branch" ? "WHERE d.branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "WHERE d.branch='" . Auth::user()->cluster . "'" : '');

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

        // $broadcast_branch = DB::select(
        //     "SELECT 
        //     d.branch,c.*
        //     FROM 
        //     (SELECT b.cluster,
        //     COUNT(a.msisdn) As 'total', 
        //     COUNT(IF(a.send='Terkirim',1,Null))AS 'sent', 
        //     COUNT(IF(a.send='Tidak Terkirim',1,Null))AS 'not_sent',
        //     COUNT(IF(a.send='Bukan Nomor Wa',1,Null))AS 'not_wa',
        //     COUNT(IF(a.baca='Dibaca',1,Null))AS 'read',
        //     COUNT(IF(a.baca='Tidak dibaca',1,Null))AS 'not_read',
        //     COUNT(IF(a.respon='Dibalas',1,Null))AS 'reply',
        //     COUNT(IF(a.respon='Tidak dibalas',1,Null))AS 'not_reply',
        //     COUNT(IF(b.usim='Y',1,Null))AS 'usim'
        //     FROM new_after_broadcast a
        //     LEFT JOIN Taker_Non_Usim_20221124 b ON a.msisdn=b.msisdn

        //     WHERE a.program='$program'  
        //     AND a.date BETWEEN '$m1' AND '$mtd'

        //     GROUP BY 1
        //     ORDER BY 1) c

        //     JOIN territory_new d ON c.cluster=d.cluster
        //     GROUP BY  1
        //     ORDER BY 1;"
        // );

        // $broadcast_cluster = DB::select(
        //     "SELECT 
        //     d.branch,d.cluster,c.*
        //     FROM 
        //     (SELECT b.cluster,
        //     COUNT(a.msisdn) As 'total', 
        //     COUNT(IF(a.send='Terkirim',1,Null))AS 'sent', 
        //     COUNT(IF(a.send='Tidak Terkirim',1,Null))AS 'not_sent',
        //     COUNT(IF(a.send='Bukan Nomor Wa',1,Null))AS 'not_wa',
        //     COUNT(IF(a.baca='Dibaca',1,Null))AS 'read',
        //     COUNT(IF(a.baca='Tidak dibaca',1,Null))AS 'not_read',
        //     COUNT(IF(a.respon='Dibalas',1,Null))AS 'reply',
        //     COUNT(IF(a.respon='Tidak dibalas',1,Null))AS 'not_reply',
        //     COUNT(IF(b.usim='Y',1,Null))AS 'usim'
        //     FROM new_after_broadcast a
        //     LEFT JOIN Taker_Non_Usim_20221124 b ON a.msisdn=b.msisdn

        //     WHERE a.program='$program'  
        //     AND a.date BETWEEN '$m1' AND '$mtd'

        //     GROUP BY 1
        //     ORDER BY 1) c

        //     JOIN territory_new d ON c.cluster=d.cluster
        //     $branch_broadcast_cluster
        //     GROUP BY 1,2
        //     ORDER BY 1,2;"
        // );

        $broadcast_cluster = DB::select(
            "SELECT 
            d.branch,d.cluster,c.*
            FROM 
            (SELECT b.cluster,
            COUNT(a.msisdn) As 'total', 
            COUNT(IF(a.send='Terkirim',1,Null))AS 'sent', 
            COUNT(IF(a.send='Tidak Terkirim',1,Null))AS 'not_sent',
            COUNT(IF(a.send='Bukan Nomor Wa',1,Null))AS 'not_wa',
            COUNT(IF(a.baca='Dibaca',1,Null))AS 'read',
            COUNT(IF(a.baca='Tidak dibaca',1,Null))AS 'not_read',
            COUNT(IF(a.respon='Dibalas',1,Null))AS 'reply',
            COUNT(IF(a.respon='Tidak dibalas',1,Null))AS 'not_reply'
            -- COUNT(IF(b.usim='Y',1,Null))AS 'usim'
            FROM new_after_broadcast a
            JOIN data_user b ON a.telp=b.telp

            WHERE a.program='$program'  
            AND a.date BETWEEN '$m1' AND '$mtd'

            GROUP BY 1
            ORDER BY 1) c

            JOIN territory_new d ON c.cluster=d.cluster
            $branch_broadcast_cluster
            GROUP BY 1,2
            ORDER BY 1,2;"
        );

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

        return view('broadcast.index', compact('dataProgram', 'broadcast', 'broadcast_cluster', 'update_broadcast', 'program_list'));
    }

    public function broadcast_call(Request $request)
    {
        $program = $request->program;
        $dataProgram = DB::table('new_list_program')->select('program')->distinct()->get();
        $call = DB::select("SELECT 
            d.branch,d.cluster,c.*
            FROM 
            (SELECT b.cluster,
            COUNT(a.msisdn) As 'total', 
            COUNT(IF(a.connect='Connected',1,Null))AS 'connect', 
            COUNT(IF(a.connect='Not Connected',1,Null))AS 'not_connect',
            COUNT(IF(a.angkat='Diangkat',1,Null))AS 'angkat',
            COUNT(IF(a.angkat='Tidak Diangkat',1,Null))AS 'not_angkat',
            COUNT(IF(a.respon='ditutup',1,Null))AS 'res_ditutup',
            COUNT(IF(a.respon='mengira penipuan',1,Null))AS 'res_penipuan',
            COUNT(IF(a.respon='Setuju ganti Kartu',1,Null))AS 'res_setuju',
            COUNT(IF(a.respon='tidak mau ganti',1,Null))AS 'res_tolak'
            FROM new_after_call a
            LEFT JOIN data_user b ON a.telp=b.telp

            WHERE a.program='$program'  
            -- AND a.date BETWEEN '2022-11-01' AND '2022-12-21'

            GROUP BY 1
            ORDER BY 1) c

            JOIN territory_new d ON c.cluster=d.cluster
            GROUP BY 1,2
            ORDER BY 1,2;");

        return view('broadcast.call', compact('call', 'dataProgram'));
    }

    public function campaign()
    {
        $branch_campaign = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "Where new_list_campain.branch ='" . Auth::user()->branch . "'" : '';

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
        $branch = Auth::user()->privilege == 'branch' ? "and branch='ALL' OR branch='" . Auth::user()->branch . "'" : '';
        $data_program =
            DB::select("select program from new_list_program where status='1'
            " . $branch . "
        ");
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

    public function whitelist(Request $request)
    {
        $program = $request->program;
        $program_call = $request->program_call;
        $dataProgram = DB::table('new_list_program')->select('program')->distinct()->get();
        $dataProgramCall = DB::table('new_list_program_call')->select('program')->distinct()->get();
        $branch = Auth::user()->privilege == "branch" ? "AND b.branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "AND b.cluster='" . Auth::user()->cluster . "'" : '');

        $whitelist = DB::select("SELECT 
                    new_data_campaign.telp, b.nama,b.branch,b.cluster,
                    count(`new_data_campaign`.msisdn) as 'wl',
                    count(if(`new_data_campaign`.telp!='no',1,NULL)) as 'diambil',
                    count(if(`new_data_campaign`.status='1',1,NULL)) as 'sudah' ,
                    count(if(`new_data_campaign`.status='0',1,NULL)) as 'belum',
                    count(if(`new_data_campaign`.telp='no',1,NULL)) as 'sisa'
                    
                    FROM `new_data_campaign`
                    JOIN data_user b ON b.telp=new_data_campaign.telp
                    
                    Where new_data_campaign.program='$program' 
					" . $branch . "
                    GROUP by 1,2,3,4
                    order by 3,4,2");

        $whitelist_call = DB::select("SELECT 
                    
                    new_data_campaign.telp, b.nama,b.branch,b.cluster,
                    count(`new_data_campaign`.msisdn) as 'wl',
                    count(if(`new_data_campaign`.telp!='no',1,NULL)) as 'diambil',
                    count(if(`new_data_campaign`.call='1',1,NULL)) as 'sudah' ,
                    count(if(`new_data_campaign`.call='0',1,NULL)) as 'belum',
                    count(if(`new_data_campaign`.telp='no',1,NULL)) as 'sisa'
                   
                    FROM `new_data_campaign`
                    JOIN data_user b ON b.telp=new_data_campaign.telp
                    
                    Where new_data_campaign.program='$program_call' 
					" . $branch . "
                    GROUP by 1,2,3,4
                    order by 3,4,2");


        $whitelist_branch = DB::select("SELECT 
                    b.branch,
                    count(`a`.msisdn) as 'wl',
                    count(if(`a`.telp!='no',1,NULL)) as 'diambil',
                    count(if(`a`.telp='no',1,NULL)) as 'sisa',
                    count(case when a.telp!='no' AND a.status ='1' then a.msisdn end) as 'sudah' ,
                    count(case when a.telp!='no' AND a.status ='0' then a.msisdn end) as 'belum'

                    FROM `new_data_campaign` a
                    JOIN territory_new b ON b.cluster=a.cluster

                    Where a.program='$program' 
                    GROUP BY 1
                    order BY 1;");

        $whitelist_cluster = DB::select("SELECT 
                    b.branch,b.cluster,
                    count(`a`.msisdn) as 'wl',
                    count(if(`a`.telp!='no',1,NULL)) as 'diambil',
                    count(if(`a`.telp='no',1,NULL)) as 'sisa',
                    count(case when a.telp!='no' AND a.status ='1' then a.msisdn end) as 'sudah' ,
                    count(case when a.telp!='no' AND a.status ='0' then a.msisdn end) as 'belum'

                    FROM `new_data_campaign` a
                    JOIN territory_new b ON b.cluster=a.cluster

                    Where a.program='$program' 
                    " . $branch . "
                    GROUP BY 1,2
                    order BY 1,2;");

        $whitelist_branch_call = DB::select("SELECT 
                    b.branch,b.cluster,
                    count(`new_data_campaign`.msisdn) as 'wl',
                    count(if(`new_data_campaign`.telp!='no',1,NULL)) as 'diambil',
                    count(if(`new_data_campaign`.call='1',1,NULL)) as 'sudah' ,
                    count(if(`new_data_campaign`.call='0',1,NULL)) as 'belum',
                    count(if(`new_data_campaign`.telp='no',1,NULL)) as 'sisa'
                   
                    FROM `new_data_campaign`
                    JOIN data_user b ON b.telp=new_data_campaign.telp
                    
                    Where new_data_campaign.program='$program_call' 
					" . $branch . "
                    GROUP by 1,2
                    order by 1,2");

        return view('broadcast.whitelist.index', compact('whitelist', 'whitelist_cluster', 'whitelist_branch', 'whitelist_call', 'whitelist_branch_call', 'dataProgram', 'dataProgramCall'));
    }

    public function release_whitelist(Request $request, $telp)
    {
        $program = $request->program;
        $whitelist = DB::table('new_data_campaign')->where('telp', $telp)->where('program', $program)->where('status', '0')->update(
            [
                'telp' => 'no'
            ]
        );

        return back();
    }

    public function create_whitelist()
    {
        $branch = Auth::user()->privilege == 'branch' ? "and branch='ALL' OR branch='" . Auth::user()->branch . "'" : '';
        if (Auth::user()->privilege == "superadmin") {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->get();
        } else {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', Auth::user()->branch)->get();
        }
        $dataProgram = DB::select("select distinct program from new_list_program where status='1'");
        // $dataProgramCall = DB::select("select program from new_list_program_call where status='1'" . $branch . "");

        // ddd("select program from new_list_program where status='1'
        //     " . $branch . "
        // ");
        // ddd(Auth::user()->privilege);
        return view('broadcast.whitelist.create', compact('cluster', 'dataProgram'));
    }

    public function store_whitelist(Request $request)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        $request->validate([
            'cluster' => 'required',
            'program' => 'required',
            'file' => 'required|mimes:csv,txt'
        ]);

        $count = DB::table('new_data_campaign')->where('telp', 'no')->where('cluster', $request->cluster)->where('program', $request->program)->count();
        if ($count >= 200) {
            return back()->with('error', 'Tidak bisa upload. Whitelist anda masih ada.');
        }

        if ($request->hasFile('file')) {
            if (file_exists($request->file)) {
                $file = fopen($request->file, "r");

                $idx = 0;

                $get_row = fgetcsv($file, 10000, ";");

                if (count($get_row) <= 1) {
                    $a = str_split($get_row[0]);
                    return back()->with('error', "Format CSV salah. Format adalah 'msisdn;site_id' bukan 'msisdn" . $a[9] . "site_id'");
                }

                while (($row = fgetcsv($file, 10000, ";")) !== FALSE) {

                    $data = [
                        'cluster' => $request->cluster,
                        'msisdn' => $row[0],
                        'site_id' => $row[1],
                        'telp' => 'no',
                        'status' => '0',
                        'call' => '0',
                        'program' => $request->program
                    ];

                    if ($idx > 0 && $idx < 501) {
                        // echo '<pre>' . $idx . var_export($data, true) . '</pre>';
                        DB::table('new_data_campaign')->insert($data);
                    } else if ($idx > 501) {
                        break;
                    }
                    $idx++;
                }
            }
        }

        return redirect()->route('whitelist.index');
    }

    public function create_whitelist_distribusi()
    {
        $branch = Auth::user()->privilege == 'branch' ? "and branch='ALL' OR branch='" . Auth::user()->branch . "'" : '';
        if (Auth::user()->privilege == "superadmin") {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->orderBy('cluster')->get();
        } else {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', Auth::user()->branch)->orderBy('cluster')->get();
        }
        $dataProgram = DB::select("select distinct program from new_list_program where status='1' $branch");
        $dataRole = DB::select("select distinct user_type as role from user_type where status='1'");
        return view('broadcast.whitelist.distribusi.create', compact('cluster', 'dataProgram', 'dataRole'));
    }

    public function get_user_distribusi(Request $request)
    {
        $cluster = $request->cluster;
        $role = $request->role;
        $program = $request->program;

        $users = DataUser::where('cluster', $cluster)->where('role', $role)->orderBy('nama')->get();
        $site_id = DB::select("select site_id,count(case when telp='no' then site_id end) jumlah from new_data_campaign where cluster='$cluster' and program='$program' group by 1 order by 1;");

        return response()->json(compact('users', 'site_id'));
    }

    public function store_whitelist_distribusi(Request $request)
    {
        $request->validate([
            'cluster' => 'required',
            'program' => 'required',
            'site' => 'required',
            'role' => 'required',
            'user' => 'required',
            'jumlah' => 'required',
        ]);

        $count = DB::table('new_data_campaign')->where('telp', $request->user)->where('status', '0')->count();

        if ($count > 5) {
            return back()->with('error', 'Mohon maaf, user ini masih memiliki jumlah whitelist diatas 5');
        }

        DB::table('new_data_campaign')->where('cluster', $request->cluster)->where('program', $request->program)->where('telp', 'no')->where('site_id', $request->site)->limit($request->jumlah)->update([
            'telp' => $request->user
        ]);

        return redirect()->route('whitelist.index');
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
