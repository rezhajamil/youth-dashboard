<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use App\Models\TravelKeberangkatan;
use App\Models\TravelNegara;
use App\Models\TravelPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TravelController extends Controller
{
    public function index()
    {
        $travels = Travel::with('images')->get();


        return view('travel.index', compact('travels'));
    }

    public function edit(Request $request, $id)
    {
        $travel = Travel::find($id);

        return view('travel.edit', compact('travel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_digipos_travel_agent' => 'numeric|nullable',
            'id_digipos_ds' => 'numeric|nullable',
            'foto_travel' => 'max:2048'
        ]);

        $travel = Travel::find($id);
        $travel->current_status = $request->current_status;
        $travel->id_digipos_travel_agent = $request->id_digipos_travel_agent;
        $travel->id_digipos_ds = $request->id_digipos_ds;
        $travel->save();

        if ($request->foto_travel) {
            TravelPhoto::where('id_travel', $travel->id)->delete();

            foreach ($request->file('foto_travel') as  $image) {
                $url = $image->store("travel");
                DB::table('foto_travel')->insert([
                    'id_travel' => $travel->id,
                    'url' => $url,
                ]);
            }
        }

        return redirect()->route('travel.index');
    }

    public function keberangkatan(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-d');

        $keberangkatan = TravelKeberangkatan::with(['travel'])
            ->select('tgl', 'negara', DB::raw('SUM(jumlah_jamaah) as jlh'))
            ->whereBetween('tgl', [$startDate, $endDate])
            ->groupBy('tgl', 'negara')
            ->get();

        return view('travel.keberangkatan.index', compact('startDate', 'endDate', 'keberangkatan'));
    }

    public function create_keberangkatan(Request $request)
    {
        $travels = Travel::select(['id', 'nama'])->orderBy('nama')->get();
        $countries = DB::table('list_negara_travel')->get();

        return view('travel.keberangkatan.create', compact('travels', 'countries'));
    }

    public function store_keberangkatan(Request $request)
    {
        $request->validate([
            'id_travel' => ['required'],
            'negara' => ['required'],
            'tgl' => ['required'],
            'jumlah_jamaah' => ['required'],
        ]);

        $keberangkatan = TravelKeberangkatan::insert($request->except('_token'));

        return redirect()->route('travel.keberangkatan');
    }
}
