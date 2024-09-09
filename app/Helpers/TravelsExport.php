<?php

namespace App\Helpers;

use App\Models\Travel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithImages;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class TravelsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Travel::all(); // Ambil data travel
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Provinsi',
            'Kota',
            'Kecamatan',
            'Cluster',
            'SBP',
            'Alamat',
            'Current Status',
            'RS Digipos',
            'ID Digipos Travel',
            'Nama DS',
            'ID Digipos DS',
            'Linkaja DS',
            'Latitude',
            'Longitude',
            'Foto Travel',
            'Foto BAK'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambahkan gaya untuk tabel di sini
    }

    public function images(): array
    {
        $images = [];
        foreach (Travel::all() as $travel) {
            if ($travel->foto_travel) {
                $images[] = new Drawing('storage/' . $travel->foto_travel);
            }
            if ($travel->foto_bak) {
                $images[] = new Drawing('storage/' . $travel->foto_bak);
            }
        }
        return $images;
    }
}
