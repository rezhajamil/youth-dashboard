<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Poin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function add_poin($data)
    {
        $poin = DB::table("poin_history")->insert($data);

        return $poin;
    }
}
