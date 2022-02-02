<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\InvitedUser;
use App\Models\Report;

class PointController extends Controller
{
    public function index()
    {
        $report = Report::selectRaw('user_id, sum(point) as points')
        ->groupBy('user_id')
        ->with(['user' => function ($query) {
            $query->select('id','users.name','users.profile_picture');}])
        ->orderBy('points','desc')
        ->get('user.name');

        return $report;
    }

    public function show_point_program($id)
    {
        $report = Report::selectRaw('reports.user_id, sum(point) as points')
        ->groupBy('reports.user_id')
        ->where('reports.program_id',$id)
        ->with(['user' => function ($query) {
            $query->select('id','users.name','users.profile_picture');}])
        ->orderBy('points','desc')
        ->get();
    

        return $report;
    }

    public function point_user($id){
        $point = DB::table('reports')
        ->where('user_id',$id)
        ->sum('point');
        
        return $point;
    }
}
