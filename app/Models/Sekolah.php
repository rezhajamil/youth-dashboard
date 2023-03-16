<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'Data_Sekolah_Sumatera';

    protected $guarded = [];

    protected $primaryKey = 'NPSN';
    public $incrementing = false;

    public static function getNearestSite($npsn)
    {
        $data = DB::select(
            "SELECT site_id AS site, a.latitude,a.longitude,
            ROUND(111.111 * DEGREES(ACOS(COS(RADIANS(CAST(a.latitude AS DECIMAL(10,6)))) * COS(RADIANS(CAST(b.LATITUDE AS DECIMAL(10,6)))) * COS(RADIANS(CAST(a.longitude AS DECIMAL(10,6)) - CAST(b.LONGITUDE AS DECIMAL(10,6)))) + SIN(RADIANS(CAST(a.latitude AS DECIMAL(10,6)))) * SIN(RADIANS(CAST(b.LATITUDE AS DECIMAL(10,6)))))), 2) AS jarak
            FROM `4g_list_site` a, Data_Sekolah_Sumatera b
            WHERE NPSN = '$npsn'
            ORDER BY jarak
            LIMIT 5;"
        );

        return $data;
    }

    public static function getNearestOutlet($npsn)
    {
        $data = DB::select(
            "SELECT namaoutlet AS outlet, a.lattitude,a.longitude,
            ROUND(111.111 * DEGREES(ACOS(COS(RADIANS(CAST(a.lattitude AS DECIMAL(10,6)))) * COS(RADIANS(CAST(b.LATITUDE AS DECIMAL(10,6)))) * COS(RADIANS(CAST(a.longitude AS DECIMAL(10,6)) - CAST(b.LONGITUDE AS DECIMAL(10,6)))) + SIN(RADIANS(CAST(a.lattitude AS DECIMAL(10,6)))) * SIN(RADIANS(CAST(b.LATITUDE AS DECIMAL(10,6)))))), 2) AS jarak
            FROM `outlet_preference` a, Data_Sekolah_Sumatera b
            WHERE NPSN = '$npsn'
            ORDER BY jarak
            LIMIT 5;"
        );

        return $data;
    }
}
