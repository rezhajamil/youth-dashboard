<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TakerController extends Controller
{
    public function segment2(Request $request){
        // $data=json_decode(html_entity_decode(stripslashes($request->row)));
        $data=$request->row;
        $res=[];
        // return $data;

        try {
            foreach ($data as $key => $value) {
                DB::table('takers_segment2')->insert($value);
                array_push($res,"Berhasil");
            }
            return response([$res,"Berhasil simpan data"]);
        } catch (\Throwable $th) {
            return response([$res,$th],400);
        }

    }

    public function non_usim(Request $request){
        $data=$request->data;

        try {
            foreach ($data as $key => $value) {
                DB::table('Taker_Non_Usim')->insert($data);
            }
            return response("Berhasil simpan data");
        } catch (\Throwable $th) {
            return response($th,400);
        }

    }
}
