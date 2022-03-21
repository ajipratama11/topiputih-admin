<?php

namespace App\Http\Controllers;

use App\Models\CategoryReport;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('pages.report.report',[
            'reports' => Report::orderBy('date','desc')->get()
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
        $report = Report::where('slug',$id)->first();
        $category = CategoryReport::all();

        return view('pages.report.detail_report', [
          'report' => $report,
          'category' => $category
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
        $fields = $request->validate([
            'note'=>'nullable',
            'status_report'=> 'nullable',
            'status_causes'=> 'nullable',
            'category_id'=> 'nullable'

        ]);
        $report = Report::where('id',$id)->first();
        $report->category_id = $fields['category_id'];
        $report->note = $fields['note'];
        $report->status_report = $fields['status_report'];
        $report->status_causes = $fields['status_causes'];

        $report->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        $report = Report::find($id);

        $report->delete();

        return back()->with('success',' Penghapusan berhasil.');
    
    }
}
