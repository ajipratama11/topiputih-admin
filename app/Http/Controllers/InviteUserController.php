<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Mail\MailInvite;
use App\Models\InvitedUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\ResearcherCertificate;

class InviteUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mail.invite',
        [
        
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
        $request->validate([
                'input.*' => 'required',
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
        }
        return back();
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $researcher = User::where('slug',$id)->first();

        $point = DB::table('reports')
        ->where('user_id',$id)
        ->sum('point');

        return view('pages.invite_user.detail_user',compact('researcher'), [
        //   'researcher' => $researcher,
        //   'point' => $point
        ]);
        // return $researcher;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program = Program::where('slug',$id)->first();
        
        $invited = InvitedUser::where('program_id',$program->id)->get();

        $notin = InvitedUser::where('invited_users.program_id',$program->id)->select('invited_users.user_id');
        $user = User::where('roles','peneliti-keamanan') 
                ->whereNotIn('users.id',$notin)
                ->get(['id','nama']);

        // $choice = User::findOrFail($id);
        return view('pages.invite_user.invite_user',compact('user'),
        [
            'program' => $program,
            'users' => $invited,
            // 'choice' => $choice
            ]);
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
        $invited = InvitedUser::find($id);

        $invited->delete();

        return back()->with('success',' Penghapusan berhasil.');
    }

    public function search($id)
    {
        $user = User::find($id);
        $point = DB::table('reports')
        ->where('user_id',$id)
        ->where('status_report','Disetujui')
        ->sum('point');
        $report = DB::table('reports')
        ->where('user_id',$id)
        ->count('user_id');
        
	    return [
            'user'=>$user,
            'point' =>$point,
            'report' => $report,
        ];
    	
    }
    public function list($id)
    {
        $foruser = ResearcherCertificate::where('user_id',$id)->get();
        // // $foruser = User::all();
	    // return $foruser;
    	
        return DataTables::of($foruser)
        ->make(true);
   
    }
}
