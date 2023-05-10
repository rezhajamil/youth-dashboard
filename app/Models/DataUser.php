<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataUser extends Model
{
    use HasFactory;

    protected $table = 'data_user';

    protected $fillable = [
        'area',
        'regional',
        'branch',
        'cluster',
        'tap',
        'nama',
        'panggilan',
        'mkios',
        'id_digipos',
        'user_calista',
        'reff_code',
        'role',
        'posisi',
        'kampus',
        'status',
        'sosmed',
        'tgl_lahir',
        'telp',
        'link_aja',
        'password',
        'reff_byu',
    ];

    public static function resume_kpi($mtd, $where_loc, $scope)
    {
        $m1 = date('Y-m-01', strtotime($mtd));
        $last_mtd = date('Y-m-d', strtotime($mtd . "-1 month"));
        $last_m1 = date('Y-m-01', strtotime($last_mtd));

        $resume = DB::select(
            "SELECT a.$scope,
                COALESCE(SUM(b.migrasi),0) AS migrasi,
                COALESCE(SUM(b.last_migrasi),0) AS last_migrasi,
                COALESCE(SUM(c.orbit),0) AS orbit,
                COALESCE(SUM(c.last_orbit),0) AS last_orbit,
                COALESCE(SUM(d.byu),0) AS byu,
                COALESCE(SUM(d.last_byu),0) AS last_byu,
                COALESCE(SUM(e.update_data),0) AS update_data,
                COALESCE(SUM(e.last_update_data),0) AS last_update_data,
                COALESCE(SUM(f.pjp),0) AS pjp,
                COALESCE(SUM(f.last_pjp),0) AS last_pjp,
                COALESCE(SUM(g.mytsel),0) AS mytsel,
                COALESCE(SUM(g.last_mytsel),0) AS last_mytsel,
                COALESCE(SUM(h.quiz),0) AS quiz,
                COALESCE(SUM(h.last_quiz),0) AS last_quiz,
                COALESCE(SUM(i.survey),0) AS survey,
                COALESCE(SUM(i.last_survey),0) AS last_survey,
                COALESCE(SUM(j.broadband),0) AS broadband,
                COALESCE(SUM(j.last_broadband),0) AS last_broadband,
                COALESCE(SUM(k.digital),0) AS digital,
                COALESCE(SUM(k.last_digital),0) AS last_digital
                FROM data_user a
                LEFT JOIN (SELECT outlet_id,COUNT(CASE WHEN date BETWEEN '$m1' AND '$mtd' THEN outlet_id END ) migrasi, COUNT(CASE WHEN date BETWEEN '$last_m1' AND '$last_mtd' THEN outlet_id END ) last_migrasi FROM `4g_usim_all_trx` WHERE date BETWEEN '$last_m1' AND '$mtd' AND (status='MIGRATION_SUCCCESS' OR status='USIM_ACTIVE') GROUP BY 1) b ON a.id_digipos=b.outlet_id
                LEFT JOIN (SELECT outlet_id,COUNT(CASE WHEN so_date BETWEEN '$m1' AND '$mtd' THEN msisdn END ) orbit, COUNT(CASE WHEN so_date BETWEEN '$last_m1' AND '$last_mtd' THEN msisdn END ) last_orbit FROM orbit_digipos WHERE so_date BETWEEN '$last_m1' AND '$mtd' GROUP BY 1) c ON a.id_digipos=c.outlet_id
                LEFT JOIN (SELECT telp,COUNT(CASE WHEN date BETWEEN '$m1' AND '$mtd' THEN msisdn END ) byu, COUNT(CASE WHEN date BETWEEN '$last_m1' AND '$last_mtd' THEN msisdn END ) last_byu FROM sales_copy WHERE date BETWEEN '$last_m1' AND '$mtd' AND kategori='BYU' GROUP BY 1) d ON a.telp=d.telp
                LEFT JOIN (SELECT telp,COUNT(CASE WHEN date BETWEEN '$m1' AND '$mtd' THEN msisdn END ) mytsel, COUNT(CASE WHEN date BETWEEN '$last_m1' AND '$last_mtd' THEN msisdn END ) last_mytsel FROM sales_copy WHERE date BETWEEN '$last_m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp=g.telp
                LEFT JOIN (SELECT telp,COUNT(CASE WHEN UPDATED_AT BETWEEN '$m1' AND '$mtd' THEN NPSN END ) update_data, COUNT(CASE WHEN UPDATED_AT BETWEEN '$last_m1' AND '$last_mtd' THEN NPSN END ) last_update_data FROM Data_Sekolah_Sumatera WHERE UPDATED_AT BETWEEN '$last_m1' AND '$mtd' AND LONGITUDE!='' GROUP BY 1) e ON a.telp=e.telp
                LEFT JOIN (SELECT telp,COUNT(CASE WHEN date BETWEEN '$m1' AND '$mtd' THEN npsn END ) pjp, COUNT(CASE WHEN date BETWEEN '$last_m1' AND '$last_mtd' THEN npsn END ) last_pjp FROM table_kunjungan WHERE date BETWEEN '$last_m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
                -- LEFT JOIN (SELECT telp,COUNT(CASE WHEN created_at BETWEEN '$m1' AND '$mtd' THEN npsn END ) oss_osk, COUNT(CASE WHEN created_at BETWEEN '$last_m1' AND '$last_mtd' THEN npsn END ) last_oss_osk FROM data_oss_osk WHERE created_at BETWEEN '$last_m1' AND '$mtd' GROUP BY 1) g ON a.telp=g.telp
                LEFT JOIN (SELECT telp,COUNT(CASE WHEN time_start BETWEEN '$m1' AND '$mtd' THEN telp END ) quiz, COUNT(CASE WHEN time_start BETWEEN '$last_m1' AND '$last_mtd' THEN telp END ) last_quiz FROM quiz_answer WHERE time_start BETWEEN '$last_m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
                LEFT JOIN (SELECT Data_Sekolah_Sumatera.telp,COUNT(CASE WHEN time_start BETWEEN '$m1' AND '$mtd' THEN survey_answer.telp_siswa END) survey,COUNT(CASE WHEN time_start BETWEEN '$last_m1' AND '$last_mtd' THEN survey_answer.telp_siswa END) last_survey FROM survey_answer JOIN Data_Sekolah_Sumatera ON survey_answer.npsn=Data_Sekolah_Sumatera.NPSN WHERE time_start BETWEEN '$last_m1' AND '$mtd' GROUP BY 1) i ON a.telp=i.telp
                LEFT JOIN (SELECT digipos_ao,SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' THEN price ELSE 0 END) broadband,SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' THEN price ELSE 0 END) last_broadband FROM trx_digipos_ds WHERE event_date BETWEEN '$last_m1' AND '$mtd' AND trx_type='DATA' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
                LEFT JOIN (SELECT digipos_ao,SUM(CASE WHEN event_date BETWEEN '$m1' AND '$mtd' THEN price ELSE 0 END) digital,SUM(CASE WHEN event_date BETWEEN '$last_m1' AND '$last_mtd' THEN price ELSE 0 END) last_digital FROM trx_digipos_ds WHERE event_date BETWEEN '$last_m1' AND '$mtd' AND trx_type='DIGITAL' GROUP BY 1) k ON a.id_digipos=k.digipos_ao
                WHERE $where_loc a.status=1
                GROUP BY 1
                ORDER BY 1;"
        );

        return $resume;
    }
}
