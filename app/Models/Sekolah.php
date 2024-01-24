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

    public static function getDetailOssOsk($territory = "")
    {
        $query = "SELECT
                data_oss_osk.id,
                Data_Sekolah_Sumatera.CLUSTER,
                data_oss_osk.kecamatan,
                data_oss_osk.npsn,
                data_oss_osk.nama_sekolah,
                data_oss_osk.outlet_id,
                data_oss_osk.nama_outlet,
                data_oss_osk.`telp pic`,
                data_user.nama,
                ROUND(111.111 * DEGREES(ACOS(COS(RADIANS(CAST(outlet_reference_1022.latitude AS DECIMAL (10, 6)))) * COS(RADIANS(CAST(Data_Sekolah_Sumatera.LATITUDE AS DECIMAL (10, 6)))) * COS(RADIANS(CAST(outlet_reference_1022.longitude AS DECIMAL (10, 6)) - CAST(Data_Sekolah_Sumatera.LONGITUDE AS DECIMAL (10, 6)))) + SIN(RADIANS(CAST(outlet_reference_1022.latitude AS DECIMAL (10, 6)))) * SIN(RADIANS(CAST(Data_Sekolah_Sumatera.LATITUDE AS DECIMAL (10, 6)))))), 2) AS jarak
            FROM
                data_oss_osk
                LEFT JOIN data_user ON data_oss_osk.telp = data_user.telp
                JOIN Data_Sekolah_Sumatera ON data_oss_osk.npsn = Data_Sekolah_Sumatera.NPSN
                JOIN outlet_reference_1022 ON data_oss_osk.outlet_id=outlet_reference_1022.outlet_id
                $territory
            ORDER BY
                Data_Sekolah_Sumatera.`CLUSTER`,
                KATEGORI_JENJANG,
                data_oss_osk.kecamatan,
                data_oss_osk.nama_sekolah;";

        // ddd($query);

        $data = DB::select($query);

        return $data;
    }

    public static function getResumeOssOsk($territory = "")
    {
        $query = "SELECT Data_Sekolah_Sumatera.BRANCH,
        Data_Sekolah_Sumatera.CLUSTER,
        COUNT(CASE WHEN (ROUND(111.111 * DEGREES(ACOS(COS(RADIANS(CAST(outlet_reference_1022.latitude AS DECIMAL (10, 6)))) * COS(RADIANS(CAST(Data_Sekolah_Sumatera.LATITUDE AS DECIMAL (10, 6)))) * COS(RADIANS(CAST(outlet_reference_1022.longitude AS DECIMAL (10, 6)) - CAST(Data_Sekolah_Sumatera.LONGITUDE AS DECIMAL (10, 6)))) + SIN(RADIANS(CAST(outlet_reference_1022.latitude AS DECIMAL (10, 6)))) * SIN(RADIANS(CAST(Data_Sekolah_Sumatera.LATITUDE AS DECIMAL (10, 6)))))), 2))<=1 THEN 1 END) AS dekat,
        COUNT(CASE WHEN (ROUND(111.111 * DEGREES(ACOS(COS(RADIANS(CAST(outlet_reference_1022.latitude AS DECIMAL (10, 6)))) * COS(RADIANS(CAST(Data_Sekolah_Sumatera.LATITUDE AS DECIMAL (10, 6)))) * COS(RADIANS(CAST(outlet_reference_1022.longitude AS DECIMAL (10, 6)) - CAST(Data_Sekolah_Sumatera.LONGITUDE AS DECIMAL (10, 6)))) + SIN(RADIANS(CAST(outlet_reference_1022.latitude AS DECIMAL (10, 6)))) * SIN(RADIANS(CAST(Data_Sekolah_Sumatera.LATITUDE AS DECIMAL (10, 6)))))), 2))>1 THEN 1 END) AS jauh,
        COUNT(data_oss_osk.npsn) as jumlah FROM data_oss_osk JOIN Data_Sekolah_Sumatera ON data_oss_osk.npsn=Data_Sekolah_Sumatera.NPSN JOIN outlet_reference_1022 ON data_oss_osk.outlet_id=outlet_reference_1022.outlet_id $territory GROUP BY 1,2 ORDER BY 1,2;";

        // ddd($query);

        $data = DB::select($query);

        return $data;
    }
}
