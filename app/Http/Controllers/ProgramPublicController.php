<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ProgramPublicController extends Controller
{
    public function index()
    {
        return view('pages.program_public.program',[
            'program' => Program::where('category','publik')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.program_public.create_program');
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
            'user_id'=>'required',
            'program_name' => 'required',
            'program_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name' => 'required',
            'price_1' => 'required',
            'price_2' => 'required',
            'price_3' => 'required',
            'price_4' => 'required',
            'price_5' => 'required',
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
        $program = Program::create($input);

        // $input = $request->validate([
        //     'user_id'=>'required',
        //     'program_name' => 'required',
        //     // 'program_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'company_name' => 'required',
        //     'price_1' => 'required',
        //     'price_2' => 'required',
        //     'price_3' => 'required',
        //     'price_4' => 'required',
        //     'price_5' => 'required',
        //     'date_start' => 'required',
        //     'date_end' => 'required',
        //     'description' => 'required',
        //     'scope' => 'required',
        //     'status' => 'required',
        //     'type' => 'required',
        //     'category' => 'required',
        // ]);
    
        // $post = Program::create($input);

        if ($program) {
            return redirect()
                ->route('program_public.index')
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
        $program = Program::findOrFail($id);
   
        return view('pages.program_public.detail_program', [
          'program' => $program,
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
        $program = Program::findOrFail($id);
   
        return view('pages.program_public.edit_program', [
          'program' => $program
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
        $fields = $request->validate([
            // 'id' => 'required',
            'program_name' => 'required',
            'program_image' => '',
            'company_name' => 'required',
            'price_1' => 'required',
            'price_2' => 'required',
            'price_3' => 'required',
            'price_4' => 'required',
            'price_5' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'description' => 'required',
            'scope' => 'required',
            'status' => 'required',
            'category' => 'required',
            'type' => 'required',
        ]);

        $program = Program::where('id',$id)->first();
        if ($image = $request->file('program_image')) {
            $destinationPath = 'img/program_image';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $program-> program_image = "$profileImage";
        }
        
        $program-> program_name = $fields['program_name'];
        $program-> company_name = $fields['company_name'];
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

        if ($program) {
            return redirect()
                ->route('program_public.index')
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $program = Program::find($id);

        $program->delete();

        return back()->with('success',' Penghapusan berhasil.');
    }
}
