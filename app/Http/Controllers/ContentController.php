<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function sapaan()
    {
        $sapaan = DB::table('data_sapaan')->orderBy('date', 'desc')->get();
        return view('content.sapaan.index', compact('sapaan'));
    }

    public function destroy_sapaan($id)
    {
        $sapaan = DB::table('data_sapaan')->delete($id);
        // ddd($sapaan);

        return back();
    }

    public function create_sapaan()
    {
        $user_type = DB::table('user_type')->select('user_type')->distinct()->where('status', '1')->orderBy('user_type')->get();
        return view('content.sapaan.create', compact('user_type'));
    }

    public function store_sapaan(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'sapaan1' => 'required',
        ]);

        $sapaan = DB::table('data_sapaan')->insert([
            'role' => $request->role,
            'sapaan1' => $request->sapaan1,
            'date' => date("Y-m-d"),
            'status' => '1',
            'user' => Auth::user()->name,
            'branch' => Auth::user()->branch,
        ]);

        return redirect()->route('sapaan.index');
    }

    public function challenge()
    {
        $challenge = DB::table('daftar_challege')->orderBy('date', 'desc')->get();
        return view('content.challenge.index', compact('challenge'));
    }

    public function create_challenge()
    {
        $user_type = DB::table('user_type')->select('user_type')->distinct()->where('status', '1')->orderBy('user_type')->get();
        return view('content.challenge.create', compact('user_type'));
    }

    public function destroy_challenge($id)
    {
        $challenge = DB::table('daftar_challege')->delete($id);
        // ddd($sapaan);

        return back();
    }

    public function store_challenge(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'date_line' => 'required',
            'judul' => 'required',
            'poin' => 'required',
            'minus' => 'required',
            'keterangan' => 'required',
        ]);

        $challenge = DB::table('daftar_challege')->insert([
            'role' => $request->role,
            'date_line' => $request->date_line,
            'judul' => $request->judul,
            'poin' => $request->poin,
            'minus' => $request->minus,
            'keterangan' => $request->keterangan,
            'status' => '1',
            'date' => date("Y-m-d"),
            'user' => Auth::user()->name,
        ]);

        return redirect()->route('challenge.index');
    }
}
