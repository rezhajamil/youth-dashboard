<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $session = DB::table('quiz_session')->orderBy('status', 'desc')->orderBy('date')->get();
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
            'time' => 'required|numeric'
        ]);

        $quiz = DB::table('quiz_session')->insert([
            'nama' => $request->nama,
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
        $active = DB::table('quiz_session')->where('status', '1')->first();

        if ($active) {
            $active->update([
                'status' => '0'
            ]);
        }

        DB::table('quiz_session')->where('id', $id)->update([
            'status' => '1'
        ]);

        return back();
    }

    public function answer(Request $request, $id)
    {
        $plain = true;
        $quiz = DB::table('quiz_session')->find($id);
        $answer = DB::table('quiz_answer')->where('session', $id)->where('telp', $request->telp)->first();
        $user = DB::table('data_user')->where('telp', $request->telp)->first();
        return view('directUser.quiz.answer', compact('quiz', 'answer', 'id', 'plain', 'user'));
    }

    public function start(Request $request, $id)
    {
        $plain = true;
        $quiz = DB::table('quiz_session')->find($id);
        $answer = DB::table('quiz_answer')->where('session', $id)->where('telp', $request->telp)->first();

        DB::table('quiz_answer')->insert([
            'session' => $id,
            'telp' => $request->telp,
            'time_start' => date('Y-m-d H:i:s'),
            'hasil' => '0'
        ]);

        return redirect(URL::to('/answer/quiz/' . $id . '?telp=' . $request->telp));
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

        return redirect(URL::to('/answer/quiz/' . $request->session . '?telp=' . $request->telp));
    }
}
