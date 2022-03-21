<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PublicKey;
use Spatie\Crypto\Rsa\PrivateKey;
 
class DashboardController extends Controller
{
    //
    public function index()
    {
        
       
        $count_company = User::where('roles','pemilik-sistem')->get()->count();
        $count_researcher = User::where('roles','peneliti-keamanan')->get()->count();
        $count_program = Program::count();
        $count_report = Report::all()->count();
        
        return view('pages.dashboard',compact('count_company','count_researcher','count_program','count_report'));
    }

    public function encodeing($sourcestr)  
    {
        $pathToPublicKey = app_path('Http/Controllers/pubkey.php');
        $key_content = file_get_contents($pathToPublicKey);  
        $pubkeyid    = openssl_get_publickey($key_content);  
          
        if (openssl_public_encrypt($sourcestr, $crypttext, $pubkeyid))  
        {
            return base64_encode("".$crypttext);  
        }
    }


    public function decodeing($crypttext)  
    {
        $pathToPrivateKey = app_path('Http/Controllers/privkey.php');
        // $pathToPrivateKey = app_path('Http/Controllers/api/client_privkey.php');
        $prikeyid    = file_get_contents($pathToPrivateKey);   
        $crypttext   = base64_decode($crypttext);
        
        if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, OPENSSL_PKCS1_PADDING))  
        {
            return "".$sourcestr;  
        }
        return ;  
    }
    

}
