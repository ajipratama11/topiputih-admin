<?php

namespace App\Http\Controllers\API;

use App\Models\Program;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        // $id = $request->input('id');
        // $program_name = $request->input('program_name');
        // $company_name = $request->input('company_name');
        // $max_price = $request->input('max_price');
        // $date_start = $request->input('date_start');
        // $date_end = $request->input('date_end');
        // $email = $request->input('email');
        // $description = $request->input('description');

        // if ($id) {
        //     $program = Program::all()->find($id);
        //     if ($id) {
        //         return ResponseFormatter::success(
        //             $program,
        //             'Data berhasil diambil'
        //         );
        //     } else {
        //         return ResponseFormatter::error(
        //             null,
        //             'Data Tidak ada',
        //             404
        //         );
        //     }
        // }

        // $program = Program::all();
        $data = Program::latest()->get();
        return response()->json([ProgramResource::collection($data), 'Programs fetched.']);
    }

    public function show($id)
    {
        $program = Program::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new ProgramResource($program)]);
    }
}
