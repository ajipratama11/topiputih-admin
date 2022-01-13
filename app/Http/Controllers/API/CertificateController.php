<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResearcherCertificate;
use App\Models\ResearcherSertificate;

class CertificateController extends Controller
{
    public function show($id)
    {
        return ResearcherCertificate::where('user_id', $id)->get();;
    }

    public function show_detail($id)
    {
        return ResearcherCertificate::where('id', $id)->first();;
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
    
        ResearcherCertificate::create($input);

        return[
            'message' => ' Berhasil Tambah Data',
            // 'cert' => $input,
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
  
        $cert = ResearcherCertificate::where('id', $fields['id'])->first();
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
            // 'cert' => $cert,
        ];
    }

    public function delete($id)
    {
        ResearcherCertificate::destroy($id);
        return[
            'message' => ' Berhasil Hapus',
        ];
    }

    public function show_1($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'cert_type' => 'keahlian'])->get();
    }

    public function show_2($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'cert_type' => 'penghargaan'])->get();
    }
}
