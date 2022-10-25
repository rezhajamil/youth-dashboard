<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
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
        if (Auth::user()->privilege == 'branch') {
            abort(403);
        }
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
            'deskripsi' => $request->deskripsi,
            'soal' => json_encode($request->soal),
            'opsi' => json_encode($request->opsi),
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
        if ($request->npsn) {
            $survey = DB::table('survey_session')->where('status', '1')->where('tipe', 'Siswa')->orderBy('date', 'desc')->first();
            $survey->soal = json_decode($survey->soal);
            $survey->jenis_soal = json_decode($survey->jenis_soal);
            $survey->opsi = json_decode($survey->opsi);
            $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);

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

        if ($request->npsn) {
            if ($request->finish) {
                return view('directUser.survey.market', compact('survey', 'plain', 'sekolah'));
            } else {
                return view('directUser.survey.market', compact('survey', 'plain', 'user', 'sekolah'));
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
                'kelas' => $request->kelas,
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
            $answer = DB::table('survey_answer')->where('telp_siswa', $request->jawaban_1[0])->count();
            if ($answer < 1) {
                DB::table('survey_answer')->insert([
                    'session' => $request->session,
                    'npsn' => $request->npsn,
                    'kelas' => $request->kelas,
                    'pilihan' => json_encode($pilihan),
                    'telp_siswa' => $request->jawaban_1[0],
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

    public function answer_list($id)
    {
        $resume = DB::table('survey_answer')->where('session', $id)->get();
        $answer = DB::table('survey_answer')->select(['survey_answer.*', 'data_user.cluster', 'nama', 'NAMA_SEKOLAH'])->join('data_user', 'data_user.telp', '=', 'survey_answer.telp')->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->orderBy('data_user.cluster')->orderBy('nama')->get();
        $survey = DB::table('survey_session')->find($id);

        $hasil = [];

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

        // ddd($hasil);

        return view('directUser.survey.result', compact('answer', 'survey', 'resume', 'hasil'));
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


    public function find_school(Request $request)
    {
        $name = $request->name;
        $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['NPSN', 'NAMA_SEKOLAH'])->where('PROVINSI', 'Sumatera Utara')->where('NAMA_SEKOLAH', 'like', '%' . $name . '%')->orderBy('NAMA_SEKOLAH')->limit('10')->get();

        return response()->json($sekolah);
    }
}
