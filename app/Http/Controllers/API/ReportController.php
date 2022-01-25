<?php

namespace App\Http\Controllers\API;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index()
    {   
      
        $report = DB::table('programs')
        ->rightJoin('users', 'users.id', '=', 'programs.user_id')
        ->rightJoin('reports', 'programs.id', '=', 'reports.program_id')
        ->get(['reports.*']);

        return $report;
    }

    public function create(Request $request){

        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        
        $input = $request->validate([
            'user_id'=>'required',
            'program_id' => 'required',
            'summary' => 'required',
            'scope_report' => 'required',
            'category_report' => 'required',
            'description_report' => 'required',
            'impact' => 'required',
            'file' => 'required|mimes:pdf|max:20000|without_spaces',
            'date' => 'required',
            'status_report' => 'required',
            'point' => ''
        ],
        
        [
            'file.without_spaces' => 'Berkas tidak boleh menggunakan spasi'
        ]);
        
        if ($file = $request->file('file')) {
            $destinationPath = 'file/report/';
            $reportFile = date('YmdHis') . "." . $file->getClientOriginalName();
            $fileName = str_replace(' ', '', $reportFile);
            $file->move($destinationPath, $fileName);
            $input['file'] = "$fileName";
            }
        Report::create($input);

        return[
            'message' => ' Berhasil Tambah Data',
        ];
    }

    public function show($id)
    {
        $report = DB::table('reports')
        ->join('users', 'users.id', '=', 'reports.user_id')
        ->join('programs', 'programs.id', '=', 'reports.program_id')
        ->where('reports.id',$id)
        // ->select('reports.*','programs.program_name','programs.date_start','programs.date_end')
        ->get();

        return $report;
    }

    public function show_list_user($id)
    {
        $report = DB::table('reports')
        ->join('users', 'users.id', '=', 'reports.user_id')
        ->join('programs', 'programs.id', '=', 'reports.program_id')
        ->where('reports.user_id',$id)
        ->select('reports.*','programs.program_name','programs.date_start','programs.date_end')
        ->get();

        return $report;
    }

    public function show_list_program($id)
    {
        $report = DB::table('reports')
        ->rightJoin('users', 'users.id', '=', 'reports.user_id')
        ->rightJoin('programs', 'programs.id', '=', 'reports.program_id')
        ->where('reports.program_id',$id)
        ->select('reports.*','users.name')
        ->get();

        return $report;
    }

    public function update(Request $request){

        $input = $request->validate([
            'user_id'=>'required',
            'program_id' => 'required',
            'summary' => 'required',
            'scope_report' => 'required',
            'category_report' => 'required',
            'description_report' => 'required',
            'impact' => 'required',
            'file' => 'max:20000',
            'date' => 'required',
            'status_report' => 'required',
            'point' => ''
        ]);

      
        $report = Report::where('id', $input['id'])->first();

        if ($file = $request->file('file')) {
            $destinationPath = 'file/report/';
            $reportFile = date('YmdHis') . "." . $file->getClientOriginalName();
            $file->move($destinationPath, $reportFile);
            $input['file'] = "$reportFile";
            }

            $report->summary = $input['summary'];
            $report->scope_report = $input['scope'];
            $report->category_report = $input['category'];
            $report->description_report = $input['description'];
            $report->impact = $input['impact'];
            $report->date = $input['date'];

        
        
            $report->save();
        return[
            'message' => ' Berhasil Update Data',
        ];
    }
}
