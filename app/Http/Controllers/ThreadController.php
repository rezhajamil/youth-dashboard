<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadComment;
use App\Models\ThreadVote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tab = $request->tab;
        $user = DB::table('data_user')->where('telp', $request->telp)->first();

        // $threads = DB::table('threads')->select('data_user.telp', 'data_user.nama', 'data_user.cluster', 'threads.message', 'threads.vote as score', 'threads.created_at as thread_create', 'threads.updated_at as thread_update', 'thread_comments.message as comment', 'thread_comments.created_at as comment_create', 'thread_votes.vote')
        $threads = Thread::with(['user', 'comments', 'votes' => function ($query) use ($user) {
            $query->where('telp', $user->telp);
        }]);

        if ($tab == '' || $tab == "populer") {
            $threads = $threads->orderBy('threads.vote', 'desc')->orderBy('threads.created_at', 'asc')->get();
        } else if ($tab == 'terbaru') {
            $threads = $threads->orderBy('threads.created_at', 'desc')->get();
        } else if ($tab == 'saya') {
            $threads = $threads->where('threads.telp', $user->telp)->get();
        }
        // ddd($threads);
        foreach ($threads as $idx_t => $thread) {
            $waktu_thread = Carbon::parse($thread->created_at);

            $selisih_thread = $waktu_thread->diffInMinutes(); // Menghitung selisih_thread menit antara waktu yang ditetapkan dan waktu sekarang

            if ($selisih_thread < 1) {
                $thread->time = '1 menit yang lalu';
            } else if ($selisih_thread < 60) {
                $thread->time = $selisih_thread . ' menit yang lalu';
            } elseif ($selisih_thread < 1440) {
                $thread->time = round($selisih_thread / 60) . ' jam yang lalu';
            } elseif ($selisih_thread < 43200) {
                $thread->time = round($selisih_thread / 1440) . ' hari yang lalu';
            } elseif ($selisih_thread < 525600) {
                $thread->time = round($selisih_thread / 43200) . ' bulan yang lalu';
            } else {
                $thread->time = round($selisih_thread / 525600) . ' tahun yang lalu';
            }


            foreach ($thread->comments as $key => $comment) {
                $waktu_comment = Carbon::parse($comment->created_at);
                $selisih_comment = $waktu_comment->diffInMinutes(); // Menghitung selisih_thread menit antara waktu yang ditetapkan dan waktu sekarang

                if ($selisih_comment < 1) {
                    $comment->time = '1 menit yang lalu';
                } else if ($selisih_comment < 60) {
                    $comment->time = $selisih_comment . ' menit yang lalu';
                } elseif ($selisih_comment < 1440) {
                    $comment->time = round($selisih_comment / 60) . ' jam yang lalu';
                } elseif ($selisih_comment < 43200) {
                    $comment->time = round($selisih_comment / 1440) . ' hari yang lalu';
                } elseif ($selisih_comment < 525600) {
                    $comment->time = round($selisih_comment / 43200) . ' bulan yang lalu';
                } else {
                    $comment->time = round($selisih_comment / 525600) . ' tahun yang lalu';
                }
            }
        }

        // ddd($threads[0]->votes);
        return view('directUser.thread.index', compact('user', 'threads', 'tab'));
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

    public function vote(Request $request)
    {
    }

    public function store_comment(Request $request)
    {
        $request->validate([
            'thread' => ['required'],
            'telp' => ['required'],
            'message' => ['required'],
        ]);

        $comment = ThreadComment::insert([
            'thread_id' => $request->thread,
            'telp' => $request->telp,
            'message' => $request->message,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // ddd($comment->thread_id);

        return back();
    }

    public function store_comment_api(Request $request)
    {
        $request->validate([
            'thread' => ['required'],
            'telp' => ['required'],
            'message' => ['required'],
        ]);

        $comment = ThreadComment::insert([
            'thread_id' => $request->thread,
            'telp' => $request->telp,
            'message' => $request->message,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // ddd($comment->thread_id);

        return response()->json($comment);
    }

    public function vote_api(Request $request)
    {
        $request->validate([
            'telp' => ['required'],
            'thread' => ['required'],
            'type' => ['required'],
        ]);

        $vote = ThreadVote::where('thread_id', $request->thread)->where('telp', $request->telp)->first();

        if ($request->type == 'up') {
            $thread = Thread::find($request->thread);

            if ($vote) {
                $thread->vote = $thread->vote + 2;
                ThreadVote::where('thread_id', $request->thread)->where('telp', $request->telp)->delete();
            } else {
                $thread->vote = $thread->vote + 1;
            }

            $thread->save();
        } else if ($request->type == 'down') {
            $thread = Thread::find($request->thread);

            if ($vote) {
                $thread->vote = $thread->vote - 2;
                ThreadVote::where('thread_id', $request->thread)->where('telp', $request->telp)->delete();
            } else {
                $thread->vote = $thread->vote - 1;
            }

            $thread->save();
        }

        ThreadVote::create([
            'thread_id' => $request->thread,
            'telp' => $request->telp,
            'type' => $request->type,
        ]);

        return response()->json($thread);
    }
}
