<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadComment extends Model
{
    use HasFactory;

    protected $table = 'thread_comments';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'telp', 'telp');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }
}