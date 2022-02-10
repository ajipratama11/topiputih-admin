<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Report;
use App\Models\InvitedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PointController extends Controller
{
    public function index()
    {
        $report = Report::selectRaw('user_id, sum(point) as points')
        ->groupBy('user_id')
        ->with(['user' => function ($query) {
            $query->select('id','users.name','users.email');}])
        ->orderBy('points','desc')
        ->get('user.name','user.email');

        // $notin = Report::get('reports.user_id');

        // $report = User::where('roles','researcher') 
        // ->whereNotIn('users.id',$notin)
        // ->select(['users.id as user_id','name'])->get();


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

    public function get_rank($id){
       $query = DB::select("SELECT ranking
        FROM
        (select reports.user_id, rank() over (order by reward desc) as ranking
        from  reports  GROUP BY user_id) reports
        WHERE user_id = $id");

        return $query;
    }
}
