<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{

    public function index()
    {
        return Program::where([
            'status'=>'active',
            'category' => 'public'
        ])->get();
        // $program = Program::where('user_id',2)
        // ->Where('program_name', 'like', '%1%')
        // ->get();

        // return $program;
    }

    public function create(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'program_name' => 'required',
            'program_image' => 'required',
            'company_name' => 'required',
            'max_price' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'description' => 'required',
            'status' => 'required',
            'category' => 'required',
        ]);

        return Program::create($request->all());
    }

    public function show($id)
    {
        return Program::find($id);
    }

    public function show_list($id)
    {
        return Program::where('user_id',$id)->get();
    }

    
    public function update(Request $request, $id)
    {
        try{
            $program = Program::find($id);
            $program->update($request->all());
            return[
                'message' => ' Berhasil Update Data',
                'program' => $program,
            ];
        }
        catch(Exception $error){
            return [
                'message' => 'Data gagal diupdate',
                'message' => $error
            ];
        }
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
