<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use SebastianBergmann\Environment\Console;

class ProgramPrivateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.program_private.program',[
            'program' => Program::where('category','privat')->where('status','aktif')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('roles','pemilik-sistem')->get([
            'id','nama'
        ]);
        return view('pages.program_private.create_program',compact('user'));
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
            'company_name' => '',
            'price_1' => '',
            'price_2' => '',
            'price_3' => '',
            'price_4' => '',
            'price_5' => '',
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
            $input['slug']=Str::slug($input['program_name']);
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
                ->route('program-privat.index')
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
    public function show(Request $request, $id)
    {
        $program = Program::where('slug',$request->session()->get('slug-program'))
        ->first();
        $back = 'program-privat';
        return view('pages.program_private.detail_program')
        ->with('program',$program)
        ->with('back',$back);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $program = Program::where('slug',$request->session()->get('slug-program'))
        ->first();

        // $user = User::where('roles','pemilik-sistem')->get([
        //     'id','nama'
        // ]);
        return view('pages.program_private.edit_program',[
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
            // 'user_id' => '',
            'program_name' => 'required',
            'program_image' => '',
            'price_1' => '',
            'price_2' => '',
            'price_3' => '',
            'price_4' => '',
            'price_5' => '',
            'date_start' => '',
            'date_end' => '',
            'description' => '',
            'scope' => '',
            'status' => '',
            'category' => '',
            'type' => '',
        ]);

        $program = Program::where('id',$id)->first();
        if ($image = $request->file('program_image')) {
            $destinationPath = 'img/program_image';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $program-> program_image = "$profileImage";
        }
        // $program-> user_id = $fields['user_id'];
        $program-> program_name = $fields['program_name'];
        $program-> slug = Str::slug($fields['program_name']);
        $program-> date_start = $fields['date_start'];
        $program-> date_end = $fields['date_end'];
        $program-> description = $fields['description'];
        $program-> scope = $fields['scope'];
        $program-> status = $fields['status'];
        $program-> category = $fields['category'];
        $program-> type = $fields['type'];
        if($fields['type'] == 'Vulnerability Disclosure'){
            $program-> price_1 = NULL;
            $program-> price_2 = NULL;
            $program-> price_3 = NULL;
            $program-> price_4 = NULL;
            $program-> price_5 = NULL;
        }else{
        $program-> price_1 = $fields['price_1'];
        $program-> price_2 = $fields['price_2'];
        $program-> price_3 = $fields['price_3'];
        $program-> price_4 = $fields['price_4'];
        $program-> price_5 = $fields['price_5'];
        }
        $program->save();
        $request->session()->put('slug-program',$program->slug);
        if ($program) {
            return redirect()
                ->route('program-privat.show','detail')
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
        $program = Program::where('id',$id)->first();
        $program-> status = 'Terhapus';
        $program->save();

        return back()->with('success',' Penghapusan berhasil.');
    }

    public function program_privat(Request $request){
        $request ->validate([
            'slug'=>'required'
        ]);
        $request->session()->put('slug-program',$request['slug']);

        return redirect()->route('program-privat.show','detail');
    }

    // public function edit_program(Request $request){
    //     $request ->validate([
    //         'slug'=>'required'
    //     ]);
    //     $request->session()->put('slug',$request['slug']);
    //     // $program = Program::where('slug',$request['slug'] )
    //     // ->first();
    //     // $user = User::where('roles','pemilik-sistem')->get([
    //     //     'id','nama'
    //     // ]);
    //     // return view('pages.program.edit_program')->with('program', $program)->with('user',$user);
    //     return redirect()->route('detail-program');
    // }
}
