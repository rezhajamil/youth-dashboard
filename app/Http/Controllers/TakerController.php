<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TakerController extends Controller
{
    public function segment2(Request $request)
    {
        ini_set("post_max_size", 0);
        // $data=json_decode(html_entity_decode(stripslashes($request->row)));
        $data = json_decode($request->row, true);
        $res = [];
        // return count($data);

        try {
            foreach ($data as $key => $value) {
                DB::table('takers_segment2')->insert($value);
                array_push($res, "Berhasil<br/>");
            }
            return response([$res, "Berhasil simpan data"]);
        } catch (\Throwable $th) {
            return response($th, 400);
        }
    }

    public function non_usim(Request $request)
    {
        ini_set("post_max_size", 0);
        // $data=json_decode(html_entity_decode(stripslashes($request->row)));
        $data = json_decode($request->row, true);
        $res = [];
        // return count($data);

        try {
            foreach ($data as $key => $value) {
                DB::table('Taker_Non_Usim_WL')->insert($value);
                array_push($res, "Berhasil<br/>");
            }
            return response([$res, "Berhasil simpan data"]);
        } catch (\Throwable $th) {
            return response($th, 400);
        }
    }

    public function digipos(Request $request)
    {
        ini_set("post_max_size", 0);
        // $data = json_decode(html_entity_decode(stripslashes($request->row)));
        $data = $request;
        $data = (array) $request;
        return response($data);
        $res = [];

        try {
            foreach ($data as $key => $value) {
                DB::table('trx_digipos_ds_test')->insert($value);
                array_push($res, "Berhasil<br/>");
            }
            return response([$res, "Berhasil simpan data"]);
        } catch (\Throwable $th) {
            return response($th, 400);
        }
    }
}
