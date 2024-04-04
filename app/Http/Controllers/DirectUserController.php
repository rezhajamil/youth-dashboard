<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Rules\TelkomselNumber;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            $users = DataUser::select('data_user.*')->join('user_type', 'data_user.role', '=', 'user_type.user_type')->where('user_type.status', 1)->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('nama')->get();
        } else if (Auth::user()->privilege == "branch") {
            $users = DataUser::select('data_user.*')->join('user_type', 'data_user.role', '=', 'user_type.user_type')->where('branch', Auth::user()->branch)->where('user_type.status', 1)->where('user_type.status', 1)->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('nama')->get();
        } else {
            $users = DataUser::select('data_user.*')->join('user_type', 'data_user.role', '=', 'user_type.user_type')->where('cluster', Auth::user()->cluster)->where('user_type.status', 1)->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('nama')->get();
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
            $region = DB::table('territory_new')->select('regional')->distinct()->whereNotNull('regional')->get();
            $branch = DB::table('territory_new')->select('branch')->distinct()->whereNotNull('branch')->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->orderBy('cluster')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->orderBy('nama')->get();
        } else if (Auth::user()->privilege == "branch") {
            $region = DB::table('territory_new')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('territory_new')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', Auth::user()->branch)->orderBy('cluster')->get();
            $tap = [];
        } else {
            $region = DB::table('territory_new')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('territory_new')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
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
            'city' => 'required',
            'kecamatan' => 'required',
            'tap' => 'required',
            'role' => 'required',
            'nama' => 'required',
            'panggilan' => 'required',
            'kampus' => 'required',
            'tgl_lahir' => 'required',
            'telp' => ['required', 'unique:data_user,telp', new TelkomselNumber],
            'mkios' => 'required',
            'id_digipos' => 'required',
            'user_calista' => 'required',
            'password' => 'required',
            'reff_byu' => 'required',
            'reff_code' => 'required',
        ]);

        if (in_array($request->role, ['AO', 'EO'])) {
            $request->validate([
                'id_digipos' => [Rule::unique('data_user', 'id_digipos')->where(fn (QueryBuilder $query) => $query->where('status', 1))]
            ]);
        }

        $data = [
            'area' => 'AREA1',
            'posisi' => '',
            'status' => '1',
            'regional' => $request->regional,
            'branch' => $request->branch,
            'cluster' => $request->cluster,
            'city' => $request->city,
            'kecamatan' => $request->kecamatan,
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
        ini_set("max_execution_time", "0");
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

        $target = DB::table('target_ds')->where('status', 1)->get();

        $list_target = [];
        $sales = 0;
        $proses = 0;

        foreach ($target as $data) {
            $item_kpi = $data->item_kpi;
            $target_value = $data->unit == 'rupiah'
                ? number_format($data->target, 0, ",", ".")
                : $data->target;

            $list_target[$item_kpi] = [
                'target' => $target_value,
                'bobot' => $data->bobot,
                'unit' => $data->unit
            ];

            if ($data->kategori == 'sales') {
                $sales += $data->bobot;
            } elseif ($data->kategori == 'proses') {
                $proses += $data->bobot;
            }
        }

        $mtd = date('Y-m-d');
        $m1 = date('Y-m-01', strtotime($mtd));
        // $kpi = DB::select(" SELECT a.branch,a.cluster,a.nama,a.telp,a.id_digipos,a.`role`, g.mytsel,e.update_data,f.pjp,h.quiz,i.survey,j.broadband,k.digital
        //     FROM data_user a
        //     LEFT JOIN (SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp = g.telp
        //     LEFT JOIN (SELECT telp,COUNT(NPSN) update_data FROM Data_Sekolah_Sumatera WHERE UPDATED_AT BETWEEN '$m1' AND '$mtd' AND LONGITUDE!='' GROUP BY 1) e ON a.telp=e.telp
        //     LEFT JOIN (SELECT telp,COUNT(npsn) pjp FROM table_kunjungan_copy WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
        //     LEFT JOIN (SELECT telp,SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
        //     LEFT JOIN (SELECT Data_Sekolah_Sumatera.telp,COUNT(survey_answer.telp_siswa) survey FROM survey_answer JOIN Data_Sekolah_Sumatera ON survey_answer.npsn=Data_Sekolah_Sumatera.NPSN WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) i ON a.telp=i.telp
        //     LEFT JOIN (SELECT digipos_ao,SUM(price) broadband FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DATA' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
        //     LEFT JOIN (SELECT digipos_ao,SUM(price) digital FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL' GROUP BY 1) k ON a.id_digipos=k.digipos_ao
        //     WHERE a.telp='$user->telp' AND a.status=1");

        $kpi = DB::select("SELECT a.branch,a.cluster,a.nama,a.telp,a.id_digipos,a.`role`,b.byu,c.sales_byu, g.mytsel,e.update_data,f.pjp,h.quiz,i.survey,j.broadband,k.digital,
            (COALESCE(b.byu,0)+COALESCE(c.sales_byu,0)) as sales_acquisition
            FROM data_user a
            LEFT JOIN (SELECT id_digipos, SUM(revenue) byu FROM byu_sales_ds WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) b ON a.id_digipos = b.id_digipos
            LEFT JOIN (SELECT telp, COUNT(msisdn)*20000 sales_byu FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND (kategori='BYU' OR (kategori='TRADE IN' AND detail='By.U')) GROUP BY 1) c ON a.telp = c.telp
            LEFT JOIN (SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp = g.telp
            LEFT JOIN (SELECT telp,COUNT(NPSN) update_data FROM Data_Sekolah_Sumatera WHERE UPDATED_AT BETWEEN '$m1' AND '$mtd' AND LONGITUDE!='' GROUP BY 1) e ON a.telp=e.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) pjp FROM table_kunjungan_copy WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
            LEFT JOIN (SELECT telp,SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
            LEFT JOIN (SELECT Data_Sekolah_Sumatera.telp,COUNT(survey_answer.telp_siswa) survey FROM survey_answer JOIN Data_Sekolah_Sumatera ON survey_answer.npsn=Data_Sekolah_Sumatera.NPSN WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) i ON a.telp=i.telp
            LEFT JOIN (SELECT digipos_ao,SUM(price) broadband FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DATA' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
            LEFT JOIN (SELECT digipos_ao,SUM(price) digital FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL' GROUP BY 1) k ON a.id_digipos=k.digipos_ao
            WHERE a.telp='$user->telp' AND a.status=1
            ORDER BY 1,2,3,5;");


        foreach ($kpi as $data) {
            foreach ($list_target as $i_target => $target) {
                // if ($i_target == 'sales_acquisition') {
                //     ddd($data);
                // }
                $ach_target = (intval($data->{$i_target}) / intval(str_replace('.', '', $target['target']))) * 100;

                if ($ach_target < 100) {
                    $ach_target = intval($ach_target) * ($target['bobot']) / 100;
                } else {
                    $ach_target = $target['bobot'];
                }

                $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');

                if ($target['unit'] == 'rupiah') {
                    $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                }
            }

            $data->{'tot_sales'} = floatval(str_replace(',', '.', $data->ach_broadband))
                + floatval(str_replace(',', '.', $data->ach_digital))
                + floatval(str_replace(',', '.', $data->ach_sales_acquisition));

            $data->{'tot_proses'} = floatval(str_replace(',', '.', $data->ach_update_data))
                + floatval(str_replace(',', '.', $data->ach_pjp))
                + floatval(str_replace(',', '.', $data->ach_survey))
                + floatval(str_replace(',', '.', $data->ach_quiz))
                + floatval(str_replace(',', '.', $data->ach_mytsel));

            $data->{'total'} = number_format(floatval($data->tot_sales) + floatval($data->tot_proses), 2, ',', '.');
        }

        $clocks = DB::select(
            "SELECT * FROM table_kunjungan_copy a JOIN data_user b ON a.telp=b.telp WHERE a.telp='$user->telp' AND a.date BETWEEN '$m1' AND '$mtd' ORDER BY a.date DESC,a.waktu DESC,a.lokasi"
        );

        return view('directUser.show', compact('month', 'year', 'user', 'quiz', 'period', 'absensi', 'list_target', 'kpi', 'sales', 'proses', 'clocks'));
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
            $region = DB::table('territory_new')->select('regional')->distinct()->whereNotNull('regional')->get();
            $branch = DB::table('territory_new')->select('branch')->distinct()->whereNotNull('branch')->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->orderBy('cluster')->get();
            $city = DB::table('territory_new')->select('kab_new as city')->distinct()->whereNotNull('kab_new')->where('cluster', $user->cluster)->orderBy('kab_new')->get();
            $kecamatan = DB::table('territory')->select('kecamatan')->distinct()->whereNotNull('kecamatan')->where('new_cluster', $user->cluster)->orderBy('kecamatan')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $user->cluster)->orderBy('nama')->get();
        } else if (Auth::user()->privilege == "branch") {
            $region = DB::table('territory_new')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('territory_new')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', Auth::user()->branch)->orderBy('cluster')->get();
            $city = DB::table('territory_new')->select('kab_new as city')->distinct()->whereNotNull('kab_new')->where('branch', Auth::user()->branch)->orderBy('kab_new')->get();
            $kecamatan = DB::table('territory')->select('kecamatan')->distinct()->whereNotNull('kecamatan')->where('new_branch', Auth::user()->branch)->orderBy('kecamatan')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $user->cluster)->orderBy('nama')->get();
        } else {
            $region = DB::table('territory_new')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('territory_new')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->where('cluster', Auth::user()->cluster)->orderBy('cluster')->get();
            $city = DB::table('territory_new')->select('kab_new as city')->distinct()->whereNotNull('kab_new')->where('cluster', Auth::user()->cluster)->orderBy('kab_new')->get();
            $kecamatan = DB::table('territory')->select('kecamatan')->distinct()->whereNotNull('kecamatan')->where('new_cluster', Auth::user()->cluster)->orderBy('kecamatan')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $user->cluster)->orderBy('nama')->get();
        }

        $role = DB::table('user_type')->where('status', '1')->get();
        return view('directUser.edit', compact('user', 'region', 'branch', 'cluster', 'city', 'kecamatan', 'tap', 'role'));
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
        $user = DataUser::find($id);

        $request->validate([
            'regional' => 'required',
            'branch' => 'required',
            'cluster' => 'required',
            'city' => 'required',
            'kecamatan' => 'required',
            'tap' => 'required',
            'role' => 'required',
            'nama' => 'required',
            'panggilan' => 'required',
            'kampus' => 'required',
            'tgl_lahir' => 'required',
            'telp' => ['required', new TelkomselNumber, Rule::unique('data_user', 'telp')->ignore($user->telp, 'telp')],
            'mkios' => 'required',
            'link_aja' => 'required',
            'id_digipos' => 'required',
            'user_calista' => 'required',
            'password' => 'required',
            'reff_byu' => 'required',
            'reff_code' => 'required',
        ]);


        if (in_array($request->role, ['AO', 'EO'])) {
            $request->validate([
                'id_digipos' => [Rule::unique('data_user', 'id_digipos')->ignore($user->id_digipos, 'id_digipos')]
            ]);
        }

        $user->timestamps = false;

        $user->regional = $request->regional;
        $user->branch = $request->branch;
        $user->cluster = $request->cluster;
        $user->city = $request->city;
        $user->kecamatan = $request->kecamatan;
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
        $role = $request->role == 'All' ? '' : " and role='$request->role'";
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
                $absensi = DB::select("SELECT cluster,absen_ao.nama,date,absen_ao.telp,branch,role
                        FROM absen_ao
                        JOIN data_user
                        on absen_ao.telp=data_user.telp
                        WHERE MONTH(date)=" . $month . " AND YEAR(date)=" . $year . " 
                        AND CLUSTER='" . $request->cluster . "'
                        $role
                        ORDER BY 2,3;");
            } else if ($request->role) {
                $absensi = DB::select("SELECT cluster,absen_ao.nama,date,absen_ao.telp,branch,role 
                        FROM absen_ao
                        JOIN data_user
                        on absen_ao.telp=data_user.telp
                        WHERE MONTH(date)=" . $month . " AND YEAR(date)=" . $year . "
                        $role
                        ORDER BY 2,3;");
            } else {
                $absensi = [];
            }
        } else {
            if ($request->cluster && $request->role) {
                $absensi = DB::select("SELECT cluster,absen_ao.nama,date,absen_ao.telp,branch,role 
                        FROM absen_ao
                        JOIN data_user
                        on absen_ao.telp=data_user.telp
                        WHERE MONTH(date)=" . $month . " AND YEAR(date)=" . $year . " 
                        AND CLUSTER='" . $request->cluster . "'
                        $role
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
        $date = $request->date;

        if (auth()->user()->privilege == 'superadmin') {
            $list_cluster = DB::table('territory_new')->select('cluster')->distinct()->get();
        } else if (auth()->user()->privilege == 'branch') {
            $list_cluster = DB::table('territory_new')->select('cluster')->where('branch', auth()->user()->branch)->distinct()->get();
        } else if (auth()->user()->privilege == 'cluster') {
            $list_cluster = DB::table('territory_new')->select('cluster')->where('cluster', auth()->user()->cluster)->distinct()->get();
        }

        if ($cluster) {
            $clocks = DB::select(
                "SELECT * FROM table_kunjungan_copy a JOIN data_user b ON a.telp=b.telp WHERE b.cluster='$cluster' AND a.date='$date' ORDER BY b.nama,a.date"
            );

            $sales = DB::select("SELECT telp,poi,COUNT(DISTINCT msisdn) sales FROM sales_copy WHERE date='$date' GROUP BY 1,2;");
        } else {
            $clocks = [];
            $sales = [];
        }


        return view('directUser.clockIn.index', compact('cluster', 'date', 'list_cluster', 'clocks', 'sales'));
    }

    public function resume_clock_in(Request $request)
    {
        $date = $request->date;

        $query_regional = "SELECT b.REGIONAL as regional,COUNT(a.id) AS jumlah FROM table_kunjungan_copy a JOIN Data_Sekolah_Sumatera b ON a.npsn=b.NPSN WHERE a.`date`='$date' GROUP BY 1 ORDER BY 1 DESC;";
        $query_branch = "SELECT b.BRANCH as branch,COUNT(a.id) AS jumlah FROM table_kunjungan_copy a JOIN Data_Sekolah_Sumatera b ON a.npsn=b.NPSN WHERE a.`date`='$date' GROUP BY 1 ORDER BY 1";
        $query_cluster = "SELECT b.CLUSTER as cluster,COUNT(a.id) AS jumlah FROM table_kunjungan_copy a JOIN Data_Sekolah_Sumatera b ON a.npsn=b.NPSN WHERE a.`date`='$date' GROUP BY 1 ORDER BY 1";

        $data_regional = DB::select($query_regional);
        $data_branch = DB::select($query_branch);
        $data_cluster = DB::select($query_cluster);

        return view('directUser.clockIn.resume', compact('data_regional', 'data_branch', 'data_cluster'));
    }

    public function monthly_clock_in(Request $request)
    {
        $cluster = $request->cluster;
        $month = $request->month ?? date('n');
        $year = $request->year ?? date('Y');
        $privilege = auth()->user()->privilege;
        $clock = [];

        $getPeriod = new DatePeriod(
            new DateTime($year . '-' . $month . '-01'),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime(date("Y-m-t", strtotime($year . '-' . $month . '-01')) . ' +1 day')))
        );
        $period = [];
        foreach ($getPeriod as $key => $value) {
            array_push($period, $value->format('d-M-Y'));
        }

        if ($privilege == 'superadmin') {
            $list_cluster = DB::table('territory_new')->select('cluster')->distinct()->get();
        } else if ($privilege == 'branch') {
            $list_cluster = DB::table('territory_new')->select('cluster')->where('branch', auth()->user()->branch)->distinct()->get();
        } else if ($privilege == 'cluster') {
            $list_cluster = DB::table('territory_new')->select('cluster')->where('cluster', auth()->user()->cluster)->distinct()->get();
        }

        if ($cluster) {
            $clock = DB::table('table_kunjungan_copy', 'a')->select(DB::raw('a.date, b.telp, b.nama, COUNT(a.id) as jumlah'))->join('data_user as b', 'a.telp', '=', 'b.telp')->where('cluster', $cluster)->where('label', 'MASUK')->whereMonth('date', $month)->whereYear('date', $year)->groupBy('date')->groupBy('telp')->groupBy('nama')->orderBy('nama')->orderBy('date')->get();
        }

        // ddd($clock);

        return view('directUser.clockIn.monthly', compact('cluster', 'month', 'year', 'period', 'list_cluster', 'clock'));
    }

    public function kpi(Request $request)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        ini_set('memory_limit', '-1');
        $u_privilege = Auth::user()->privilege;
        $u_branch = Auth::user()->branch;
        $u_cluster = Auth::user()->cluster;
        $where_loc = $u_privilege == 'cluster' ? " a.`cluster`='$u_cluster' AND " : ($u_privilege == 'branch' ? "a.`branch`='$u_branch' AND " : "");
        $where_role = $request->role ? " a.role='$request->role' AND " : '';

        $target = DB::table('target_ds')->where('status', 1)->get();

        $list_target = [];
        $sales = 0;
        $proses = 0;

        foreach ($target as $data) {
            $item_kpi = $data->item_kpi;
            $target_value = $data->unit == 'rupiah'
                ? number_format($data->target, 0, ",", ".")
                : $data->target;

            $list_target[$item_kpi] = [
                'target' => $target_value,
                'bobot' => $data->bobot,
                'unit' => $data->unit
            ];

            if ($data->kategori == 'sales') {
                $sales += $data->bobot;
            } elseif ($data->kategori == 'proses') {
                $proses += $data->bobot;
            }
        }

        if ($request->date) {
            $mtd = $request->date;
            $m1 = date('Y-m-01', strtotime($mtd));

            // LEFT JOIN (SELECT telp, COUNT(msisdn)*20000 sales_byu FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND (kategori='BYU' OR (kategori='TRADE IN' AND detail='By.U')) GROUP BY 1) c ON a.telp = c.telp
            $detail = DB::select("SELECT a.branch,a.cluster,a.nama,a.telp,a.id_digipos,a.`role`,b.byu,c.sales_byu, g.mytsel,e.update_data,f.pjp,h.quiz,i.survey,j.broadband,k.digital,
            (COALESCE(b.byu,0)+COALESCE(c.sales_byu,0)) as sales_acquisition
            FROM data_user a
            LEFT JOIN (SELECT id_digipos, SUM(revenue) byu FROM byu_sales_ds WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) b ON a.id_digipos = b.id_digipos
            -- LEFT JOIN (SELECT telp, COUNT(msisdn)*20000 sales_byu FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND (kategori='BYU' OR (kategori='TRADE IN' AND detail='By.U')) GROUP BY 1) c ON a.telp = c.telp
            LEFT JOIN(SELECT sales_copy.telp,SUM(CASE WHEN price IS NOT NULL THEN price ELSE 0 END) sales_byu FROM sales_copy JOIN byu_validasi ON sales_copy.msisdn=byu_validasi.msisdn WHERE byu_validasi.`tgl` BETWEEN '$m1' AND '$mtd' GROUP BY 1) c ON a.telp=c.telp
            LEFT JOIN (SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp = g.telp
            LEFT JOIN (SELECT telp,COUNT(NPSN) update_data FROM Data_Sekolah_Sumatera WHERE UPDATED_AT BETWEEN '$m1' AND '$mtd' AND LONGITUDE!='' GROUP BY 1) e ON a.telp=e.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) pjp FROM table_kunjungan_copy WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
            LEFT JOIN (SELECT telp,SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
            LEFT JOIN (SELECT Data_Sekolah_Sumatera.telp,COUNT(survey_answer.telp_siswa) survey FROM survey_answer JOIN Data_Sekolah_Sumatera ON survey_answer.npsn=Data_Sekolah_Sumatera.NPSN WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) i ON a.telp=i.telp
            LEFT JOIN (SELECT digipos_ao,SUM(price) broadband FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DATA' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
            LEFT JOIN (SELECT digipos_ao,SUM(price) digital FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type LIKE 'DIGITAL%' OR trx_type LIKE 'EXTENSION%' GROUP BY 1) k ON a.id_digipos=k.digipos_ao
            WHERE $where_loc $where_role a.status=1
            ORDER BY 1,2,3,5;");

            foreach ($detail as $data) {
                foreach ($list_target as $i_target => $target) {
                    $ach_target = (intval($data->{$i_target}) / intval(str_replace('.', '', $target['target']))) * 100;

                    if ($ach_target < 100) {
                        $ach_target = intval($ach_target) * ($target['bobot']) / 100;
                    } else {
                        $ach_target = $target['bobot'];
                    }

                    $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');

                    if ($target['unit'] == 'rupiah') {
                        $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                    }
                }

                $data->{'tot_sales'} = floatval(str_replace(',', '.', $data->ach_broadband))
                    + floatval(str_replace(',', '.', $data->ach_digital))
                    + floatval(str_replace(',', '.', $data->ach_sales_acquisition));

                $data->{'tot_proses'} = floatval(str_replace(',', '.', $data->ach_update_data))
                    + floatval(str_replace(',', '.', $data->ach_pjp))
                    + floatval(str_replace(',', '.', $data->ach_survey))
                    + floatval(str_replace(',', '.', $data->ach_quiz))
                    + floatval(str_replace(',', '.', $data->ach_mytsel));

                $data->{'total'} = number_format(floatval($data->tot_sales) + floatval($data->tot_proses), 2, ',', '.');
            }


            // ddd($detail);
        } else {
            $detail = [];
        }

        $last_sales = DB::table('sales_copy')->select('date')->orderBy('date', 'desc')->first();
        $last_digipos = DB::table('trx_digipos_ds_2024')->select('event_date as date')->whereNotIn('event_date', ['None'])->orderBy('event_date', 'desc')->first();
        $last_acquisition = DB::table('byu_validasi')->select('tgl as date')->orderBy('date', 'desc')->first();

        // ddd($detail);

        // ddd(compact('last_migrasi', 'last_orbit', 'last_trade', 'last_digipos'));
        return view('directUser.kpi.index', compact('detail', 'list_target', 'sales', 'proses', 'last_sales', 'last_digipos', 'last_acquisition'));
    }


    public function resume_kpi(Request $request)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        ini_set('memory_limit', '-1');
        $u_privilege = Auth::user()->privilege;
        $u_branch = Auth::user()->branch;
        $u_cluster = Auth::user()->cluster;
        $where_loc = $u_privilege == 'cluster' ? " a.`cluster`='$u_cluster' AND " : ($u_privilege == 'branch' ? "a.`branch`='$u_branch' AND " : "");

        $target = DB::table('target_ds')->where('status', 1)->get();

        $list_target = [];

        foreach ($target as $data) {
            $item_kpi = $data->item_kpi;
            $target_value = $data->unit == 'rupiah'
                ? number_format($data->target, 0, ",", ".")
                : $data->target;

            $list_target[$item_kpi] = [
                'target' => $target_value,
                'bobot' => $data->bobot,
                'unit' => $data->unit
            ];
        }

        if ($request->date) {
            $resume_region = DataUser::resume_kpi($request->date, $where_loc, 'regional');
            $resume_branch = DataUser::resume_kpi($request->date, $where_loc, 'branch');
            $resume_cluster = DataUser::resume_kpi($request->date, $where_loc, 'cluster');
            // $resume_branch = [];
            // $resume_cluster = [];

            $user_region = DB::select("SELECT regional as region,count(role) jumlah FROM data_user WHERE status='1' GROUP BY 1 ORDER BY regional DESC,branch,cluster;");
            $user_branch = DB::select("SELECT branch,count(role) jumlah FROM data_user WHERE status='1' GROUP BY 1 ORDER BY regional DESC,branch,cluster;");
            $user_cluster = DB::select("SELECT cluster,count(role) jumlah FROM data_user WHERE status='1' GROUP BY 1 ORDER BY regional DESC,branch,cluster;");

            foreach ($resume_region as $data) {
                foreach ($list_target as $i_target => $target) {
                    // ddd($user_region);
                    foreach ($user_region as $key => $user) {
                        if ($user->region == $data->regional) {
                            if ($i_target == 'quiz') {
                                $ach_target = (intval($data->{$i_target}) / intval($user->jumlah)) * 100;
                            } else {
                                $ach_target = (intval($data->{$i_target} / $user->jumlah) / intval(str_replace('.', '', $target['target']))) * 100;
                            }

                            $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');
                            $data->{"mom_$i_target"} = number_format(($data->{$i_target} / ($data->{"last_$i_target"} == 0 ? 1 : $data->{"last_$i_target"})) * 100, 2, ',', '.');

                            if ($target['unit'] == 'rupiah') {
                                $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                            }
                        }
                    }
                }
            }
            // ddd($resume_region);

            foreach ($resume_branch as $data) {
                foreach ($list_target as $i_target => $target) {
                    // ddd($user_branch);
                    foreach ($user_branch as $key => $user) {
                        if ($user->branch == $data->branch) {
                            if ($i_target == 'quiz') {
                                $ach_target = (intval($data->{$i_target}) / intval($user->jumlah)) * 100;
                            } else {
                                $ach_target = (intval($data->{$i_target} / $user->jumlah) / intval(str_replace('.', '', $target['target']))) * 100;
                            }

                            $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');
                            $data->{"mom_$i_target"} = number_format(($data->{$i_target} / ($data->{"last_$i_target"} == 0 ? 1 : $data->{"last_$i_target"})) * 100, 2, ',', '.');

                            if ($target['unit'] == 'rupiah') {
                                $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                            }
                        }
                    }
                }
            }

            foreach ($resume_cluster as $data) {
                foreach ($list_target as $i_target => $target) {
                    // ddd($user_cluster);
                    foreach ($user_cluster as $key => $user) {
                        if ($user->cluster == $data->cluster) {
                            if ($i_target == 'quiz') {
                                $ach_target = (intval($data->{$i_target}) / intval($user->jumlah)) * 100;
                            } else {
                                $ach_target = (intval($data->{$i_target} / $user->jumlah) / intval(str_replace('.', '', $target['target']))) * 100;
                            }

                            $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');
                            $data->{"mom_$i_target"} = number_format(($data->{$i_target} / ($data->{"last_$i_target"} == 0 ? 1 : $data->{"last_$i_target"})) * 100, 2, ',', '.');

                            if ($target['unit'] == 'rupiah') {
                                $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                            }
                        }
                    }
                }
            }
            // foreach ([$resume_region, $resume_branch, $resume_cluster] as $key => $resume) {
            //     // ddd($resume);
            // }
        } else {
            $resume_region = [];
            $resume_branch = [];
            $resume_cluster = [];
        }


        $last_sales = DB::table('sales_copy')->select('date')->orderBy('date', 'desc')->first();
        $last_digipos = DB::table('trx_digipos_ds_2024')->select('event_date as date')->whereNotIn('event_date', ['None'])->orderBy('event_date', 'desc')->first();

        return view('directUser.kpi.resume', compact('resume_region', 'resume_branch', 'resume_cluster', 'last_sales', 'last_digipos'));
    }

    public function kpi_old(Request $request)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        ini_set('memory_limit', '-1');
        $u_privilege = Auth::user()->privilege;
        $u_branch = Auth::user()->branch;
        $u_cluster = Auth::user()->cluster;
        $where_loc = $u_privilege == 'cluster' ? " a.`cluster`='$u_cluster' AND " : ($u_privilege == 'branch' ? "a.`branch`='$u_branch' AND " : "");

        // $target = DB::table('target_ds')->where('status', 1)->get();
        // $list_target = [];
        // $sales = 0;
        // $proses = 0;
        // foreach ($target as $key => $data) {
        //     $list_target[$data->item_kpi] = ['target' => $data->unit == 'rupiah' ? number_format("$data->target", 0, ",", ".") : $data->target, 'bobot' => $data->bobot, 'unit' => $data->unit];
        //     $sales += $data->kategori == 'sales' ? $data->bobot : 0;
        //     $proses += $data->kategori == 'proses' ? $data->bobot : 0;
        // }

        $target = DB::table('target_ds_old')->where('status', 1)->get();

        $list_target = [];
        $sales = 0;
        $proses = 0;

        foreach ($target as $data) {
            $item_kpi = $data->item_kpi;
            $target_value = $data->unit == 'rupiah'
                ? number_format($data->target, 0, ",", ".")
                : $data->target;

            $list_target[$item_kpi] = [
                'target' => $target_value,
                'bobot' => $data->bobot,
                'unit' => $data->unit
            ];

            if ($data->kategori == 'sales') {
                $sales += $data->bobot;
            } elseif ($data->kategori == 'proses') {
                $proses += $data->bobot;
            }
        }

        if ($request->date) {
            $mtd = $request->date;
            $m1 = date('Y-m-01', strtotime($mtd));

            $detail = DB::select("SELECT a.branch,a.cluster,a.nama,a.telp,a.id_digipos,a.`role`,b.migrasi,c.orbit,d.byu, g.mytsel,e.update_data,f.pjp,h.quiz,i.survey,j.broadband,k.digital
            FROM data_user a
            LEFT JOIN (SELECT outlet_id,COUNT(outlet_id) migrasi FROM `4g_usim_all_trx` WHERE date BETWEEN '$m1' AND '$mtd' AND (status='MIGRATION_SUCCCESS' OR status='USIM_ACTIVE') GROUP BY 1) b ON a.id_digipos=b.outlet_id
            LEFT JOIN (SELECT outlet_id,COUNT(msisdn) orbit FROM orbit_digipos WHERE so_date BETWEEN '$m1' AND '$mtd' GROUP BY 1) c ON a.id_digipos=c.outlet_id
            LEFT JOIN (SELECT telp,COUNT(msisdn) byu FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='BYU' GROUP BY 1) d ON a.telp=d.telp
            LEFT JOIN (SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp = g.telp
            LEFT JOIN (SELECT telp,COUNT(NPSN) update_data FROM Data_Sekolah_Sumatera WHERE UPDATED_AT BETWEEN '$m1' AND '$mtd' AND LONGITUDE!='' GROUP BY 1) e ON a.telp=e.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) pjp FROM table_kunjungan_copy WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
            LEFT JOIN (SELECT telp,SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
            LEFT JOIN (SELECT Data_Sekolah_Sumatera.telp,COUNT(survey_answer.telp_siswa) survey FROM survey_answer JOIN Data_Sekolah_Sumatera ON survey_answer.npsn=Data_Sekolah_Sumatera.NPSN WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) i ON a.telp=i.telp
            LEFT JOIN (SELECT digipos_ao,SUM(price) broadband FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DATA' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
            LEFT JOIN (SELECT digipos_ao,SUM(price) digital FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL' GROUP BY 1) k ON a.id_digipos=k.digipos_ao
            WHERE $where_loc a.status=1
            ORDER BY 1,2,3,5;");


            // $detail = DB::table('data_user as a')
            //     ->select('a.branch', 'a.cluster', 'a.nama', 'a.telp', 'a.role', 'b.migrasi', 'c.orbit', 'd.trade', 'g.mytsel', 'e.update_data', 'f.pjp', 'h.quiz', 'i.survey', 'j.broadband', 'k.digital')
            //     ->leftJoin(DB::raw("(SELECT outlet_id, COUNT(outlet_id) migrasi FROM 4g_usim_all_trx WHERE date BETWEEN '$m1' AND '$mtd' AND (status='MIGRATION_SUCCCESS' OR status='USIM_ACTIVE') GROUP BY 1) b"), 'a.id_digipos', '=', 'b.outlet_id')
            //     ->leftJoin(DB::raw("(SELECT outlet_id, COUNT(msisdn) orbit FROM orbit_digipos WHERE so_date BETWEEN '$m1' AND '$mtd' GROUP BY 1) c"), 'a.id_digipos', '=', 'c.outlet_id')
            //     ->leftJoin(DB::raw("(SELECT telp, COUNT(msisdn) trade FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='TRADE IN' GROUP BY 1) d"), 'a.telp', '=', 'd.telp')
            //     ->leftJoin(DB::raw("(SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g"), 'a.telp', '=', 'd.telp')
            //     ->leftJoin(DB::raw("(SELECT telp, COUNT(NPSN) update_data FROM Data_Sekolah_Sumatera WHERE UPDATED_AT BETWEEN '$m1' AND '$mtd' AND LONGITUDE!='' GROUP BY 1) e"), 'a.telp', '=', 'e.telp')
            //     ->leftJoin(DB::raw("(SELECT telp, COUNT(npsn) pjp FROM _copy WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f"), 'a.telp', '=', 'f.telp')
            //     ->leftJoin(DB::raw("(SELECT telp, SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h"), 'a.telp', '=', 'h.telp')
            //     ->leftJoin(DB::raw("(SELECT Data_Sekolah_Sumatera.telp, COUNT(survey_answer.telp_siswa) survey FROM survey_answer JOIN Data_Sekolah_Sumatera ON survey_answer.npsn=Data_Sekolah_Sumatera.NPSN WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) i"), 'a.telp', '=', 'i.telp')
            //     ->leftJoin(DB::raw("(SELECT digipos_ao, SUM(price) broadband FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DATA' GROUP BY 1) j"), 'a.id_digipos', '=', 'j.digipos_ao')
            //     ->leftJoin(DB::raw("(SELECT digipos_ao, SUM(price) digital FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL' GROUP BY 1) k"), 'a.id_digipos', '=', 'k.digipos_ao')
            //     ->whereRaw("$where_loc a.status")
            //     ->orderBy('a.branch')
            //     ->orderBy('a.cluster')
            //     ->orderBy('a.nama')
            //     ->orderBy('a.role')
            //     ->get();

            // $detail = json_decode(json_encode($detail), true);

            // foreach ($detail as $i_detail => $data) {
            //     foreach ($list_target as $i_target => $target) {
            //         $data->{"ach_$i_target"} = (intval($data->{$i_target}) / (int)str_replace('.', '', $target['target'])) * 100;
            //         $data->{"ach_$i_target"} = $data->{"ach_$i_target"} < 100 ? intval($data->{"ach_$i_target"}) * ($target['bobot']) / 100 : $target['bobot'];
            //         $data->{"ach_$i_target"} = number_format($data->{"ach_$i_target"}, 2, ',', '.');
            //         if ($target['unit'] == 'rupiah') {
            //             $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
            //         }
            //     }
            //     // ddd((float)str_replace(',','.',$data->ach_migrasi));
            //     $data->{'tot_sales'} = (float)str_replace(',', '.', $data->ach_broadband) + (float)str_replace(',', '.', $data->ach_digital) + (float)str_replace(',', '.', $data->ach_orbit) + (float)str_replace(',', '.', $data->ach_migrasi) + (float)str_replace(',', '.', $data->ach_byu);
            //     $data->{'tot_proses'} = (float)str_replace(',', '.', $data->ach_update_data) + (float)str_replace(',', '.', $data->ach_pjp) + (float)str_replace(',', '.', $data->ach_survey) + (float)str_replace(',', '.', $data->ach_oss_osk) + (float)str_replace(',', '.', $data->ach_quiz);
            //     $data->{'total'} = number_format(floatval($data->tot_sales) + floatval($data->tot_proses), 2, ',', '.');
            // }

            foreach ($detail as $data) {
                foreach ($list_target as $i_target => $target) {
                    $ach_target = (intval($data->{$i_target}) / intval(str_replace('.', '', $target['target']))) * 100;

                    if ($ach_target < 100) {
                        $ach_target = intval($ach_target) * ($target['bobot']) / 100;
                    } else {
                        $ach_target = $target['bobot'];
                    }

                    $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');

                    if ($target['unit'] == 'rupiah') {
                        $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                    }
                }

                $data->{'tot_sales'} = floatval(str_replace(',', '.', $data->ach_broadband))
                    + floatval(str_replace(',', '.', $data->ach_digital))
                    + floatval(str_replace(',', '.', $data->ach_orbit))
                    + floatval(str_replace(',', '.', $data->ach_migrasi))
                    + floatval(str_replace(',', '.', $data->ach_byu))
                    + floatval(str_replace(',', '.', $data->ach_mytsel));

                $data->{'tot_proses'} = floatval(str_replace(',', '.', $data->ach_update_data))
                    + floatval(str_replace(',', '.', $data->ach_pjp))
                    + floatval(str_replace(',', '.', $data->ach_survey))
                    + floatval(str_replace(',', '.', $data->ach_quiz));

                $data->{'total'} = number_format(floatval($data->tot_sales) + floatval($data->tot_proses), 2, ',', '.');
            }


            // ddd($detail);
        } else {
            $detail = [];
        }
        $last_migrasi = DB::table('4g_usim_all_trx')->select('date')->orderBy('date', 'desc')->first();
        $last_orbit = DB::table('orbit_digipos')->select('so_date as date')->orderBy('so_date', 'desc')->first();
        $last_sales = DB::table('sales_copy')->select('date')->orderBy('date', 'desc')->first();
        $last_digipos = DB::table('trx_digipos_ds_2024')->select('event_date as date')->whereNotIn('event_date', ['None'])->orderBy('event_date', 'desc')->first();

        // ddd(compact('last_migrasi', 'last_orbit', 'last_trade', 'last_digipos'));
        return view('directUser.kpi_old.index', compact('detail', 'list_target', 'sales', 'proses', 'last_migrasi', 'last_orbit', 'last_sales', 'last_digipos'));
    }

    public function resume_kpi_old(Request $request)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        ini_set('memory_limit', '-1');
        $u_privilege = Auth::user()->privilege;
        $u_branch = Auth::user()->branch;
        $u_cluster = Auth::user()->cluster;
        $where_loc = $u_privilege == 'cluster' ? " a.`cluster`='$u_cluster' AND " : ($u_privilege == 'branch' ? "a.`branch`='$u_branch' AND " : "");

        $target = DB::table('target_ds_old')->where('status', 1)->get();

        $list_target = [];

        foreach ($target as $data) {
            $item_kpi = $data->item_kpi;
            $target_value = $data->unit == 'rupiah'
                ? number_format($data->target, 0, ",", ".")
                : $data->target;

            $list_target[$item_kpi] = [
                'target' => $target_value,
                'bobot' => $data->bobot,
                'unit' => $data->unit
            ];
        }

        if ($request->date) {
            $resume_region = DataUser::resume_kpi($request->date, $where_loc, 'regional');
            $resume_branch = DataUser::resume_kpi($request->date, $where_loc, 'branch');
            $resume_cluster = DataUser::resume_kpi($request->date, $where_loc, 'cluster');
            // $resume_branch = [];
            // $resume_cluster = [];

            $user_region = DB::select("SELECT regional as region,count(role) jumlah FROM data_user WHERE status='1' GROUP BY 1 ORDER BY regional DESC,branch,cluster;");
            $user_branch = DB::select("SELECT branch,count(role) jumlah FROM data_user WHERE status='1' GROUP BY 1 ORDER BY regional DESC,branch,cluster;");
            $user_cluster = DB::select("SELECT cluster,count(role) jumlah FROM data_user WHERE status='1' GROUP BY 1 ORDER BY regional DESC,branch,cluster;");

            foreach ($resume_region as $data) {
                foreach ($list_target as $i_target => $target) {
                    // ddd($user_region);
                    foreach ($user_region as $key => $user) {
                        if ($user->region == $data->regional) {
                            if ($i_target == 'quiz') {
                                $ach_target = (intval($data->{$i_target}) / intval($user->jumlah)) * 100;
                            } else {
                                $ach_target = (intval($data->{$i_target} / $user->jumlah) / intval(str_replace('.', '', $target['target']))) * 100;
                            }

                            $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');
                            $data->{"mom_$i_target"} = number_format(($data->{$i_target} / ($data->{"last_$i_target"} == 0 ? 1 : $data->{"last_$i_target"})) * 100, 2, ',', '.');

                            if ($target['unit'] == 'rupiah') {
                                $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                            }
                        }
                    }
                }
            }
            // ddd($resume_region);

            foreach ($resume_branch as $data) {
                foreach ($list_target as $i_target => $target) {
                    // ddd($user_branch);
                    foreach ($user_branch as $key => $user) {
                        if ($user->branch == $data->branch) {
                            if ($i_target == 'quiz') {
                                $ach_target = (intval($data->{$i_target}) / intval($user->jumlah)) * 100;
                            } else {
                                $ach_target = (intval($data->{$i_target} / $user->jumlah) / intval(str_replace('.', '', $target['target']))) * 100;
                            }

                            $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');
                            $data->{"mom_$i_target"} = number_format(($data->{$i_target} / ($data->{"last_$i_target"} == 0 ? 1 : $data->{"last_$i_target"})) * 100, 2, ',', '.');

                            if ($target['unit'] == 'rupiah') {
                                $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                            }
                        }
                    }
                }
            }

            foreach ($resume_cluster as $data) {
                foreach ($list_target as $i_target => $target) {
                    // ddd($user_cluster);
                    foreach ($user_cluster as $key => $user) {
                        if ($user->cluster == $data->cluster) {
                            if ($i_target == 'quiz') {
                                $ach_target = (intval($data->{$i_target}) / intval($user->jumlah)) * 100;
                            } else {
                                $ach_target = (intval($data->{$i_target} / $user->jumlah) / intval(str_replace('.', '', $target['target']))) * 100;
                            }

                            $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');
                            $data->{"mom_$i_target"} = number_format(($data->{$i_target} / ($data->{"last_$i_target"} == 0 ? 1 : $data->{"last_$i_target"})) * 100, 2, ',', '.');

                            if ($target['unit'] == 'rupiah') {
                                $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                            }
                        }
                    }
                }
            }
            // foreach ([$resume_region, $resume_branch, $resume_cluster] as $key => $resume) {
            //     // ddd($resume);
            // }
        } else {
            $resume_region = [];
            $resume_branch = [];
            $resume_cluster = [];
        }


        $last_migrasi = DB::table('4g_usim_all_trx')->select('date')->orderBy('date', 'desc')->first();
        $last_orbit = DB::table('orbit_digipos')->select('so_date as date')->orderBy('so_date', 'desc')->first();
        $last_sales = DB::table('sales_copy')->select('date')->orderBy('date', 'desc')->first();
        $last_digipos = DB::table('trx_digipos_ds_2024')->select('event_date as date')->whereNotIn('event_date', ['None'])->orderBy('event_date', 'desc')->first();

        return view('directUser.kpi_old.resume', compact('resume_region', 'resume_branch', 'resume_cluster', 'last_migrasi', 'last_orbit', 'last_sales', 'last_digipos'));
    }

    public function kpi_yba(Request $request)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        ini_set('memory_limit', '-1');
        $u_privilege = Auth::user()->privilege;
        $u_branch = Auth::user()->branch;
        $u_cluster = Auth::user()->cluster;
        $where_loc = $u_privilege == 'cluster' ? " a.`cluster`='$u_cluster' AND " : ($u_privilege == 'branch' ? "a.`branch`='$u_branch' AND " : "");
        // $where_role = $request->role ? " a.role='$request->role' AND " : '';

        $target = DB::table('target_yba')->where('status', 1)->get();

        $list_target = [];
        $sales = 0;
        $proses = 0;

        foreach ($target as $data) {
            $item_kpi = $data->item_kpi;
            $target_value = $data->unit == 'rupiah'
                ? number_format($data->target, 0, ",", ".")
                : $data->target;

            $list_target[$item_kpi] = [
                'target' => $target_value,
                'bobot' => $data->bobot,
                'unit' => $data->unit
            ];

            if ($data->kategori == 'sales') {
                $sales += $data->bobot;
            } elseif ($data->kategori == 'proses') {
                $proses += $data->bobot;
            }
        }

        if ($request->date) {
            $mtd = $request->date;
            $m1 = date('Y-m-01', strtotime($mtd));

            $query = "SELECT a.branch,a.cluster,a.nama,a.telp,a.id_digipos,a.`role`,b.byu,c.sales_byu,d.school_dealing,e.event_handling,f.pjp, g.mytsel,h.quiz,j.sales_digipos,
            (COALESCE(b.byu,0)+COALESCE(c.sales_byu,0)) as sales_acquisition
            FROM data_user a
            LEFT JOIN (SELECT id_digipos, SUM(revenue) byu FROM byu_sales_ds WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) b ON a.id_digipos = b.id_digipos
            LEFT JOIN (SELECT telp, COUNT(msisdn)*20000 sales_byu FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='BYU' GROUP BY 1) c ON a.telp = c.telp
            LEFT JOIN (SELECT telp_ds as telp,COUNT(DISTINCT npsn) school_dealing FROM peserta_event_sekolah WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) d ON a.telp=d.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) event_handling FROM pjp WHERE date BETWEEN '$m1' AND '$mtd' AND event!='' AND event IS NOT NULL GROUP BY 1) e ON a.telp=e.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) pjp FROM table_kunjungan_copy WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
            LEFT JOIN (SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp = g.telp
            LEFT JOIN (SELECT telp,SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
            LEFT JOIN (SELECT digipos_ao,SUM(price) sales_digipos FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
            WHERE $where_loc a.role='YBA' AND a.status=1
            ORDER BY 1,2,3,5;";

            // die($query); 

            $detail = DB::select($query);

            foreach ($detail as $data) {
                foreach ($list_target as $i_target => $target) {
                    $ach_target = (intval($data->{$i_target}) / intval(str_replace('.', '', $target['target']))) * 100;

                    if ($ach_target < 100) {
                        $ach_target = intval($ach_target) * ($target['bobot']) / 100;
                    } else {
                        $ach_target = $target['bobot'];
                    }

                    $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');

                    if ($target['unit'] == 'rupiah') {
                        $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                    }
                }

                $data->{'tot_sales'} = floatval(str_replace(',', '.', $data->ach_school_dealing))
                    + floatval(str_replace(',', '.', $data->ach_sales_digipos))
                    + floatval(str_replace(',', '.', $data->ach_sales_acquisition));

                $data->{'tot_proses'} = floatval(str_replace(',', '.', $data->ach_event_handling))
                    + floatval(str_replace(',', '.', $data->ach_pjp))
                    + floatval(str_replace(',', '.', $data->ach_quiz))
                    + floatval(str_replace(',', '.', $data->ach_mytsel));

                $data->{'total'} = number_format(floatval($data->tot_sales) + floatval($data->tot_proses), 2, ',', '.');
            }


            // ddd($detail);
        } else {
            $detail = [];
        }

        $last_sales = DB::table('sales_copy')->select('date')->orderBy('date', 'desc')->first();
        $last_digipos = DB::table('trx_digipos_ds_2024')->select('event_date as date')->whereNotIn('event_date', ['None'])->orderBy('event_date', 'desc')->first();

        // ddd(compact('last_migrasi', 'last_orbit', 'last_trade', 'last_digipos'));
        return view('directUser.kpi_yba.index', compact('detail', 'list_target', 'sales', 'proses', 'last_sales', 'last_digipos'));
    }

    public function kpi_api(Request $request)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        ini_set('memory_limit', '-1');
        $where_role = $request->role ? " a.role='$request->role' AND " : '';

        $target = DB::table('target_ds')->where('status', 1)->get();

        $list_target = [];
        $sales = 0;
        $proses = 0;

        foreach ($target as $data) {
            $item_kpi = $data->item_kpi;
            $target_value = $data->unit == 'rupiah'
                ? number_format($data->target, 0, ",", ".")
                : $data->target;

            $list_target[$item_kpi] = [
                'target' => $target_value,
                'bobot' => $data->bobot,
                'unit' => $data->unit
            ];

            if ($data->kategori == 'sales') {
                $sales += $data->bobot;
            } elseif ($data->kategori == 'proses') {
                $proses += $data->bobot;
            }
        }

        if ($request->telp) {
            $mtd = date('Y-m-d');
            $m1 = date('Y-m-01', strtotime($mtd));

            $detail = DB::select("SELECT a.branch,a.cluster,a.nama,a.telp,a.id_digipos,a.`role`,b.byu,c.sales_byu, g.mytsel,e.update_data,f.pjp,h.quiz,i.survey,j.broadband,k.digital,
            (COALESCE(b.byu,0)+COALESCE(c.sales_byu,0)) as sales_acquisition
            FROM data_user a
            LEFT JOIN (SELECT id_digipos, SUM(revenue) byu FROM byu_sales_ds WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) b ON a.id_digipos = b.id_digipos
            LEFT JOIN (SELECT telp, COUNT(msisdn)*20000 sales_byu FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='BYU' GROUP BY 1) c ON a.telp = c.telp
            LEFT JOIN (SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp = g.telp
            LEFT JOIN (SELECT telp,COUNT(NPSN) update_data FROM Data_Sekolah_Sumatera WHERE UPDATED_AT BETWEEN '$m1' AND '$mtd' AND LONGITUDE!='' GROUP BY 1) e ON a.telp=e.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) pjp FROM table_kunjungan_copy WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
            LEFT JOIN (SELECT telp,SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
            LEFT JOIN (SELECT Data_Sekolah_Sumatera.telp,COUNT(survey_answer.telp_siswa) survey FROM survey_answer JOIN Data_Sekolah_Sumatera ON survey_answer.npsn=Data_Sekolah_Sumatera.NPSN WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) i ON a.telp=i.telp
            LEFT JOIN (SELECT digipos_ao,SUM(price) broadband FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DATA' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
            LEFT JOIN (SELECT digipos_ao,SUM(price) digital FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL' GROUP BY 1) k ON a.id_digipos=k.digipos_ao
            WHERE a.telp='$request->telp' AND $where_role a.status=1
            ORDER BY 1,2,3,5;");


            foreach ($detail as $data) {
                foreach ($list_target as $i_target => $target) {
                    $ach_target = (intval($data->{$i_target}) / intval(str_replace('.', '', $target['target']))) * 100;

                    if ($ach_target < 100) {
                        $ach_target = intval($ach_target) * ($target['bobot']) / 100;
                    } else {
                        $ach_target = $target['bobot'];
                    }

                    $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');

                    if ($target['unit'] == 'rupiah') {
                        $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                    }
                }

                $data->{'tot_sales'} = floatval(str_replace(',', '.', $data->ach_broadband))
                    + floatval(str_replace(',', '.', $data->ach_digital))
                    + floatval(str_replace(',', '.', $data->ach_sales_acquisition));

                $data->{'tot_proses'} = floatval(str_replace(',', '.', $data->ach_update_data))
                    + floatval(str_replace(',', '.', $data->ach_pjp))
                    + floatval(str_replace(',', '.', $data->ach_survey))
                    + floatval(str_replace(',', '.', $data->ach_quiz))
                    + floatval(str_replace(',', '.', $data->ach_mytsel));

                $data->{'total'} = number_format(floatval($data->tot_sales) + floatval($data->tot_proses), 2, ',', '.');
            }


            echo intval($detail[0]->total);
            // ddd(intval($detail[0]->total));
        } else {
            $detail = [];
        }
    }


    public function kpi_yba_api(Request $request)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        ini_set('memory_limit', '-1');
        // $where_role = $request->role ? " a.role='$request->role' AND " : '';

        $target = DB::table('target_yba')->where('status', 1)->get();

        $list_target = [];
        $sales = 0;
        $proses = 0;

        foreach ($target as $data) {
            $item_kpi = $data->item_kpi;
            $target_value = $data->unit == 'rupiah'
                ? number_format($data->target, 0, ",", ".")
                : $data->target;

            $list_target[$item_kpi] = [
                'target' => $target_value,
                'bobot' => $data->bobot,
                'unit' => $data->unit
            ];

            if ($data->kategori == 'sales') {
                $sales += $data->bobot;
            } elseif ($data->kategori == 'proses') {
                $proses += $data->bobot;
            }
        }

        if ($request->telp) {
            $mtd = date('Y-m-d');
            $m1 = date('Y-m-01', strtotime($mtd));

            $query = "SELECT a.branch,a.cluster,a.nama,a.telp,a.id_digipos,a.`role`,b.byu,c.sales_byu,d.school_dealing,e.event_handling,f.pjp, g.mytsel,h.quiz,j.sales_digipos,
            (COALESCE(b.byu,0)+COALESCE(c.sales_byu,0)) as sales_acquisition
            FROM data_user a
            LEFT JOIN (SELECT id_digipos, SUM(revenue) byu FROM byu_sales_ds WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) b ON a.id_digipos = b.id_digipos
            LEFT JOIN (SELECT telp, COUNT(msisdn)*20000 sales_byu FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='BYU' GROUP BY 1) c ON a.telp = c.telp
            LEFT JOIN (SELECT telp_ds as telp,COUNT(DISTINCT npsn) school_dealing FROM peserta_event_sekolah WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) d ON a.telp=d.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) event_handling FROM pjp WHERE date BETWEEN '$m1' AND '$mtd' AND event!='' AND event IS NOT NULL GROUP BY 1) e ON a.telp=e.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) pjp FROM table_kunjungan_copy WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
            LEFT JOIN (SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp = g.telp
            LEFT JOIN (SELECT telp,SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
            LEFT JOIN (SELECT digipos_ao,SUM(price) sales_digipos FROM trx_digipos_ds_2024 WHERE event_date BETWEEN '$m1' AND '$mtd' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
            WHERE a.telp='$request->telp' AND a.role='YBA' AND a.status=1
            ORDER BY 1,2,3,5;";

            // die($query); 

            $detail = DB::select($query);

            foreach ($detail as $data) {
                foreach ($list_target as $i_target => $target) {
                    $ach_target = (intval($data->{$i_target}) / intval(str_replace('.', '', $target['target']))) * 100;

                    if ($ach_target < 100) {
                        $ach_target = intval($ach_target) * ($target['bobot']) / 100;
                    } else {
                        $ach_target = $target['bobot'];
                    }

                    $data->{"ach_$i_target"} = number_format($ach_target, 2, ',', '.');

                    if ($target['unit'] == 'rupiah') {
                        $data->{$i_target} = number_format($data->{$i_target}, 0, ',', '.');
                    }
                }

                $data->{'tot_sales'} = floatval(str_replace(',', '.', $data->ach_school_dealing))
                    + floatval(str_replace(',', '.', $data->ach_sales_digipos))
                    + floatval(str_replace(',', '.', $data->ach_sales_acquisition));

                $data->{'tot_proses'} = floatval(str_replace(',', '.', $data->ach_event_handling))
                    + floatval(str_replace(',', '.', $data->ach_pjp))
                    + floatval(str_replace(',', '.', $data->ach_quiz))
                    + floatval(str_replace(',', '.', $data->ach_mytsel));

                $data->{'total'} = number_format(floatval($data->tot_sales) + floatval($data->tot_proses), 2, ',', '.');
            }

            echo intval($detail[0]->total);
            // ddd($detail);
        } else {
            $detail = [];
        }
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
