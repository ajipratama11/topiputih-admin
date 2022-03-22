<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResearcherCertificate;
use App\Models\ResearcherSertificate;

class CertificateController extends Controller
{

    public function index()
    {
        return ResearcherCertificate::all();
    }
    
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
            'nama_sertifikat' => 'required',
            'berkas_sertifikat' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_sertifikat' => 'required',
            'tipe_sertifikat' => 'required',
        ]);
  
        $input = $request->all();
  
        if ($image = $request->file('berkas_sertifikat')) {
            $destinationPath = 'img/certificate/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $input['berkas_sertifikat'] = "$profileImage";
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
            'nama_sertifikat' => 'required',
            'berkas_sertifikat' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_sertifikat' => 'required',
            'tipe_sertifikat' => 'required',
        ]);
  
        $cert = ResearcherCertificate::where('id', $fields['id'])->first();
        if ($image = $request->file('berkas_sertifikat')) {
            $destinationPath = 'img/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $cert-> berkas_sertifikat = "$profileImage";
        }
        $cert-> nama_sertifikat = $fields['nama_sertifikat'];
        $cert-> tanggal_sertifikat = $fields['tanggal_sertifikat'];
        $cert-> tipe_sertifikat = $fields['tipe_sertifikat'];
    
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
            'tipe_sertifikat' => 'keahlian'])->get();
    }

    public function show_2($user_id)
    {
        return ResearcherCertificate::where([
            'user_id'=> $user_id,
            'tipe_sertifikat' => 'penghargaan'])->get();
    }
}
