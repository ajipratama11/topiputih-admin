<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ResearcherSertificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{

    public function store(Request $request)
    {
    $request->validate([
               'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
            ]);
    
            $fileUpload = new ResearcherSertificate;
    
            if($request->file()) {
                $file_name = time().'_'.$request->file->getClientOriginalName();
                $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');

                $fileUpload->user_id = '1';
                $fileUpload->cert_file = time().'_'.$request->file->getClientOriginalName();
                $fileUpload->cert_name = '/public/' . $file_path;
                $fileUpload->cert_date = '1';
                $fileUpload->cert_type = 'test';
                $fileUpload->save();
    
                return response()->json(['success'=>'File uploaded successfully.']);
            
            }
    }
}
