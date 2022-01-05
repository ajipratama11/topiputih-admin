<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function user(Request $request){
        // auth()->user()->tokens();
        return Auth::user();
        // return [
        //     'message' =>auth()->user(),
        // ];
    }



    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Berhasil Keluar'
        ];
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone_number' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
                'roles' => ['required', 'string', 'max:255'],
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($this->decodeing( $request->password)),
                'roles' => $request->roles,
            ]);

            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('token')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Email atau username sudah digunakan',
                'error' => $error
            ], 'Authentication Failed', 500);
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
    public function login(Request $request)
    {
                $fields = $request->validate([
                            'email' => 'required|string',
                            'password' => 'required|string'
                        ]);
                // Check email
                $user = User::where('email', $fields['email'])->first();

                // $decrypted = openssl_decrypt(base64_decode( $fields['password']), 'aes-128-cbc', self::AES_KEY, OPENSSL_RAW_DATA, self::AES_IV);
                $decrypted = $this->decodeing( $fields['password']);
                // Check password
                if(!$user || !Hash::check($decrypted, $user->password)) {
                    return response([
                        'message' => 'Invalid',
                        'field' => $fields
                    ], 401);
                }
        // $pass = 'password';

        // $dec = openssl_decrypt(base64_decode($pass), 'aes-128-cbc', self::AES_KEY, OPENSSL_RAW_DATA, self::AES_IV);

        // $credentials = request([
        //     'email',
        //     'password'
        // ]);
        // if (!Auth::attempt($credentials)) {
        //     return response([
        //         'message' => 'Invalid' ,
        //         'input' => $credentials

        //     ], Response::HTTP_UNAUTHORIZED);
        // }


        // $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'message' => 'Success',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            // 'input' => $credentials,
        ])->withCookie($cookie);


    }

}
