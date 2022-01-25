<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PointController extends Controller
{
    public function index()
    {
        $report = DB::table('users')
        ->rightJoin('reports', 'reports.user_id', '=', 'users.id')
        // ->where()
        // ->sum('reports.point')
        ->select('users.name','reports.point')
        ->get();

        return $report;
    }

    public function show_point_program($id)
    {
        $report = DB::table('reports')
        ->rightJoin('users', 'users.id', '=', 'reports.user_id')
        ->rightJoin('programs', 'programs.id', '=', 'reports.program_id')
        ->where('reports.program_id',$id)
        ->select('users.name','reports.point')
        ->get();

        return $report;
    }
}
