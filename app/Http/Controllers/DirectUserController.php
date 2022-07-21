<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
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
            $users = DataUser::whereRaw("role=? or role=? or role=? or role=? ", array('EO', 'AO', 'MOGI', 'YBA'))->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('nama')->get();
        } else {
            $users = DataUser::whereRaw("branch=? and (role=? or role=? or role=? or role=?) ", array(Auth::user()->branch, 'EO', 'AO', 'MOGI', 'YBA'))->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('nama')->get();
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
            $cluster = DB::table('wilayah')->select('cluster')->distinct()->whereNotNull('cluster')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->orderBy('nama')->get();
        } else {
            $region = DB::table('wilayah')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('wilayah')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', Auth::user()->branch)->get();
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
            'telp' => 'required',
            'mkios' => 'required',
            'id_digipos' => 'required',
            'user_calista' => 'required',
            'password' => 'required',
            'reff_byu' => 'required',
            'reff_code' => 'required',
        ]);

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
        $user = DataUser::find($id);

        if (Auth::user()->privilege == "superadmin") {
            $region = DB::table('wilayah')->select('regional')->distinct()->whereNotNull('regional')->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->get();
            $cluster = DB::table('wilayah')->select('cluster')->distinct()->whereNotNull('cluster')->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->orderBy('nama')->get();
        } else {
            $region = DB::table('wilayah')->select('regional')->distinct()->where('regional', Auth::user()->regional)->get();
            $branch = DB::table('wilayah')->select('branch')->distinct()->where('branch', Auth::user()->branch)->get();
            $cluster = DB::table('wilayah')->select('cluster')->distinct()->whereNotNull('cluster')->where('branch', Auth::user()->branch)->get();
            $tap = DB::table('taps')->select('nama')->distinct()->whereNotNull('nama')->where('cluster', $user->cluster)->orderBy('nama')->get();
        }

        $role = DB::table('user_type')->where('status', '1')->get();
        return view('directUser.edit', compact('user', 'region', 'branch', 'cluster', 'tap', 'role'));
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
            'telp' => 'required',
            'mkios' => 'required',
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
        $user->id_digipos = $request->id_digipos;
        $user->user_calista = $request->user_calista;
        $user->password = $request->password;
        $user->reff_byu = $request->reff_byu;
        $user->reff_code = $request->reff_code;

        $user->save();
        return redirect()->route('direct_user.index')->with('success');
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
