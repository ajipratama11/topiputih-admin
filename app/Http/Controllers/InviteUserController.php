<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\InvitedUser;
use Illuminate\Http\Request;
use App\Mail\InviteProgramMail;
use App\Mail\MailInvite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        $notin = InvitedUser::where('invited_users.program_id',$id)->select('invited_users.user_id');

        $program = Program::findOrFail($id);
        
        $invited = InvitedUser::where('program_id',$id)->get();

        $user = User::where('roles','researcher') 
                ->whereNotIn('users.id',$notin)
                ->get(['id','name']);

        return view('pages.invite_user.invite_user',compact('user'),
        [
            'program' => $program,
            'users' => $invited
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
}
