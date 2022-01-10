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
        // return ResearcherBank::where('user_id', $user_id)->first();

        $bank =  ResearcherBank::where('user_id', $user_id)->first();

        return[
            'message' => 'berhasil',
            'id' => $bank -> id,
            'user_id' => $bank -> user_id,
            'bank_name' => $bank -> bank_name,
            'account_number' => $this->encodeing($bank -> account_number),
            'account_name' => $this->encodeing($bank -> account_name),
        ];
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
        ]);
            $bank = new ResearcherBank;
            $bank-> user_id = $fields['user_id'];
            $bank-> bank_name = $fields['bank_name'];
            $bank-> account_number = $this->decodeing($fields['account_number']);
            $bank-> account_name = $this->decodeing($fields['account_name']);
            $bank->save();
            return[
                'message' => ' Berhasil Menambahkan Data',
                'bank' => $bank,
            ];
    }

    public function update(Request $request)
    {
        
        $fields = $request->validate([
            'user_id' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
        ]);
        
            $bank = ResearcherBank::where('user_id', $fields['user_id'])->first();
            // $bank = ResearcherBank::find( 1);
            // $bank-> user_id = $fields['user_id'];
            $bank-> bank_name = $fields['bank_name'];
            // $bank-> account_number = $fields['account_number'];
            // $bank-> account_name = $fields['account_name'];
            $bank-> account_number = $this->decodeing($fields['account_number']);
            $bank-> account_name = $this->decodeing($fields['account_name']);
            $bank->save();
            return[
                'message' => ' Berhasil Update Data',
                'bank' => $bank,
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
