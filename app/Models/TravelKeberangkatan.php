<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelKeberangkatan extends Model
{
    use HasFactory;

    protected $table = 'list_keberangkatan_travel';

    public function travel()
    {
        return $this->belongsTo(Travel::class, 'id_travel');
    }
}
