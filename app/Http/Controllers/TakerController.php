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
        // $data = json_decode($request);
        // return response($request->data);
        $data = $request->input('data');

        // If $data is a JSON string, decode it into an array
        // $dataArray = json_decode($data, true);
        $res = [];

        try {
            DB::table('trx_digipos_ds_2024_test')->insert($data);
            // foreach ($request->input('data') as $key => $value) {
            //     array_push($res, "Berhasil<br/>");
            // }
            return response([$res, "Berhasil simpan data"]);
        } catch (\Throwable $th) {
            return response($th, 400);
        }
    }

    public function receiveFileDigipos(Request $request)
    {
        ini_set('post_max_size', '20M');
        ini_set('upload_max_filesize', '20M');

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $file->storeAs('upload/taker/digipos', $file->getClientOriginalName(), 'public');

            return response()->json(['status' => 'success', 'message' => 'File received and stored.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid file.']);
        }
    }
}
