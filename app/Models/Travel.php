<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $table = 'list_travel';

    public $timestamps = false;

    public function images()
    {
        return $this->hasMany(TravelPhoto::class, 'id_travel');
    }

    public function ds()
    {
        return $this->belongsTo(DataUser::class, 'telp_ds', 'telp');
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class, 'cluster', 'cluster');
    }
}
