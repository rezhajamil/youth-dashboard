<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function slide()
    {
        $slide = DB::table('slide_show')->orderBy('date', 'desc')->get();
        return view('content.slide.index', compact('slide'));
    }

    public function create_slide()
    {
        return view('content.slide.create');
    }

    public function store_slide(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'judul' => 'required',
            'gambar' => 'required|image',
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $url = $gambar->storeAs('slide_show', $gambar->getClientOriginalName());
            $slide = DB::table('slide_show')->insert([
                'role' => $request->role,
                'judul' => $request->judul,
                'nama' => Auth::user()->name,
                'branch' => Auth::user()->branch,
                'status' => '1',
                'date' => date("Y-m-d"),
                'gambar' => $url,
            ]);
        }

        return redirect()->route('slide.index');
    }

    public function destroy_slide($id)
    {
        $slide = DB::table('slide_show')->find($id);
        $gambar = $slide->gambar;
        Storage::disk('public')->delete($gambar);
        DB::table('slide_show')->delete($id);

        return back();
    }

    public function schedule()
    {
        $schedule = DB::table('daftar_pertemuan')->orderBy('date', 'desc')->get();
        return view('content.schedule.index', compact('schedule'));
    }

    public function create_schedule()
    {
        $user_type = DB::table('user_type')->select('user_type')->distinct()->where('status', '1')->orderBy('user_type')->get();
        return view('content.schedule.create', compact('user_type'));
    }

    public function store_schedule(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
            'date' => 'required',
            'time' => 'required',
            'pembicara' => 'required',
            'mc' => 'required',
            'judul' => 'required',
            'poin' => 'required',
            'minus' => 'required',
        ]);

        $schedule = DB::table('daftar_pertemuan')->insert([
            'jenis' => $request->jenis,
            'date' => $request->date,
            'time' => $request->time,
            'judul' => $request->judul,
            'pembicara' => $request->pembicara,
            'mc' => $request->mc,
            'poin' => $request->poin,
            'minus' => $request->minus,
            'status' => '0',
        ]);

        return redirect()->route('schedule.index');
    }

    public function destroy_schedule($id)
    {
        DB::table('daftar_pertemuan')->delete($id);

        return back();
    }

    public function change_status_schedule($id)
    {
        $schedule = DB::table('daftar_pertemuan')->where('id', $id)->first();
        $status = $schedule->status ? 0 : 1;

        DB::table('daftar_pertemuan')->where('id', $id)->update([
            'status' => $status
        ]);
        return back();
    }

    public function notification()
    {
        $notification = DB::table('notification')->orderBy('date', 'desc')->get();
        return view('content.notification.index', compact('notification'));
    }

    public function create_notification()
    {
        $user_type = DB::table('user_type')->select('user_type')->distinct()->where('status', '1')->orderBy('user_type')->get();
        return view('content.notification.create', compact('user_type'));
    }

    public function store_notification(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'judul' => 'required',
            'message' => 'required',
        ]);

        $notification = DB::table('notification')->insert([
            'role' => $request->role,
            'judul' => $request->judul,
            'message' => $request->message,
            'date' => date("Y-m-d"),
        ]);

        return redirect()->route('notification.index');
    }

    public function destroy_notification($id)
    {
        DB::table('notification')->delete($id);

        return back();
    }
}
