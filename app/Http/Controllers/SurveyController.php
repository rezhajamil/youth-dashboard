<?php

namespace App\Http\Controllers;

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
            'time' => 'required|numeric',
            'jenis' => 'required',
        ]);

        $survey = DB::table('survey_session')->insert([
            'nama' => ucwords($request->nama),
            'time' => $request->time,
            'jenis' => $request->jenis,
            'date' => date('Y-m-d'),
            'deskripsi' => $request->deskripsi,
            'soal' => json_encode($request->soal),
            'opsi' => json_encode($request->opsi),
            'jawaban' => json_encode($request->jawaban),
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
        // $active = DB::table('survey_session')->where('status', '1')->first();

        // if ($active) {
        //     DB::table('survey_session')->where('status', '1')->update([
        //         'status' => '0'
        //     ]);
        // }

        $survey = DB::table('survey_session')->find($id);
        DB::table('survey_session')->where('id', $id)->update([
            'status' => !$survey->status
        ]);

        return back();
    }

    public function answer(Request $request)
    {
        $plain = true;
        $survey = DB::table('survey_session')->where('status', '1')->where('jenis', 'Youth Apps')->orderBy('date', 'desc')->first();
        if ($survey) {
            $answer = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->first();
        } else {
            $answer = [];
        }
        $user = DB::table('data_user')->where('telp', $request->telp)->first();
        $history = DB::select("SELECT * FROM survey_answer a JOIN survey_session b ON a.session=b.id where a.telp='" . $request->telp . "' and MONTH(b.date)=" . date('m') . " order BY b.date");

        return view('directUser.survey.answer', compact('survey', 'answer', 'plain', 'user', 'history'));
    }

    public function start(Request $request)
    {
        $plain = true;
        $survey = DB::table('survey_session')->where('status', '1')->where('jenis', 'Youth Apps')->first();
        $answer = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->count();

        if ($answer < 1) {
            DB::table('survey_answer')->insert([
                'session' => $survey->id,
                'telp' => $request->telp,
                'time_start' => date('Y-m-d H:i:s'),
                'hasil' => '0'
            ]);
        }

        return redirect(URL::to('/qns?telp=' . $request->telp));
    }

    public function store_answer(Request $request)
    {
        $survey = DB::table('survey_session')->find($request->session);
        $jawaban = json_decode($survey->jawaban);
        $hasil = 0;
        $pilihan = [];

        foreach ($jawaban as $key => $data) {
            if ($data == $request['pilihan' . $key]) {
                $hasil++;
            }
            array_push($pilihan, $request['pilihan' . $key]);
        }

        DB::table('survey_answer')->where('session', $request->session)->where('telp', $request->telp)->update([
            'hasil' => $hasil,
            'finish' => '1',
            'pilihan' => json_encode($pilihan)
        ]);

        return redirect(URL::to('/qns?telp=' . $request->telp));
    }

    public function answer_list($id)
    {
        $resume = DB::select("SELECT b.regional,b.branch,b.`cluster`,
                        COUNT(CASE WHEN a.`session`='$id' THEN a.telp END) as partisipan,
                        d.total
                        FROM survey_answer as a  
                        right JOIN data_user as b
                        ON a.telp=b.telp
                        JOIN (SELECT c.`cluster`,COUNT(c.telp) as total FROM data_user as c GROUP BY 1) as d
                        ON b.`cluster`=d.`cluster`
                        GROUP BY 1,2,3
                        ORDER BY b.regional desc,b.branch,b.`cluster`;");
        if (request()->get('jenis') == 'event') {
            $answer = DB::table('survey_answer')->join('user_event', 'user_event.telp', '=', 'survey_answer.telp')->distinct('nama')->where('session', $id)->orderBy('nama')->get();
        } else {
            $answer = DB::table('survey_answer')->select(["survey_answer.id", "cluster", "nama", "survey_answer.telp", "role", "session", "hasil", "pilihan"])->join('data_user', 'data_user.telp', '=', 'survey_answer.telp')->distinct('nama')->where('session', $id)->orderBy('cluster')->orderBy('nama')->get();
        }
        $survey = DB::table('survey_session')->find($id);
        return view('directUser.survey.result', compact('answer', 'survey', 'resume'));
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
        // ddd(json_decode($answer->pilihan));

        return view('directUser.survey.show_answer', compact('answer', 'survey', 'user'));
    }
}
