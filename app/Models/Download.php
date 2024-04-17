<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Download extends Model
{
    use HasFactory;

    public static function sales($date)
    {
        $m1 = date('Y-m-01', strtotime($date));
        $mtd = date('Y-m-d', strtotime($date));
        $privilege = auth()->user()->privilege;
        $branch = auth()->user()->branch;
        $cluster = auth()->user()->cluster;

        $data = DB::select("SELECT 
            g.id AS id, 
            g.poi, 
            g.regional, 
            g.branch, 
            g.cluster, 
            j.CITY AS kabupaten, 
            j.KECAMATAN AS kecamatan, 
            j.stategy, 
            g.msisdn, 
            g.telp,  
            g.id_digipos, 
            g.kategori, 
            j.KATEGORI_JENJANG AS jenis_poi, 
            DAY(g.date) AS day, 
            MONTH(g.date) AS month, 
            YEAR(g.date) AS year
        FROM 
            (SELECT SUBSTRING_INDEX(a.poi,'-',1) AS id, 
                    a.poi, 
                    b.regional, 
                    b.branch, 
                    b.cluster, 
                    a.msisdn, 
                    b.telp, 
                    b.id_digipos, 
                    a.kategori, 
                    a.date
            FROM sales_copy a
            LEFT JOIN data_user b ON b.telp = a.telp
            WHERE a.date BETWEEN '$m1' AND '$mtd'
                AND b.status = '1'
                AND a.jenis = 'SEKOLAH'
                " . ($privilege == 'branch' ? "AND b.branch = '$branch'" : ($privilege == 'cluster' ? "AND b.cluster = '$cluster'" : "")) . "
            UNION ALL
            SELECT SUBSTRING_INDEX(a.poi,'-',1) AS id, 
                    a.poi, 
                    b.regional, 
                    b.branch, 
                    b.cluster, 
                    a.msisdn, 
                    b.telp, 
                    b.id_digipos, 
                    a.kategori, 
                    a.date
            FROM sales_copy a
            LEFT JOIN data_user b ON b.telp = a.telp
            WHERE a.date BETWEEN '$m1' AND '$mtd'
                AND b.status = '1'
                AND a.jenis != 'SEKOLAH'
                " . ($privilege == 'branch' ? "AND b.branch = '$branch'" : ($privilege == 'cluster' ? "AND b.cluster = '$cluster'" : "")) . "
            ) AS g
        LEFT JOIN 
            (SELECT i.stategy, 
                    h.NPSN, 
                    h.CITY, 
                    h.KECAMATAN, 
                    h.KATEGORI_JENJANG 
            FROM Data_Sekolah_Sumatera h 
            JOIN strategy_profile i ON i.city=h.CITY
            " . ($privilege == 'branch' ? "WHERE h.branch = '$branch'" : ($privilege == 'cluster' ? "WHERE h.cluster = '$cluster'" : "")) . "
            UNION ALL
            SELECT i.stategy, 
                    h.id AS NPSN,  
                    h.kabupaten AS CITY,  
                    h.kecamatan AS KECAMATAN, 
                    h.jenis_poi AS KATEGORI_JENJANG
            FROM list_poi h 
            JOIN strategy_profile i ON i.city=h.kabupaten) AS j  ON j.NPSN=g.id;");

        return $data;
    }
}
