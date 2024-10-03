<?php

namespace App\Http\Controllers;

use App\Rules\MsisdnNumber;
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
                $data->outlet_mom = $this->persen($data->last_mtd - $data->last_ds_mtd, $data->mtd - $data->ds_mtd);
            }

            foreach ($sales_branch as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
                $data->ds_mom = $this->persen($data->last_ds_mtd, $data->ds_mtd);
                $data->outlet_mom = $this->persen($data->last_mtd - $data->last_ds_mtd, $data->mtd - $data->ds_mtd);
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

        $sales_area = [];

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
                    
                    WHERE a.status IN ('USIM_ACTIVE','MIGRATION_SUCCESS')
                    AND a.date BETWEEN '$last_m1' AND '$mtd'
                    " . $where_branch . "
                    GROUP BY 1,2,3
                    ORDER BY 1,2,3;
            ";

            $query_cluster = "
            SELECT a.`cluster`,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) ds_mtd,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_ds_mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_mtd
                        
                    FROM 4g_usim_all_trx a 
                    WHERE a.status IN ('USIM_ACTIVE','MIGRATION_SUCCESS')
                    and a.regional IN ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')
                    AND a.date BETWEEN '$last_m1' AND '$mtd'
                    " . $where_branch . "
                    GROUP BY 1;";

            $query_branch = "
            SELECT c.regional,c.branch,
            COUNT(DISTINCT CASE WHEN c.date BETWEEN '$m1' and '$mtd' then c.outlet_id end) ds_mtd,
            COUNT(DISTINCT CASE WHEN c.date BETWEEN '$last_m1' and '$last_mtd' then c.outlet_id end) last_ds_mtd,
            COUNT(CASE WHEN c.date BETWEEN '$m1' and '$mtd' then c.outlet_id end) mtd,
            COUNT(CASE WHEN c.date BETWEEN '$last_m1' and '$last_mtd' then c.outlet_id end) last_mtd
            
            from (
            SELECT a.regional,b.branch,a.`cluster`,a.date,a.outlet_id,a.status 
            FROM `4g_usim_all_trx` a 
            INNER JOIN territory_new b ON a.`cluster`=b.`cluster`
            WHERE a.status IN ('USIM_ACTIVE','MIGRATION_SUCCESS')            
        	and a.regional IN ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')      
            AND a.date BETWEEN '2023-09-01' AND '2023-10-18'
            $where_branch
            GROUP BY 1,2,3,4,5,6
            )c
                
            GROUP BY 1,2
            ORDER BY 1 DESC,2;";

            $query_region = "
            SELECT a.regional,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) ds_mtd,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_ds_mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_mtd
                        
                    FROM 4g_usim_all_trx a 

                    WHERE a.status IN ('USIM_ACTIVE','MIGRATION_SUCCESS')
                    and a.regional IN ('SUMBAGUT','SUMBAGTENG','SUMBAGSEL')
                    AND a.date BETWEEN '$last_m1' AND '$mtd'

                    " . $where_branch . "
                    GROUP BY 1
                    ORDER BY 1 DESC;";


            $query_full = "
            SELECT b.regional,b.branch,b.cluster,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) ds_mtd,
            COUNT(DISTINCT CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_ds_mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $m1 . "' and '" . $mtd . "' then outlet_id end) mtd,
            COUNT(CASE WHEN a.date BETWEEN '" . $last_m1 . "' and '" . $last_mtd . "' then outlet_id end) last_mtd
                
            FROM 4g_usim_all_trx a 
            
            JOIN territory_new b ON a.`cluster`=b.`cluster`
            
            WHERE a.status='MIGRATION_SUCCCESS' OR a.status='USIM_ACTIVE'
            " . $where_branch . "
            GROUP BY 1,2,3
            ORDER BY 1 DESC,2,3;";
            // ddd($query_full);

            $sales = DB::select($query, [1]);
            $sales_cluster = DB::select($query_cluster, [1]);
            // ddd(array_keys((array)$sales_cluster[0]));
            $sales_branch = DB::select($query_branch, [1]);
            $sales_region = DB::select($query_region, [1]);
            $sales_full = DB::select($query_full, [1]);

            foreach ($sales as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
            }

            foreach ($sales_cluster as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
                $data->ds_mom = $this->persen($data->last_ds_mtd, $data->ds_mtd);
                $data->outlet_mom = $this->persen($data->last_mtd - $data->last_ds_mtd, $data->mtd - $data->ds_mtd);
            }

            foreach ($sales_branch as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
                $data->ds_mom = $this->persen($data->last_ds_mtd, $data->ds_mtd);
                $data->outlet_mom = $this->persen($data->last_mtd - $data->last_ds_mtd, $data->mtd - $data->ds_mtd);
            }

            foreach ($sales_region as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
                $data->ds_mom = $this->persen($data->last_ds_mtd, $data->ds_mtd);
                $data->outlet_mom = $this->persen($data->last_mtd - $data->last_ds_mtd, $data->mtd - $data->ds_mtd);

                foreach ($data as $key => $d) {
                    if (is_numeric($d)) {
                        if (!isset($sales_area[$key])) $sales_area[$key] = 0;
                        $sales_area[$key] += $d;
                    }
                }
            }

            $sales_area['mom'] = $this->persen($sales_area['last_mtd'], $sales_area['mtd']);
            $sales_area['ds_mom'] = $this->persen($sales_area['last_ds_mtd'], $sales_area['ds_mtd']);
            $sales_area['outlet_mom'] = $this->persen($sales_area['last_mtd'] - $sales_area['last_ds_mtd'], $sales_area['mtd'] - $sales_area['ds_mtd']);
            // ddd($sales_area);
            $sales_area = (object)$sales_area;
            foreach ($sales_full as $key => $data) {
                $data->mom = $this->persen($data->last_mtd, $data->mtd);
                $data->ds_mom = $this->persen($data->last_ds_mtd, $data->ds_mtd);
                $data->outlet_mom = $this->persen($data->last_mtd - $data->last_ds_mtd, $data->mtd - $data->ds_mtd);
            }
        } else {
            $sales = [];
            $sales_cluster = [];
            $sales_branch = [];
            $sales_region = [];
            $sales_full = [];
        }
        return view('sales.migrasi.index', compact('sales', 'sales_cluster', 'sales_branch', 'sales_region', 'sales_area', 'sales_full', 'update'));
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
                    $and
                    $branch
                    GROUP BY 1,2,3;";

            $query_cluster = "SELECT b.cluster,c.status,
                    COUNT(CASE WHEN a.`date` BETWEEN '" . $m1 . "' AND '" . $mtd . "' THEN a.msisdn END) mtd,
                    COUNT(CASE WHEN a.`date` BETWEEN '" . $last_m1 . "' AND '" . $last_mtd . "' THEN a.msisdn END) last_mtd
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    LEFT JOIN validasi_orbit c on c.msisdn = a.msisdn
                    WHERE a.kategori='ORBIT'
                    $and
                    $branch
                    GROUP BY 1,2;";

            $query = "SELECT b.nama,b.cluster,b.role,b.telp,b.reff_code, a.msisdn, c.status,a.`date`,a.serial,a.jenis,a.detail
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    LEFT JOIN validasi_orbit c on c.msisdn = a.msisdn
                    where a.date BETWEEN '" . $m1 . "' AND '" . $mtd . "'
                    and not a.status ='1' and a.kategori='ORBIT'
                    $and
                    $branch
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


    public function orbit_digipos(Request $request)
    {
        $update = DB::select('select max(so_date) as last_update from orbit_digipos;');
        if ($request->date) {
            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
            $last_mtd = $this->convDate($mtd);
            $branch = Auth::user()->privilege == "branch" ? "branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "b.cluster='" . Auth::user()->cluster . "'" : '');
            $where = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "where " : "";
            $and = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "and" : "";

            $query_branch = "SELECT b.regional, b.branch ,
                    COUNT(CASE WHEN a.`so_date` BETWEEN '$m1' AND '$mtd' THEN a.msisdn END) mtd,
                    COUNT(CASE WHEN a.`so_date` BETWEEN '$last_m1' AND '$last_mtd' THEN a.msisdn END) last_mtd
                    FROM orbit_digipos a  
                    JOIN data_user b ON b.id_digipos = a.outlet_id
                    $where
                    $branch
                    GROUP BY 1,2
                    ORDER BY 1 DESC,2;";

            $query_cluster = "SELECT b.branch, b.cluster ,
                    COUNT(CASE WHEN a.`so_date` BETWEEN '$m1' AND '$mtd' THEN a.msisdn END) mtd,
                    COUNT(CASE WHEN a.`so_date` BETWEEN '$last_m1' AND '$last_mtd' THEN a.msisdn END) last_mtd
                    FROM orbit_digipos a  
                    JOIN data_user b ON b.id_digipos = a.outlet_id
                    $where
                    $branch
                    GROUP BY 1,2
                    ORDER BY 1,2;";

            $query = "SELECT b.nama,b.cluster,b.role,b.telp,b.reff_code, a.msisdn,a.so_date,a.imei
                    FROM orbit_digipos a  
                    JOIN data_user b ON b.id_digipos = a.outlet_id
                    where a.so_date BETWEEN '$m1' AND '$mtd'
                    $and
                    $branch
                    ORDER by b.cluster, b.nama ASC";

            $sales_branch = DB::select($query_branch, [1]);
            $sales_cluster = DB::select($query_cluster, [1]);
            $sales = DB::select($query, [1]);
        } else {
            $sales_branch = [];
            $sales_cluster = [];
            $sales = [];
        }
        return view('sales.orbit_digipos.index', compact('sales_branch', 'sales_cluster', 'sales', 'update'));
    }

    public function destroy_orbit($msisdn)
    {
        $orbit = DB::table('sales_copy')->where('msisdn', $msisdn)->update([
            'status' => '1'
        ]);

        return back();
    }

    public function destroy_product($msisdn)
    {
        $trade = DB::table('sales_copy')->where('msisdn', $msisdn)->update([
            'status' => '1'
        ]);

        return back();
    }

    public function digipos_old()
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

    public function digipos(Request $request)
    {
        // $list_trx_type = DB::table('trx_digipos_ds_2024')->select('trx_type')->distinct()->get();
        $list_trx_type = [
            (object)['trx_type' => 'BYU'],
            (object)['trx_type' => 'DATA'],
            (object)['trx_type' => 'DIGITAL'],
            (object)['trx_type' => 'EXTENSION'],
            (object)['trx_type' => 'ORBIT'],
            (object)['trx_type' => 'ROAMING'],
            (object)['trx_type' => 'VOICE_SMS'],
        ];

        $sales = [];
        $sales_branch = [];
        $sales_cluster = [];

        if ($request->date) {
            $territory = Auth::user()->privilege == 'branch' ? " AND branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == 'cluster' ? " AND cluster='" . Auth::user()->cluster . "'" : '');
            $trx_type = $request->trx_type != "ALL" ? ' AND trx_type like "%' . $request->trx_type . '%"' : '';

            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
            $last_mtd = $this->convDate($mtd);

            if ($request->trx_type == "DIGITAL") {
                $query = "SELECT digipos_ao,nama_ao,branch,cluster,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_DTU' THEN price ELSE 0 END) m1_dtu,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_DTU' THEN price ELSE 0 END) mtd_dtu,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_GAME' THEN price ELSE 0 END) m1_game,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_GAME' THEN price ELSE 0 END) mtd_game,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_MUSIC' THEN price ELSE 0 END) m1_music,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_MUSIC' THEN price ELSE 0 END) mtd_music,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_OTHER' THEN price ELSE 0 END) m1_other,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_OTHER' THEN price ELSE 0 END) mtd_other,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_VIDEO' THEN price ELSE 0 END) m1_video,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_VIDEO' THEN price ELSE 0 END) mtd_video
                    FROM trx_digipos_ds_2024 
                    JOIN data_user
                    ON data_user.id_digipos=trx_digipos_ds_2024.digipos_ao
                    WHERE event_date BETWEEN '$last_m1' AND '$mtd'
                    $trx_type
                    $territory
                    GROUP BY 1,2,3,4
                    ORDER BY 3,4,2;";

                $query_branch = "SELECT branch,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_DTU' THEN price ELSE 0 END) m1_dtu,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_DTU' THEN price ELSE 0 END) mtd_dtu,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_GAME' THEN price ELSE 0 END) m1_game,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_GAME' THEN price ELSE 0 END) mtd_game,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_MUSIC' THEN price ELSE 0 END) m1_music,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_MUSIC' THEN price ELSE 0 END) mtd_music,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_OTHER' THEN price ELSE 0 END) m1_other,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_OTHER' THEN price ELSE 0 END) mtd_other,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_VIDEO' THEN price ELSE 0 END) m1_video,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_VIDEO' THEN price ELSE 0 END) mtd_video
                    FROM trx_digipos_ds_2024 
                    JOIN data_user
                    ON data_user.id_digipos=trx_digipos_ds_2024.digipos_ao
                    WHERE event_date BETWEEN '$last_m1' AND '$mtd'
                    $trx_type
                    $territory
                    GROUP BY 1
                    ORDER BY 1;";

                $query_cluster = "SELECT cluster,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_DTU' THEN price ELSE 0 END) m1_dtu,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_DTU' THEN price ELSE 0 END) mtd_dtu,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_GAME' THEN price ELSE 0 END) m1_game,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_GAME' THEN price ELSE 0 END) mtd_game,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_MUSIC' THEN price ELSE 0 END) m1_music,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_MUSIC' THEN price ELSE 0 END) mtd_music,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_OTHER' THEN price ELSE 0 END) m1_other,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_OTHER' THEN price ELSE 0 END) mtd_other,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' AND trx_type='DIGITAL_VIDEO' THEN price ELSE 0 END) m1_video,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL_VIDEO' THEN price ELSE 0 END) mtd_video
                    FROM trx_digipos_ds_2024 
                    JOIN data_user
                    ON data_user.id_digipos=trx_digipos_ds_2024.digipos_ao
                    WHERE event_date BETWEEN '$last_m1' AND '$mtd'
                    $trx_type
                    $territory
                    GROUP BY 1
                    ORDER BY 1;";
            } else {
                $query = "SELECT digipos_ao,nama_ao,branch,cluster,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' THEN price ELSE 0 END) m1,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' THEN price ELSE 0 END) mtd
                    FROM trx_digipos_ds_2024 
                    JOIN data_user
                    ON data_user.id_digipos=trx_digipos_ds_2024.digipos_ao
                    WHERE event_date BETWEEN '$last_m1' AND '$mtd'
                    $trx_type
                    $territory
                    GROUP BY 1,2,3,4
                    ORDER BY 3,4,2;";

                $query_branch = "SELECT branch,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' THEN price ELSE 0 END) m1,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' THEN price ELSE 0 END) mtd
                    FROM trx_digipos_ds_2024 
                    JOIN data_user
                    ON data_user.id_digipos=trx_digipos_ds_2024.digipos_ao
                    WHERE event_date BETWEEN '$last_m1' AND '$mtd'
                    $trx_type
                    $territory
                    GROUP BY 1
                    ORDER BY 1;";

                $query_cluster = "SELECT cluster,
                    SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' THEN price ELSE 0 END) m1,
                    SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' THEN price ELSE 0 END) mtd
                    FROM trx_digipos_ds_2024 
                    JOIN data_user
                    ON data_user.id_digipos=trx_digipos_ds_2024.digipos_ao
                    WHERE event_date BETWEEN '$last_m1' AND '$mtd'
                    $trx_type
                    $territory
                    GROUP BY 1
                    ORDER BY 1;";
            }

            $sales = DB::select($query);
            $sales_branch = DB::select($query_branch);
            $sales_cluster = DB::select($query_cluster);
        }

        return view('sales.digipos.index', compact('sales', 'sales_branch', 'sales_cluster', 'list_trx_type'));
    }

    public function product(Request $request)
    {
        ini_set("max_execution_time", "0");

        $update = DB::select('select max(date) as last_update from sales_copy;');
        $last_validasi = DB::select('select max(tanggal) as tanggal from validasi_mytsel;');
        $list_kategori = DB::table('kategori_produk')->select('jenis_produk as kategori')->whereNotIn('jenis_produk', ['', 'ORBIT', 'MY TELKOMSEL'])->whereNotNull('jenis_produk')->distinct()->get();
        $list_kategori->push((object)['kategori' => 'MYTSEL ENTRY'], (object)['kategori' => 'MYTSEL VALIDASI']);

        $list_regional = DB::table('territory_new')->select('regional')->distinct()->orderBy('regional')->get();
        $list_branch = DB::table('territory_new')->select('branch')->distinct()->orderBy('branch')->get();

        $kategori = $request->kategori;
        $select_mytsel = $kategori == 'MYTSEL VALIDASI' ? ",c.revenue" : '';
        $join_mytsel = $kategori == 'MYTSEL VALIDASI' ? " JOIN validasi_mytsel c ON a.msisdn=c.msisdn" : '';
        $sum_mytsel = $kategori == 'MYTSEL VALIDASI' ? " ,SUM(CASE WHEN c.revenue!='NULL' THEN c.revenue ELSE 0 END) revenue" : '';

        if ($request->date && $kategori) {
            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
            $last_mtd = $this->convDate($mtd);
            $kategori = in_array($kategori, ['MYTSEL ENTRY', 'MYTSEL VALIDASI'])  ? 'MY TELKOMSEL' : $kategori;

            if ($request->regional) {
                $regional = "regional='" . $request->regional . "'";
                $and = "and ";
            } else {
                $regional = "";
                $and = "";
            }

            if ($request->branch) {
                $branch = "branch='" . $request->branch . "'";
                $and_branch = "and ";
            } else {
                $branch = Auth::user()->privilege == "branch" ? "branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "b.cluster='" . Auth::user()->cluster . "'" : '');
                $where = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "where" : "";
                $and_branch = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "and" : "";
            }

            $query_branch = "SELECT b.regional, b.branch ,
                    COUNT(CASE WHEN a.`date` BETWEEN '$m1' AND '$mtd' THEN a.msisdn END) mtd,
                    COUNT(CASE WHEN a.`date` BETWEEN '$last_m1' AND '$last_mtd' THEN a.msisdn END) last_mtd
                    $sum_mytsel
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    $join_mytsel
                    WHERE a.kategori='$kategori' 
                    AND a.date BETWEEN '$last_m1' AND '$mtd' AND b.status='1'
                    $and
                    $regional
                    $and_branch
                    $branch
                    GROUP BY 1,2
                    ORDER by 1 DESC,2;";

            $query_cluster = "SELECT b.cluster,
                    COUNT(CASE WHEN a.`date` BETWEEN '$m1' AND '$mtd' THEN a.msisdn END) mtd,
                    COUNT(CASE WHEN a.`date` BETWEEN '$last_m1' AND '$last_mtd' THEN a.msisdn END) last_mtd
                    $sum_mytsel
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    $join_mytsel
                    WHERE a.kategori='$kategori'
                AND a.date BETWEEN '$last_m1' AND '$mtd' AND b.status='1'
                    $and
                    $regional
                    $and_branch
                    $branch
                    GROUP BY 1 ;";


            // $query = "SELECT b.nama,b.branch,b.cluster,b.role,b.telp,b.reff_code, a.msisdn,a.`date`,a.serial,a.poi,a.jenis,a.detail $select_mytsel
            //         FROM sales_copy a  
            //         JOIN data_user b ON b.telp = a.telp
            //         $join_mytsel
            //         where a.date BETWEEN '$m1' AND '$mtd'
            //         and not a.status ='1' and a.kategori='$kategori' AND b.status='1'
            //         $and
            //         $regional
            //         $and_branch
            //         $branch
            //         ORDER by b.regional DESC,b.branch,b.cluster, b.nama ASC";

            $sales_branch = DB::select($query_branch, [1]);
            $sales_cluster = DB::select($query_cluster, [1]);
            // $sales = DB::select($query, [1]);
            $sales = DB::table('sales_copy as a')
                ->select(
                    'b.nama',
                    'b.branch',
                    'b.cluster',
                    'b.role',
                    'b.telp',
                    'b.reff_code',
                    'a.msisdn',
                    'a.date',
                    'a.serial',
                    'a.poi',
                    'a.jenis',
                    'a.detail',
                    'd.*'
                )
                ->join('data_user as b', 'b.telp', '=', 'a.telp')
                ->leftJoin('kode_prefix_operator as d', function ($join) {
                    $join->on(
                        DB::raw("CASE 
                              WHEN LEFT(a.serial, 1) = '0' THEN SUBSTRING(a.serial, 1, 4) 
                              WHEN LEFT(a.serial, 1) = '6' THEN SUBSTRING(a.serial, 3, 3) 
                            END"),
                        '=',
                        DB::raw("CASE 
                                WHEN LEFT(a.serial, 1) = '0' THEN d.kode_prefix
                                WHEN LEFT(a.serial, 1) = '6' THEN SUBSTRING(d.kode_prefix, 2, 3)
                            END")
                    );
                })
                ->whereBetween('a.date', [$m1, $mtd])
                ->where('a.status', '<>', '1')
                ->where('a.kategori', $kategori)
                ->where('b.status', '1')
                ->orderByDesc('b.regional')
                ->orderBy('b.branch')
                ->orderBy('b.cluster')
                ->orderBy('b.nama');

            if ($request->kategori == 'MYTSEL VALIDASI') {
                $sales = $sales->select('c.revenue', "SUM(CASE WHEN c.revenue!='NULL' THEN c.revenue ELSE 0 END) revenue")->join('validasi_mytsel as c', 'a.msisdn', '=', 'c.msisdn');
            }

            $sales->when($request->regional, function ($q) use ($request) {
                return $q->where('regional', $request->regional);
            });

            $sales->when($request->branch, function ($q) use ($request) {
                return $q->where('branch', $request->branch);
            });

            $sales->when(auth()->user()->privilege == 'branch', function ($q) use ($regional) {
                return $q->where('b.branch', auth()->user()->branch);
            });

            $sales->when(auth()->user()->privilege == 'cluster', function ($q) use ($branch) {
                return $q->where('b.cluster', auth()->user()->cluster);
            });

            $sales = $sales->paginate(500)->appends($request->query());
        } else {
            $sales_branch = [];
            $sales_cluster = [];
            $sales = [];
        }
        return view('sales.product.index', compact('list_kategori', 'list_regional', 'list_branch', 'sales_branch', 'sales_cluster', 'sales', 'update', 'last_validasi'));
    }

    public function exportProduct(Request $request)
    {
        ini_set("max_execution_time", "0");

        $kategori = $request->kategori;
        $select_mytsel = $kategori == 'MYTSEL VALIDASI' ? ",c.revenue" : '';
        $join_mytsel = $kategori == 'MYTSEL VALIDASI' ? " JOIN validasi_mytsel c ON a.msisdn=c.msisdn" : '';
        $sum_mytsel = $kategori == 'MYTSEL VALIDASI' ? " ,SUM(CASE WHEN c.revenue!='NULL' THEN c.revenue ELSE 0 END) revenue" : '';

        if ($request->date && $kategori) {
            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
            $last_mtd = $this->convDate($mtd);
            $kategori = in_array($kategori, ['MYTSEL ENTRY', 'MYTSEL VALIDASI'])  ? 'MY TELKOMSEL' : $kategori;

            if ($request->regional) {
                $regional = "regional='" . $request->regional . "'";
                $and = "and ";
            } else {
                $regional = "";
                $and = "";
            }

            if ($request->branch) {
                $branch = "branch='" . $request->branch . "'";
                $and_branch = "and ";
            } else {
                $branch = Auth::user()->privilege == "branch" ? "branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "b.cluster='" . Auth::user()->cluster . "'" : '');
                $where = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "where" : "";
                $and_branch = Auth::user()->privilege == "branch" || Auth::user()->privilege == "cluster" ? "and" : "";
            }

            $sales = DB::table('sales_copy as a')
                ->select(
                    'b.nama',
                    'b.branch',
                    'b.cluster',
                    'b.role',
                    'b.telp',
                    'b.reff_code',
                    'a.msisdn',
                    'a.date',
                    'a.serial',
                    'a.poi',
                    'a.jenis',
                    'a.detail',
                    'd.*'
                )
                ->join('data_user as b', 'b.telp', '=', 'a.telp')
                ->leftJoin('kode_prefix_operator as d', function ($join) {
                    $join->on(
                        DB::raw("CASE 
                              WHEN LEFT(a.serial, 1) = '0' THEN SUBSTRING(a.serial, 1, 4) 
                              WHEN LEFT(a.serial, 1) = '6' THEN SUBSTRING(a.serial, 3, 3) 
                            END"),
                        '=',
                        DB::raw("CASE 
                                WHEN LEFT(a.serial, 1) = '0' THEN d.kode_prefix
                                WHEN LEFT(a.serial, 1) = '6' THEN SUBSTRING(d.kode_prefix, 2, 3)
                            END")
                    );
                })
                ->whereBetween('a.date', [$m1, $mtd])
                ->where('a.status', '<>', '1')
                ->where('a.kategori', $kategori)
                ->where('b.status', '1')
                ->orderByDesc('b.regional')
                ->orderBy('b.branch')
                ->orderBy('b.cluster')
                ->orderBy('b.nama');

            if ($request->kategori == 'MYTSEL VALIDASI') {
                $sales = $sales->select('c.revenue', "SUM(CASE WHEN c.revenue!='NULL' THEN c.revenue ELSE 0 END) revenue")->join('validasi_mytsel as c', 'a.msisdn', '=', 'c.msisdn');
            }

            $sales->when($request->regional, function ($q) use ($request) {
                return $q->where('regional', $request->regional);
            });

            $sales->when($request->branch, function ($q) use ($request) {
                return $q->where('branch', $request->branch);
            });

            $sales->when(auth()->user()->privilege == 'branch', function ($q) use ($regional) {
                return $q->where('b.branch', auth()->user()->branch);
            });

            $sales->when(auth()->user()->privilege == 'cluster', function ($q) use ($branch) {
                return $q->where('b.cluster', auth()->user()->cluster);
            });

            $sales = $sales->get();
        } else {
            $sales = [];
        }


        return response()->json($sales);
    }

    public function location(Request $request)
    {
        $list_jenis = DB::table('kategori_sales')->select('jenis_sales as jenis')->where('status', 1)->distinct()->get();
        $list_location = DB::table('sales_copy')->select(['poi as location'])->whereIn('jenis', ['EVENT', 'SEKOLAH', 'U60', 'ORBIT'])->whereNotNull('poi')->where('poi', '!=', '')->distinct()->orderBy('poi')->join('data_user', 'sales_copy.telp', '=', 'data_user.telp');

        if (auth()->user()->privilege == 'branch') {
            $list_location->where('data_user.branch', auth()->user()->branch);
        } else if (auth()->user()->privilege == 'cluster') {
            $list_location->where('data_user.cluster', auth()->user()->cluster);
        }
        $list_location = $list_location->get();

        $jenis = $request->jenis;
        $location = $request->location ? " and a.poi='$request->location'" : '';

        if ($request->date) {
            $m1 = date('Y-m-01', strtotime($request->date));
            $mtd = date('Y-m-d', strtotime($request->date));
            $last_m1 = date('Y-m-01', strtotime($this->convDate($mtd)));
            $last_mtd = $this->convDate($mtd);

            if (auth()->user()->privilege != 'superadmin') {
                $territory = auth()->user()->privilege == 'branch' ? " and b.branch='" . auth()->user()->branch . "'" : " and b.cluster='" . auth()->user()->cluster . "'";
            } else {
                $territory = '';
            }

            // $query_kategori = "SELECT a.date,a.kategori,
            //         COUNT(CASE WHEN a.`date` BETWEEN '$m1' AND '$mtd' THEN a.msisdn END) mtd
            //         FROM sales_copy a  
            //         WHERE a.date BETWEEN '$m1' AND '$mtd'
            //         $location
            //         GROUP BY 1,2  ORDER BY 1,2;";

            if ($jenis == 'SEKOLAH') {
                $query = "SELECT b.nama,b.branch,b.cluster,b.role,b.telp,b.reff_code, a.msisdn,a.`date`,a.serial,a.jenis,a.kategori,a.detail,a.poi,c.JENJANG as jenjang,a.jarak,a.status,c.KECAMATAN as kecamatan
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    JOIN Data_Sekolah_Sumatera c ON SUBSTRING_INDEX(a.poi, '-', 1)=c.NPSN
                    where a.date BETWEEN '$m1' AND '$mtd'
                    and not a.status ='1' and jenis='$jenis' $location $territory
                    ORDER by b.regional DESC,b.branch,b.cluster, b.nama ASC";

                // dd($query);
            } else {
                $query = "SELECT b.nama,b.branch,b.cluster,b.role,b.telp,b.reff_code, a.msisdn,a.`date`,a.serial,a.jenis,a.kategori,a.detail,a.poi,a.jarak,a.status,c.kecamatan
                    FROM sales_copy a  
                    JOIN data_user b ON b.telp = a.telp
                    LEFT JOIN list_poi c ON SUBSTRING_INDEX(a.poi, '-', 1)=c.id
                    where a.date BETWEEN '$m1' AND '$mtd'
                    and not a.status ='1' and jenis='$jenis' $location $territory
                    ORDER by b.regional DESC,b.branch,b.cluster, b.nama ASC";
            }


            // $sales_kategori = DB::select($query_kategori, [1]);
            // ddd($sales_kategori);
            $sales = DB::select($query, [1]);
        } else {
            $sales_kategori = [];
            $sales = [];
        }
        return view('sales.location.index', compact('list_jenis',  'sales'));
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

    public function getRefferal(Request $request)
    {
        $user = [];
        $paket = [];

        if ($request->telp) {
            $user = DB::table('user_buddies')->where('user_id', $request->telp)->first();
            $paket = DB::table('produk_sales')->select('detail as paket')->where('kategori', 'TRADE IN')->orderBy('detail')->get();
        }

        return view('sales.refferal', compact('user', 'paket'));
    }

    public function storeRefferal(Request $request)
    {
        $request->validate([
            'telp' => ['required'],
            'msisdn' => ['required', 'min:11', 'unique:sales_refferal,msisdn', new MsisdnNumber],
            'kompetitor' => ['required', 'min:13', 'starts_with:628', 'unique:sales_refferal,kompetitor'],
            'paket' => ['required'],
        ]);

        $data = DB::table('sales_refferal')->insert([
            'nik' => $request->telp,
            'msisdn' => $request->msisdn,
            'kompetitor' => $request->kompetitor,
            'program' => 'TRADE IN BUDDIES',
            'paket' => $request->paket,
            'date' => date('Y-m-d'),
        ]);

        return redirect()->route('sales.get_refferal', ['telp' => $request->telp])->with('success', 'Berhasil Input Data Trade In');
    }

    public function getRefferalPon(Request $request)
    {
        $user = [];
        $paket = [];

        if ($request->telp) {
            $user = DB::table('data_user_pon')->where('telp', $request->telp)->first();
            $paket = DB::table('produk_sales')->select('detail as paket')->where('kategori', 'TRADE IN')->orderBy('detail')->get();
        }

        return view('sales.refferal_pon', compact('user', 'paket'));
    }

    public function storeRefferalPon(Request $request)
    {
        $request->validate([
            'telp' => ['required'],
            'msisdn' => ['required', 'min:11', 'unique:sales_refferal,msisdn', new MsisdnNumber],
            'paket' => ['required'],
        ]);

        $data = DB::table('sales_refferal')->insert([
            'nik' => $request->telp,
            'msisdn' => $request->msisdn,
            'program' => 'PON',
            'paket' => $request->paket,
            'date' => date('Y-m-d'),
        ]);

        return redirect()->route('sales.get_refferal_pon', ['telp' => $request->telp])->with('success', 'Berhasil Input Data');
    }

    public function getRefferalTapanuli(Request $request)
    {
        $user = [];
        $paket = [];

        if ($request->telp) {
            $user = DB::table('data_user_tradein_sf_hh')->where('telp', $request->telp)->first();
            $paket = DB::table('produk_sales')->select('detail as paket')->where('kategori', 'TRADE IN')->orderBy('detail')->get();
        }

        return view('sales.refferal_tapanuli', compact('user', 'paket'));
    }

    public function storeRefferalTapanuli(Request $request)
    {
        $request->validate([
            'telp' => ['required'],
            'msisdn' => ['required', 'min:11', 'unique:sales_refferal,msisdn', new MsisdnNumber],
            'paket' => ['required'],
        ]);

        $data = DB::table('sales_refferal')->insert([
            'nik' => $request->telp,
            'msisdn' => $request->msisdn,
            'kompetitor' => $request->kompetitor,
            'program' => 'TAPANULI',
            'paket' => $request->paket,
            'date' => date('Y-m-d'),
        ]);

        return redirect()->route('sales.get_refferal_tapanuli', ['telp' => $request->telp])->with('success', 'Berhasil Input Data');
    }

    public function getRefferalMytsel(Request $request)
    {
        $user = [];
        $paket = [];

        if ($request->telp) {
            $user = DB::table('data_user_tradein_sf_hh')->where('telp', $request->telp)->first();
            $paket = DB::table('produk_sales')->select('detail as paket')->where('kategori', 'TRADE IN')->orderBy('detail')->get();
        }

        return view('sales.refferal_mytsel', compact('user', 'paket'));
    }

    public function storeRefferalMytsel(Request $request)
    {
        $request->validate([
            'telp' => ['required'],
            'msisdn' => ['required', 'min:11', 'unique:sales_refferal,msisdn', new MsisdnNumber],
        ]);

        $data = DB::table('sales_refferal')->insert([
            'nik' => $request->telp,
            'msisdn' => $request->msisdn,
            'program' => 'MYTSEL',
            'date' => date('Y-m-d'),
        ]);

        return redirect()->route('sales.get_refferal_mytsel', ['telp' => $request->telp])->with('success', 'Berhasil Input Data');
    }


    public function getLocation(Request $request)
    {
        $start_date = date('Y-m-01', strtotime($request->date));
        $end_date = date('Y-m-d', strtotime($request->date));

        $list_location = DB::table('sales_copy')->select(['poi as location'])->where('jenis', $request->jenis)->whereBetween('date', [$start_date, $end_date])->whereNotNull('poi')->where('poi', '!=', '')->distinct()->orderBy('poi')->join('data_user', 'sales_copy.telp', '=', 'data_user.telp');

        if ($request->privilege == 'branch') {
            $list_location->where('data_user.branch', $request->branch);
        } else if ($request->privilege == 'cluster') {
            $list_location->where('data_user.cluster', $request->cluster);
        }

        $list_location = $list_location->get();

        return response()->json($list_location);
    }

    public function tradeInBuddies(Request $request)
    {
        $data = DB::table('sales_refferal')->join('user_buddies', 'sales_refferal.nik', '=', 'user_buddies.user_id')->where('program', 'TRADE IN BUDDIES')->orderBy('regional', 'desc')->orderBy('branch')->orderBy('cluster')->orderBy('city')->get();

        return view('sales.trade.index', compact('data'));
    }
}
