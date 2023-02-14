<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
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
        return view('sales.migrasi.index', compact('sales', 'sales_cluster', 'sales_branch'));
    }

    public function migrasi(Request $request)
    {
        $update = DB::select('select max(date) as last_update from 4g_usim_all_trx;');
        if ($request->date) {
            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
            // ddd(date('Y-m-01', strtotime($this->convDate($mtd))));
            $last_mtd = $this->convDate($mtd);
            $where_branch = Auth::user()->privilege == "branch" ? "and branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "and b.cluster='" . Auth::user()->cluster . "'" : '');

            $query = "
            SELECT b.`cluster`, b.tap, b.nama,COUNT(b.id_digipos) as digipos,
            COUNT(CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_mtd
                        
                    FROM 4g_usim_all_trx a 
                    
                    INNER JOIN data_user b ON a.outlet_id=b.id_digipos
                    
                    WHERE a.status='MIGRATION_SUCCCESS' OR a.status='USIM_ACTIVE'
                    " . $where_branch . "
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
                    " . $where_branch . "
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
                    " . $where_branch . "
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
        return view('sales.migrasi.index', compact('sales', 'sales_cluster', 'sales_branch', 'update'));
    }

    public function orbit(Request $request)
    {
        $update = DB::select('select max(date) as last_update from sales_copy;');
        if ($request->date) {
            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
            $last_mtd = $this->convDate($mtd);
            $branch = Auth::user()->privilege == "branch" ? "branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "b.cluster='" . Auth::user()->cluster . "'" : '');
            $where = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "where" : "";
            $and = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "and" : "";

            $query_branch = "SELECT b.regional, b.branch ,c.status,
                    COUNT(CASE WHEN a.`date` BETWEEN '" . $m1 . "' AND '" . $mtd . "' THEN a.msisdn END) mtd,
                       COUNT(CASE WHEN a.`date` BETWEEN '" . $last_m1 . "' AND '" . $last_mtd . "' THEN a.msisdn END) last_mtd
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    LEFT JOIN validasi_orbit c on c.msisdn = a.msisdn
                    WHERE a.kategori='ORBIT'
                    " . $branch . "
                    GROUP BY 1,2,3;";

            $query_cluster = "SELECT b.cluster,c.status,
                    COUNT(CASE WHEN a.`date` BETWEEN '" . $m1 . "' AND '" . $mtd . "' THEN a.msisdn END) mtd,
                       COUNT(CASE WHEN a.`date` BETWEEN '" . $last_m1 . "' AND '" . $last_mtd . "' THEN a.msisdn END) last_mtd
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    LEFT JOIN validasi_orbit c on c.msisdn = a.msisdn
                    WHERE a.kategori='ORBIT'
                    " . $branch . "
                    GROUP BY 1,2;";

            $query = "SELECT b.nama,b.cluster,b.role,b.telp,b.reff_code, a.msisdn, c.status,a.`date`,a.serial,a.jenis,a.detail
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    LEFT JOIN validasi_orbit c on c.msisdn = a.msisdn
                    where a.date BETWEEN '" . $m1 . "' AND '" . $mtd . "'
                    and not a.status ='1' and a.kategori='ORBIT'
                    " . $and . "
                    " . $branch . "
                    ORDER by b.cluster, b.nama ASC";

            $sales_branch = DB::select($query_branch, [1]);
            $sales_cluster = DB::select($query_cluster, [1]);
            $sales = DB::select($query, [1]);
        } else {
            $sales_branch = [];
            $sales_cluster = [];
            $sales = [];
        }
        return view('sales.orbit.index', compact('sales_branch', 'sales_cluster', 'sales', 'update'));
    }

    public function destroy_orbit($msisdn)
    {
        $orbit = DB::table('sales_copy')->where('msisdn', $msisdn)->update([
            'status' => '1'
        ]);

        return back();
    }

    public function destroy_trade($msisdn)
    {
        $trade = DB::table('sales_copy')->where('msisdn', $msisdn)->update([
            'status' => '1'
        ]);

        return back();
    }

    public function digipos()
    {
        $branch = Auth::user()->privilege == 'branch' ? "WHERE a.branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == 'cluster' ? "WHERE a.cluster='" . Auth::user()->cluster . "'" : '');
        $query = "SELECT a.`cluster`,a.outlet_id,a.fisik,b.nama,b.role,
                SUM(omset_jun22) as omset_last_mtd,
                SUM(rech_reg_jun22) as rech_reg_last_mtd,
                SUM(rech_vas_jun22) as rech_vas_last_mtd,
                SUM(digital_jun22) as digital_last_mtd,
                SUM(cvm_jun22) as cvm_last_mtd,
                SUM(voice_jun22) as voice_last_mtd,
                SUM(nsb_jun22) as nsb_last_mtd,
                SUM(ketengan_jun22) as ketengan_last_mtd,

                SUM(omset_jul22) as omset_mtd,
                SUM(rech_reg_jul22) as rech_reg_mtd,
                SUM(rech_vas_jul22) as rech_vas_mtd,
                SUM(digital_jul22) as digital_mtd,
                SUM(cvm_jul22) as cvm_mtd,
                SUM(voice_jul22) as voice_mtd,
                SUM(nsb_jul22) as nsb_mtd,
                SUM(ketengan_jul22) as ketengan_mtd

                FROM `penjualan_digipos` a 
                INNER JOIN data_user b ON a.outlet_id=b.id_digipos
                " . $branch . "
                GROUP BY 1,2,3,4,5;";

        $query_branch = "SELECT a.region,a.branch,
            SUM(omset_jun22) as omset_last_mtd,
            SUM(rech_reg_jun22) as rech_reg_last_mtd,
            SUM(rech_vas_jun22) as rech_vas_last_mtd,
            SUM(digital_jun22) as digital_last_mtd,
            SUM(cvm_jun22) as cvm_last_mtd,
            SUM(voice_jun22) as voice_last_mtd,
            SUM(nsb_jun22) as nsb_last_mtd,
            SUM(ketengan_jun22) as ketengan_last_mtd,

            SUM(omset_jul22) as omset_mtd,
            SUM(rech_reg_jul22) as rech_reg_mtd,
            SUM(rech_vas_jul22) as rech_vas_mtd,
            SUM(digital_jul22) as digital_mtd,
            SUM(cvm_jul22) as cvm_mtd,
            SUM(voice_jul22) as voice_mtd,
            SUM(nsb_jul22) as nsb_mtd,
            SUM(ketengan_jul22) as ketengan_mtd

            FROM `penjualan_digipos` a 
            INNER JOIN data_user b ON a.outlet_id=b.id_digipos
            " . $branch . "
            GROUP BY 1,2;";

        $query_cluster = "SELECT a.cluster,
            SUM(omset_jun22) as omset_last_mtd,
            SUM(rech_reg_jun22) as rech_reg_last_mtd,
            SUM(rech_vas_jun22) as rech_vas_last_mtd,
            SUM(digital_jun22) as digital_last_mtd,
            SUM(cvm_jun22) as cvm_last_mtd,
            SUM(voice_jun22) as voice_last_mtd,
            SUM(nsb_jun22) as nsb_last_mtd,
            SUM(ketengan_jun22) as ketengan_last_mtd,

            SUM(omset_jul22) as omset_mtd,
            SUM(rech_reg_jul22) as rech_reg_mtd,
            SUM(rech_vas_jul22) as rech_vas_mtd,
            SUM(digital_jul22) as digital_mtd,
            SUM(cvm_jul22) as cvm_mtd,
            SUM(voice_jul22) as voice_mtd,
            SUM(nsb_jul22) as nsb_mtd,
            SUM(ketengan_jul22) as ketengan_mtd

            FROM `penjualan_digipos` a 
            INNER JOIN data_user b ON a.outlet_id=b.id_digipos
            WHERE a.branch='JAMBI'
            GROUP BY 1;";

        $sales = DB::select($query);
        $sales_branch = DB::select($query_branch);
        $sales_cluster = DB::select($query_cluster);

        foreach ($sales as $key => $data) {
            $data->omset_mom = $this->persen($data->omset_last_mtd, $data->omset_mtd);
            $data->rech_reg_mom = $this->persen($data->rech_reg_last_mtd, $data->rech_reg_mtd);
            $data->rech_vas_mom = $this->persen($data->rech_vas_last_mtd, $data->rech_vas_mtd);
            $data->digital_mom = $this->persen($data->digital_last_mtd, $data->digital_mtd);
            $data->cvm_mom = $this->persen($data->cvm_last_mtd, $data->cvm_mtd);
            $data->voice_mom = $this->persen($data->voice_last_mtd, $data->voice_mtd);
            $data->nsb_mom = $this->persen($data->nsb_last_mtd, $data->nsb_mtd);
            $data->ketengan_mom = $this->persen($data->ketengan_last_mtd, $data->ketengan_mtd);
        }

        foreach ($sales_branch as $key => $data) {
            $data->omset_mom = $this->persen($data->omset_last_mtd, $data->omset_mtd);
            $data->rech_reg_mom = $this->persen($data->rech_reg_last_mtd, $data->rech_reg_mtd);
            $data->rech_vas_mom = $this->persen($data->rech_vas_last_mtd, $data->rech_vas_mtd);
            $data->digital_mom = $this->persen($data->digital_last_mtd, $data->digital_mtd);
            $data->cvm_mom = $this->persen($data->cvm_last_mtd, $data->cvm_mtd);
            $data->voice_mom = $this->persen($data->voice_last_mtd, $data->voice_mtd);
            $data->nsb_mom = $this->persen($data->nsb_last_mtd, $data->nsb_mtd);
            $data->ketengan_mom = $this->persen($data->ketengan_last_mtd, $data->ketengan_mtd);
        }

        foreach ($sales_cluster as $key => $data) {
            $data->omset_mom = $this->persen($data->omset_last_mtd, $data->omset_mtd);
            $data->rech_reg_mom = $this->persen($data->rech_reg_last_mtd, $data->rech_reg_mtd);
            $data->rech_vas_mom = $this->persen($data->rech_vas_last_mtd, $data->rech_vas_mtd);
            $data->digital_mom = $this->persen($data->digital_last_mtd, $data->digital_mtd);
            $data->cvm_mom = $this->persen($data->cvm_last_mtd, $data->cvm_mtd);
            $data->voice_mom = $this->persen($data->voice_last_mtd, $data->voice_mtd);
            $data->nsb_mom = $this->persen($data->nsb_last_mtd, $data->nsb_mtd);
            $data->ketengan_mom = $this->persen($data->ketengan_last_mtd, $data->ketengan_mtd);
        }

        return view('sales.digipos.index', compact('sales', 'sales_branch', 'sales_cluster'));
    }

    public function trade(Request $request)
    {
        $update = DB::select('select max(date) as last_update from sales_copy;');
        if ($request->date) {
            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
            $last_mtd = $this->convDate($mtd);
            $branch = Auth::user()->privilege == "branch" ? "branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "b.cluster='" . Auth::user()->cluster . "'" : '');
            $where = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "where" : "";
            $and = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "and" : "";

            $query_branch = "SELECT b.regional, b.branch ,
                    COUNT(CASE WHEN a.`date` BETWEEN '" . $m1 . "' AND '" . $mtd . "' THEN a.msisdn END) mtd,
                       COUNT(CASE WHEN a.`date` BETWEEN '" . $last_m1 . "' AND '" . $last_mtd . "' THEN a.msisdn END) last_mtd
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    WHERE a.kategori='TRADE IN'
                    " . $branch . "
                    GROUP BY 1,2;";

            $query_cluster = "SELECT b.cluster,
                    COUNT(CASE WHEN a.`date` BETWEEN '" . $m1 . "' AND '" . $mtd . "' THEN a.msisdn END) mtd,
                       COUNT(CASE WHEN a.`date` BETWEEN '" . $last_m1 . "' AND '" . $last_mtd . "' THEN a.msisdn END) last_mtd
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    WHERE a.kategori='TRADE IN'
                    " . $branch . "
                    GROUP BY 1;";

            $query = "SELECT b.nama,b.cluster,b.role,b.telp,b.reff_code, a.msisdn,a.`date`,a.serial,a.jenis,a.detail
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    where a.date BETWEEN '" . $m1 . "' AND '" . $mtd . "'
                    and not a.status ='1' and a.kategori='TRADE IN'
                    " . $and . "
                    " . $branch . "
                    ORDER by b.cluster, b.nama ASC";

            $sales_branch = DB::select($query_branch, [1]);
            $sales_cluster = DB::select($query_cluster, [1]);
            $sales = DB::select($query, [1]);
        } else {
            $sales_branch = [];
            $sales_cluster = [];
            $sales = [];
        }
        return view('sales.trade.index', compact('sales_branch', 'sales_cluster', 'sales', 'update'));
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
