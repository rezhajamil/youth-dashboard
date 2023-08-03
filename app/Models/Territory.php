<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Territory extends Model
{
    use HasFactory;

    public static function getCluster()
    {
        $privilege = Auth::user()->privilege;
        $branch = Auth::user()->branch;
        $cluster = Auth::user()->cluster;

        $territory = DB::table('territory_new')->select('cluster')->distinct()->orderBy('cluster');

        if ($privilege == 'superadmin') {
            $territory = $territory->get();
        } else if ($privilege == 'branch') {
            $territory = $territory->where('branch', $branch)->get();
        } else if ($privilege == 'cluster') {
            $territory = $territory->where('cluster', $cluster)->get();
        }

        return $territory;
    }
}