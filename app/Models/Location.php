<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    use HasFactory;

    public static function getNearestOutlet($site)
    {
        $data = DB::select(
            "SELECT namaoutlet AS outlet, a.lattitude,a.longitude,
            ROUND(111.111 * DEGREES(ACOS(COS(RADIANS(CAST(a.lattitude AS DECIMAL(10,6)))) * COS(RADIANS(CAST(b.latitude AS DECIMAL(10,6)))) * COS(RADIANS(CAST(a.longitude AS DECIMAL(10,6)) - CAST(b.longitude AS DECIMAL(10,6)))) + SIN(RADIANS(CAST(a.lattitude AS DECIMAL(10,6)))) * SIN(RADIANS(CAST(b.latitude AS DECIMAL(10,6)))))), 2) AS jarak
            FROM `outlet_preference` a, list_site_1022 b
            WHERE b.id='$site'
            HAVING jarak IS NOT NULL
            ORDER BY jarak
            LIMIT 5;"
        );

        return $data;
    }

    public static function getNearestSekolah($site)
    {
        $data = DB::select(
            "SELECT NAMA_SEKOLAH AS sekolah, a.LATITUDE,a.LONGITUDE,
            ROUND(111.111 * DEGREES(ACOS(COS(RADIANS(CAST(a.LATITUDE AS DECIMAL(10,6)))) * COS(RADIANS(CAST(b.latitude AS DECIMAL(10,6)))) * COS(RADIANS(CAST(a.LONGITUDE AS DECIMAL(10,6)) - CAST(b.longitude AS DECIMAL(10,6)))) + SIN(RADIANS(CAST(a.LATITUDE AS DECIMAL(10,6)))) * SIN(RADIANS(CAST(b.latitude AS DECIMAL(10,6)))))), 2) AS jarak
            FROM `Data_Sekolah_Sumatera` a, list_site_1022 b
            WHERE b.id='$site'
            HAVING jarak IS NOT NULL
            ORDER BY jarak
            LIMIT 5;"
        );

        return $data;
    }
}
