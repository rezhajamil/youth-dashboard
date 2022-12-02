<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TakerController extends Controller
{
    public function segment2(Request $request){
        $msisdn=$request->msisdn;
        $region=$request->region;
        $cluster=$request->cluster;
        $city=$request->city;
        $site_id=$request->site_id;
        $arpu_data=$request->arpu_data;
        $payload_base=$request->payload_base;
        $comask=$request->comask;
        $isak=$request->isak;
        $channel=$request->channel;
        $program=$request->program;
        $usim=$request->usim;
        $sdn=$request->sdn;
        $card_status=$request->card_status;
        $payload_mtd=$request->payload_mtd;
        $payload_m1=$request->payload_m1;
        $payload_2mon=$request->payload_2mon;
        $rev_mtd=$request->rev_mtd;
        $rev_mtd_m1=$request->rev_mtd_m1;
        $rev_data_mtd=$request->rev_data_mtd;
        $rev_data_m1=$request->rev_data_m1;
        $event_date=$request->event_date;
        $data=$request->data;

        try {
            foreach ($data as $key => $value) {
                DB::table('taker_segment2')->insert($data);
            }
            return response("Berhasil simpan data");
        } catch (\Throwable $th) {
            return response($th,400);
        }

    }

    public function non_usim(Request $request){
        // $msisdn=$request->msisdn;
        // $region=$request->region;
        // $cluster=$request->cluster;
        // $city=$request->city;
        // $site_id=$request->site_id;
        // $arpu_data=$request->arpu_data;
        // $payload_base=$request->payload_base;
        // $comask=$request->comask;
        // $isak=$request->isak;
        // $channel=$request->channel;
        // $program=$request->program;
        // $usim=$request->usim;
        // $sdn=$request->sdn;
        // $card_status=$request->card_status;
        // $payload_mtd=$request->payload_mtd;
        // $payload_m1=$request->payload_m1;
        // $payload_2mon=$request->payload_2mon;
        // $rev_mtd=$request->rev_mtd;
        // $rev_mtd_m1=$request->rev_mtd_m1;
        // $rev_data_mtd=$request->rev_data_mtd;
        // $rev_data_m1=$request->rev_data_m1;
        // $event_date=$request->event_date;
        $data=$request->data;

        try {
            foreach ($data as $key => $value) {
                DB::table('Taker_Non_Usim')->insert($data);
            }
            return response("Berhasil simpan data");
        } catch (\Throwable $th) {
            return response($request->data,400);
        }

    }
}
