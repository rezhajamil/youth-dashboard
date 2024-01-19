<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\Sekolah;
use App\Models\Territory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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
        $session = DB::table('survey_session')->orderBy('regional')->orderBy('branch')->orderBy('cluster')->orderBy('role')->orderBy('id', 'desc')->get();
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

        $region = DB::table('wilayah')->select('regional')->distinct()->whereNotNull('regional')->get();
        $branch = DB::table('wilayah')->select('branch')->distinct()->whereNotNull('branch')->get();
        $cluster = DB::table('territory_new')->select('cluster')->distinct()->whereNotNull('cluster')->orderBy('cluster')->get();
        $role = DB::table('user_type')->where('status', '1')->get();

        return view('directUser.survey.create', compact('region', 'branch', 'cluster', 'role'));
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
            'nama' => 'required|unique:survey_session,nama',
        ]);

        $survey = DB::table('survey_session')->insertGetId([
            'nama' => ucwords($request->nama),
            'regional' => $request->regional,
            'branch' => $request->branch,
            'cluster' => $request->cluster,
            'role' => $request->role,
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

        // $regional = $request->regional == 'All' ? '' : "-$request->regional";
        // $branch = $request->branch == 'All' ? '' : "-$request->branch";
        // $cluster = $request->cluster == 'All' ? '' : "-$request->cluster";
        $role = $request->role == 'All' ? '' : "-" . Str::lower($request->role);

        if ($request->cluster !== 'All') {
            $url = "s-" . Str::snake(Str::lower($request->cluster)) . $role . '-' . $survey;
        } else if ($request->branch !== 'All') {
            $url = "s-" . Str::snake(Str::lower($request->branch)) . $role . '-' . $survey;
        } else if ($request->regional !== 'All') {
            $url = "s-" . Str::snake(Str::lower($request->regional)) . $role . '-' . $survey;
        } else {
            $url = "s-" . $survey;
        }

        DB::table('survey_session')->where('id', $survey)->update([
            // 'url' => "https://tyes.live/admin/$url", 
            'url' => "$url",
        ]);

        return redirect()->route('survey.index');
    }

    public function redirect_survey(Request $request, $url)
    {
        if ($request->finish) {
            return redirect()->route('survey.answer.create', [$url, 'npsn' => $request->npsn, 'finish' => 1]);
        } else if ($url != '') {
            return redirect()->route('survey.answer.create', [$url, 'npsn' => $request->npsn]);
        } else {
            return redirect()->route('home');
        }
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

    public function answer(Request $request, $url)
    {
        $plain = true;

        // ddd($url);
        $survey = DB::table('survey_session')->where('url', $url)->orderBy('date', 'desc')->first();
        $survey->soal = json_decode($survey->soal);
        $survey->jenis_soal = json_decode($survey->jenis_soal);
        $survey->opsi = json_decode($survey->opsi);
        $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);
        $survey->validasi = json_decode($survey->validasi);

        if ($request->npsn) {
            $sekolah = DB::table('Data_Sekolah_Sumatera')->where('NPSN', $request->npsn)->first();
        } else {
            $sekolah = [];
        }

        // if ($request->npsn || $request->telp) {
        //     // ddd($url);
        //     // $survey = DB::table('survey_session')->where('status', '1')->where('tipe', 'Siswa')->orderBy('date', 'desc')->first();

        //     // ddd($survey);

        // } else {
        //     $survey = DB::table('survey_session')->where('status', '1')->where('tipe', 'DS')->orderBy('date', 'desc')->first();
        // }

        if ($survey) {
            $answer = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->first();
            // $answer = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->where('telp_siswa', $request->telp_siswa)->first();
            $history = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->orderBy('npsn')->orderBy('kelas')->orderBy('telp_siswa')->get();
        } else {
            $answer = [];
            $answer = [];
            $history = [];
        }
        // ddd($survey);
        $user = DB::table('data_user')->where('telp', $request->telp)->first();
        $title = $survey->nama ?? '';

        if ($request->npsn || $request->telp) {
            if ($request->finish) {
                return view('directUser.survey.market', compact('survey', 'plain', 'sekolah', 'url'));
            } else {
                return view('directUser.survey.market', compact('survey', 'plain', 'user', 'sekolah', 'title', 'url'));
            }
        } else {
            return view('directUser.survey.answer', compact('survey', 'answer', 'plain', 'user', 'history'));
        }
    }

    public function start(Request $request, $url)
    {
        $plain = true;
        // ddd($request->id);
        $survey = DB::table('survey_session')->where('url', $url)->where('status', '1')->orderBy('date', 'desc')->first();
        $answer = DB::table('survey_answer')->where('session', $survey->id)->where('telp', $request->telp)->where('telp_siswa', $request->telp_siswa)->count();

        if ($request->npsn) {
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
        } else {
            DB::table('survey_travel_answer')->insert([
                'session' => $survey->id,
                'telp' => $request->telp,
                'time_start' => date('Y-m-d H:i:s'),
                'finish' => '0',
            ]);
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
        // ddd($request);

        if ($survey->tipe == 'DS') {
            foreach ($soal as $key => $data) {
                array_push($pilihan, $request['pilihan' . $key]);
            }
        } else {
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
            $answer = DB::table('survey_answer')->where('session', $request->session)->where('telp_siswa', $request->jawaban_0[0])->whereMonth('time_start', date('m'))->whereYear('time_start', date('Y'))->count();
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
            } else {
                // return redirect(URL::to("/qns/survey/$request->url?npsn=$request->npsn&finish=1"));
                return redirect()->route('survey.answer.create', ['url' => $request->url, 'npsn' => $request->npsn, 'finish' => 1]);
            }
        } else if ($request->telp) {
            $answer = DB::table('survey_travel_answer')->where('session', $request->session)->where('telp_pic', $request->jawaban_3[0]);

            if ($request->jawaban_7[0] != "Belum Punya") {
                $answer->orWhere('id_digipos', $request->jawaban_8[0]);
            }

            $answer = $answer->count();
            // ddd($request->session);
            if ($answer < 1) {
                DB::table('survey_travel_answer')->insert([
                    'session' => $request->session,
                    'telp' => $request->telp,
                    'id_digipos' => $request->jawaban_8[0],
                    'pilihan' => json_encode($pilihan),
                    'telp_pic' => $request->jawaban_3[0],
                    'time_start' => date('Y-m-d H:i:s'),
                    'finish' => '1'
                ]);
            } else {
                return redirect(URL::to("/qns/survey/$request->url?telp=$request->telp&finish=1"));
            }
        } else {
            DB::table('survey_answer')->where('session', $request->session)->where('telp', $request->telp)->where('telp_siswa', $request->telp_siswa)->update([
                'finish' => '1',
                'pilihan' => json_encode($pilihan)
            ]);
        }

        if ($request->npsn) {
            return redirect(URL::to("/qns/survey/$request->url?npsn=$request->npsn&finish=1"));
        } else if ($request->telp) {
            return redirect(URL::to("/qns/survey/$request->url?telp=$request->telp&finish=1"));
        } else {
            return redirect(URL::to("/qns/$request->url?telp=$request->telp"));
        }
    }

    public function resume(Request $request, $id)
    {
        ini_set(
            'max_execution_time',
            '0'
        );
        ini_set('memory_limit', '-1');

        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $city = Territory::getCity();

        $survey = DB::table('survey_session')->find($id);

        $kode_operator = DB::table('kode_prefix_operator')->get();

        $operator = DB::table('kode_prefix_operator')->select('operator')->distinct()->orderBy('operator', 'desc')->get();

        $hasil = [];

        if ($survey->tipe == 'DS') {
            $resume = DB::table('survey_answer')->where('session', $id)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->get();
            // $resume = DB::table('survey_answer')->where('session', $id)->whereMonth('time_start', $month)->whereYear('time_start', $year)->get();
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
                $resume = DB::table('survey_answer')->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->where('branch', auth()->user()->branch)->whereMonth('time_start', $month)->whereYear('time_start', $year)->get();
                $sekolah = DB::table('survey_answer')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH'])->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->where('branch', auth()->user()->branch)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->distinct()->orderBy('NAMA_SEKOLAH')->get();
            } else if (auth()->user()->privilege == 'cluster') {
                $resume = DB::table('survey_answer')->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->where('cluster', auth()->user()->cluster)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->get();
                $sekolah = DB::table('survey_answer')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH'])->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->where('cluster', auth()->user()->cluster)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->distinct()->orderBy('NAMA_SEKOLAH')->get();
            } else {
                $resume = DB::table('survey_answer')->where('session', $id)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->get();
                $sekolah = DB::table('survey_answer')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH'])->join('Data_Sekolah_Sumatera', 'survey_answer.npsn', '=', 'Data_Sekolah_Sumatera.NPSN')->where('session', $id)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->distinct()->orderBy('NAMA_SEKOLAH')->get();
            }

            $survey->soal = json_decode($survey->soal);
            $survey->jenis_soal = json_decode($survey->jenis_soal);
            $survey->opsi = json_decode($survey->opsi);
            $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);
            // ddd([$resume, $sekolah]);

            return view('directUser.survey.result_market', compact('kode_operator', 'operator', 'answer', 'survey', 'resume', 'hasil', 'sekolah', 'city'));
        } else {
            $answer = DB::table('survey_answer')->where('session', $id)->get();
            if (auth()->user()->privilege == 'branch') {
                $resume = DB::table('survey_answer')->join('data_user', 'survey_answer.telp', '=', 'data_user.telp')->where('session', $id)->where('branch', auth()->user()->branch)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->get();
            } else if (auth()->user()->privilege == 'cluster') {
                $resume = DB::table('survey_answer')->join('data_user', 'survey_answer.telp', '=', 'data_user.telp')->where('session', $id)->where('cluster', auth()->user()->cluster)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->get();
            } else {
                $resume = DB::table('survey_answer')->where('session', $id)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->get();
            }

            $survey->soal = json_decode($survey->soal);
            $survey->jenis_soal = json_decode($survey->jenis_soal);
            $survey->opsi = json_decode($survey->opsi);
            $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);

            return view('directUser.survey.result_travel', compact('kode_operator', 'operator', 'answer', 'survey', 'resume', 'city'));
        }
    }

    public function answer_list(Request $request)
    {
        $survey = DB::table('survey_session')->find($request->session);

        // ddd($survey);
        $hasil = [];

        $survey->soal = json_decode($survey->soal);
        $survey->jenis_soal = json_decode($survey->jenis_soal);
        $survey->opsi = json_decode($survey->opsi);
        $survey->jumlah_opsi = json_decode($survey->jumlah_opsi);

        if ($survey->tipe == 'Siswa') {
            $answer = DB::table('survey_answer')->where('session', $request->session)->where('npsn', $request->npsn)->whereBetween('time_start', [$request->start_date, $request->end_date])->get();
            $sekolah = DB::table('Data_Sekolah_Sumatera')->where('NPSN', $request->npsn)->first();

            return view('directUser.survey.result_list_market', compact('answer', 'survey', 'hasil', 'sekolah'));
        } else if ($survey->tipe == 'Travel') {
            $answer = DB::table('survey_travel_answer')->join('data_user', 'survey_travel_answer.telp', '=', 'data_user.telp')->where('session', $request->session)->get();

            return view('directUser.survey.result_list_travel', compact('answer', 'survey', 'hasil'));
        }
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

    public function lucky_draw(Request $request)
    {
        $plain = true;
        $list_survey = DB::table('survey_session')->where('status', '1')->where('tipe', 'Siswa')->orderBy('date', 'desc')->get();

        if ($request->survey) {
            $survey = DB::table('survey_session')->where('url', $request->survey)->first();
            $sekolah = DB::table('survey_answer', 'a')->where('session', $survey->id)->select(['b.NAMA_SEKOLAH', 'b.NPSN'])->join('Data_Sekolah_Sumatera as b', 'a.npsn', '=', 'b.NPSN')->distinct()->orderBy('b.NAMA_SEKOLAH');
            $participant = DB::table('survey_answer', 'a')->select(['a.npsn', 'a.kelas', 'a.telp_siswa'])->where('session', $survey->id);

            if ($request->tanggal) {
                $sekolah = $sekolah->whereDate('a.time_start', '=', $request->tanggal);
                $participant = $participant->whereDate('a.time_start', '=', $request->tanggal);
            }

            $sekolah = $sekolah->get();
            $participant = $participant->get();
        } else {
            $survey = [];
            $sekolah = [];
            $participant = [];
        }

        return view('directUser.survey.lucky_draw', compact('list_survey', 'survey', 'sekolah', 'participant', 'plain'));
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
        if ($request->name) {
            $name = $request->name;
            $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['NPSN', 'NAMA_SEKOLAH'])->where('PROVINSI', 'Sumatera Utara')->where('NAMA_SEKOLAH', 'like', '%' . $name . '%')->orderBy('NAMA_SEKOLAH')->limit('10')->get();
        }
        return response()->json($sekolah);
    }

    public function test(Request $request)
    {
        if ($request->name) {
            $name = $request->name;
            $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['NPSN', 'NAMA_SEKOLAH'])->where('PROVINSI', 'Sumatera Utara')->where('NAMA_SEKOLAH', 'like', '%' . $name . '%')->orderBy('NAMA_SEKOLAH')->limit('10')->get();
        } else if ($request->city) {
            $city = $request->city;
            $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['NPSN', 'NAMA_SEKOLAH'])->where('KAB_KOTA', $city)->orderBy('NAMA_SEKOLAH')->get();
        }

        return response()->json($sekolah);
    }

    public function get_resume_school(Request $request)
    {
        $city = $request->city;
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');
        // $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH'])->join('survey_answer', "survey_answer.npsn", "=", "Data_Sekolah_Sumatera.NPSN")->where('KAB_KOTA', $city)->whereMonth("time_start", $request->month)->whereYear("time_start", $request->year)->distinct()->orderBy('NAMA_SEKOLAH', 'asc')->get();
        $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH', 'KECAMATAN'])->join('survey_answer', "survey_answer.npsn", "=", "Data_Sekolah_Sumatera.NPSN")->where('KAB_KOTA', $city)->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->distinct()->orderBy('NAMA_SEKOLAH', 'asc')->get();
        // $sekolah = DB::table('Data_Sekolah_Sumatera')->select(['Data_Sekolah_Sumatera.NPSN', 'NAMA_SEKOLAH', 'City', 'KECAMATAN'])->join('survey_answer', "survey_answer.npsn", "=", "Data_Sekolah_Sumatera.NPSN")->where('time_start', ">=", $start_date)->where('time_start', "<=", $end_date)->distinct()->orderBy('City', 'DESC')->orderBy('KECAMATAN', 'DESC')->orderBy('NAMA_SEKOLAH', 'DESC')->get();

        return response()->json($sekolah);
    }

    public function resume_territory(Request $request, $id)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $privilege = Auth::user()->privilege;
        $where = $privilege == 'superadmin' ? "" : "and $privilege='" . Auth::user()->{$privilege} . "'";

        $survey = DB::table('survey_session')->find($id);

        if ($start_date && $end_date) {
            $kode_operator = DB::table('kode_prefix_operator')->get();
            $operator = DB::table('kode_prefix_operator')->select('operator')->distinct()->orderBy('operator', 'desc')->get();
            $resume = DB::select("SELECT a.REGIONAL,a.BRANCH,a.CLUSTER,a.KAB_KOTA as CITY,b.telp_siswa FROM Data_Sekolah_Sumatera a JOIN survey_answer b ON a.NPSN=b.npsn WHERE b.session=$id AND b.time_start BETWEEN '$start_date' AND '$end_date' $where ORDER BY 1 DESC,2,3,4;");
            $region = DB::select("SELECT DISTINCT a.REGIONAL FROM Data_Sekolah_Sumatera a JOIN survey_answer b ON a.NPSN=b.npsn WHERE b.session=$id AND b.time_start BETWEEN '$start_date' AND '$end_date' $where ORDER BY REGIONAL DESC,BRANCH,CLUSTER,KAB_KOTA;");
            $branch = DB::select("SELECT DISTINCT a.BRANCH FROM Data_Sekolah_Sumatera a JOIN survey_answer b ON a.NPSN=b.npsn WHERE b.session=$id AND b.time_start BETWEEN '$start_date' AND '$end_date' $where ORDER BY REGIONAL DESC,BRANCH,CLUSTER,KAB_KOTA;");
            $cluster = DB::select("SELECT DISTINCT a.CLUSTER FROM Data_Sekolah_Sumatera a JOIN survey_answer b ON a.NPSN=b.npsn WHERE b.session=$id AND b.time_start BETWEEN '$start_date' AND '$end_date' $where ORDER BY REGIONAL DESC,BRANCH,CLUSTER,KAB_KOTA;");
            $city = DB::select("SELECT DISTINCT a.KAB_KOTA as CITY FROM Data_Sekolah_Sumatera a JOIN survey_answer b ON a.NPSN=b.npsn WHERE b.session=$id AND b.time_start BETWEEN '$start_date' AND '$end_date' $where ORDER BY REGIONAL DESC,BRANCH,CLUSTER,KAB_KOTA;");
        } else {
            $kode_operator = [];
            $operator = [];
            $resume = [];
            $region = [];
            $branch = [];
            $cluster = [];
            $city = [];
        }

        return view('directUser.survey.resume_territory', compact('survey', 'kode_operator', 'operator', 'resume', 'region', 'branch', 'cluster', 'city'));
    }

    public function get_operator_percentage(Request $request, $url)
    {
        if ($request->npsn) {
            $survey = DB::table('survey_session')->where('url', $url)->first();

            if ($survey) {
                $telp = DB::table('survey_answer')->select('telp_siswa')->where('npsn', $request->npsn)->get();

                if ($telp) {

                    $kode_operator = DB::table('kode_prefix_operator')->get();
                    $telkomsel = 0;
                    $xl = 0;
                    $axis = 0;
                    $indosat = 0;
                    $tri = 0;
                    $smartfren = 0;
                    $lainnya = 0;
                    foreach ($telp as $key => $d_telp) {
                        $firstFourDigits = substr($d_telp->telp_siswa, 0, 4);

                        foreach ($kode_operator as $key => $kode) {
                            if ($kode->kode_prefix == $firstFourDigits) {
                                switch ($kode->operator) {
                                    case 'Telkomsel':
                                        $telkomsel += 1;
                                        break;
                                    case 'XL':
                                        $xl += 1;
                                        break;
                                    case 'Axis':
                                        $axis += 1;
                                        break;
                                    case 'Indosat':
                                        $indosat += 1;
                                        break;
                                    case 'Tri':
                                        $tri += 1;
                                        break;
                                    case 'Smartfren':
                                        $smartfren += 1;
                                        break;
                                    default:
                                        $lainnya += 1;
                                        break;
                                }
                            }
                        }
                    }

                    echo number_format((($axis / count($telp)) * 100), 2, ',', '.') . "%#";
                    echo "<br/>";
                    echo number_format((($indosat / count($telp)) * 100), 2, ',', '.') . "%#";
                    echo "<br/>";
                    echo number_format((($lainnya / count($telp)) * 100), 2, ',', '.') . "%#";
                    echo "<br/>";
                    echo number_format((($smartfren / count($telp)) * 100), 2, ',', '.') . "%#";
                    echo "<br/>";
                    echo number_format((($telkomsel / count($telp)) * 100), 2, ',', '.') . "%#";
                    echo "<br/>";
                    echo number_format((($tri / count($telp)) * 100), 2, ',', '.') . "%#";
                    echo "<br/>";
                    echo number_format((($xl / count($telp)) * 100), 2, ',', '.') . "%#";
                    echo "<br/>";
                } else {
                    echo "000000";
                }
            } else {
                echo "000000";
            }
        } else {
            echo "000000";
        }
    }
}
