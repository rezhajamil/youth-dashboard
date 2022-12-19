<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
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
        ddd(phpinfo());
        $provinsi = Sekolah::select('provinsi')->distinct()->whereNotNull('provinsi')->orderBy('provinsi')->get();
        $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->get();

        if ($request->kecamatan) {
            $sekolah = Sekolah::where('kecamatan', $request->kecamatan)->orderBy('nama_sekolah')->get();
            $kabupaten = DB::table('territory')->select('kabupaten')->where('provinsi', $request->provinsi)->whereNotNull('kabupaten')->distinct()->orderBy('kabupaten')->get();
            $kecamatan = DB::table('territory')->select('kecamatan')->where('kabupaten', $request->kabupaten)->whereNotNull('kecamatan')->distinct()->orderBy('kecamatan')->get();
        } else if ($request->kabupaten) {
            $sekolah = Sekolah::where('kab_kota', $request->kabupaten)->orderBy('kecamatan')->orderBy('nama_sekolah')->get();
            $kabupaten = DB::table('territory')->select('kabupaten')->where('provinsi', $request->provinsi)->whereNotNull('kabupaten')->distinct()->orderBy('kabupaten')->get();
            $kecamatan = DB::table('territory')->select('kecamatan')->where('kabupaten', $request->kabupaten)->whereNotNull('kecamatan')->distinct()->orderBy('kecamatan')->get();
        } else if ($request->provinsi) {
            $sekolah = Sekolah::where('provinsi', $request->provinsi)->orderBy('kab_kota')->orderBy('kecamatan')->orderBy('nama_sekolah')->get();
            $kabupaten = DB::table('territory')->select('kabupaten')->where('provinsi', $request->provinsi)->whereNotNull('kabupaten')->distinct()->orderBy('kabupaten')->get();
            $kecamatan = [];
        } else {
            $sekolah = [];
            $kabupaten = [];
            $kecamatan = [];
        }

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($npsn)
    {
        $sekolah = Sekolah::where('NPSN', $npsn)->first();
        $regional = explode(".", $sekolah->REGIONAL);
        if ($sekolah->KAB_KOTA) {
            // $kabupaten = [(object)['kabupaten' => $sekolah->KAB_KOTA]];
            $kabupaten = [(object)['kabupaten' => $sekolah->KAB_KOTA]];
        } else {
            $kabupaten = DB::table('territory')->select('kabupaten')->distinct()->where('region', $regional[1])->orderBy('kabupaten')->get();
        }

        if ($sekolah->KECAMATAN) {
            $kecamatan = [(object)['kecamatan' => $sekolah->KECAMATAN]];
        } else {
            if ($sekolah->KAB_KOTA) {
                $kecamatan = DB::table('territory')->select('kecamatan')->distinct()->where('kabupaten', $sekolah->KAB_KOTA)->orderBy('kecamatan')->get();
            } else {
                $kecamatan = [];
            }
        }
        // foreach ($kabupaten as $item) {
        //     ddd($item);
        // }
        $branch = DB::table('territory')->select('new_branch as branch')->distinct()->where('region', $regional[1])->orderBy('new_branch')->get();
        return view('sekolah.edit', compact('sekolah', 'kabupaten', 'kecamatan', 'branch'));
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
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'branch' => 'required',
            'cluster' => 'required',
            'pjp' => 'required',
            'frekuensi' => 'required',
        ]);

        $sekolah = Sekolah::find($npsn);
        $sekolah->timestamps = false;
        $sekolah->KAB_KOTA = $request->kabupaten;
        $sekolah->KECAMATAN = $request->kecamatan;
        $sekolah->BRANCH = $request->branch;
        $sekolah->CLUSTER = $request->cluster;
        $sekolah->PJP = $request->pjp;
        $sekolah->FREKUENSI = $request->frekuensi;

        $sekolah->save();

        return redirect()->route('sekolah.index');
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
        $resume = DB::select("SELECT BRANCH,CLUSTER,COUNT(data_oss_osk.npsn) as jumlah FROM data_oss_osk JOIN Data_Sekolah_Sumatera ON data_oss_osk.npsn=Data_Sekolah_Sumatera.NPSN GROUP BY 1,2 ORDER BY 1,2;");
        $sekolah = DB::select("SELECT * FROM data_oss_osk JOIN Data_Sekolah_Sumatera ON data_oss_osk.npsn=Data_Sekolah_Sumatera.NPSN ORDER BY `CLUSTER`,KATEGORI_JENJANG,data_oss_osk.kecamatan,data_oss_osk.nama_sekolah");

        return view('sekolah.oss_osk', compact('sekolah', 'resume'));
    }

    public function pjp()
    {
        // $pjp = DB::select("SELECT BRANCH,CLUSTER,PJP,COUNT(PJP) as jumlah FROM Data_Sekolah_Sumatera WHERE PJP IS NOT NULL GROUP BY 1,2,3 ORDER BY 1,2,3;");
        $pjp = DB::select("SELECT a.*,b.NAMA_SEKOLAH,b.REGIONAL,b.BRANCH,b.CLUSTER FROM pjp a JOIN Data_Sekolah_Sumatera b on a.npsn=b.NPSN ORDER BY a.date desc,a.time desc;");

        return view('sekolah.pjp', compact('pjp'));
    }

    public function create_pjp()
    {
        return view('sekolah.create_pjp');
    }

    public function store_pjp(Request $request)
    {
        $request->validate([
            'npsn' => 'required',
            'date' => 'required',
            'time' => 'required',
            'telp' => 'required',
            'frekuensi' => 'required',
            'activity' => 'required',
        ]);

        $pjp = DB::table('pjp')->insert([
            'npsn' => $request->npsn,
            'telp' => $request->telp,
            'frekuensi' => $request->frekuensi,
            'activity' => $request->activity,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->route('sekolah.pjp');
    }

    public function find_school(Request $request)
    {
        $name = $request->name;
        $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['NPSN', 'NAMA_SEKOLAH'])->where('PROVINSI', 'Sumatera Utara')->where('NAMA_SEKOLAH', 'like', '%' . $name . '%')->orderBy('NAMA_SEKOLAH')->limit('100')->get();

        return response()->json($sekolah);
    }
}
