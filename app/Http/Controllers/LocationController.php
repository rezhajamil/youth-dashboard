<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LocationController extends Controller
{
    public function taps()
    {
        $privilege = Auth::user()->privilege;
        $territory = $privilege == 'branch' ? Auth::user()->branch : Auth::user()->cluster;

        if ($privilege == 'branch') {
            $taps = DB::table('taps')->where('branch', $territory)->orderBy('region_channel', 'desc')->orderBy('cluster')->orderBy('provinsi')->orderBy('kabupaten')->orderBy('kecamatan')->orderBy('kelurahan')->orderBy('nama')->get();
        } else if ($privilege == 'cluster') {
            $taps = DB::table('taps')->where('cluster', $territory)->orderBy('region_channel', 'desc')->orderBy('cluster')->orderBy('provinsi')->orderBy('kabupaten')->orderBy('kecamatan')->orderBy('kelurahan')->orderBy('nama')->get();
        } else {
            $taps = DB::table('taps')->orderBy('region_channel', 'desc')->orderBy('cluster')->orderBy('provinsi')->orderBy('kabupaten')->orderBy('kecamatan')->orderBy('kelurahan')->orderBy('nama')->get();
        }

        return view('location.taps.index', compact('taps'));
    }

    public function create_taps()
    {
        if (Auth::user()->privilege == 'superadmin') {
            $region = DB::table('territory_new')->select('regional')->orderBy('regional', 'desc')->distinct()->get();
        } else {
            $region = DB::table('territory_new')->select('regional')->where('branch', auth()->user()->branch)->distinct()->get();
        }

        return view('location.taps.create', compact('region'));
    }


    public function store_taps(Request $request)
    {
        $request->validate([
            'regional' => 'required',
            'branch' => 'required',
            'cluster' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'nama' => 'required|unique:taps,nama',
            'alamat' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $taps = DB::table('taps')->insert([
            'region_channel' => $request->regional,
            'branch' => $request->branch,
            'cluster' => $request->cluster,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kode_pos' => $request->kode_pos ?? '0',
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'mitra_ad_cluster' => $request->mitra_ad_cluster,
            'call_center' => $request->call_center ?? '0',
            'email' => $request->email ?? '0',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('location.taps');
    }

    public function edit_taps($id)
    {
        $tap = DB::table('taps')->find($id);
        $cluster = DB::table('territory_new')->select('cluster')->distinct()->get();
        return view('location.taps.edit', compact('tap', 'cluster'));
    }

    public function update_taps(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $tap = DB::table('taps')->find($id);

        DB::table('taps')->where('id', $id)->update([
            "cluster" => $request->cluster,
            "latitude" => $request->latitude,
            "longitude" => $request->longitude
        ]);

        return redirect()->route('location.taps');
    }

    public function poi()
    {
        $privilege = Auth::user()->privilege;
        $territory = $privilege == 'branch' ? Auth::user()->branch : Auth::user()->cluster;

        if ($privilege == 'branch') {
            $poi = DB::table('list_poi')->where('branch', $territory)->where('status', '1')->orderBy('regional', 'desc')->orderBy('branch')->orderBy('cluster')->orderBy('kabupaten')->orderBy('poi_name')->get();
        } else if ($privilege == 'cluster') {
            $poi = DB::table('list_poi')->where('cluster', $territory)->where('status', '1')->orderBy('regional', 'desc')->orderBy('branch')->orderBy('cluster')->orderBy('kabupaten')->orderBy('poi_name')->get();
        } else {
            $poi = DB::table('list_poi')->where('status', '1')->orderBy('regional', 'desc')->orderBy('branch')->orderBy('cluster')->orderBy('kabupaten')->orderBy('poi_name')->get();
        }


        $location = DB::table('list_poi')->select('location')->distinct()->get();

        return view('location.poi.index', compact('poi', 'location'));
    }

    public function create_poi()
    {
        if (Auth::user()->privilege == 'superadmin') {
            $region = DB::table('territory_new')->select('regional')->orderBy('regional', 'desc')->distinct()->get();
        } else {
            $region = DB::table('territory_new')->select('regional')->orderBy('regional', 'desc')->where('regional', auth()->user()->regional)->distinct()->get();
        }

        $location = DB::table('location_poi')->select('name')->distinct()->get();
        $keterangan = DB::table('keterangan_poi')->select('name')->distinct()->get();
        $jenis = DB::table('list_poi')->select('jenis_poi')->distinct()->get();

        return view('location.poi.create', compact('region', 'location', 'keterangan', 'jenis'));
    }

    public function store_poi(Request $request)
    {
        $request->validate([
            'regional' => 'required',
            'branch' => 'required',
            // 'sub_branch' => 'required',
            'cluster' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'location' => 'required',
            'keterangan_poi' => 'required',
            'jenis_poi' => 'required',
            'name' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $poi = DB::table('list_poi')->insert([
            'area' => 'SUMATERA',
            'regional' => $request->regional,
            'branch' => $request->branch,
            // 'sub_branch' => $request->sub_branch,
            'cluster' => $request->cluster,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'location' => $request->location,
            'keterangan_poi' => $request->keterangan_poi,
            'jenis_poi' => $request->jenis_poi,
            'poi_name' => ucwords($request->name),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => '1',
        ]);

        return redirect()->route('location.poi');
    }


    public function edit_poi($id)
    {
        $poi = DB::table('list_poi')->find($id);
        $kecamatan = DB::table('territory')->select('kecamatan')->distinct()->whereNotNull('kecamatan')->where('kabupaten', $poi->kabupaten)->orderBy('kecamatan')->get();
        // $cluster = DB::table('territory_new')->select('cluster')->distinct()->get();
        return view('location.poi.edit', compact('poi', 'kecamatan'));
    }


    public function update_poi(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kecamatan' => 'required',
        ]);
        $poi = DB::table('list_poi')->find($id);

        DB::table('list_poi')->where('id', $id)->update([
            "latitude" => $request->latitude,
            "longitude" => $request->longitude,
            "kecamatan" => $request->kecamatan
        ]);

        return redirect()->route('location.poi');
    }

    public function site(Request $request)
    {
        $privilege = Auth::user()->privilege;
        $territory = $privilege == 'branch' ? Auth::user()->branch : Auth::user()->cluster;

        if ($privilege == 'branch') {
            $site = DB::table('list_site_1022')->where('branch', $territory);
        } else if ($privilege == 'cluster') {
            $site = DB::table('list_site_1022')->where('cluster', $territory);
        } else {
            $site = DB::table('list_site_1022');
        }

        if ($request->kategori) {
            $site->where('kategori', $request->kategori);
        }

        if ($request->architype) {
            $site->where('architype', $request->architype);
        }

        $site = $site->orderBy('regional', 'desc')->orderBy('branch')->orderBy('cluster')->orderBy('kabupaten')->orderBy('site_id')->paginate(200);

        $architype = DB::table('list_site_1022')->select('architype')->distinct()->get();
        $kategori = DB::table('list_site_1022')->select('kategori')->distinct()->get();

        // ddd(compact('site', 'type', 'kategori'));
        return view('location.site.index', compact('site', 'architype', 'kategori'));
    }

    public function show_site($id)
    {
        $outlet = Location::getNearestOutlet($id);
        $sekolah = Location::getNearestSekolah($id);
        $site = DB::table('list_site_1022')->where('id', $id)->first();
        // $site = Sekolah::getNearestSite($id);
        $list_sekolah = [];

        foreach ($sekolah as $key => $data) {
            array_push($list_sekolah, $data->NPSN);
        }
        // ddd($list_sekolah);

        $last_survey = DB::table('survey_answer')->select(['session', 'time_start'])->distinct()->whereIn('npsn', $list_sekolah)->orderBy('time_start', 'DESC')->get();
        // ddd(count($last_survey));

        if (count($last_survey)) {
            $answer = DB::table('survey_answer')->where('session', $last_survey[0]->session)->whereIn('npsn', $list_sekolah)->get();
            $survey = DB::table('survey_session')->find($last_survey[0]->session);

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

        return view('location.site.show', compact('outlet', 'sekolah', 'site', 'answer', 'survey', 'kode_operator', 'operator'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
