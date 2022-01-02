<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //
    public function index()
    {
        return view('pages.company',[
            'companies' => User::where('roles','user')->get()
        ]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

  
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $company = User::findOrFail($id);
   
        return view('pages.edit_company', [
          'company' => $company
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        $researcher = User::find($id);

        $researcher->delete();

        return back()->with('success',' Penghapusan berhasil.');
    }
}
