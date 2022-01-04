<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PublicKey;
use Spatie\Crypto\Rsa\PrivateKey;
 
class DashboardController extends Controller
{
    //
    public function index()
    {
        
        $pathToPublicKey = app_path('Http/Controllers/pubkey.php');
        $key_content = file_get_contents($pathToPublicKey);  
        
        $pathToPrivateKey = app_path('Http/Controllers/privkey.php');
        $prikeyid    = file_get_contents($pathToPrivateKey);  
        // $crypttext   = base64_decode($crypttext);

        $count_company = User::where('roles','company')->get()->count();
        $count_researcher = User::where('roles','researcher')->get()->count();
    
        // $enc = 
        
        $enc = $this->encodeing('123');
        $dec = $this->decodeing('PriWRxUATQg+arvye7CyZkg0fp2DbYfoMcXQYCzTHf7UN2BLXTHCFYIcz4x+NDf1nMhkRbzJIVIum/D/UaMEGwI1Q1Dn44JesF9x8aMhy0jynzDVgr8g4FnBxozGPL+3Qazz49BGPOpq26qh5vEV7mEMUnHJoj9U5/uvy4mn17g=');
        // $enc = $key_content;
        // $dec = $prikeyid;
        return view('pages.dashboard',compact('count_company','count_researcher','dec','enc'));
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
        $prikeyid    = file_get_contents($pathToPrivateKey);   
        $crypttext   = base64_decode($crypttext);
        
        if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, OPENSSL_PKCS1_PADDING))  
        {
            return "".$sourcestr;  
        }
        return ;  
    }
    

}
