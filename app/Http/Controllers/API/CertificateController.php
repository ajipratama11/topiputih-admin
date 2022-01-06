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
            $destinationPath = 'img/certificate/';
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

    public function update(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required',
            'cert_name' => 'required',
            'cert_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cert_date' => 'required',
            'cert_type' => 'required',
        ]);
  
        $cert = ResearcherSertificate::where('id', $fields['id'])->first();
        if ($image = $request->file('cert_file')) {
            $destinationPath = 'img/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $cert-> cert_file = "$profileImage";
        }
        $cert-> cert_name = $fields['cert_name'];
        $cert-> cert_date = $fields['cert_date'];
        $cert-> cert_type = $fields['cert_type'];
    
        $cert->save();

        return[
            'message' => ' Berhasil Update Data',
            'cert' => $cert,
        ];
    }

    public function delete($id)
    {
            ResearcherSertificate::destroy($id);
            return[
                'message' => ' Berhasil Hapus',
            ];
    }
}
