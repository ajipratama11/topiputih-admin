<?php

namespace App\Http\Controllers;

use App\Models\ResearcherCertificate;
use App\Models\ResearcherSertificate;
use App\Models\User;
use Illuminate\Http\Request;

class ResearcherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $count = ResearcherSertificate::where([
        //     'cert_type' => 'keahlian'])->count();


        return view('pages.researcher.researcher',[
            'researchers' => User::where('roles','peneliti-keamanan')->get()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.researcher.create_researcher');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        // $researcher = User::findOrFail($id);
        $researcher = User::where('slug',$request->session()->get('slug'))
        ->first();
        return view('pages.researcher.detail_researcher', [
          'researcher' => $researcher,
          'certificate' => ResearcherCertificate::where('user_id',$researcher->id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $researcher = User::findOrFail($id);
   
        return view('pages.researcher.edit_researcher', [
          'researcher' => $researcher
        ]);
        // return view('pages.researcher',[
        //     'researchers' => User::where('roles','admin')->get()
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $researcher)
    {
        $researcher->update($request->all());

        return redirect()->route('researcher.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $researcher = User::find($id);

        $researcher->delete();

        return back()->with('success',' Penghapusan berhasil.');
    }

    public function peneliti_keamanan(Request $request){
        $request ->validate([
            'slug'=>'required'
        ]);
        $request->session()->put('slug',$request['slug']);

        return redirect()->route('peneliti-keamanan.show','detail');
    }
}
