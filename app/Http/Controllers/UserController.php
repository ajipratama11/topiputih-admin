<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
        return view('pages.user.create_user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'max:255'],
        ]);
        // $input['nama']= 'administrator';
        $input['roles']= 'administrator';
        $input['slug']= Str::slug($input['nama']);
        $input['nomor_telepon']= '000000000000';
        $input['foto_pengguna']= 'topiputih.png';
        $input['password']= Hash::make($input['password']);
        $user = User::create($input);

        if ($user) {
            return redirect()->intended('/halaman-utama')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
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
        $user=User::find($id);
        return view('pages.user.change_password',[
            'user'=> $user
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
        $request->validate([
            'password_old' => '',
            'password_new' => '',
            'password_confirm' => '',
        ]);
        $user = User::find($id);

        if(!Hash::check($request['password_old'],$user->password)) {
            return redirect()->route('user.edit',$id)->with('error', 'Password Lama Salah');
        }elseif($request['password_new']!=$request['password_confirm']){
            return redirect()->route('user.edit',$id)->with('error', 'Password Tidak Sama');
        }else{
            $user->password =  Hash::make($request['password_new']);
            $user->save();
            return redirect()->route('user.edit',$id)->with('error', 'Password Berhasil Diubah');
        }
        
        
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
