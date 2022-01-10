<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Program;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //
    public function index()
    {
        return view('pages.company.company',[
            'companies' => User::where('roles','company')->get()
        ]);
    }


    public function create()
    {
        return view('pages.company.create_company');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'roles' => ['required', 'string', 'max:255'],
        ]);
    }

  
    public function show($id)
    {
        $company = User::findOrFail($id);
   
        return view('pages.company.detail_company', [
          'company' => $company,
          'program' => Program::where('user_id',$id)->get()
        ]);
    }

  
    public function edit($id)
    {
        $company = User::findOrFail($id);
   
        return view('pages.company.edit_company', [
          'company' => $company
        ]);
    }

    public function update(Request $request, User $company)
    {
        $company->update($request->all());

        return redirect()->route('company.index');
    }

  
    public function destroy($id)
    {
        $researcher = User::find($id);

        $researcher->delete();

        return back()->with('success',' Penghapusan berhasil.');
    }
}
