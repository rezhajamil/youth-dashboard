<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $privilege = auth()->user()->privilege;
        $branch = auth()->user()->branch;
        $cluster = auth()->user()->cluster;
        ini_set('memory_limit', '-1');
        switch ($privilege) {
            case 'branch':
                $provinsi = Sekolah::select('provinsi')->distinct()->whereNotNull('provinsi')->where('branch', $branch)->orderBy('provinsi')->get();
                $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->where('branch', $branch)->get();
                break;
            case 'cluster':
                $provinsi = Sekolah::select('provinsi')->distinct()->whereNotNull('provinsi')->where('cluster', $cluster)->orderBy('provinsi')->get();
                $branch = [];
                break;
            default:
                $provinsi = Sekolah::select('provinsi')->distinct()->whereNotNull('provinsi')->orderBy('provinsi')->get();
                $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->get();
                break;
        }

        if ($request->kecamatan) {
            $sekolah = Sekolah::where('kecamatan', $request->kecamatan)->join('data_sekolah_favorit', 'Data_Sekolah_Sumatera.NPSN', '=', 'data_sekolah_favorit.npsn', 'left')->orderBy('nama_sekolah')->get();
            $kabupaten = DB::table('territory')->select('kabupaten')->where('provinsi', $request->provinsi)->whereNotNull('kabupaten')->distinct()->orderBy('kabupaten')->get();
            $kecamatan = DB::table('territory')->select('kecamatan')->where('kabupaten', $request->kabupaten)->whereNotNull('kecamatan')->distinct()->orderBy('kecamatan')->get();
        } else if ($request->kabupaten) {
            $sekolah = Sekolah::where('kab_kota', $request->kabupaten)->join('data_sekolah_favorit', 'Data_Sekolah_Sumatera.NPSN', '=', 'data_sekolah_favorit.npsn', 'left')->orderBy('kecamatan')->orderBy('nama_sekolah')->get();
            $kabupaten = DB::table('territory')->select('kabupaten')->where('provinsi', $request->provinsi)->whereNotNull('kabupaten')->distinct()->orderBy('kabupaten')->get();
            $kecamatan = DB::table('territory')->select('kecamatan')->where('kabupaten', $request->kabupaten)->whereNotNull('kecamatan')->distinct()->orderBy('kecamatan')->get();
        } else if ($request->provinsi) {
            $sekolah = Sekolah::where('provinsi', $request->provinsi)->join('data_sekolah_favorit', 'Data_Sekolah_Sumatera.NPSN', '=', 'data_sekolah_favorit.npsn', 'left')->orderBy('kab_kota')->orderBy('kecamatan')->orderBy('nama_sekolah')->get();
            $kabupaten = DB::table('territory')->select('kabupaten')->where('provinsi', $request->provinsi)->whereNotNull('kabupaten')->distinct()->orderBy('kabupaten')->get();
            $kecamatan = [];
        } else {
            $sekolah = [];
            $kabupaten = [];
            $kecamatan = [];
        }

        // ddd($sekolah);
        return view('sekolah.index', compact('provinsi', 'kabupaten', 'kecamatan', 'branch', 'sekolah'));
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
        $list_sekolah = DB::select("SELECT *,b.PD as siswa,b.Guru as guru,b.Pegawai as pegawai,b.`R. Kelas` as kelas,c.nama as ao,d.* FROM Data_Sekolah_Sumatera a LEFT JOIN data_rombel_sumatera b ON a.NPSN=b.npsn LEFT JOIN data_user c ON a.TELP=c.telp LEFT JOIN data_sekolah_favorit d ON a.NPSN=d.npsn WHERE a.NPSN='$id' LIMIT 1;");
        $sekolah = $list_sekolah[0];
        $outlet = Sekolah::getNearestOutlet($id);
        $site = Sekolah::getNearestSite($id);
        $last_visit = DB::table('table_kunjungan AS a')->join('data_user AS b', 'a.telp', '=', 'b.telp')->where('npsn', $sekolah->NPSN)->orderBy('date', 'DESC')->orderBy('waktu', 'DESC')->limit(3)->get();

        $last_survey = DB::table('survey_answer')->select(['session', 'time_start'])->distinct()->where('npsn', $sekolah->NPSN)->orderBy('time_start', 'DESC')->first();

        if ($last_survey) {
            $answer = DB::table('survey_answer')->where('session', $last_survey->session)->where('npsn', $sekolah->NPSN)->get();
            $survey = DB::table('survey_session')->find($last_survey->session);

            $kode_operator = DB::table('kode_prefix_operator')->get();

            $operator = DB::table('kode_prefix_operator')->select('operator')->distinct()->orderBy('operator', 'desc')->get();

            $survey->soal = json_decode($survey->soal);
            $survey->jenis_soal = json_decode($survey->jenis_soal);
            $survey->opsi = json_decode($survey->opsi);
            $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);
        } else {
            $answer = [];
            $survey = [];
            $kode_operator = [];
            $operator = [];
        }

        // ddd($last_visit);
        return view('sekolah.show', compact('list_sekolah', 'sekolah', 'outlet', 'site', 'last_visit', 'survey', 'answer', 'kode_operator', 'operator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($npsn)
    {
        $sekolah = Sekolah::where('Data_Sekolah_Sumatera.NPSN', $npsn)->join('data_sekolah_favorit', 'Data_Sekolah_Sumatera.NPSN', '=', 'data_sekolah_favorit.npsn', 'left')->first();
        // foreach ($kabupaten as $item) {
        //     ddd($item);
        // }
        $user = DataUser::where('cluster', $sekolah->CLUSTER)->orderBy('nama')->get();
        return view('sekolah.edit', compact('sekolah', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $npsn)
    {
        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'pjp' => 'nullable',
            'frekuensi' => 'nullable',
            'telp' => 'nullable|numeric',
        ]);


        DB::table('Data_Sekolah_Sumatera')->where('NPSN', $npsn)->update([
            'LATITUDE' => $request->latitude,
            'LONGITUDE' => $request->longitude,
            'PJP' => $request->pjp,
            'FREKUENSI' => $request->frekuensi,
        ]);

        return redirect()->route('sekolah.show', $npsn);
    }

    public function update_favorit(Request $request, $npsn)
    {
        $request->validate([
            'jlh_siswa_lk' => 'nullable|numeric',
            'jlh_siswa_pr' => 'nullable|numeric',
        ]);


        DB::table('data_sekolah_favorit')->where('npsn', $npsn)->update([
            'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
            'nama_operator' => $request->nama_operator,
            'akses_internet' => $request->akses_internet,
            'sumber_listrik' => $request->sumber_listrik,
            'jlh_siswa_lk' => $request->jlh_siswa_lk,
            'jlh_siswa_pr' => $request->jlh_siswa_pr,
            'tgl_update' => date('Y-m-d'),
        ]);

        return redirect()->route('sekolah.show', $npsn);
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

    public function resume()
    {
        $sekolah = DB::select("SELECT BRANCH,`CLUSTER`,
                        COUNT(CASE WHEN LATITUDE is NOT NULL AND LONGITUDE is NOT NULL and BRANCH is NOT NULL and CLUSTER is NOT NULL THEN NPSN END) total
                        FROM Data_Sekolah_Sumatera
                        WHERE CLUSTER is NOT NULL and NOT CLUSTER=''
                        GROUP BY 1,2
                        ORDER BY 1,2");

        return view('sekolah.resume', compact('sekolah'));
    }

    public function getKabupaten(Request $request)
    {
        $provinsi = $request->provinsi;
        $kabupaten = DB::table('territory')->select('kabupaten')->distinct()->where('provinsi', $provinsi)->whereNotNull('kabupaten')->orderBy('kabupaten')->get();

        return response()->json($kabupaten);
    }

    public function getKecamatan(Request $request)
    {
        $kabupaten = $request->kabupaten;
        $kecamatan = DB::table('territory')->select('kecamatan')->distinct()->where('kabupaten', $kabupaten)->whereNotNull('kecamatan')->orderBy('kecamatan')->get();

        return response()->json($kecamatan);
    }

    public function oss_osk()
    {
        $privilege = Auth::user()->privilege;
        $territory = 'WHERE ' . ($privilege == 'branch' ? "Data_Sekolah_Sumatera.branch='" . Auth::user()->branch . "'" : "Data_Sekolah_Sumatera.cluster='" . Auth::user()->cluster . "'");

        if ($privilege != 'superadmin') {
            $resume = Sekolah::getResumeOssOsk($territory);
            $sekolah = Sekolah::getDetailOssOsk($territory);
        } else {
            $resume = Sekolah::getResumeOssOsk();
            $sekolah = Sekolah::getDetailOssOsk();
        }

        // ddd($sekolah[0]);

        return view('sekolah.oss_osk', compact('sekolah', 'resume'));
    }

    public function destroy_oss_osk($id)
    {
        $data = DB::delete("DELETE from data_oss_osk where id='$id'");

        return back();
    }

    public function pjp()
    {
        // $pjp = DB::select("SELECT BRANCH,CLUSTER,PJP,COUNT(PJP) as jumlah FROM Data_Sekolah_Sumatera WHERE PJP IS NOT NULL GROUP BY 1,2,3 ORDER BY 1,2,3;");
        // $where=Auth::user()->privilege=='branch'?"where a.cluster='auth()"
        $where = Auth::user()->privilege == 'branch' ? " AND b.branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == 'cluster' ? " AND b.cluster='" . Auth::user()->cluster . "'" : '');
        $pjp = DB::select("SELECT a.*,b.NAMA_SEKOLAH,c.regional,c.branch,c.cluster,c.nama FROM pjp a LEFT JOIN Data_Sekolah_Sumatera b on a.npsn=b.NPSN LEFT JOIN data_user c ON a.telp=c.telp WHERE c.status=1 $where ORDER BY a.kategori desc;");

        return view('sekolah.pjp', compact('pjp'));
    }

    public function create_pjp()
    {
        if (auth()->user()->privilege == 'superadmin') {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->orderBy('cluster')->get();
        } else if (auth()->user()->privilege == 'branch') {
            $cluster = DB::table('territory_new')->select('cluster')->where('branch', auth()->user()->branch)->distinct()->orderBy('cluster')->get();
        } else {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->where('cluster', auth()->user()->cluster)->distinct()->orderBy('cluster')->get();
        }
        return view('sekolah.create_pjp', compact('cluster'));
    }

    public function edit_pjp($id)
    {
        if (auth()->user()->privilege == 'superadmin') {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->orderBy('cluster')->get();
        } else if (auth()->user()->privilege == 'branch') {
            $cluster = DB::table('territory_new')->select('cluster')->where('branch', auth()->user()->branch)->distinct()->orderBy('cluster')->get();
        } else {
            $cluster = DB::table('territory_new')->select('cluster')->distinct()->where('cluster', auth()->user()->cluster)->distinct()->orderBy('cluster')->get();
        }

        $pjp = DB::table('pjp')->find($id);

        return view('sekolah.edit_pjp', compact('cluster', 'pjp'));
    }

    public function store_pjp(Request $request)
    {
        $request->validate([
            'telp' => 'required',
        ]);

        if ($request->kategori == 'sekolah') {
            $request->validate([
                'hari' => 'required',
                'frekuensi' => 'required',
            ]);
            $sekolah = DB::table('Data_Sekolah_Sumatera')->where('NPSN', $request->npsn)->first();
            $pjp = DB::table('pjp')->insert([
                'kategori' => $request->kategori,
                'npsn' => $request->npsn,
                'telp' => $request->telp,
                'frekuensi' => $request->frekuensi,
                'hari' => $request->hari,
                'lokasi' => $sekolah->NAMA_SEKOLAH,
                'longitude' => $sekolah->LONGITUDE,
                'latitude' => $sekolah->LATITUDE,
            ]);
        } else if ($request->kategori == 'event') {
            $request->validate([
                'poi' => 'required',
                'event' => 'required',
                'date' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
            ]);

            $poi = DB::table('list_poi')->find($request->poi);
            $pjp = DB::table('pjp')->insert([
                'kategori' => $request->kategori,
                'npsn' => $request->poi,
                'event' => ucwords($request->event),
                'telp' => $request->telp,
                'date' => $request->date,
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'longitude' => $poi->longitude,
                'latitude' => $poi->latitude,
            ]);
        } else if ($request->kategori == 'u60') {
            $request->validate([
                'date' => 'required',
                'site_id' => 'required',
            ]);
            $site = DB::table('4g_list_site')->where('site_id', $request->site_id)->first();
            $pjp = DB::table('pjp')->insert([
                'kategori' => $request->kategori,
                'npsn' => $request->site_id,
                'event' => ucwords($request->event),
                'telp' => $request->telp,
                'date' => $request->date,
                'keterangan' => $request->keterangan,
                'longitude' => $site->longitude,
                'latitude' => $site->latitude,
            ]);
        } else if ($request->kategori == 'orbit') {
            $request->validate([
                'date' => 'required',
                'poi' => 'required',
                'lokasi' => 'required',
            ]);
            $poi = DB::table('list_poi')->find($request->poi);
            $pjp = DB::table('pjp')->insert([
                'kategori' => $request->kategori,
                'npsn' => $request->poi,
                'event' => ucwords($request->event),
                'telp' => $request->telp,
                'date' => $request->date,
                'lokasi' => $request->lokasi,
                'keterangan' => $request->keterangan,
                'longitude' => $poi->longitude,
                'latitude' => $poi->latitude,
            ]);
        } else if ($request->kategori == 'outlet') {
            $request->validate([
                'hari' => 'required',
                'frekuensi' => 'required',
            ]);
            $outlet = DB::table('outlet_reference_1022')->where('outlet_id', $request->outlet)->first();
            $pjp = DB::table('pjp')->insert([
                'kategori' => $request->kategori,
                'npsn' => $request->outlet,
                'telp' => $request->telp,
                'frekuensi' => $request->frekuensi,
                'hari' => $request->hari,
                'lokasi' => $outlet->nama_outlet,
                'longitude' => $outlet->longitude,
                'latitude' => $outlet->latitude,
            ]);
        }

        return redirect()->route('sekolah.pjp');
    }

    public function destroy_pjp($id)
    {
        $pjp = DB::table('pjp')->delete($id);

        return back();
    }

    public function get_user_pjp(Request $request)
    {
        $users = DataUser::where('cluster', $request->cluster)->orderBy('nama')->get();

        return response()->json(compact('users'));
    }

    public function get_poi(Request $request)
    {
        $poi = DB::table('list_poi')->where('cluster', $request->cluster)->where('status', '1')->orderBy('poi_name')->get();

        return response()->json(compact('poi'));
    }

    public function get_site(Request $request)
    {
        $site = DB::table('4g_list_site')->where('cluster', $request->cluster)->orderBy('site_id')->get();

        return response()->json(compact('site'));
    }

    public function get_outlet(Request $request)
    {
        $outlet = DB::table('outlet_reference_1022')->where('cluster', $request->cluster)->orderBy('outlet_id')->get();

        return response()->json(compact('outlet'));
    }

    public function find_school(Request $request)
    {
        $name = $request->name;
        $cluster = $request->cluster;
        $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['NPSN', 'NAMA_SEKOLAH'])->where('CLUSTER', $cluster)->where('NAMA_SEKOLAH', 'like', '%' . $name . '%')->orderBy('NAMA_SEKOLAH')->limit('10')->get();

        return response()->json($sekolah);
    }
}
