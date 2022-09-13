<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class QuizController extends Controller
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
        $session = DB::table('quiz_session')->orderBy('date', 'desc')->get();
        return view('directUser.quiz.index', compact('session'));
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
        return view('directUser.quiz.create');
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
            'time' => 'required|numeric'
        ]);

        $quiz = DB::table('quiz_session')->insert([
            'nama' => ucwords($request->nama),
            'time' => $request->time,
            'date' => date('Y-m-d'),
            'deskripsi' => $request->deskripsi,
            'soal' => json_encode($request->soal),
            'opsi' => json_encode($request->opsi),
            'jawaban' => json_encode($request->jawaban),
            'status' => '0'
        ]);

        return redirect()->route('quiz.index');
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
        $quiz = DB::table('quiz_session')->find($id);

        return view('directUser.quiz.show', compact('quiz'));
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
        // $active = DB::table('quiz_session')->where('status', '1')->first();

        // if ($active) {
        //     DB::table('quiz_session')->where('status', '1')->update([
        //         'status' => '0'
        //     ]);
        // }

        $quiz = DB::table('quiz_session')->find($id);
        DB::table('quiz_session')->where('id', $id)->update([
            'status' => !$quiz->status
        ]);

        return back();
    }

    public function answer(Request $request)
    {
        $plain = true;
        $quiz = DB::table('quiz_session')->where('status', '1')->where('jenis', 'Youth Apps')->orderBy('date', 'desc')->first();
        if ($quiz) {
            $answer = DB::table('quiz_answer')->where('session', $quiz->id)->where('telp', $request->telp)->first();
        } else {
            $answer = [];
        }
        $user = DB::table('data_user')->where('telp', $request->telp)->first();
        $history = DB::select("SELECT * FROM quiz_answer a JOIN quiz_session b ON a.session=b.id where a.telp='" . $request->telp . "' and MONTH(b.date)=" . date('m') . " order BY b.date");

        return view('directUser.quiz.answer', compact('quiz', 'answer', 'plain', 'user', 'history'));
    }

    public function start(Request $request)
    {
        $plain = true;
        $quiz = DB::table('quiz_session')->where('status', '1')->where('jenis', 'Youth Apps')->first();
        $answer = DB::table('quiz_answer')->where('session', $quiz->id)->where('telp', $request->telp)->first();

        DB::table('quiz_answer')->insert([
            'session' => $quiz->id,
            'telp' => $request->telp,
            'time_start' => date('Y-m-d H:i:s'),
            'hasil' => '0'
        ]);

        return redirect(URL::to('/qns?telp=' . $request->telp));
    }

    public function store_answer(Request $request)
    {
        $quiz = DB::table('quiz_session')->find($request->session);
        $jawaban = json_decode($quiz->jawaban);
        $hasil = 0;

        foreach ($jawaban as $key => $data) {
            if ($data == $request['pilihan' . $key]) {
                $hasil++;
            }
        }

        DB::table('quiz_answer')->where('session', $request->session)->where('telp', $request->telp)->update([
            'hasil' => $hasil,
            'finish' => '1'
        ]);

        return redirect(URL::to('/qns?telp=' . $request->telp));
    }

    public function answer_list($id)
    {
        $resume = DB::select("SELECT b.regional,b.branch,b.`cluster`,
                        COUNT(CASE WHEN a.`session`='$id' THEN a.telp END) as partisipan,
                        d.total
                        FROM quiz_answer as a  
                        right JOIN data_user as b
                        ON a.telp=b.telp
                        JOIN (SELECT c.`cluster`,COUNT(c.telp) as total FROM data_user as c GROUP BY 1) as d
                        ON b.`cluster`=d.`cluster`
                        GROUP BY 1,2,3
                        ORDER BY b.regional desc,b.branch,b.`cluster`;");
        $answer = DB::table('quiz_answer')->join('data_user', 'data_user.telp', '=', 'quiz_answer.telp')->distinct('nama')->where('session', $id)->orderBy('cluster')->orderBy('nama')->get();
        $quiz = DB::table('quiz_session')->find($id);
        return view('directUser.quiz.result', compact('answer', 'quiz', 'resume'));
    }
}
