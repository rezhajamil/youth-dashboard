<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
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
        $request->validate([
            'nama' => 'required',
            'time' => 'required|numeric',
            'jenis' => 'required',
        ]);

        $quiz = DB::table('quiz_session')->insert([
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
        $answer = DB::table('quiz_answer')->where('session', $quiz->id)->where('telp', $request->telp)->count();

        if ($answer < 1) {
            DB::table('quiz_answer')->insert([
                'session' => $quiz->id,
                'telp' => $request->telp,
                'time_start' => date('Y-m-d H:i:s'),
                'hasil' => '0'
            ]);
        }

        return redirect(URL::to('/qns?telp=' . $request->telp));
    }

    public function store_answer(Request $request)
    {
        $quiz = DB::table('quiz_session')->find($request->session);
        $jawaban = json_decode($quiz->jawaban);
        $hasil = 0;
        $pilihan = [];

        foreach ($jawaban as $key => $data) {
            if ($data == $request['pilihan' . $key]) {
                $hasil++;
            }
            array_push($pilihan, $request['pilihan' . $key]);
        }

        DB::table('quiz_answer')->where('session', $request->session)->where('telp', $request->telp)->update([
            'hasil' => $hasil,
            'finish' => '1',
            'time_end' => date('Y-m-d H:i:s'),
            'pilihan' => json_encode($pilihan),
        ]);

        return redirect(URL::to('/qns?telp=' . $request->telp));
    }

    public function answer_list($id)
    {
        $territory_resume = Auth::user()->privilege == "branch" ? "and b.branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "and b.cluster='" . Auth::user()->cluster . "'" : '');
        $territory_answer = Auth::user()->privilege == "branch" ? "and data_user.branch='" . Auth::user()->branch . "'" : (Auth::user()->privilege == "cluster" ? "and data_user.cluster='" . Auth::user()->cluster . "'" : '');


        $resume = DB::select("SELECT b.regional,b.branch,b.`cluster`,
                        COUNT(CASE WHEN a.`session`='$id' THEN a.telp END) as partisipan,
                        MAX(d.total) as total
                        FROM quiz_answer as a  
                        right JOIN data_user as b
                        ON a.telp=b.telp
                        JOIN (SELECT c.`cluster`,COUNT(c.telp) as total FROM data_user as c 
                        WHERE c.status='1'  AND c.role IN ('AO','EO','YBA') GROUP BY 1) as d
                        ON b.`cluster`=d.`cluster`
                        WHERE NOT b.`branch`='ALL' AND b.status=1 AND b.role IN ('AO','EO','YBA') $territory_resume
                        GROUP BY 1,2,3
                        ORDER BY b.regional desc,b.branch,b.`cluster`;");


        if (request()->get('jenis') == 'event') {
            $answer = DB::table('quiz_answer')->join('user_event', 'user_event.telp', '=', 'quiz_answer.telp')->distinct('nama')->where('session', $id)->orderBy('nama')->get();
        } else {
            // $answer = DB::table('quiz_answer')->select(["quiz_answer.id", "cluster", "nama", "quiz_answer.telp", "role", "session", "hasil", "pilihan"])->join('data_user', 'data_user.telp', '=', 'quiz_answer.telp')->distinct('nama')->where('session', $id)->orderBy('cluster')->orderBy('nama')->get();
            $answer = DB::select("SELECT quiz_answer.id, cluster, nama, quiz_answer.telp, role, session, hasil, pilihan,time_start,time_end,TIMESTAMPDIFF(SECOND, time_start, time_end) AS durasi from quiz_answer join data_user on data_user.telp=quiz_answer.telp WHERE session='$id' $territory_answer ORDER BY hasil desc,CASE WHEN durasi IS NULL THEN 1 ELSE 0 END,durasi,time_start");
        }
        $quiz = DB::table('quiz_session')->find($id);
        return view('directUser.quiz.result', compact('answer', 'quiz', 'resume'));
    }

    public function show_answer(Request $request, $id)
    {
        $answer = DB::table('quiz_answer')->find($id);
        $quiz = DB::table('quiz_session')->find($answer->session);

        if ($request->jenis != 'event') {
            $user = DataUser::where('telp', $answer->telp)->first();
        } else {
            $user = [];
        }
        // ddd(json_decode($answer->pilihan));

        return view('directUser.quiz.show_answer', compact('answer', 'quiz', 'user'));
    }
}
