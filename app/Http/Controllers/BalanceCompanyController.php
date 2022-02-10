<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $balance = Payment::select('users.id','users.name',DB::raw('SUM(payments.payment_amount) AS balance'))
        // ->rightJoin('users','users.id','=','payments.user_id')
        // ->where('payments.status','Diterima')
        // ->groupBy('users.id')
        // ->get();
        $balance = User::all();

        return view('pages.balance.balance',[
            'balance' => $balance
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
        $payment=  Program::select('users.id','users.name','reports.user_id','programs.program_name','reports.reward','reports.status_reward','reports.updated_at')
        ->rightJoin('reports', 'reports.program_id', '=', 'programs.id')
        ->leftJoin('users', 'users.id', '=', 'programs.user_id')
        ->where('reports.status_reward','Selesai')
        ->where('users.id',$id)
        ->orderBy('date','desc')
        ->get();

        $balance = Payment::where('user_id',$id)
        ->orderBy('payment_date','desc')
        ->get();
        
        return view('pages.balance.detail_balance', [
          'balance' => $balance,
          'payment' => $payment
        ]);
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
