<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->date) {
            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime('-1 month', strtotime($request->date)));
            $last_mtd = $this->convDate($mtd);
            $query = "
            SELECT b.`cluster`, b.tap, b.nama,COUNT(b.id_digipos) as digipos,
            COUNT(CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_mtd
                        
                    FROM 4g_usim_all_trx a 
                    
                    INNER JOIN data_user b ON a.outlet_id=b.id_digipos
                    
                    WHERE a.status='MIGRATION_SUCCCESS' OR a.status='USIM_ACTIVE'
                    GROUP BY 1,2,3
                    ORDER BY 1,2,3;
            ";

            $query_cluster = "
            SELECT b.`cluster`,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) ds_mtd,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_ds_mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_mtd
                        
                    FROM 4g_usim_all_trx a 
                    
                    INNER JOIN data_user b ON a.outlet_id=b.id_digipos
                    
                    WHERE a.status='MIGRATION_SUCCCESS' OR a.status='USIM_ACTIVE'
                    GROUP BY 1;";

            $query_branch = "
            SELECT b.regional,b.branch,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) ds_mtd,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_ds_mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_mtd
                        
                    FROM 4g_usim_all_trx a 
                    
                    INNER JOIN data_user b ON a.outlet_id=b.id_digipos
                    
                    WHERE a.status='MIGRATION_SUCCCESS' OR a.status='USIM_ACTIVE'
                    GROUP BY 1,2;";

            $sales = DB::select($query, [1]);
            $sales_cluster = DB::select($query_cluster, [1]);
            $sales_branch = DB::select($query_branch, [1]);

            foreach ($sales as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
            }

            foreach ($sales_cluster as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
                $data->ds_mom = $this->persen($data->last_ds_mtd, $data->ds_mtd);
            }

            foreach ($sales_branch as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
                $data->ds_mom = $this->persen($data->last_ds_mtd, $data->ds_mtd);
            }
        } else {
            $sales = [];
            $sales_cluster = [];
            $sales_branch = [];
        }
        // ddd($sales);
        return view('sales.index', compact('sales', 'sales_cluster', 'sales_branch'));
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

    public function convDate($tanggal)
    {
        $now = date("Y-m-d", strtotime($tanggal));
        $hari = date("d", strtotime($now));
        $last = date("Y-m-t", strtotime($now));

        if ($last == $tanggal) {
            return date(
                "Y-m-d",
                strtotime($tanggal . "last day of previous month")
            );
        } else {
            if ($hari > 28 && date("m", strtotime($now)) == 3) {
                return date(
                    "Y-m-d",
                    strtotime($tanggal . "last day of previous month")
                );
            } else {
                return date("Y-m-d", strtotime($now . "-1 Months"));
            }
        }
    }

    function convertBil($bilangan, $pow = 6)
    {
        if ($bilangan < pow(10, 9) && $bilangan >= pow(10, 6)) {
            $res = $bilangan / pow(10, $pow);
            return number_format($res, 2, ",", ".");
        } elseif ($bilangan < pow(10, 6) && $bilangan >= pow(10, 3)) {
            $res = $bilangan / pow(10, $pow);
            return number_format($res, 2, ",", ".");
        } else {
            $res = $bilangan / pow(10, $pow);
            return number_format($res, 2, ",", ".");
        }
    }

    function persen($var1, $var2)
    {
        if ($var1 != 0) {
            $persen = round(($var2 / $var1 - 1) * 100, 2);
            return number_format($persen, 2, ",", ".");
        } else {
            $var1 = 1;
            $persen = round(($var2 / $var1 - 1) * 100, 2);
            return number_format($persen, 2, ",", ".");
        }
    }
}
