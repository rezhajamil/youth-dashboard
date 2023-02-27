<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Rules\TelkomselNumber;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->privilege == "superadmin") {
            $users = DataUser::join('user_type', 'data_user.role', '=', 'user_type.user_type')->where('user_type.status', 1)->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('nama')->get();
        } else if (Auth::user()->privilege == "branch") {
            $users = DataUser::join('user_type', 'data_user.role', '=', 'user_type.user_type')->where('branch', Auth::user()->branch)->where('user_type.status', 1)->where('user_type.status', 1)->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('nama')->get();
        } else {
            $users = DataUser::join('user_type', 'data_user.role', '=', 'user_type.user_type')->where('cluster', Auth::user()->cluster)->where('user_type.status', 1)->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('nama')->get();
        }

        // ddd(DataUser::whereRaw("branch='?' and role=? or role=? or role=? or role=? ", array(Auth::user()->branch, 'EO', 'AO', 'MOGI', 'YBA')));
        return view('directUser.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->privilege == "superadmin") {
            $region = DB::table('wilayah')->select('regional')->distinct()->whereNotNull('regional')->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->orderBy('cluster')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->orderBy('nama')->get();
        } else if (Auth::user()->privilege == "branch") {
            $region = DB::table('wilayah')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', Auth::user()->branch)->orderBy('cluster')->get();
            $tap = [];
        } else {
            $region = DB::table('wilayah')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('cluster', Auth::user()->cluster)->orderBy('cluster')->get();
            $tap = [];
        }

        $role = DB::table('user_type')->where('status', '1')->get();

        return view('directUser.create', compact('region', 'branch', 'cluster', 'tap', 'role'));
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
            'regional' => 'required',
            'branch' => 'required',
            'cluster' => 'required',
            'tap' => 'required',
            'role' => 'required',
            'nama' => 'required',
            'panggilan' => 'required',
            'kampus' => 'required',
            'tgl_lahir' => 'required',
            'telp' => ['required', new TelkomselNumber],
            'mkios' => 'required',
            'id_digipos' => 'required',
            'user_calista' => 'required',
            'password' => 'required',
            'reff_byu' => 'required',
            'reff_code' => 'required',
        ]);

        if (in_array($request->role, ['AO', 'EO'])) {
            $request->validate([
                'id_digipos' => 'unique:data_user,id_digipos'
            ]);
        }

        $data = [
            'area' => 'AREA1',
            'posisi' => '',
            'status' => '1',
            'regional' => $request->regional,
            'branch' => $request->branch,
            'cluster' => $request->cluster,
            'tap' => $request->tap,
            'role' => $request->role,
            'nama' => $request->nama,
            'panggilan' => $request->panggilan,
            'kampus' => $request->kampus,
            'tgl_lahir' => $request->tgl_lahir,
            'telp' => $request->telp,
            'mkios' => $request->mkios,
            'id_digipos' => $request->id_digipos,
            'user_calista' => $request->user_calista,
            'password' => $request->password,
            'reff_byu' => $request->reff_byu,
            'reff_code' => $request->reff_code,
        ];

        DataUser::insert($data);

        return redirect()->route('direct_user.index')->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = DataUser::find($id);

        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $quiz = DB::select("SELECT * FROM quiz_session a LEFT JOIN quiz_answer b ON a.id=b.session JOIN data_user c ON b.telp=c.telp WHERE MONTH(a.date)=$month AND YEAR(a.date)=$year AND c.telp='$user->telp';");

        $getPeriod = new DatePeriod(
            new DateTime($year . '-' . $month . '-01'),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime(date("Y-m-t", strtotime($year . '-' . $month . '-01')) . ' +1 day')))
        );

        $period = [];
        foreach ($getPeriod as $key => $value) {
            array_push($period, $value->format('d-M-Y'));
        }

        $query = "SELECT * FROM absen_ao WHERE telp='" . $user->telp . "' order by date;";
        $absensi = DB::select($query);

        return view('directUser.show', compact('month', 'year', 'user', 'quiz', 'period', 'absensi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DataUser::find($id);

        if (Auth::user()->privilege == "superadmin") {
            $region = DB::table('wilayah')->select('regional')->distinct()->whereNotNull('regional')->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->orderBy('cluster')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $user->cluster)->orderBy('nama')->get();
        } else if (Auth::user()->privilege == "branch") {
            $region = DB::table('wilayah')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', Auth::user()->branch)->orderBy('cluster')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $user->cluster)->orderBy('nama')->get();
        } else {
            $region = DB::table('wilayah')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('cluster', Auth::user()->cluster)->orderBy('cluster')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $user->cluster)->orderBy('nama')->get();
        }

        $role = DB::table('user_type')->where('status', '1')->get();
        return view('directUser.edit', compact('user', 'region', 'branch', 'cluster', 'tap', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Htp\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Respotnse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'regional' => 'required',
            'branch' => 'required',
            'cluster' => 'required',
            'tap' => 'required',
            'role' => 'required',
            'nama' => 'required',
            'panggilan' => 'required',
            'kampus' => 'required',
            'tgl_lahir' => 'required',
            'telp' => ['required', new TelkomselNumber],
            'mkios' => 'required',
            'link_aja' => 'required',
            'id_digipos' => 'required',
            'user_calista' => 'required',
            'password' => 'required',
            'reff_byu' => 'required',
            'reff_code' => 'required',
        ]);

        $user = DataUser::find($id);
        $user->timestamps = false;

        $user->regional = $request->regional;
        $user->branch = $request->branch;
        $user->cluster = $request->cluster;
        $user->tap = $request->tap;
        $user->role = $request->role;
        $user->nama = $request->nama;
        $user->panggilan = $request->panggilan;
        $user->kampus = $request->kampus;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->telp = $request->telp;
        $user->mkios = $request->mkios;
        $user->link_aja = $request->link_aja;
        $user->id_digipos = $request->id_digipos;
        $user->user_calista = $request->user_calista;
        $user->password = $request->password;
        $user->reff_byu = $request->reff_byu;
        $user->reff_code = $request->reff_code;

        $user->save();
        return redirect()->route('direct_user.index')->with('success');
    }

    public function absensi(Request $request)
    {
        if (Auth::user()->privilege == 'branch') {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->where('branch', Auth::user()->branch)->whereNotNull('cluster')->orderBy('cluster')->get();
        } else if (Auth::user()->privilege == 'cluster') {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->where('cluster', Auth::user()->cluster)->orderBy('cluster')->get();
        } else {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->orderBy('cluster')->get();
        }

        if ($request->month && $request->year) {
            $month = $request->month;
            $year = $request->year;
        } else {
            $month = date('n');
            $year = date('Y');
        }
        // ddd($month);

        $getPeriod = new DatePeriod(
            new DateTime($year . '-' . $month . '-01'),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime(date("Y-m-t", strtotime($year . '-' . $month . '-01')) . ' +1 day')))
        );
        $period = [];
        foreach ($getPeriod as $key => $value) {
            array_push($period, $value->format('d-M-Y'));
        }

        // $query = "SELECT cluster,absen_ao.nama,date,absen_ao.telp 
        //                 FROM absen_ao
        //                 JOIN data_user
        //                 on absen_ao.telp=data_user.telp
        //                 WHERE MONTH(date)=" . $month . " AND YEAR(date)=" . $year . " 
        //                 AND CLUSTER='" . $request->cluster . "'
        //                 and role='" . $request->role . "'
        //                 ORDER BY 2,3;";

        if (Auth::user()->privilege == 'superadmin') {
            if ($request->cluster && $request->role) {
                $absensi = DB::select("SELECT cluster,absen_ao.nama,date,absen_ao.telp,branch 
                        FROM absen_ao
                        JOIN data_user
                        on absen_ao.telp=data_user.telp
                        WHERE MONTH(date)=" . $month . " AND YEAR(date)=" . $year . " 
                        AND CLUSTER='" . $request->cluster . "'
                        and role='" . $request->role . "'
                        ORDER BY 2,3;");
            } else if ($request->role) {
                $absensi = DB::select("SELECT cluster,absen_ao.nama,date,absen_ao.telp,branch 
                        FROM absen_ao
                        JOIN data_user
                        on absen_ao.telp=data_user.telp
                        WHERE MONTH(date)=" . $month . " AND YEAR(date)=" . $year . "
                        and role='" . $request->role . "'
                        ORDER BY 2,3;");
            } else {
                $absensi = [];
            }
        } else {
            if ($request->cluster && $request->role) {
                $absensi = DB::select("SELECT cluster,absen_ao.nama,date,absen_ao.telp,branch 
                        FROM absen_ao
                        JOIN data_user
                        on absen_ao.telp=data_user.telp
                        WHERE MONTH(date)=" . $month . " AND YEAR(date)=" . $year . " 
                        AND CLUSTER='" . $request->cluster . "'
                        and role='" . $request->role . "'
                        ORDER BY 2,3;");
            } else {
                $absensi = [];
            }
        }
        $role = DB::table('user_type')->where('status', '1')->get();
        // ddd($role);
        return view('directUser.absensi.index', compact('absensi', 'period', 'cluster', 'year', 'month', 'role'));
    }

    public function show_absensi($telp, Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $getPeriod = new DatePeriod(
            new DateTime($year . '-' . $month . '-01'),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime(date("Y-m-t", strtotime($year . '-' . $month . '-01')) . ' +1 day')))
        );
        $period = [];
        foreach ($getPeriod as $key => $value) {
            array_push($period, $value->format('d-M-Y'));
        }

        $query = "SELECT * FROM absen_ao WHERE telp='" . $telp . "' order by date;";
        $absensi = DB::select($query);

        return view('directUser.absensi.show', compact('absensi', 'period'));
    }

    public function clock_in(Request $request)
    {
        $cluster = $request->cluster;
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        if (auth()->user()->privilege == 'superadmin') {
            $list_cluster = DB::table('territory_new')->select('cluster')->distinct()->get();
        } else if (auth()->user()->privilege == 'branch') {
            $list_cluster = DB::table('territory_new')->select('cluster')->where('branch', auth()->user()->branch)->distinct()->get();
        } else if (auth()->user()->privilege == 'cluster') {
            $list_cluster = DB::table('territory_new')->select('cluster')->where('cluster', auth()->user()->cluster)->distinct()->get();
        }

        if ($cluster) {
            $clocks = DB::select(
                "SELECT * FROM table_kunjungan a JOIN data_user b ON a.telp=b.telp WHERE b.cluster='$cluster' AND MONTH(a.date)=$month AND YEAR(a.date)=$year ORDER BY b.nama,a.date"
            );
        } else {
            $clocks = [];
        }

        return view('directUser.clockIn.index', compact('cluster', 'month', 'year', 'list_cluster', 'clocks'));
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

    public function changeStatus($id)
    {
        $user = DataUser::find($id);

        if ($user->status) {
            $user->status = '0';
        } else {
            $user->status = '1';
        }

        $user->timestamps = false;
        $user->save();

        return back()->with('success');
    }
}
