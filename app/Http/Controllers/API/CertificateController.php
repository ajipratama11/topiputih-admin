<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ResearcherSertificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function show($id)
    {
        return ResearcherSertificate::where('user_id', $id)->get();;
    }

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
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $input['cert_file'] = "$profileImage";
        }
    
        ResearcherSertificate::create($input);

        return[
            'message' => ' Berhasil Tambah Data',
            'cert' => $input,
        ];
    }

    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required',
    //         'cert_name' => 'required',
    //         'cert_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'cert_date' => 'required',
    //         'cert_type' => 'required',
    //     ]);
  
    //     $input = $request->all();
  
    //     if ($image = $request->file('cert_file')) {
    //         $destinationPath = 'img/';
    //         $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
    //         $image->move($destinationPath, $profileImage);
    //         $input['cert_file'] = "$profileImage";
    //     }
    
    //     ResearcherSertificate::create($input);

    //     return[
    //         'message' => ' Berhasil Update Data',
    //         'cert' => $input,
    //     ];
    // }

    public function delete($id)
    {
            ResearcherSertificate::destroy($id);
            return[
                'message' => ' Berhasil Hapus',
            ];
    }
}
