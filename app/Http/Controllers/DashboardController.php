<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        
        $count_company = User::where('roles','company')->get()->count();
        $count_researcher = User::where('roles','researcher')->get()->count();
        $dec = $this->aes_encrypt('123');
        $enc = $this->aes_decrypt('1SOcNAHVRsKYr9VZmQL7HQ==');
        // dd($count);
        return view('pages.dashboard',compact('count_company','count_researcher','dec','enc'));
    }

    const AES_KEY = "qq3217834abcdefg"; //16-bit
    const AES_IV  = "1234567890123456"; //16-bit

    public static function aes_decrypt($str)
    {
        $decrypted = openssl_decrypt(base64_decode($str), 'aes-128-cbc', self::AES_KEY, OPENSSL_RAW_DATA, self::AES_IV);

        return $decrypted;
    }

    public static function aes_encrypt($plain_text)
    {
        $encrypted_data = openssl_encrypt($plain_text, 'aes-128-cbc', self::AES_KEY, OPENSSL_RAW_DATA, self::AES_IV);

        return base64_encode($encrypted_data);
    }

}
