<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\r;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit', -1);
        $all_site = DB::table('4g_list_site')->select('*')->get();
        $all_outlet = DB::table('outlet_preference')->select('*')->get();
        $unit = 'kilometers';
        // ddd('aa');
        // dd($all_outlet);

        foreach ($all_outlet as $key => $outlet) {
            $match_site = [];
            foreach ($all_site as $key => $site) {
                $theta = floatval($outlet->longitude) - floatval($site->longitude);
                $distance = (sin(deg2rad(floatval($outlet->lattitude))) * sin(deg2rad(floatval($site->latitude)))) + (cos(deg2rad(floatval($outlet->lattitude))) * cos(deg2rad(floatval($site->latitude))) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = rad2deg($distance);
                $distance = $distance * 60 * 1.1515;
                switch ($unit) {
                    case 'miles':
                        break;
                    case 'kilometers':
                        $distance = $distance * 1.609344;
                }
                $jarak = (round($distance, 2));
                $match_site[$site->site_id] = $jarak;
                asort($match_site);
            }

            $outlet->site_id = array_key_first($match_site);
            $outlet->jarak = reset($match_site);
        }
        return view('outlet.index', compact('all_outlet'));
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
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function show(r $r)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function edit(r $r)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, r $r)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function destroy(r $r)
    {
        //
    }

    public function getSiteTerdekat()
    {
        $all_outlet = Outlet::all();
        $all_site = DB::table('4g_list_site')->select('*')->get();

        return $all_site;
    }
}
