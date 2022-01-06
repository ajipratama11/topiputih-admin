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
        return Auth::user();
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
                'contact_name' => ['required', 'string', 'max:255'],
                'profile_picture' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'unique:users'],
                'phone_number' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
                'roles' => ['required', 'string', 'max:255'],
            ]);

            User::create([
                'name' => $request->name,
                'contact_name' => $request->contact_name,
                'profile_picture' =>$request->profile_picture,
                'email' => $this->decodeing($request->email),
                'phone_number' => $request->phone_number,
                'password' => Hash::make($this->decodeing( $request->password)),
                // 'password' => Hash::make( $request->password),   
                'roles' => $this->decodeing($request->roles)
            ]);

            $user = User::where('email',$this->decodeing($request->email))->first();

            // dd($user);
            $tokenResult = $user->createToken('token')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
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
                $user = User::where('email',$this->decodeing( $fields['email']))->first();

                // $decrypted = openssl_decrypt(base64_decode( $fields['password']), 'aes-128-cbc', self::AES_KEY, OPENSSL_RAW_DATA, self::AES_IV);
                $decrypted = $this->decodeing( $fields['password']);
                
                if(!$user || !Hash::check($decrypted,$user->password)) {
                    return response([
                        'message' => 'Invalid',
                        'field' => $fields
                    ], 401);
                }
        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'message' => 'Success',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'field' => $fields
            // 'input' => $credentials,
        ])->withCookie($cookie);


    }

    public function cek_password (Request $request){

        $fields = $request->validate([
                            'id' => 'required|string',
                            'password' => 'required|string'
                        ]);
        $user = User::where('id', $fields['id'])->first();
        $decrypted = $this->decodeing( $fields['password']);
        if(!$user || !Hash::check( $decrypted,$user->password)) {
            return response([
                'message' => 'Password Tidak cocok',
                'field' => $fields
            ], 401);
        }
        return response([
            'message' => 'Password cocok',
            'user' => $user,
            'field' => $fields
        ]);

    }

    public function edit_password (Request $request){
        $fields = $request->validate([
                            'id' => 'required|string',
                            'password' => 'required|string',
                            'password_new' => 'string'
                        ]);
        $user = User::where('id', $fields['id'])->first();
        $decrypted = $this->decodeing( $fields['password']);
        if(!$user || !Hash::check($decrypted,$user->password)) {
            return response([
                'message' => 'Password Tidak cocok',
                'field' => $fields
            ], 401);
        }else{
            $user = User::find( $fields['id']);
            // $user-> name = 'budis';
            $user-> password =  Hash::make($this->decodeing($fields['password_new']));
            $user->save();
            return[
                'message' => ' Berhasil Update Data',
                'program' => $user,
            ];
        }
        
        
    }

    public function show($id)
    {
        return User::where('id', $id)->first();;
    }

    public function edit_user (Request $request){
        $fields = $request->validate([
                            'id' => ['required', 'string', 'max:255'],
                            'name' => ['required', 'string', 'max:255'],
                            'contact_name' => [  'max:255'],
                            'email' => ['required', 'string', 'max:255'],
                            'phone_number' => ['required', 'string', 'max:255']
                        ]);
        // $user = User::where('id', $fields['id'])->first();
        $user = User::find( $fields['id']);
        $user-> name =  $fields['name'];
        $user-> contact_name =  $fields['contact_name'];
        $user-> email =  $fields['email'];
        $user-> phone_number =  $fields['phone_number'];
        $user->save();
        return[
            'message' => ' Berhasil Update Data',
            'program' => $user,
        ];
    }
}
