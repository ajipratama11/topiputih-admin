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
            'user_id' => 'required',
            'cert_name' => 'required',
            'cert_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cert_date' => 'required',
            'cert_type' => 'required',
        ]);
  
        $input = $request->all();
  
        if ($image = $request->file('cert_file')) {
            $destinationPath = 'img/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['cert_file'] = "$profileImage";
        }
    
        ResearcherSertificate::create($input);

        return ('success Product created successfully.');
    }
}
