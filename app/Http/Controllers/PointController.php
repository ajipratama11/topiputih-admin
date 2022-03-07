<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $point = Report::selectRaw('user_id, sum(point) as points')
        // ->groupBy('user_id')
        // ->with(['user' => function ($query) {
        //     $query->select('id','users.name','users.email');}])
        // ->orderBy('points','desc')
        // ->get('user.name','user.email');

        $point = DB::table('users')
        ->leftJoin('reports','reports.user_id','=','users.id')
        ->where('roles','researcher')
        // ->where('reports.status_report','Disetujui')
        ->select('users.id as id','users.name as name',DB::raw('SUM(reports.point) AS points'))
        ->groupBy('users.id')
        ->get();
        
        return view('pages.point.point',[
            'point' => $point,
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
