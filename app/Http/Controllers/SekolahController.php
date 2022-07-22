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
        $provinsi = Sekolah::select('provinsi')->distinct()->orderBy('provinsi')->get();
        $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->get();

        if ($request->kecamatan) {
            $sekolah = Sekolah::where('kecamatan', $request->kecamatan)->orderBy('nama_sekolah')->get();
            $kabupaten = Sekolah::select('kab_kota')->where('provinsi', $request->provinsi)->whereNotNull('kab_kota')->distinct()->orderBy('kab_kota')->get();
            $kecamatan = Sekolah::select('kecamatan')->where('kab_kota', $request->kabupaten)->whereNotNull('kecamatan')->distinct()->orderBy('kecamatan')->get();
        } else if ($request->kabupaten) {
            $sekolah = Sekolah::where('kab_kota', $request->kabupaten)->orderBy('kecamatan')->orderBy('nama_sekolah')->get();
            $kabupaten = Sekolah::select('kab_kota')->where('provinsi', $request->provinsi)->whereNotNull('kab_kota')->distinct()->orderBy('kab_kota')->get();
            $kecamatan = [];
        } else if ($request->provinsi) {
            $sekolah = Sekolah::where('provinsi', $request->provinsi)->orderBy('kab_kota')->orderBy('kecamatan')->orderBy('nama_sekolah')->get();
            $kabupaten = [];
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

    public function getKabupaten(Request $request)
    {
        $provinsi = $request->provinsi;
        $kabupaten = Sekolah::select('kab_kota')->distinct()->where('provinsi', $provinsi)->whereNotNull('kab_kota')->orderBy('kab_kota')->get();

        return response()->json($kabupaten);
    }

    public function getKecamatan(Request $request)
    {
        $kabupaten = $request->kabupaten;
        $kecamatan = Sekolah::select('kecamatan')->distinct()->where('kab_kota', $kabupaten)->whereNotNull('kecamatan')->orderBy('kecamatan')->get();

        return response()->json($kecamatan);
    }
}
