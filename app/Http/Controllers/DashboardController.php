<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $data = [
        //     "username" => "vivi",
        //     "password" => \bcrypt("vivi123"),
        //     "id_branch" => "",
        //     "name" => "Vivi",
        //     "privilege" => "superadmin",
        //     "branch" => "",
        //     "regional" => "SUMBAGUT"
        // ];
        // dd(phpinfo());

        // User::create($data);
        if (auth()->user()->privilege == 'superadmin') {
            $userAO = DataUser::where('role', 'AO')->where('status',1)->where('status',1)->count();
            $userEO = DataUser::where('role', 'EO')->where('status',1)->count();
            $userYBA = DataUser::where('role', 'YBA')->where('status',1)->count();
            $userORBIT = DataUser::where('role', 'ORBIT')->where('status',1)->count();
            $userPROMOTOR = DataUser::where('role', 'PROMOTOR')->where('status',1)->count();
            $pjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'PJP')->count();
            $nonPjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'NON PJP')->count();
            $oss_osk = DB::table('data_oss_osk')->count();
        } else if (auth()->user()->privilege == 'branch') {
            $userAO = DataUser::where('role', 'AO')->where('branch', auth()->user()->branch)->where('status',1)->count();
            $userEO = DataUser::where('role', 'EO')->where('branch', auth()->user()->branch)->where('status',1)->count();
            $userYBA = DataUser::where('role', 'YBA')->where('branch', auth()->user()->branch)->where('status',1)->count();
            $userORBIT = DataUser::where('role', 'ORBIT')->where('branch', auth()->user()->branch)->where('status',1)->count();
            $userPROMOTOR = DataUser::where('role', 'PROMOTOR')->where('branch', auth()->user()->branch)->where('status',1)->count();
            $pjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'PJP')->where('branch', auth()->user()->branch)->count();
            $nonPjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'NON PJP')->where('branch', auth()->user()->branch)->count();
            $oss_osk = DB::table('data_oss_osk')->join('Data_Sekolah_Sumatera', "Data_Sekolah_Sumatera.NPSN", "=", "data_oss_osk.npsn")->where('branch', auth()->user()->branch)->count();
        } else {
            $userAO = DataUser::where('role', 'AO')->where('cluster', auth()->user()->cluster)->where('status',1)->count();
            $userEO = DataUser::where('role', 'EO')->where('cluster', auth()->user()->cluster)->where('status',1)->count();
            $userYBA = DataUser::where('role', 'YBA')->where('cluster', auth()->user()->cluster)->where('status',1)->count();
            $userORBIT = DataUser::where('role', 'ORBIT')->where('cluster', auth()->user()->cluster)->where('status',1)->count();
            $userPROMOTOR = DataUser::where('role', 'PROMOTOR')->where('cluster', auth()->user()->cluster)->where('status',1)->count();
            $pjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'PJP')->where('cluster', auth()->user()->cluster)->count();
            $nonPjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'NON PJP')->where('cluster', auth()->user()->cluster)->count();
            $oss_osk = DB::table('data_oss_osk')->join('Data_Sekolah_Sumatera', "Data_Sekolah_Sumatera.NPSN", "=", "data_oss_osk.npsn")->where('cluster', auth()->user()->cluster)->count();
        }

        return view('dashboard', compact('userAO', 'userEO', 'userYBA', 'userORBIT','userPROMOTOR', 'pjp', 'nonPjp', 'oss_osk'));
    }

    public function resume_api(){
        $userAO = DataUser::where('role', 'AO')->where('status',1)->count();
        $userEO = DataUser::where('role', 'EO')->where('status',1)->count();
        $userYBA = DataUser::where('role', 'YBA')->where('status',1)->count();
        $userORBIT = DataUser::where('role', 'ORBIT')->where('status',1)->count();
        $userPROMOTOR = DataUser::where('role', 'PROMOTOR')->where('status',1)->count();
        $pjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'PJP')->count();
        $nonPjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'NON PJP')->count();
        $oss_osk = DB::table('data_oss_osk')->count();

        $data=[
            'userAO'=>$userAO,
            'userEO'=>$userEO,
            'userYBA'=>$userYBA,
            'userORBIT'=>$userORBIT,
            'userPROMOTOR'=>$userPROMOTOR,
            'pjp'=>$pjp,
            'nonPjp'=>$nonPjp,
            'oss_osk'=>$oss_osk,
        ];

        return response()->json($data);

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
