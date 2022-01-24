<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\InvitedUser;
use Illuminate\Http\Request;
use App\Models\ResearcherCertificate;
use Symfony\Component\Console\Input\Input;

class ProgramPublicController extends Controller
{
    public function index()
    {
        return view('pages.program.program',[
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
        $user = User::where('roles','company')->get([
            'id','name'
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
        $program = Program::create($input);



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
   
        return view('pages.program.detail_program', [
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
        $user = User::where('roles','company')->get([
            'id','name'
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
            'user_id' => 'required',
            'program_name' => 'required',
            'program_image' => '',
            // 'company_name' => '',
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
        $program-> user_id = $fields['user_id'];
        $program-> program_name = $fields['program_name'];
        // $program-> company_name = $fields['company_name'];
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
