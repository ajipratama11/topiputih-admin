<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{

    public function index()
    {   
      
        $program = DB::table('programs')
        ->rightJoin('users', 'users.id', '=', 'programs.user_id')
        ->where('date_start','<=',Carbon::now()->isoFormat('Y-MM-DD'))
        ->where('date_end','>=',Carbon::now()->isoFormat('Y-MM-DD'))
        ->where([
            'status'=>'aktif',
            'category' => 'publik'
        ])
        ->get(['programs.*']);

        return $program;
    }

    public function create(Request $request)
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
        Program::create($input);

        return[
            'message' => ' Berhasil Tambah Data',
            // 'program' => $input,
        ];
    }

    public function show($id)
    {
        return Program::find($id);
    }

    public function show_list($id)
    {
        return Program::where('user_id',$id)->get();
    }

    
    public function update(Request $request)
    {
        
        $fields = $request->validate([
            'id' => 'required',
            'program_name' => 'required',
            'program_image' => 'required',
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

        $program = Program::where('id', $fields['id'])->first();
        if ($image = $request->file('img/program_image')) {
            $destinationPath = 'img/';
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

        return[
            'message' => ' Berhasil Update Data',
            // 'program' => $program,
        ];
        // }

        // catch(Exception $error){
        //     return [
        //         'message' => 'Data gagal diupdate',
        //         'message' => $error
        //     ];
        // }
    }

    public function delete($id)
    {
        
        Program::destroy($id);

            return[
                'message' => ' Berhasil Hapus',
            ];
       
    }

    public function search($program_name)
    {
        return Program::where('program_name', 'like', '%'.$program_name.'%')->get();
        
    }
}
