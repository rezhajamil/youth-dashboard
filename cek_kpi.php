<?php
include "koneksi.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$telp = $_GET['telp'];
$mtd = date("Y-m-d", strtotime($_GET['date']));
$m1 = date('Y-m-01', strtotime($mtd));

$sql = "SELECT a.branch,a.cluster,a.nama,a.telp,a.id_digipos,a.`role`,b.migrasi,c.orbit,d.byu, g.mytsel,e.update_data,f.pjp,h.quiz,i.survey,j.broadband,k.digital
            FROM data_user a
            LEFT JOIN (SELECT outlet_id,COUNT(outlet_id) migrasi FROM `4g_usim_all_trx` WHERE date BETWEEN '$m1' AND '$mtd' AND (status='MIGRATION_SUCCCESS' OR status='USIM_ACTIVE') GROUP BY 1) b ON a.id_digipos=b.outlet_id
            LEFT JOIN (SELECT outlet_id,COUNT(msisdn) orbit FROM orbit_digipos WHERE so_date BETWEEN '$m1' AND '$mtd' GROUP BY 1) c ON a.id_digipos=c.outlet_id
            LEFT JOIN (SELECT telp,COUNT(msisdn) byu FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='BYU' GROUP BY 1) d ON a.telp=d.telp
            LEFT JOIN (SELECT telp, COUNT(msisdn) mytsel FROM sales_copy WHERE date BETWEEN '$m1' AND '$mtd' AND kategori='MY TELKOMSEL' GROUP BY 1) g ON a.telp = g.telp
            LEFT JOIN (SELECT telp,COUNT(NPSN) update_data FROM Data_Sekolah_Sumatera WHERE UPDATED_AT BETWEEN '$m1' AND '$mtd' AND LONGITUDE!='' GROUP BY 1) e ON a.telp=e.telp
            LEFT JOIN (SELECT telp,COUNT(npsn) pjp FROM table_kunjungan WHERE date BETWEEN '$m1' AND '$mtd' GROUP BY 1) f ON a.telp=f.telp
            LEFT JOIN (SELECT telp,SUM(hasil) quiz FROM quiz_answer WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) h ON a.telp=h.telp
            LEFT JOIN (SELECT Data_Sekolah_Sumatera.telp,COUNT(survey_answer.telp_siswa) survey FROM survey_answer JOIN Data_Sekolah_Sumatera ON survey_answer.npsn=Data_Sekolah_Sumatera.NPSN WHERE time_start BETWEEN '$m1' AND '$mtd' GROUP BY 1) i ON a.telp=i.telp
            LEFT JOIN (SELECT digipos_ao,SUM(price) broadband FROM trx_digipos_ds WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DATA' GROUP BY 1) j ON a.id_digipos=j.digipos_ao
            LEFT JOIN (SELECT digipos_ao,SUM(price) digital FROM trx_digipos_ds WHERE event_date BETWEEN '$m1' AND '$mtd' AND trx_type='DIGITAL' GROUP BY 1) k ON a.id_digipos=k.digipos_ao
            WHERE a.telp='$telp'
            ORDER BY 1,2,3,5;";

//Get Target DS
$target = mysqli_query($dbc, "SELECT * FROM target_ds where status='1'");

$list_target = [];
$sales = 0;
$proses = 0;

foreach ($target as $data) {
    $item_kpi = $data['item_kpi'];
    $target_value = $data['unit'] == 'rupiah'
        ? number_format($data['target'], 0, ",", ".")
        : $data['target'];

    $list_target[$item_kpi] = [
        'target' => $target_value,
        'bobot' => $data['bobot'],
        'unit' => $data['unit']
    ];

    if ($data['kategori'] == 'sales') {
        $sales += $data['bobot'];
    } elseif ($data['kategori'] == 'proses') {
        $proses += $data['bobot'];
    }
}

$hasil = mysqli_query($dbc, $sql);

if (mysqli_num_rows($hasil) > 0) {
    while ($kpi = mysqli_fetch_assoc($hasil)) {

        foreach ($list_target as $i_target => $target) {
            $ach_target = (intval($kpi[$i_target]) / intval(str_replace('.', '', $target['target']))) * 100;

            if ($ach_target <= 100) {
                $ach_target = intval($ach_target) * ($target['bobot']) / 100;
            } else {
                $ach_target = $target['bobot'];
            }

            $kpi["ach_$i_target"] = number_format($ach_target, 2, ',', '.');

            if ($target['unit'] == 'rupiah') {
                $kpi[$i_target] = number_format($kpi[$i_target], 0, ',', '.');
            }
        }

        $kpi['tot_sales'] = floatval(str_replace(',', '.', $kpi['ach_broadband']))
            + floatval(str_replace(',', '.', $kpi['ach_digital']))
            + floatval(str_replace(',', '.', $kpi['ach_orbit']))
            + floatval(str_replace(',', '.', $kpi['ach_migrasi']))
            + floatval(str_replace(',', '.', $kpi['ach_byu']))
            + floatval(str_replace(',', '.', $kpi['ach_mytsel']));


        $kpi['tot_proses'] = floatval(str_replace(',', '.', $kpi['ach_update_data']))
            + floatval(str_replace(',', '.', $kpi['ach_pjp']))
            + floatval(str_replace(',', '.', $kpi['ach_survey']))
            + floatval(str_replace(',', '.', $kpi['ach_quiz']));

        $kpi['total'] = number_format(floatval($kpi['tot_sales']) + floatval($kpi['tot_proses']), 2, ',', '.');

        // echo var_export($list_target['broadband'],true);
        // echo var_export($kpi,true);
        echo $kpi['total'] . "%";
    }
} else {
    echo '#Tidak ada data';
}
