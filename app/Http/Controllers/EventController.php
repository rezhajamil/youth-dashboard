<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Poin;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!request()->get('kategori') || request()->get('kategori') == 'All') {
            $peserta = DB::select("SELECT * FROM peserta_event a LEFT JOIN Data_Sekolah_Sumatera b ON a.npsn=b.NPSN ORDER BY kategori,id asc,jenis,KAB_KOTA,KECAMATAN,a.npsn,NAMA_SEKOLAH,nama;");
        } else {
            $peserta = DB::select("SELECT * FROM peserta_event a LEFT JOIN Data_Sekolah_Sumatera b ON a.npsn=b.NPSN WHERE a.kategori='" . request()->get('kategori') . "' ORDER BY kategori,id asc,jenis,KAB_KOTA,KECAMATAN,a.npsn,NAMA_SEKOLAH,nama;");
        }
        $kategori = DB::table('peserta_event')->select('kategori')->distinct()->orderBy('kategori')->get();
        return view('event.index', compact('peserta', 'kategori'));
    }

    public function resume()
    {
        $peserta = DB::select("SELECT kategori,jenis,COUNT(telp) jumlah FROM peserta_event GROUP BY 1,2 ORDER BY 1,2;");
        $total = 0;

        foreach ($peserta as $data) {
            $total += $data->jumlah;
        }
        return view('event.resume', compact('peserta', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function absen()
    {
        $absen = DB::table('absen')->orderBy('judul')->orderBy('nama')->get();
        $judul = DB::table('absen')->select('judul')->distinct()->get();

        return view('event.absen.index', compact('absen', 'judul'));
    }

    public function create_absen()
    {
        $pertemuan = DB::table('daftar_pertemuan')->where('status', '1')->get();
        return view('event.absen.create', compact('pertemuan'));
    }

    public function store_absen(Request $request)
    {
        $request->validate([
            'pertemuan' => ['required'],
            'email' => ['required', 'email', 'exists:user_event'],
            'telp' => ['required', 'exists:user_event'],
        ]);

        $user = DB::table('user_event')->where('email', $request->email)->first();
        $pertemuan = DB::table('daftar_pertemuan')->where('judul', $request->pertemuan)->first();

        DB::table('absen')->insert([
            'nama' => $user->nama,
            'telp' => $request->telp,
            'id_digipos' => $request->telp,
            'judul' => $request->pertemuan,
            'pembicara' => $pertemuan->pembicara,
            'poin' => $pertemuan->poin,
            'time_in' => date('H:i:s'),
            'date' => date('Y-m-d'),
            'status' => 0,
        ]);

        DB::table('poin_history')->insert([
            'email' => $request->email,
            'telp' => $request->telp,
            'jenis' => 'Absen',
            'keterangan' => $request->pertemuan,
            'jumlah' => $pertemuan->poin,
            'tanggal' => date('Y-m-d H:i:s'),
        ]);

        DB::table('user_event')->where('email', $request->email)->update([
            'poin' => $user->poin + $pertemuan->poin
        ]);


        return back();
    }

    public function challenge()
    {
        $challenge = DB::table('sosmed')->orderBy('challenge')->orderBy('nama')->get();
        $judul = DB::table('sosmed')->select('challenge')->distinct()->get();

        return view('event.challenge', compact('challenge', 'judul'));
    }

    public function layak(Request $request, $id)
    {
        $layak = DB::table('peserta_event')->where('id', $id)->update([
            'layak' => $request->layak
        ]);

        return back();
    }

    public function add_keterangan(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'layak' => 'required',
        ]);

        DB::table('peserta_event')->where('id', $request->id)->update([
            'layak' => $request->layak,
            'keterangan' => $request->keterangan
        ]);

        return back();
    }

    public function poin_history()
    {
        $poin = DB::table('poin_history')->join('user_event', 'user_event.email', "=", "poin_history.email")->orderBy('jenis')->orderBy('keterangan')->get();
        $jenis = DB::table('poin_history')->select('jenis')->distinct()->get();
        return view('event.poin_history', compact('poin', 'jenis'));
    }

    public function approve($id)
    {
        $challenge = DB::table('sosmed')->where('id', $id)->update([
            'approver' => auth()->user()->name
        ]);

        return back();
    }

    public function challenge_status($id)
    {
        $challenge = DB::table('sosmed')->find($id);

        DB::table('sosmed')->where('id', $id)->update([
            'status' => !$challenge->status
        ]);

        return back();
    }

    public function add_keterangan_challenge(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'telp' => 'required',
            'poin' => 'required',
            'judul' => 'required',
            'approver' => 'required',
        ]);

        DB::table('sosmed')->where('id', $request->id)->update([
            'approver' => $request->approver,
            'keterangan' => $request->keterangan
        ]);

        if ($request->approver == '1') {
            $user = DB::table('user_event')->where('telp', $request->telp)->first();

            DB::table('user_event')->where('telp', $request->telp)->update([
                'poin' => $user->poin + $request->poin
            ]);


            Poin::add_poin([
                'email' => $user->email,
                'telp' => $user->telp,
                'jenis' => 'Challenge',
                'keterangan' => $request->judul,
                'jumlah' => $request->poin,
                'tanggal' => date('Y-m-d H:i:s')
            ]);
        }


        return back();
    }
}
