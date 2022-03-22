<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Report;
use App\Models\Program;
use App\Mail\MailInvite;
use App\Models\InvitedUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\InviteProgramMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class ProgramController extends Controller
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

    public function index_bb()
    {   
        $program = DB::table('programs')
        ->rightJoin('users', 'users.id', '=', 'programs.user_id')
        ->where('date_start','<=',Carbon::now()->isoFormat('Y-MM-DD'))
        ->where('date_end','>=',Carbon::now()->isoFormat('Y-MM-DD'))
        ->where([
            'status'=>'Aktif',
            'category' => 'publik',
            // 'type' => 'Bug Bounty'
        ])
        ->get(['programs.*','users.nama']);

        return $program;
    }

    public function index_vd()
    {   
        $program = DB::table('programs')
        ->rightJoin('users', 'users.id', '=', 'programs.user_id')
        ->where('date_start','<=',Carbon::now()->isoFormat('Y-MM-DD'))
        ->where('date_end','>=',Carbon::now()->isoFormat('Y-MM-DD'))
        ->where([
            'status'=>'Aktif',
            'category' => 'publik',
            'type' => 'Vulnerability Disclosure'
        ])
        ->get(['programs.*','users.nama']);

        return $program;
    }

    public function create(Request $request)
    {
        $input = $request->validate([
            'user_id'=>'required',
            'program_name' => 'required',
            'program_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'company_name' => '',
            'price_1' => '',
            'price_2' => '',
            'price_3' => '',
            'price_4' => '',
            'price_5' => '',
            'date_start' => 'required',
            'date_end' => 'required',
            'description' => 'required',
            'scope' => 'required',
            'status' => 'required',
            'type' => 'required',
            'category' => 'required',
        ]);
        
        if ($image = $request->file('program_image')) {
            $destinationPath = 'img/program_image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $input['program_image'] = "$profileImage";
            }
            $input['user_id']= $this->decodeing($input['user_id']);
            $input['program_name']= $this->decodeing($input['program_name']);
            $input['slug'] = Str::slug($input['program_name']);
            // $input['price_1']= $this->decodeing($input['price_1']);
            // $input['price_2']= $this->decodeing($input['price_2']);
            // $input['price_3']= $this->decodeing($input['price_3']);
            // $input['price_4']= $this->decodeing($input['price_4']);
            // $input['price_5']= $this->decodeing($input['price_5']);
            $input['date_start']= $this->decodeing($input['date_start']);
            $input['date_end']= $this->decodeing($input['date_end']);
            $input['description']= $this->decodeing($input['description']);
            $input['scope']= $this->decodeing($input['scope']);
            $input['status']= $this->decodeing($input['status']);
            $input['type']= $this->decodeing($input['type']);
            $input['category']= $this->decodeing($input['category']);
        Program::create($input);

        return[
            'message' => ' Berhasil Tambah Data',
            // 'program' => $input,
        ];
    }

    public function cek_program($id,$user_id){
        $notin = InvitedUser::where('invited_users.program_id',$id)->select('invited_users.user_id');

        $user = DB::table('users')
                ->rightJoin('programs','programs.user_id','=','users.id')
                ->where('users.id',$user_id)
                ->where('programs.id',$id)
                ->whereIn('users.id',$notin)
                ->get(['users.id','users.nama','programs.program_name']);

        

        // $program = DB::table('programs')
        // ->rightJoin('users', 'users.id', '=', 'programs.user_id')
        // ->where('programs.id','=',$id)
        // ->first(['programs.*','users.nama']);

        return $user;
    }

    public function show($id)
    {

        // $notin = InvitedUser::where('invited_users.program_id',$id)->select('invited_users.user_id');

        // $user = DB::table('users')
        //         ->where('users.id',$user_id)
        //         ->whereIn('users.id',$notin)
        //         ->get(['id as user_id','nama']);

        $program = DB::table('programs')
        ->rightJoin('users', 'users.id', '=', 'programs.user_id')
        ->where('programs.id','=',$id)
        // ->where('programs.slug','=',$id)
        ->first(['programs.*','users.nama']);

        // return $program;
        return [

        'id' => $this->encodeing($program->id),
        'user_id' => $this->encodeing($program->user_id),
        'program_name' => $this->encodeing($program->program_name),
        'program_image' => $program->program_image,
        'date_start' => $this->encodeing($program->date_start),
        'date_end' => $this->encodeing($program->date_end),
        'description' => $program->scope,
        'scope' => $this->encodeing($program->scope),
        'price_1' => $this->encodeing($program->price_1),
        'price_2' => $this->encodeing($program->price_2),
        'price_3' => $this->encodeing($program->price_3),
        'price_4' => $this->encodeing($program->price_4),
        'price_5' => $this->encodeing($program->price_5),
        'status' => $this->encodeing($program->status),
        'type' => $this->encodeing($program->type),
        'category' => $this->encodeing($program->category),
        'nama' => $this->encodeing($program->nama)];
    }

    public function show_list($id)
    {
        return Program::where('user_id',$id)->get();
    }

    
    public function update(Request $request)
    {
        
        $fields = $request->validate([
            'id' => 'required',
            'program_name' => 'required',
            // 'program_image' => 'required',
            // 'company_name' => '',
            'price_1' => '',
            'price_2' => '',
            'price_3' => '',
            'price_4' => '',
            'price_5' => '',
            'date_start' => 'required',
            'date_end' => 'required',
            'description' => 'required',
            'scope' => 'required',
            'status' => 'required',
            'category' => 'required',
            'type' => 'required',
        ]);

        $program = Program::where('id', $this->decodeing($fields['id']))->first();
        // if ($image = $request->file('program_image')) {
        //     $destinationPath = 'img/program_image';
        //     $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
        //     $image->move($destinationPath, $profileImage);
        //     $program-> program_image = "$profileImage";
        // }
        $program-> program_name = $this->decodeing($fields['program_name']);
        // $program-> company_name = $fields['company_name'];
        $program-> slug =  Str::slug($program->program_name);
        $program-> date_start = $this->decodeing($fields['date_start']);
        $program-> date_end = $this->decodeing($fields['date_end']);
        $program-> description = $fields['description'];
        $program-> scope = $this->decodeing($fields['scope']);
        $program-> status = $this->decodeing($fields['status']);
        $program-> category = $this->decodeing($fields['category']);
        $program-> type = $this->decodeing($fields['type']);
        
        if($this->decodeing($fields['type']) == 'Vulnerability Disclosure'){
            $program-> price_1 = NULL;
            $program-> price_2 = NULL;
            $program-> price_3 = NULL;
            $program-> price_4 = NULL;
            $program-> price_5 = NULL;
        }else{
        $program-> price_1 = $fields['price_1'];
        $program-> price_2 = $fields['price_2'];
        $program-> price_3 = $fields['price_3'];
        $program-> price_4 = $fields['price_4'];
        $program-> price_5 = $fields['price_5'];
        }

        $program->save();

        return[
            'message' => ' Berhasil Update Data',
            // 'program' => $program,
        ];
        // }

        // catch(Exception $error){
        //     return [
        //         'message' => 'Data gagal diupdate',
        //         'message' => $error
        //     ];
        // }
    }

    public function update_image(Request $request)
    {
        
            $fields = $request->validate([
                'id' => 'required',
            ]);

            $program = Program::where('id', $fields['id'])->first();
            if ($image = $request->file('program_image')) {
                $destinationPath = 'img/program_image';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
                $image->move($destinationPath, $profileImage);
                $program-> program_image = "$profileImage";
            }
            // $program->program_image = "$profileImage";
            $program->save();

            return[
                'message' => ' Berhasil Update Data',
                // 'program' => $program,
                // 'image' => "$profileImage"

            ];
        

    }

    public function delete($id)
    {
        
        Program::destroy($id);

            return[
                'message' => ' Berhasil Hapus',
            ];
       
    }

    public function search($program_name)
    {
        return Program::where('program_name', 'like', '%'.$program_name.'%')->get();
        
    }

    public function get_researcher($id){
        $notin = InvitedUser::where('invited_users.program_id',$id)->select('invited_users.user_id');

        $user = User::where('roles','peneliti-keamanan') 
        // ->join('reports','reports.user_id','=','users.id')
        ->whereNotIn('users.id',$notin)
        // ->groupBy('reports.user_id')
        // ->sum('reports.point')
        ->get(['users.id as user_id','nama']);

        // $user = DB::table('users')
        //     ->leftJoin('reports','reports.user_id','=','users.id')
        //     ->where('roles','researcher')
        //     ->WhereNotIn('users.id',$notin)
        //     ->select('users.id as user_id','users.nama as nama',DB::raw('SUM(reports.point) AS points'))
        //     ->groupBy('reports.user_id')
        //     ->get();
            // ->toSql();

        return $user;
    }
    
    public function no_researcher(){

        $query = DB::select(" SELECT  users.id as user_id,users.nama as nama, users.email , ifnull(r.points,0) as points FROM `users` 
        left JOIN(SELECT reports.user_id,sum(reports.point) as points FROM reports WHERE reports.status_report = 'disetujui'  GROUP BY(reports.user_id)) r
        on ( users.id = r.user_id)
        WHERE users.roles = 'peneliti-keamanan'");

        return $query;

        // SELECT  users.id as id,users.nama , ifnull(r.points,0) as points FROM `users` 
        // left JOIN(SELECT reports.user_id,sum(reports.point) as points FROM reports WHERE reports.status_report = 'disetujui'  GROUP BY(reports.user_id)) r
        // on ( users.id = r.user_id)
        // WHERE users.roles = 'peneliti-keamanan';

        // $user = DB::table('users')
        // ->leftJoin('reports','reports.user_id','=','users.id')
        // ->where('roles','peneliti-keamanan')
        // ->select('users.id as user_id','users.nama as nama','users.email',DB::raw('SUM(reports.point) AS points'))
        // ->groupBy('reports.user_id')
        // ->get();

        // return $user;
    }

    public function researcher_program(Request $request){

        $fields = $request->validate([
            'program_id'=>'',
            'user_id' => '',
        ]);

    
        $notin = InvitedUser::where('invited_users.program_id',$fields['program_id'])
        ->where('user_id',$fields['user_id'])
        ->get();
        // $program = Program::where('user_id',$fields['program_id'])->get();
        // $user = DB::table('users')
        //         ->where('roles','researcher')
        //         ->whereIn('users.id',$notin)
        //         ->get('id as user_id','nama');

        return $notin;

    }

    public function set_user(Request $request){
        $request->validate([
            'input.*' => '',
            // 'user_id'=>'',
            'program_id'=>''
        ]);

        $program = Program::where('id',$request->program_id)->first();

        $data = [
            'id' => $program->id,
            'name' => $program->program_name,
            'category' => $program->category
        ];
        foreach ($request->input as $key => $value) {
            $value['program_id']= $request->program_id; 
            InvitedUser::create($value);
            // InvitedUser::create($value['user_id']);
            $email = User::where('id', $value['user_id'])->first();

            Mail::to($email['email'])->send(new MailInvite($data));
            // return ['berhasil'];
        };
    }

    public function delete_invited($id)
    {
        
        InvitedUser::destroy($id);

            return[
                'message' => ' Berhasil Hapus',
            ];
       
    }

    public function get_user_invited($id){
        // return InvitedUser::where('program_id',$id)->get();

        $invite = DB::table('invited_users')
        ->join('users', 'users.id', '=', 'invited_users.user_id')
        ->join('programs', 'programs.id', '=', 'invited_users.program_id')
        ->where('programs.id',$id)
        ->select('invited_users.*','users.nama')
        ->get();

        return $invite;
    }

    public function get_user_program($id){
        // return InvitedUser::where('invited_users',$id)->get();

        $invite = DB::table('invited_users')
        ->join('users', 'users.id', '=', 'invited_users.user_id')
        ->join('programs', 'programs.id', '=', 'invited_users.program_id')
        ->where('invited_users.user_id',$id)
        ->select('invited_users.*','programs.program_name','programs.program_image','programs.type')
        ->get();

        return $invite;
    }

    public function get_info_invited($id){
        // return InvitedUser::where('invited_users',$id)->get();

        $invite = DB::table('invited_users')
        ->join('users', 'users.id', '=', 'invited_users.user_id')
        ->join('programs', 'programs.id', '=', 'invited_users.program_id')
        ->where('invited_users.user_id',$id)
        ->select('invited_users.*','programs.program_name','programs.program_image','programs.type')
        ->get();

        return $invite;
    }

    public function get_reward($program_id){
        $program = Program::where('id',$program_id)
        ->select('price_1','price_2','price_3','price_4','price_5')
        ->get();

        return $program;
    }
}
