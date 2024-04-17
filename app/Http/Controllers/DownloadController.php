<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    public function index()
    {
        $list_jenis = ["sales"];
        return view('download.index', compact('list_jenis'));
    }

    public function downloadCsv(Request $request)
    {
        switch ($request->jenis) {
            case 'sales':
                $data = Download::sales($request->date);
                $csvFileName = "data_sales_$request->date.csv";
                break;
        }

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            // Cek apakah $data tidak kosong dan merupakan array
            if (!empty($data) && is_array($data)) {
                // Mengambil header dari kunci array item pertama
                $headers = array_keys((array)$data[0]);
                fputcsv($file, $headers);
            }

            foreach ($data as $row) {
                // Mengkonversi $row menjadi array jika belum
                $rowData = (array)$row;
                fputcsv($file, $rowData);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
