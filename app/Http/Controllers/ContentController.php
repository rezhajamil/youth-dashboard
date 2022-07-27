<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function sapaan()
    {
        $sapaan = DB::table('daftar_sapaan')->orderBy('date')->get();
        return view('conten.sapaan', compact('sapaan'));
    }

    public function destroy_sapaan($id){
        $sapaan=DB::table('daftar_sapaan')
    }
}
