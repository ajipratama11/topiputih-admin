<?php

namespace App\Http\Controllers\API;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CategoryReport;
use App\Models\Program;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function encodeing($sourcestr)  
    {
        
        $pathToPublicKey = app_path('Http/Controllers/api/client_pubkey.php');
        $key_content = file_get_contents($pathToPublicKey);  
        $pubkeyid    = openssl_get_publickey($key_content);  
          
        if (openssl_public_encrypt($sourcestr, $crypttext, $pubkeyid))  
        {
            return base64_encode("".$crypttext);  
        }
    }

    public function decodeing($crypttext)
    {
        $pathToPrivateKey = app_path('Http/Controllers/privkey.php');
        $prikeyid    = file_get_contents($pathToPrivateKey);
        $crypttext   = base64_decode($crypttext);

        if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, OPENSSL_PKCS1_PADDING))
        {
            return "".$sourcestr;
        }
        return ;
    }
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
            'category_id' => '',
            'description_report' => 'required',
            'impact' => 'required',
            'file' => 'mimes:pdf|max:20000|without_spaces',
            'date' => 'required',
            'status_report' => 'required',
            'point' => '',
            'reward'=> '',
            'status_reward'=> ''
        ],
        
        [
            'file.without_spaces' => 'Berkas tidak boleh menggunakan spasi'
        ]);
        
        $input['user_id']= $this->decodeing($input['user_id']);
        $input['program_id']= $this->decodeing($input['program_id']);
        $input['summary']= $this->decodeing($input['summary']);
        $input['scope_report']= $this->decodeing($input['scope_report']);
        $input['impact']= $this->decodeing($input['impact']);
        $input['date']= $this->decodeing($input['date']);
        $input['status_report']= $this->decodeing($input['status_report']);



        if ($file = $request->file('file')) {
            $destinationPath = 'file/report/';
            $reportFile = date('YmdHis') . "." . $file->getClientOriginalName();
            $fileName = str_replace(' ', '', $reportFile);
            $file->move($destinationPath, $fileName);
            $input['file'] = "$fileName";
            }

        
        $cat = CategoryReport::select('category')
        ->where('id',$input['category_id'])
        ->first();
        $program = Program::where('id',$input['program_id'])
        ->select('price_1','price_2','price_3','price_4','price_5')
        ->first();

        $program_type = Program::where('id',$input['program_id'])
        ->select('type')
        ->first();

        if($program_type->type == 'Bug Bounty'){
            if ($cat->category == 'Sangat Rendah' ){
                $input['reward']= $program->price_1;
                $input['point'] = '12.5';
            }
            elseif($cat->category == 'Rendah' ){
                $input['reward']= $program->price_2;
                $input['point'] = '25';
            }
            elseif($cat->category == 'Sedang' ){
                $input['reward']= $program->price_3;
                $input['point'] = '37.5';
            }
            elseif($cat->category == 'Tinggi' ){
                $input['reward']= $program->price_4;
                $input['point'] = '62.5';
            }
            elseif($cat->category == 'Sangat Tinggi' ){
                $input['reward']= $program->price_5;
                $input['point'] = '100';
            }
        }else{}

        $input['status_reward']= 'Proses';
        Report::create($input);
        return[
            'message' => 'Berhasil Tambah Data',
            // 'type'=>$program_type,
            // 'program' => $cat->category,
            // 'price' => $input['reward']

        ];


    }

    public function show($id)
    {
        $report = DB::table('reports')
        ->join('users', 'users.id', '=', 'reports.user_id')
        ->join('programs', 'programs.id', '=', 'reports.program_id')
        ->join('category_reports','category_reports.id','=','reports.category_id')
        ->where('reports.id',$id)
        // ->select('reports.*','programs.program_name','programs.date_start','programs.date_end')
        ->first();
       
        return [
            // $report,
        'id' => $this->encodeing($report->id),
        'user_id'=>$this->encodeing($report->user_id),
        'program_id' => $this->encodeing($report->program_id),
        'summary' => $this->encodeing($report->summary),
        'scope_report' => $this->encodeing($report->scope_report),
        'category_id' => $report->category_id,
        'description_report' => $report->description_report,
        'impact' => $this->encodeing($report->impact),
        'file' => $report->file,
        'date' => $this->encodeing($report->date),
        'date_start' => $this->encodeing($report->date_start),
        'date_end' => $this->encodeing($report->date_end),
        'status_report' => $this->encodeing($report->status_report),
        'point' => $report->file,
        'reward'=> $this->encodeing($report->reward),
        'status_reward'=> $this->encodeing($report->status_reward),
        'program_name'=> $this->encodeing($report->program_name),
        'category'=> $this->encodeing($report->category),
        'detail'=> $this->encodeing($report->detail),
    ];
    }

    public function show_list_user($id)
    {
        $report = DB::table('reports')
        ->join('users', 'users.id', '=', 'reports.user_id')
        ->join('programs', 'programs.id', '=', 'reports.program_id')
        ->where('reports.user_id',$id)
        // ->where('status_report','')
        ->select('reports.*','programs.program_name','programs.date_start','programs.date_end')
        ->get();

        return $report;
    }

    public function show_list_program($id)
    {
        $report = DB::table('reports')
        ->rightJoin('users', 'users.id', '=', 'reports.user_id')
        ->rightJoin('programs', 'programs.id', '=', 'reports.program_id')
        ->rightJoin('category_reports','category_reports.id','=','reports.category_id')
        ->where('reports.program_id',$id)
        ->where('status_report','Disetujui')
        ->select('reports.*','users.name','category_reports.detail','category_reports.category')
        ->get();

        return $report;
    }

    public function update(Request $request){
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        $input = $request->validate([
            'user_id'=>'required',
            'program_id' => 'required',
            'summary' => 'required',
            'scope_report' => 'required',
            'category_id' => 'required',
            'description_report' => 'required',
            'impact' => 'required',
            'file' => 'max:20000',
            'date' => 'required',
            'status_report' => 'required',
            'point' => ''
        ], [
            'file.without_spaces' => 'Berkas tidak boleh menggunakan spasi'
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
            $report->category_id = $input['category'];
            $report->description_report = $input['description'];
            $report->impact = $input['impact'];
            $report->date = $input['date'];
            $report->status_report = $input['status_report'];
            $report->point = $input['point'];
        
            $report->save();
        return[
            'message' => ' Berhasil Update Data',
        ];
    }

    public function count_report_program($id)
    {
   
        // $report = DB::select("SELECT users.name ,reports.program_id,
        // programs.program_name, programs.date_start, programs.date_end,
        // programs.type,
        // count(reports.program_id) as count_report FROM `reports`
        // RIGHT JOIN programs ON programs.id = reports.program_id
        // RIGHT JOIN users ON users.id = programs.user_id
        // WHERE users.id = $id 
        // AND status_report = 'Disetujui'
        // GROUP by reports.program_id");

        $report = Program::where('users.id',$id)
        ->leftJoin('reports','reports.program_id','=','programs.id')
        ->leftJoin('users','users.id','=','programs.user_id')
        ->select('users.name' ,'reports.program_id',
        'programs.program_name', 'programs.date_start', 'programs.date_end',
        'programs.type',DB::raw('count(reports.user_id) AS count_report'))
        ->groupBy('programs.id')
        ->where('status_report','Disetujui')
        ->get();

        return $report;
    }
    
    public function change_status(Request $request)
    {
        $fields = $request->validate([
            'id'=>'required',
            'status_report'=> 'required',
            'status_causes'=> ''
        ]);
        $report = Report::where('id',$fields['id'])->first();
        $report->status_report = $fields['status_report'];
        $report->status_causes = $fields['status_causes'];

        $report->save();
        return[
            'message' => ' Berhasil Update Data',
        ];
    }

    public function category_report(){
        return CategoryReport::all();
    }

    public function reward_researcher($id){
        $bank =  Report::where('reports.user_id',$id)
        ->where('reports.status_report','Disetujui')
        ->where('reports.status_reward','Selesai')
        ->sum('reports.reward');

        return $bank;
    }

    public function total_report($id){
        $report = Program::where('users.id',$id)
        ->leftJoin('reports','reports.program_id','=','programs.id')
        ->leftJoin('users','users.id','=','programs.user_id')
        // ->select('users.name' ,'reports.program_id',
        // 'programs.program_name', 'programs.date_start', 'programs.date_end',
        // 'programs.type',DB::raw('count(reports.user_id) AS count_report'))
        // ->groupBy('programs.id')
        ->where('status_report','Disetujui')
        ->count('reports.id');
        // ->get();
        return $report;
    }
}
