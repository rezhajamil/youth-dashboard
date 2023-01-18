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
            $userAO = DataUser::where('role', 'AO')->count();
            $userEO = DataUser::where('role', 'EO')->count();
            $userYBA = DataUser::where('role', 'YBA')->count();
            $userMOGI = DataUser::where('role', 'MOGI')->count();
            $pjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'PJP')->count();
            $nonPjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'NON PJP')->count();
            $oss_osk = DB::table('data_oss_osk')->count();
        } else if (auth()->user()->privilege == 'branch') {
            $userAO = DataUser::where('role', 'AO')->where('branch', auth()->user()->branch)->count();
            $userEO = DataUser::where('role', 'EO')->where('branch', auth()->user()->branch)->count();
            $userYBA = DataUser::where('role', 'YBA')->where('branch', auth()->user()->branch)->count();
            $userMOGI = DataUser::where('role', 'MOGI')->where('branch', auth()->user()->branch)->count();
            $pjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'PJP')->where('branch', auth()->user()->branch)->count();
            $nonPjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'NON PJP')->where('branch', auth()->user()->branch)->count();
            $oss_osk = DB::table('data_oss_osk')->join('Data_Sekolah_Sumatera', "Data_Sekolah_Sumatera.NPSN", "=", "data_oss_osk.npsn")->where('branch', auth()->user()->branch)->count();
        } else {
            $userAO = DataUser::where('role', 'AO')->where('cluster', auth()->user()->cluster)->count();
            $userEO = DataUser::where('role', 'EO')->where('cluster', auth()->user()->cluster)->count();
            $userYBA = DataUser::where('role', 'YBA')->where('cluster', auth()->user()->cluster)->count();
            $userMOGI = DataUser::where('role', 'MOGI')->where('cluster', auth()->user()->cluster)->count();
            $pjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'PJP')->where('cluster', auth()->user()->cluster)->count();
            $nonPjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'NON PJP')->where('cluster', auth()->user()->cluster)->count();
            $oss_osk = DB::table('data_oss_osk')->join('Data_Sekolah_Sumatera', "Data_Sekolah_Sumatera.NPSN", "=", "data_oss_osk.npsn")->where('cluster', auth()->user()->cluster)->count();
        }

        return view('dashboard', compact('userAO', 'userEO', 'userYBA', 'userMOGI', 'pjp', 'nonPjp', 'oss_osk'));
    }

    public function resume_api(){
        $userAO = DataUser::where('role', 'AO')->count();
        $userEO = DataUser::where('role', 'EO')->count();
        $userYBA = DataUser::where('role', 'YBA')->count();
        $userMOGI = DataUser::where('role', 'MOGI')->count();
        $pjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'PJP')->count();
        $nonPjp = DB::table('Data_Sekolah_Sumatera')->where('PJP', 'NON PJP')->count();
        $oss_osk = DB::table('data_oss_osk')->count();

        $data=[
            $userAO,
            $userEO,
            $userYBA,
            $userMOGI,
            $pjp,
            $nonPjp,
            $oss_osk,
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
