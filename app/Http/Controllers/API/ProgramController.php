<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Program;
use App\Models\InvitedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\InviteProgramMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\MailInvite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class ProgramController extends Controller
{

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
        ->get(['programs.*','users.name']);

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
        ->get(['programs.*','users.name']);

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
                ->get(['users.id','users.name','programs.program_name']);

        

        // $program = DB::table('programs')
        // ->rightJoin('users', 'users.id', '=', 'programs.user_id')
        // ->where('programs.id','=',$id)
        // ->first(['programs.*','users.name']);

        return $user;
    }

    public function show($id)
    {

        // $notin = InvitedUser::where('invited_users.program_id',$id)->select('invited_users.user_id');

        // $user = DB::table('users')
        //         ->where('users.id',$user_id)
        //         ->whereIn('users.id',$notin)
        //         ->get(['id as user_id','name']);

        $program = DB::table('programs')
        ->rightJoin('users', 'users.id', '=', 'programs.user_id')
        ->where('programs.id','=',$id)
        ->first(['programs.*','users.name']);

        return $program;
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

        $program = Program::where('id', $fields['id'])->first();
        // if ($image = $request->file('program_image')) {
        //     $destinationPath = 'img/program_image';
        //     $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
        //     $image->move($destinationPath, $profileImage);
        //     $program-> program_image = "$profileImage";
        // }
        $program-> program_name = $fields['program_name'];
        // $program-> company_name = $fields['company_name'];
        $program-> price_1 = $fields['price_1'];
        $program-> price_2 = $fields['price_2'];
        $program-> price_3 = $fields['price_3'];
        $program-> price_4 = $fields['price_4'];
        $program-> price_5 = $fields['price_5'];
        $program-> date_start = $fields['date_start'];
        $program-> date_end = $fields['date_end'];
        $program-> description = $fields['description'];
        $program-> scope = $fields['scope'];
        $program-> status = $fields['status'];
        $program-> category = $fields['category'];
        $program-> type = $fields['type'];
    
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
         try {
            $fields = $request->validate([
                'id' => 'required',
                'program_image' => 'required',
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
        } catch (Exception $error) {
            return [
                'message' => 'gagal',
                'error' => $error
            ];
        }

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

        $user = User::where('roles','researcher') 
        // ->join('researcher_certificates','researcher_certificates.user_id','=','users.id')
        ->whereNotIn('users.id',$notin)
        ->with('researchercertificate')
        ->get();

        return $user;

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
        //         ->get('id as user_id','name');

        return $notin;

    }

    public function set_user(Request $request){
        $request->validate([
            'input.*' => '',
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
            $email = User::where('id',$value['user_id'])->first();

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
        ->select('invited_users.*','users.name')
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

}
