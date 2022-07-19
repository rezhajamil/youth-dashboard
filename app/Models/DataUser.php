<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUser extends Model
{
    use HasFactory;

    protected $table = 'data_user';

    protected $fillable = [
        'area',
        'regional',
        'branch',
        'cluster',
        'tap',
        'nama',
        'panggilan',
        'mkios',
        'id_digipos',
        'user_calista',
        'reff_code',
        'role',
        'posisi',
        'kampus',
        'status',
        'sosmed',
        'tgl_lahir',
        'telp',
        'link_aja',
        'password',
        'reff_byu',
    ];
}
