<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Report;
use App\Models\InvitedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class PointController extends Controller
{
    public function index()
    {
       $point = Report::selectRaw('user_id, sum(point) as points')
        ->groupBy('user_id')
        ->with(['user' => function ($query) {
            $query->select('id','users.nama','users.email');}])
        ->orderBy('points','desc')
        ->limit(10)
        ->get('user.nama','user.email');

        return$point;
    }

    public function list_point(){
        $point = Report::selectRaw('user_id, sum(point) as points')
        ->groupBy('user_id')
        ->with(['user' => function ($query) {
            $query->select('id','users.nama','users.email');}])
        ->orderBy('points','desc')
        ->where('date','<=',Carbon::now()->isoFormat('Y-MM-DD'))
        ->where('date','>=',Carbon::now()->subMonths(6)->isoFormat('Y-MM-DD'))
        ->limit(10)
        ->get('user.nama','user.email');

        return $point;
    }

    public function show_point_program($id)
    {
       $point = Report::selectRaw('reports.user_id, sum(point) as points')
        ->groupBy('reports.user_id')
        ->where('reports.program_id',$id)
        ->with(['user' => function ($query) {
            $query->select('id','users.nama','users.profile_picture');}])
        ->orderBy('points','desc')
        ->get();
    

        return $point;
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
