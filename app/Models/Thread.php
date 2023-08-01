<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $table = 'threads';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'telp', 'telp');
    }

    public function comments()
    {
        return $this->hasMany(ThreadComment::class);
    }

    public function votes()
    {
        return $this->hasMany(ThreadVote::class);
    }
}
