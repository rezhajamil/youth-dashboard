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

    public function category()
    {
        $category = DB::table('kategori')->where('status', '1')->orderBy('date', 'desc')->get();
        return view('content.category.index', compact('category'));
    }

    public function create_category()
    {
        $user_type = DB::table('user_type')->select('user_type')->distinct()->where('status', '1')->orderBy('user_type')->get();
        return view('content.category.create', compact('user_type'));
    }

    public function store_category(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'jenis' => 'required',
            'detail' => 'required',
            'harga' => 'required',
            'poin' => 'required',
            'keterangan' => 'required',
        ]);

        $category = DB::table('kategori')->insert([
            'role' => $request->role,
            'jenis' => $request->jenis,
            'detail' => $request->detail,
            'harga' => $request->harga,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan,
            'status' => '1',
            'branch' => Auth::user()->name,
            'date' => date("Y-m-d"),
        ]);

        return redirect()->route('category.index');
    }

    public function destroy_category($id)
    {
        DB::table('kategori')->delete($id);

        return back();
    }

    public function news()
    {
        $news = DB::table('berita')->orderBy('date', 'desc')->get();
        return view('content.news.index', compact('news'));
    }

    public function create_news()
    {
        $user_type = DB::table('user_type')->select('user_type')->distinct()->where('status', '1')->orderBy('user_type')->get();
        $event = DB::table('daftar_pertemuan')->select('judul')->where('jenis', 'Event')->distinct()->orderBy('judul')->get();
        $meeting = DB::table('daftar_pertemuan')->select('judul')->where('jenis', 'Pertemuan')->distinct()->orderBy('judul')->get();
        $challenge = DB::table('daftar_challege')->select('judul')->distinct()->orderBy('judul')->get();
        return view('content.news.create', compact('user_type', 'event', 'meeting', 'challenge'));
    }

    public function store_news(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'judul' => 'required',
            'type' => 'required',
            'link_meeting' => 'required',
            'alamat' => 'required',
            'gambar' => 'required|image',
        ]);

        $type = $request->type == 'IMAGE' ? 'gambar' : 'video';

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $url = $gambar->storeAs('news', $gambar->getClientOriginalName());
            $news = DB::table('berita')->insert([
                'role' => $request->role,
                'judul' => $request->judul,
                'link_meeting' => $request->link_meeting,
                'alamat' => $request->alamat,
                'keterangan' => $request->keterangan,
                'type' => $type,
                'nama' => Auth::user()->name,
                'branch' => Auth::user()->branch,
                'status' => '1',
                'date' => date("Y-m-d"),
                'gambar' => $url,
                'jenis' => ucwords($request->jenis),
            ]);
        }

        return redirect()->route('news.index');
    }

    public function destroy_news($id)
    {
        $news = DB::table('berita')->find($id);
        $gambar = $news->gambar;
        Storage::disk('public')->delete($gambar);
        DB::table('berita')->delete($id);

        return back();
    }
}
