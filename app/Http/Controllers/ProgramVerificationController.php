<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $program = Program::where('status','Tidak Aktif')->get();
        $program_hapus = Program::where('status','Request Hapus')->get();
        return view('pages.program_verification.program',[
            'program' => $program
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $program = Program::where('slug',$request->session()->get('slug-program') )
        ->first();
        $back = 'aktifkan-program';
        return view('pages.delete_program.detail_program')->with('program', $program)->with('back',$back);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $program = Program::where('id',$id)->first();
        $program-> status = 'Aktif';
        $program->save();

         $request->session()->put('slug-program',$program->slug);
        // if ($program) {
            return redirect()
                ->route('aktifkan-program.index')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
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

    public function detail_program(Request $request){
        $request ->validate([
            'slug'=>'required'
        ]);
        $request->session()->put('slug-program',$request['slug']);

        return redirect()->route('aktifkan-program.show','detail');

    }
}
