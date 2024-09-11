<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\Travel;
use App\Models\TravelKeberangkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TravelController extends Controller
{
    public function index()
    {
        $travels = Travel::with(['ds']);

        if (Auth::user()->privilege === 'cluster') {
            $travels = $travels->where('cluster', Auth::user()->cluster);
        }

        $travels = $travels->get();

        return view('travel.index', compact('travels'));
    }

    public function create()
    {
        $user = DataUser::orderBy('nama');
        $province = DB::table('territory_new')->distinct()->select('provinsi')->orderBy('provinsi');
        $city = DB::table('territory_new')->distinct()->select('kab_new as city')->orderBy('kab_new');
        $district = DB::table('territory')->distinct()->select('kecamatan')->orderBy('kecamatan');
        $cluster = DB::table('territory_new')->distinct()->select('cluster')->orderBy('cluster');

        if (Auth::user()->privilege == 'cluster') {
            $user = $user->where('cluster', Auth::user()->cluster);
            $province = $province->where('cluster', Auth::user()->cluster);
            $city = $city->where('cluster', Auth::user()->cluster);
            $district = $district->where('new_cluster', Auth::user()->cluster);
            $cluster = $cluster->where('cluster', Auth::user()->cluster);
        } else  if (Auth::user()->privilege == 'branch') {
            $user = $user->where('branch', Auth::user()->branch);
            $province = $province->where('branch', Auth::user()->branch);
            $city = $city->where('branch', Auth::user()->branch);
            $district = $district->where('new_branch', Auth::user()->branch);
            $cluster = $cluster->where('branch', Auth::user()->branch);
        }

        $user = $user->where('status', 1)->get();
        $province = $province->get();
        $city = $city->get();
        $district = $district->get();
        $cluster = $cluster->get();

        return view('travel.create', compact('user', 'province', 'city', 'district', 'cluster'));
    }

    public function store(Request $request)
    {
        if ($request->foto_travel) {
            $foto_travel = $request->file('foto_travel')->store("foto_travel");
        }

        if ($request->foto_bak) {
            $foto_bak = $request->file('foto_bak')->store("foto_bak");
        }

        $travel = Travel::insert([
            'nama' => $request->nama,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'cluster' => $request->cluster,
            'sbp' => $request->sbp,
            'direktur' => $request->direktur,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'current_status' => $request->current_status,
            'rs_digipos' => $request->rs_digipos,
            'id_digipos_travel_agent' => $request->id_digipos_travel_agent,
            'telp_ds' => $request->telp_ds,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'foto_travel' => $foto_travel ?? "",
            'foto_bak' => $foto_bak ?? "",
        ]);

        return redirect()->route('travel.index')->with('success');
    }

    public function edit(Request $request, $id)
    {
        $travel = Travel::find($id);
        $user = DataUser::orderBy('nama');

        if (Auth::user()->privilege == 'cluster') {
            $user = $user->where('cluster', Auth::user()->cluster);
        } else {
            $user = $user->where('cluster', $travel->cluster);
        }

        $user = $user->where('status', 1)->get();

        return view('travel.edit', compact('travel', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_digipos_travel_agent' => 'numeric|nullable',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_travel' => 'max:2048',
            'foto_bak' => 'max:2048'
        ]);

        $travel = Travel::find($id);
        $travel->current_status = $request->current_status;
        $travel->rs_digipos = $request->rs_digipos;
        $travel->telp_ds = $request->telp_ds;
        $travel->id_digipos_travel_agent = $request->id_digipos_travel_agent;
        $travel->latitude = $request->latitude;
        $travel->longitude = $request->longitude;

        if ($request->foto_travel) {
            $foto_travel = $request->file('foto_travel')->store("foto_travel");
            $travel->foto_travel = $foto_travel;
        }

        if ($request->foto_bak) {
            $foto_bak = $request->file('foto_bak')->store("foto_bak");
            $travel->foto_bak = $foto_bak;
        }

        $travel->save();

        return redirect()->route('travel.index');
    }

    public function keberangkatan(Request $request)
    {
        $privilege = Auth::user()->privilege;
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-d');


        $keberangkatan = TravelKeberangkatan::with(['travel.territory'])
            ->select('id_travel', 'tgl', 'negara', DB::raw('SUM(jumlah_jamaah) as jlh'));

        if ($privilege == 'superadmin') {
            $region = DB::table('territory_new')->select('regional')->distinct()->get();
            if ($request->region) {
                $keberangkatan = $keberangkatan->whereHas('travel.territory', function ($query) use ($request) {
                    $query->where('regional', $request->region);
                });
            }

            if ($request->branch) {
                $keberangkatan = $keberangkatan->whereHas('travel.territory', function ($query) use ($request) {
                    $query->where('branch', $request->branch);
                });
            }

            if ($request->cluster) {
                $keberangkatan = $keberangkatan->whereHas('travel.territory', function ($query) use ($request) {
                    $query->where('cluster', $request->cluster);
                });
            }
        } else {
            $region = [];
            if ($privilege == 'branch') {
                $keberangkatan = $keberangkatan->whereHas('travel.territory', function ($query) {
                    $query->where('branch', Auth::user()->branch);
                });
            }
            if ($privilege == 'cluster') {
                $keberangkatan = $keberangkatan->whereHas('travel.territory', function ($query) {
                    $query->where('cluster', Auth::user()->cluster);
                });
            }
        }

        $keberangkatan = $keberangkatan->whereBetween('tgl', [$startDate, $endDate])
            ->groupBy('id_travel', 'tgl', 'negara')->get();

        $regionalCounts = $keberangkatan->groupBy('travel.territory.regional')
            ->map(function ($group) {
                return $group->sum('jlh');
            });

        $clusterCounts = $keberangkatan->groupBy('travel.territory.cluster')
            ->map(function ($group) {
                return $group->count();
            });

        return view('travel.keberangkatan.index', compact('startDate', 'endDate', 'region', 'keberangkatan'));
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

    public function export()
    {
        $travels = Travel::with(['ds']);

        if (Auth::user()->privilege === 'cluster') {
            $travels = $travels->where('cluster', Auth::user()->cluster);
        }

        $travels = $travels->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Provinsi')
            ->setCellValue('D1', 'Kota')
            ->setCellValue('E1', 'Kecamatan')
            ->setCellValue('F1', 'Cluster')
            ->setCellValue('G1', 'SBP')
            ->setCellValue('H1', 'Alamat')
            ->setCellValue('I1', 'Current Status')
            ->setCellValue('J1', 'RS Digipos')
            ->setCellValue('K1', 'ID Digipos Travel')
            ->setCellValue('L1', 'Nama DS')
            ->setCellValue('M1', 'ID Digipos DS')
            ->setCellValue('N1', 'Linkaja DS')
            ->setCellValue('O1', 'Latitude')
            ->setCellValue('P1', 'Longitude')
            ->setCellValue('Q1', 'Foto Travel')
            ->setCellValue('R1', 'Foto BAK');

        $row = 2; // Mulai dari baris kedua
        foreach ($travels as $key => $travel) {
            $sheet->setCellValue("A{$row}", $key + 1)
                ->setCellValue("B{$row}", $travel->nama)
                ->setCellValue("C{$row}", $travel->provinsi)
                ->setCellValue("D{$row}", $travel->kota)
                ->setCellValue("E{$row}", $travel->kecamatan)
                ->setCellValue("F{$row}", $travel->cluster)
                ->setCellValue("G{$row}", $travel->sbp)
                ->setCellValue("H{$row}", $travel->alamat)
                ->setCellValue("I{$row}", $travel->current_status != '' ? $travel->current_status : '-')
                ->setCellValue("J{$row}", $travel->id_digipos_travel_agent != '' ? $travel->id_digipos_travel_agent : '-')
                ->setCellValue("K{$row}", $travel->rs_digipos != '' ? $travel->rs_digipos : '-')
                ->setCellValue("L{$row}", optional($travel->ds)->nama ?? '-')
                ->setCellValue("M{$row}", optional($travel->ds)->id_digipos ?? '-')
                ->setCellValue("N{$row}", optional($travel->ds)->linkaja ?? '-')
                ->setCellValue("O{$row}", $travel->latitude != '' ? $travel->latitude : '-')
                ->setCellValue("P{$row}", $travel->longitude != '' ? $travel->longitude : '-')
            ;

            // Tambahkan gambar foto_travel
            if ($travel->foto_travel) {
                $drawing = new Drawing();
                $drawing->setName('Foto Travel');
                $drawing->setPath(storage_path('app/public/' . $travel->foto_travel)); // Path gambar
                $drawing->setWidth(30);
                $drawing->setCoordinates("Q{$row}"); // Lokasi gambar pada sheet
                $drawing->setWorksheet($sheet);
            }

            // Tambahkan gambar foto_bak
            if ($travel->foto_bak) {
                $drawing = new Drawing();
                $drawing->setName('Foto BAK');
                $drawing->setPath(storage_path('app/public/' . $travel->foto_bak)); // Path gambar
                $drawing->setWidth(30);
                $drawing->setCoordinates("R{$row}"); // Lokasi gambar pada sheet
                $drawing->setWorksheet($sheet);
            }

            $row++;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // Simpan file ke storage
        $filePath = storage_path('app/public/data_travel.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
