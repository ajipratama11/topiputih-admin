<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    

    public function index()
    {
        return Program::all();
    }

    public function create(Request $request)
    {
        $request->validate([
            'program_name' => 'required',
            'company_name' => 'required',
            'max_price' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'email' => 'required',
            'description' => 'required',
        ]);

        return Program::create($request->all());
    }

    public function show($id)
    {
        return Program::find($id);
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
        
            $program = Program::destroy($id);

            return[
                'message' => ' Berhasil Hapus',
            ];
       
    }

    public function search($program_name)
    {
        return Program::where('program_name', 'like', '%'.$program_name.'%')->get();
        
    }
}
