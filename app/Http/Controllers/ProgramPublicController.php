<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\InvitedUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProgramPublicController extends Controller
{
    public function index()
    {
        return view('pages.program.program',[
            'program' => Program::where('category','publik')
            ->where('status','aktif')->get()
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
        
        return view('pages.program.create_program', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  public function store(Request $request){
         
    //     $request->validate([
    //         'input.*' => 'required',
    //         'program_id'=>''
    //     ]);
        
    //     foreach ($request->input as $key => $value) {
    //         $value['program_id']= $request->program_id;
    //         InvitedUser::create($value);
    //     }

    //     // $request->validate([
    //     //         'name' => ''
    //     //     ]);
    //     // $data = $request->all();
    //     // $finalArray = array();
    //     // foreach($data as $key=>$value){
    //     //     print_r($value); die;
    //     // array_push($finalArray, array(
    //     //                 // 'program_id'=>$value['program_id'],
    //     //                 // 'user_id'=>$value['id'],
    //     //                 'name'=>$value['sname'] )
    //     // );
    //     // }
    //     // dd($value);
    //     InvitedUser::insert($finalArray);

    //     return redirect()
    //                 ->route('program_public.index');
    //  }


    public function store(Request $request)
    {
        $input = $request->validate([
            'user_id'=>'required',
            'program_name' => 'required',
            'program_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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



        if ($program) {
            return redirect()
                ->route('program-publik.index')
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
    public function show(Request $request )
    {
        $program = Program::where('slug',$request->session()->get('slug-program') )
        ->first();
        $back = 'program-publik';
        return view('pages.program.detail_program')->with('program', $program)->with('back',$back);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        // $program = Program::findOrFail($id);
        $program = Program::where('slug',$request->session()->get('slug-program'))
        ->first();
        $user = User::where('roles','pemilik-sistem')->get([
            'id','nama'
        ]);
        return view('pages.program.edit_program', compact('user'), [
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
            'program_name' => '',
            'program_image' => '',
            // 'company_name' => '',
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
        // if ($program) {
            return redirect()
                ->route('program-publik.show','detail')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        // } else {
        //     return redirect()
        //         ->back()
        //         ->withInput()
        //         ->with([
        //             'error' => 'Some problem occurred, please try again'
        //         ]);
        // }
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

    public function data($id)
    {
        $program = Program::where('slug',$id)
        ->first();
        
        return [
            'program'=>$program,
        ];
    }

    public function program_publik(Request $request){
        $request ->validate([
            'slug'=>'required'
        ]);
        $request->session()->put('slug-program',$request['slug']);

        return redirect()->route('program-publik.show','detail');

    }

    // public function edit_program(Request $request){
    //     $request ->validate([
    //         'slug'=>'required'
    //     ]);
    //     $request->session()->put('slug-program',$request['slug']);
    //     // $program = Program::where('slug',$request['slug'] )
    //     // ->first();
    //     // $user = User::where('roles','pemilik-sistem')->get([
    //     //     'id','nama'
    //     // ]);
    //     // return view('pages.program.edit_program')->with('program', $program)->with('user',$user);
    //     return redirect()->route('program-publik.show','detail');
    // }

    // public function detail_program(Request $request){
    //     // $request->session()->get('slug');
    //     $program = Program::where('slug',$request->session()->get('slug'))
    //     ->first();

    //     return view('pages.program.detail_program')->with('program', $program);
    // }
}
