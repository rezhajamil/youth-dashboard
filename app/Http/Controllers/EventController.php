<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Poin;
use App\Rules\PhoneNumber;
use App\Rules\TelkomselNumber;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->get('event')) {
            if (!request()->get('kategori') || request()->get('kategori') == 'All') {
                $peserta = DB::select("SELECT * FROM peserta_event a LEFT JOIN Data_Sekolah_Sumatera b ON a.npsn=b.NPSN WHERE a.event='" . request()->get('event') . "' ORDER BY kategori,id asc,jenis,KAB_KOTA,KECAMATAN,a.npsn,NAMA_SEKOLAH,nama;");
            } else {
                $peserta = DB::select("SELECT * FROM peserta_event a LEFT JOIN Data_Sekolah_Sumatera b ON a.npsn=b.NPSN WHERE a.kategori='" . request()->get('kategori') . "' AND a.event='" . request()->get('event') . "' ORDER BY kategori,id asc,jenis,KAB_KOTA,KECAMATAN,a.npsn,NAMA_SEKOLAH,nama;");
            }
            $kategori = DB::table('peserta_event')->select('kategori')->where('event', request()->get('event'))->distinct()->orderBy('kategori')->get();
        } else {
            $peserta = [];
            $kategori = [];
        }

        $event = DB::table('list_event')->get();
        return view('event.index', compact('peserta', 'kategori', 'event'));
    }

    public function resume()
    {
        if (request()->get('event')) {
            $event = request()->get('event');
            $peserta = DB::select("SELECT kategori,jenis,COUNT(telp) jumlah FROM peserta_event WHERE event='$event' GROUP BY 1,2 ORDER BY 1,2;");
            // $kategori = DB::table('peserta_event')->select('kategori')->where('event', request()->get('event'))->distinct()->orderBy('kategori')->get();
        } else {
            $peserta = [];
            // $kategori = [];
        }

        $total = 0;

        foreach ($peserta as $data) {
            $total += $data->jumlah;
        }
        $event = DB::table('list_event')->get();
        return view('event.resume', compact('peserta', 'total', 'event'));
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

    public function create_peserta_sekolah()
    {
        $ds = DB::table('data_user')->where('status', 1)->orderBy('nama');

        if (auth()->user()->privilege == 'superadmin') {
            $ds = $ds->get();
        } else if (auth()->user()->privilege == 'branch') {
            $ds = $ds->where('branch', auth()->user()->branch)->get();
        } else if (auth()->user()->privilege == 'cluster') {
            $ds = $ds->where('cluster', auth()->user()->cluster)->get();
        }
        return view('event.create_peserta_sekolah', compact('ds'));
    }

    public function store_peserta_sekolah(Request $request)
    {
        $request->validate([
            'telp_ds' => ['required'],
            'npsn' => ['required', 'numeric'],
            'file' => ['required'],
        ]);

        // ddd($request);

        if ($request->hasFile('file')) {
            if (file_exists($request->file)) {
                $file = fopen($request->file, "r");

                $idx = 0;

                $get_row = fgetcsv($file, 10000, ";");

                $peserta = [];

                // if (count($get_row) <= 1) {
                //     $a = str_split($get_row[0]);
                //     return back()->with('error', "Format CSV salah. Format adalah 'nomor_akuisisi_byu'");
                // }

                $user = DB::table('data_user')->where('telp', $request->telp_ds)->where('status', 1)->first();
                $sekolah = DB::table('Data_Sekolah_Sumatera')->where('NPSN', $request->npsn)->first();
                // ddd([$user, $sekolah]);

                while (($row = fgetcsv($file, 10000, ";")) !== FALSE) {
                    // ddd($row);
                    if ($idx < 1001) {
                        $data = [
                            'nama' => $user->nama,
                            'telp' => $user->telp,
                            'id_digipos' => $user->id_digipos,
                            'jenis' => 'EVENT',
                            'kategori' => 'BYU',
                            'detail' => '',
                            'poi' => $sekolah->NPSN . '-' . $sekolah->NAMA_SEKOLAH,
                            'jarak' => '0',
                            'serial' => '',
                            'msisdn' => $row[0],
                            'date' => date('Y-m-d'),
                            'status' => 'POI',
                            'consumen' => '|||',
                        ];

                        array_push($peserta, $data);
                        // echo '<pre>' . $idx . var_export($data, true) . '</pre>';
                        // ddd($peserta);
                    } else if ($idx > 1001) {
                        break;
                    }
                    $idx++;
                }

                if (count($peserta)) {
                    $msisdns = array_column($data, 'msisdn');

                    // Check for duplicate 'msisdn' values
                    $uniqueMsisdns = array_unique($msisdns);

                    if (
                        count($msisdns) !== count($uniqueMsisdns)
                    ) {
                        // Handle the case where there are duplicate 'msisdn' values in $data
                        return back()->with('error', "Terdapat duplikat msisdn");
                    } else {
                        // Insert the data into the database table
                        DB::table('sales_copy')->insertOrIgnore($peserta);
                    }
                }
            }
        }

        // $data = DB::table('peserta_event_sekolah')->insert([
        //     'telp_ds' => $request->telp_ds,
        //     'npsn' => $request->npsn,
        //     'nama_peserta' => $request->nama_peserta,
        //     'telp_peserta' => $request->telp_peserta,
        //     'no_akuisisi_byu' => $request->no_akuisisi_byu,
        //     'date' => date('Y-m-d'),
        // ]);

        return back()->with('success', 'Berhasil Upload Data Peserta');
    }
}
