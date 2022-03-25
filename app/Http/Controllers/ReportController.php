<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\CategoryReport;
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
        
        $program = Program::where('id',$report->program_id)->first();

        $report->category_id = $fields['category_id'];
        $report->note = $fields['note'];
        $report->status_report = $fields['status_report'];
        $report->status_causes = $fields['status_causes'];

        if($report->status_report == 'Disetujui'){
            $report->status_reward = 'Belum Dibayarkan';
        }elseif($report->status_report == 'Ditolak'){
            $report->status_reward  == 'Ditolak';
        }

        $cat = CategoryReport::where('id',$report->category_id)->first();

        if($program->type == 'Bug Bounty'){
            if($cat->category == 'Sangat Rendah'){
                $report->point = '12.5';
                $report->reward = $program->price_1;
            }elseif($cat->category == 'Rendah'){
                $report->point= '25';
                $report->reward = $program->price_2;
            }elseif($cat->category == 'Sedang'){
                $report->point= '37.5';
                $report->reward = $program->price_3;
            }elseif($cat->category == 'Tinggi'){
                $report->point= '62.5';
                $report->reward = $program->price_4;
            }elseif($cat->category == 'Sangat Tinggi'){
                $report->point= '100';
                $report->reward = $program->price_5;
            }
        }elseif($program->type == 'Vulnerability Disclosure'){ 
            if ($cat->category == 'Sangat Rendah' ){
                $report->point = '12.5';
            }
            elseif($cat->category == 'Rendah' ){
                $report->point= '25';
            }
            elseif($cat->category == 'Sedang' ){
                $report->point= '37.5';
            }
            elseif($cat->category == 'Tinggi' ){
                $report->point= '62.5';
            }
            elseif($cat->category == 'Sangat Tinggi' ){
                $report->point= '100';
            }
        }

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

    public function change_category(Request $request, $id){
        $fields = $request->validate([
            'category_id'=> 'required'

        ]);
        $report = Report::where('id',$id)->first();
        $program = Program::where('id',$report->program_id)->first();

        $report->category_id = $fields['category_id'];
        $cat = CategoryReport::where('id',$report->category_id)->first();
        if($cat->category == 'Rendah'){
        $report->point= '12.5';
        $report->reward = $program->price_1;
        }elseif($cat->category == 'Sangat Rendah'){
            $report->point= '25';
            $report->reward = $program->price_2;
        }elseif($cat->category == 'Sedang'){
            $report->point= '37.5';
            $report->reward = $program->price_3;
        }elseif($cat->category == 'Tinggi'){
            $report->point= '62.5';
            $report->reward = $program->price_4;
        }elseif($cat->category == 'Sangat Tinggi'){
            $report->point= '100';
            $report->reward = $program->price_5;
        }

        $report->save();
        return back();
    }
}
