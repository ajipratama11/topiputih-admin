<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentResearcherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $balance = User::where('roles','peneliti-keamanan')->get();
        // ->join('users','users.id','=','payments.user_id')
        // ->get();
        return view('pages.payment_researcher.payment',[
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
        
        $request ->validate([
            'slug'=>'required'
            ]);
        
            $id=User::where('slug',$request['slug'])->first('id');

        $payment = Report::where('reports.user_id',$id->id)
        // ->join('programs','programs.id','=','reports.program_id')
        ->orderBy('reports.updated_at','desc')
        ->where('status_report','Disetujui')
        ->get();
        
        return view('pages.payment_researcher.detail_payment')->with('payment', $payment);
          
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Report::where('reports.user_id',$id)
        // ->join('programs','programs.id','=','reports.program_id')
        ->orderBy('reports.updated_at','desc')
        ->where('status_report','Disetujui')
        ->get();
        
        return view('pages.payment_researcher.detail_payment', [
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
