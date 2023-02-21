<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (Auth::user()->privilege == 'branch') {
        //     abort(403);
        // }
        $session = DB::table('survey_session')->orderBy('date', 'desc')->get();
        return view('directUser.survey.index', compact('session'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->privilege == 'branch') {
            abort(403);
        }
        return view('directUser.survey.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->privilege == 'branch') {
            abort(403);
        }
        $request->validate([
            'nama' => 'required',
        ]);

        $survey = DB::table('survey_session')->insert([
            'nama' => ucwords($request->nama),
            'date' => date('Y-m-d'),
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi,
            'soal' => json_encode($request->soal),
            'opsi' => json_encode($request->opsi),
            'jumlah_opsi' => json_encode($request->jumlah_opsi),
            'jenis_soal' => json_encode($request->jenis_soal),
            'validasi' => json_encode($request->validasi),
            'status' => '0'
        ]);

        return redirect()->route('survey.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->privilege == 'branch') {
            abort(403);
        }
        $survey = DB::table('survey_session')->find($id);

        return view('directUser.survey.show', compact('survey'));
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

    public function change_status($id)
    {
        $survey = DB::table('survey_session')->find($id);
        DB::table('survey_session')->where('id', $id)->update([
            'status' => !$survey->status
        ]);

        return back();
    }

    public function answer(Request $request)
    {
        $plain = true;
        // ddd(json_encode([
        //     "",
        //     "Pensi",
        //     "Olahraga",
        //     "Game Competition",
        //     "Knowledge Seminar",
        //     "Visit Artis Favorit",
        //     "Pulsa",
        //     "Kuota Internet",
        //     "Peralatan Sekolah",
        //     "Uang Saku",
        //     "Hape",
        //     "",
        //     "",
        //     "",
        //     "Telkomsel",
        //     "Indosat",
        //     "Tri",
        //     "XL",
        //     "Axis",
        //     "Smartfren",
        //     "ByU",
        //     "Telkomsel",
        //     "Indosat",
        //     "Tri",
        //     "XL",
        //     "Axis",
        //     "Smartfren",
        //     "ByU",
        //     "",
        //     "Nelpon Jernih",
        //     "Internetan Cepat",
        //     "Harga Paket Internetan Murah",
        //     "Kuota Besar",
        //     "Masa Aktif Panjang",
        //     "Dibawah 10 ribu",
        //     "10 ribu - 20 ribu",
        //     "20 ribu - 30 ribu",
        //     "30 ribu - 50 ribu",
        //     "Diatas 50 ribu",
        //     "Dibawah 2 GB",
        //     "2 GB - 5 GB",
        //     "5 GB - 10 GB",
        //     "10 GB - 15 GB",
        //     "Diatas 15 GB",
        //     "Instagram",
        //     "Facebook",
        //     "Twitter",
        //     "Linkedin",
        //     "Youtube",
        //     "TikTok",
        //     "Whatsapp",
        //     "Line",
        //     "Streaming Musik",
        //     "Streaming Video",
        //     "Streaming Film",
        //     "Streaming Youtube",
        //     "Semuanya",
        //     "Netflix",
        //     "Disney Hotstar",
        //     "Maxstream",
        //     "Vidio",
        //     "Lainnya",
        //     "Free Fire",
        //     "Mobile Legend",
        //     "PUBG Mobile",
        //     "Tidak Suka Main Game",
        //     "Lainnya",
        //     "Kantin / Koperasi sekolah",
        //     "Outlet Sekitar Sekolah",
        //     "Outlet Sekitar Rumah",
        //     "Indomaret / Alfamart dan sejenisnya",
        //     "MyTelkomsel / MyXL / MyCare / MySmartfren dan sejenisnya",
        //     "Bank / E-Wallet / Tokopedia dan sejenisnya",
        // ]));

        if ($request->npsn) {
            $survey = DB::table('survey_session')->where('status', '1')->where('tipe', 'Siswa')->orderBy('date', 'desc')->first();
            $survey->soal = json_decode($survey->soal);
            $survey->jenis_soal = json_decode($survey->jenis_soal);
            $survey->opsi = json_decode($survey->opsi);
            $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);
            $survey->validasi = json_decode($survey->validasi);

            $sekolah = DB::table('Data_Sekolah_Sumatera')->where('NPSN', $request->npsn)->first();
        } else {
            $survey = DB::table('survey_session')->where('status', '1')->where('tipe', 'DS')->orderBy('date', 'desc')->first();
        }

        if ($survey) {
            $answer = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->where('telp_siswa', $request->telp_siswa)->first();
            $history = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->orderBy('npsn')->orderBy('kelas')->orderBy('telp_siswa')->get();
        } else {
            $answer = [];
            $answer = [];
            $history = [];
        }
        // ddd($survey);
        $user = DB::table('data_user')->where('telp', $request->telp)->first();
        $title = $survey->nama;

        if ($request->npsn) {
            if ($request->finish) {
                return view('directUser.survey.market', compact('survey', 'plain', 'sekolah'));
            } else {
                return view('directUser.survey.market', compact('survey', 'plain', 'user', 'sekolah', 'title'));
            }
        } else {
            return view('directUser.survey.answer', compact('survey', 'answer', 'plain', 'user', 'history'));
        }
    }

    public function start(Request $request)
    {
        $plain = true;
        $survey = DB::table('survey_session')->where('status', '1')->orderBy('date', 'desc')->first();
        $answer = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->where('telp_siswa', $request->telp_siswa)->count();

        if ($answer < 1) {
            DB::table('survey_answer')->insert([
                'session' => $survey->id,
                'telp' => $request->telp,
                'npsn' => $request->npsn,
                'kelas' => $request->kelas ?? 'All',
                'telp_siswa' => $request->telp_siswa,
                'time_start' => date('Y-m-d H:i:s'),
                'finish' => '0',
            ]);

            return redirect(URL::to('/qns/survey?telp=' . $request->telp . '&npsn=' . $request->npsn . '&kelas=' . $request->kelas . '&telp_siswa=' . $request->telp_siswa));
        }

        return redirect(URL::to('/qns/survey?telp=' . $request->telp));
    }

    public function store_answer(Request $request)
    {
        $survey = DB::table('survey_session')->find($request->session);
        $soal = json_decode($survey->soal);
        $jenis_soal = json_decode($survey->jenis_soal);
        $opsi = json_decode($survey->opsi);
        $jumlah_opsi = json_decode($survey->jumlah_opsi);
        $pilihan = [];

        if ($survey->tipe == 'DS') {
            foreach ($soal as $key => $data) {
                array_push($pilihan, $request['pilihan' . $key]);
            }
        } else if ($survey->tipe == 'Siswa') {
            $posisi = 0;
            $others = [];
            foreach ($soal as $key => $data) {
                $other = '';
                switch ($jenis_soal[$key]) {
                    case 'Isian':
                        array_push($pilihan, $request['jawaban_' . $key]);
                        break;
                    case 'Pilgan':
                        array_push($pilihan, $request['jawaban_' . $key]);
                        break;
                    case 'Pilgan & Isian':
                        array_push($pilihan, $request['jawaban_' . $key]);
                        break;
                    case 'Checklist':
                        array_push($pilihan, $request['jawaban_' . $key]);
                        break;
                    case 'Prioritas':
                        array_push($pilihan, $request['jawaban_' . $key]);
                        break;
                    default:
                        break;
                }
                array_push($others, $other);
            }
        }

        if ($request->npsn) {
            $answer = DB::table('survey_answer')->where('telp_siswa', $request->jawaban_0[0])->count();
            // ddd($request->session);
            if ($answer < 1) {
                $sekolah = Sekolah::where('npsn', $request->npsn)->first();
                DB::table('survey_answer')->insert([
                    'session' => $request->session,
                    'npsn' => $request->npsn,
                    'telp' => $sekolah->TELP,
                    'kelas' => $request->kelas ?? 'All',
                    'pilihan' => json_encode($pilihan),
                    'telp_siswa' => $request->jawaban_0[0],
                    'time_start' => date('Y-m-d H:i:s'),
                    'finish' => '1'
                ]);
            }
        } else {
            DB::table('survey_answer')->where('session', $request->session)->where('telp', $request->telp)->where('telp_siswa', $request->telp_siswa)->update([
                'finish' => '1',
                'pilihan' => json_encode($pilihan)
            ]);
        }

        if ($request->npsn) {
            return redirect(URL::to("/qns/survey?npsn=$request->npsn&finish=1"));
        } else {
            return redirect(URL::to('/qns/survey?telp=' . $request->telp));
        }
    }

    public function resume($id)
    {
        $resume = DB::table('survey_answer')->where('session', $id)->get();

        $survey = DB::table('survey_session')->find($id);

        $hasil = [];

        if ($survey->tipe == 'DS') {
            $answer = DB::table('survey_answer')->select(['survey_answer.*', 'data_user.cluster', 'nama', 'NAMA_SEKOLAH'])->join('data_user', 'data_user.telp', '=', 'survey_answer.telp')->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->orderBy('data_user.cluster')->orderBy('nama')->get();
            foreach ($resume as $idx => $resume) {
                foreach (json_decode($resume->pilihan) as $soal => $pilihan) {
                    $hasil[$soal]['A'] = $hasil[$soal]['A'] ?? 0;
                    $hasil[$soal]['B'] = $hasil[$soal]['B'] ?? 0;
                    $hasil[$soal]['C'] = $hasil[$soal]['C'] ?? 0;
                    $hasil[$soal]['D'] = $hasil[$soal]['D'] ?? 0;
                    $hasil[$soal]['E'] = $hasil[$soal]['E'] ?? 0;
                    switch ($pilihan) {
                        case 'A':
                            $hasil[$soal]['A'] += 1;
                            break;
                        case 'B':
                            $hasil[$soal]['B'] += 1;
                            break;
                        case 'C':
                            $hasil[$soal]['C'] += 1;
                            break;
                        case 'D':
                            $hasil[$soal]['D'] += 1;
                            break;
                        case 'E':
                            $hasil[$soal]['E'] += 1;
                            break;

                        default:
                            # code...
                            break;
                    }
                }
            }

            return view('directUser.survey.result', compact('answer', 'survey', 'resume', 'hasil'));
        } else if ($survey->tipe == 'Siswa') {
            $answer = DB::table('survey_answer')->where('session', $id)->get();
            if (auth()->user()->privilege == 'branch') {
                $sekolah = DB::table('survey_answer')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH'])->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->where('branch', auth()->user()->branch)->distinct()->get();
            } else if (auth()->user()->privilege == 'cluster') {
                $sekolah = DB::table('survey_answer')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH'])->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->where('cluster', auth()->user()->cluster)->distinct()->get();
            } else {
                $sekolah = DB::table('survey_answer')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH'])->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->distinct()->get();
            }



            $survey->soal = json_decode($survey->soal);
            $survey->jenis_soal = json_decode($survey->jenis_soal);
            $survey->opsi = json_decode($survey->opsi);
            $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);

            return view('directUser.survey.result_market', compact('answer', 'survey', 'resume', 'hasil', 'sekolah'));
        }
    }

    public function answer_list(Request $request)
    {
        $survey = DB::table('survey_session')->find($request->session);

        $hasil = [];

        $answer = DB::table('survey_answer')->where('session', $request->session)->where('npsn', $request->npsn)->get();
        $sekolah = DB::table('survey_answer')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH'])->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $request->session)->distinct()->get();

        $survey->soal = json_decode($survey->soal);
        $survey->jenis_soal = json_decode($survey->jenis_soal);
        $survey->opsi = json_decode($survey->opsi);
        $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);

        return view('directUser.survey.result_list_market', compact('answer', 'survey', 'hasil', 'sekolah'));
    }

    public function show_answer(Request $request, $id)
    {
        $answer = DB::table('survey_answer')->find($id);
        $survey = DB::table('survey_session')->find($answer->session);

        if ($request->jenis != 'event') {
            $user = DataUser::where('telp', $answer->telp)->first();
        } else {
            $user = [];
        }

        return view('directUser.survey.show_answer', compact('answer', 'survey', 'user'));
    }

    public function lucky_draw()
    {
        $plain = true;
        $survey = DB::table('survey_session')->where('status', '1')->where('tipe', 'Siswa')->orderBy('date', 'desc')->first();
        $sekolah = DB::table('survey_answer', 'a')->where('session', $survey->id)->select(['b.NAMA_SEKOLAH', 'b.NPSN'])->join('Data_Sekolah_Sumatera as b', 'a.npsn', '=', 'b.NPSN')->distinct()->orderBy('b.NAMA_SEKOLAH')->get();
        return view('directUser.survey.lucky_draw', compact('survey', 'sekolah', 'plain'));
    }


    public function telp_list(Request $request)
    {
        $survey = $request->survey;
        $npsn = $request->npsn;
        $jumlah = $request->jumlah;
        $kelas = $request->kelas;

        if ($kelas == '') {
            $telp = DB::table('survey_answer')->select('telp_siswa')->where('npsn', $npsn)->where('session', $survey)->orderBy('time_start')->get();
        } else {
            $telp = DB::table('survey_answer')->select('telp_siswa')->where('npsn', $npsn)->where('kelas', $kelas)->where('session', $survey)->orderBy('time_start')->get();
        }

        return response()->json($telp);
    }

    public function find_school(Request $request)
    {
        $name = $request->name;
        $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['NPSN', 'NAMA_SEKOLAH'])->where('PROVINSI', 'Sumatera Utara')->where('NAMA_SEKOLAH', 'like', '%' . $name . '%')->orderBy('NAMA_SEKOLAH')->limit('10')->get();

        return response()->json($sekolah);
    }

    public function test(Request $request)
    {
        $name = $request->name;
        $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['NPSN', 'NAMA_SEKOLAH'])->where('PROVINSI', 'Sumatera Utara')->where('NAMA_SEKOLAH', 'like', '%' . $name . '%')->orderBy('NAMA_SEKOLAH')->limit('10')->get();

        return response()->json($sekolah);
    }
}
