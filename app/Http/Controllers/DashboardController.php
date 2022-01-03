<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        
        $count_company = User::where('roles','company')->get()->count();
        $count_researcher = User::where('roles','researcher')->get()->count();
        // dd($count);
        return view('pages.dashboard',compact('count_company','count_researcher'));
    }
}
