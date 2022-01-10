<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;

class LoginController extends Controller
{
    //
    public function index()
    {

        return view('pages.login');

    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
        // $user = User::where([
        //     'email'=>$credentials['email'],
        //     'password'=>$credentials['']]);
        if(Auth::attempt($credentials)){
            // if($user = User::where('roles','administrator')){
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            // };
            
        };

        return back()->with('loginEror','Login Gagal');
    }

    public function logout(Request $request){
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
