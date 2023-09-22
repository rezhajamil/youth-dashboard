<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Byu extends Model
{
    use HasFactory;

    public static function getResume($month, $year)
    {
        $privilege = auth()->user()->privilege;
        $branch = auth()->user()->branch;
        $cluster = auth()->user()->cluster;

        $filter = "";

        if ($privilege == 'branch') {
            $filter = " AND a.branch='$branch'";
        }

        if ($privilege == 'cluster') {
            $filter = " AND a.cluster='$cluster'";
        }

        $resume = DB::select(
            "SELECT a.regional, a.cluster, a.kab_new AS city, 
                b.*, c.*, d.*, e.*
            FROM territory_new a
            LEFT JOIN (
                SELECT city, 
                    SUM(CASE WHEN type='DS' THEN jumlah ELSE 0 END) AS st_ds,
                    SUM(CASE WHEN type='Outlet' THEN jumlah ELSE 0 END) AS st_outlet,
                    SUM(jumlah) AS st_all,
                    COUNT(CASE WHEN type='Outlet' THEN id_digipos END) AS outlet_st
                FROM byu_distribusi
                WHERE MONTH(date)=$month AND YEAR(date)=$year
                GROUP BY 1
            ) AS b ON a.kab_new = b.city
            LEFT JOIN (
                SELECT city,
                    SUM(injected) AS injected,
                    SUM(redeem_outlet) AS outlet_redeem,
                    SUM(ds_redeem) AS ds_redeem,
                    SUM(redeem_outlet+ds_redeem) AS redeem_all
                FROM byu_report
                WHERE MONTH(created_at)=$month AND YEAR(created_at)=$year
                GROUP BY 1
            ) AS c ON a.kab_new = c.city
            LEFT JOIN (
                SELECT kabupaten AS city,
                    COUNT(telp) AS jlh_ds
                FROM data_user
                JOIN taps ON data_user.tap = taps.nama
                WHERE status = 1
                GROUP BY 1
            ) AS d ON a.kab_new = d.city
            RIGHT JOIN byu_target_city AS e ON a.kab_new = e.city
            WHERE a.lbo_city = 1 $filter
            GROUP BY 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20
            ORDER BY 1 DESC, 2, 3;"
        );

        return $resume;
    }
}
