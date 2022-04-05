<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class PaymentResearcherDelayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment=  Program::select('users.id','reports.id as rid','users.nama','reports.user_id','programs.program_name','reports.reward','reports.status_reward','reports.updated_at')
        ->rightJoin('reports', 'reports.program_id', '=', 'programs.id')
        ->leftJoin('users', 'users.id', '=', 'programs.user_id')
        ->where('reports.status_report','Disetujui')
        ->where('reports.status_reward','Belum Dibayarkan')
        ->orderBy('date','desc')
        ->get();

        return view('pages.payment_researcher_delay.payment',[
            'payment' => $payment
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
