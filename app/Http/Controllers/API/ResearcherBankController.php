<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ResearcherBank;
use Illuminate\Http\Request;
use Exception;

class ResearcherBankController extends Controller
{


    public function show($user_id)
    {
        
        $bank =  ResearcherBank::where('user_id',$user_id)->first();
        return[

            'message' => 'berhasil',
            'id' => $this->encodeing($bank -> id),
            'user_id' => $this->encodeing( $bank -> user_id),
            'nama_bank' => $bank -> nama_bank,
            'nomor_rekening' => $this->encodeing($bank -> nomor_rekening),
            'nama_rekening' => $this->encodeing($bank -> nama_rekening),
        ];
        
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required',
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'nama_rekening' => 'required',
        ]);
            $bank = new ResearcherBank;
            $bank-> user_id = $this->decodeing($fields['user_id']);
            $bank-> nama_bank = $fields['nama_bank'];
            $bank-> nomor_rekening = $this->decodeing($fields['nomor_rekening']);
            $bank-> nama_rekening = $this->decodeing($fields['nama_rekening']);
            $bank->save();
            return[
                'message' => ' Berhasil Menambahkan Data',
                // 'bank' => $bank,
            ];
    }

    public function update(Request $request)
    {
        
        $fields = $request->validate([
            'user_id' => 'required',
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'nama_rekening' => 'required',
        ]);
        
            $bank = ResearcherBank::where('user_id', $this->decodeing($fields['user_id']))->first();
            // $bank = ResearcherBank::find( 1);
            // $bank-> user_id = $fields['user_id'];
            $bank-> nama_bank = $fields['nama_bank'];
            // $bank-> nomor_rekening = $fields['nomor_rekening'];
            // $bank-> nama_rekening = $fields['nama_rekening'];
            $bank-> nomor_rekening = $this->decodeing($fields['nomor_rekening']);
            $bank-> nama_rekening = $this->decodeing($fields['nama_rekening']);
            $bank->save();
            return[
                'message' => ' Berhasil Update Data',
                // 'bank' => $bank,
            ];
        
    }

    public function decodeing($crypttext)
    {
        $pathToPrivateKey = app_path('Http/Controllers/privkey.php');
        $prikeyid    = file_get_contents($pathToPrivateKey);
        $crypttext   = base64_decode($crypttext);

        if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, OPENSSL_PKCS1_PADDING))
        {
            return "".$sourcestr;
        }
        return ;
    }

    public function encodeing($sourcestr)  
    {
        
        $pathToPublicKey = app_path('Http/Controllers/api/client_pubkey.php');
        $key_content = file_get_contents($pathToPublicKey);  
        $pubkeyid    = openssl_get_publickey($key_content);  
          
        if (openssl_public_encrypt($sourcestr, $crypttext, $pubkeyid))  
        {
            return base64_encode("".$crypttext);  
        }
    }

   
}
