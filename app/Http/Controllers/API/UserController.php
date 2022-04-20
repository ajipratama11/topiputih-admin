<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
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
        $user = Auth::user();
        return [
            
            'message' => ' Berhasil Mengubah Data',
            'nama' =>$this->encodeing( $user-> nama),
            'nama_pengguna' =>$this->encodeing( $user-> nama_pengguna) ,
            'email'=>$this->encodeing($user-> email),
            'nomor_telepon'=>$this->encodeing($user-> nomor_telepon) ,
            'foto_pengguna' => $user->foto_pengguna,
            'roles'=>$this->encodeing($user->roles)
        ];
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return [
            'message' => ' Berhasil Mengubah Data',
            'nama' =>$this->encodeing( $user-> nama),
            'nama_pengguna' =>$this->encodeing( $user-> nama_pengguna) ,
            'email'=>$this->encodeing($user-> email),
            'nomor_telepon'=>$this->encodeing($user-> nomor_telepon) ,
            'foto_pengguna' => $user->foto_pengguna,
            'roles'=>$this->encodeing($user->roles)
        ];
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'nama_pengguna' => ['required', 'string', 'max:255'],
                'foto_pengguna' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'unique:users'],
                'nomor_telepon' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
                'roles' => ['required', 'string', 'max:255'],
            ]);

            User::create([
                'nama' => $request->nama,
                'slug' =>  Str::slug($request->nama),
                'nama_pengguna' => $request->nama_pengguna,
                'foto_pengguna' =>$request->foto_pengguna,
                'email' => $this->decodeing($request->email),
                'nomor_telepon' => $request->nomor_telepon,
                'password' => Hash::make($this->decodeing( $request->password)),
                // 'password' => Hash::make( $request->password),   
                'roles' => $this->decodeing($request->roles)
            ]);

            $user = User::where('email',$this->decodeing($request->email))->first();

            // dd($user);
            $tokenResult = $user->createToken('token')->plainTextToken;
            return ResponseFormatter::success([
                'message' => 'Berhasil daftar',
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                // 'user' => $user,
            ], 'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Alamat Surat Elektronik sudah Digunakan',
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
                    'password' => 'required|string',
                    'is_verified' => 'required'
                ]);
        
        $user = User::where('email',$this->decodeing( $fields['email']))->first();

        $decrypted = $this->decodeing( $fields['password']);
        
        if(!$user || !Hash::check($decrypted,$user->password)) {
            return response([
                'message' => 'Alamat Surat Elektronik atau Kata Sandi salah',
            ], 401);
        }
        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60);

        return response([
            'message' => 'Berhasil Masuk',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
            // 'id'=> $user->id
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
                'message' => 'Password Tidak cocok'
            ], 401);
        }
        return response([
            'message' => 'Password cocok',
            // 'user' => $user
        ]);

    }

    public function edit_password (Request $request){
        $fields = $request->validate([
                            'id' => 'required|string',
                            'password' => 'required|string',
                            'password_new' => 'string'
                        ]);
        $user = User::where('id', $this->decodeing($fields['id']))->first();
        $decrypted = $this->decodeing( $fields['password']);
        if(!$user || !Hash::check($decrypted,$user->password)) {
            return response([
                'message' => 'Kata Sandi Tidak cocok'
            ], 401);
        }else{
            $user = User::find( $this->decodeing($fields['id']));
            // $user-> name = 'budis';
            $user-> password =  Hash::make($this->decodeing($fields['password_new']));
            $user->save();
            return[
                'message' => ' Berhasil Mengubah Kata Sandi',
                // 'user' => $user,
            ];
        }
    }

    public function edit_user (Request $request){
        $fields = $request->validate([
                            'id' => ['required', 'string', 'max:255'],
                            'nama' => ['required', 'string', 'max:255'],
                            'nama_pengguna' => [  'max:255'],
                            'email' => ['required', 'string', 'max:255'],
                            'nomor_telepon' => ['required', 'string', 'max:255']
                        ]);
        // $user = User::where('id', $fields['id'])->first();
        $user = User::find( $this->decodeing($fields['id']));
        $user-> nama =  $this->decodeing($fields['nama']);
        $user-> slug = Str::slug($this->decodeing($fields['nama']));
        $user-> nama_pengguna =  $this->decodeing($fields['nama_pengguna']);
        $user-> email =  $this->decodeing($fields['email']);
        $user-> nomor_telepon =  $this->decodeing($fields['nomor_telepon']);
        $user->save();
        
        return[
            'message' => ' Berhasil Mengubah Data',
            // 'user' => 
            // $user-> name,
            // $user-> contact_name ,
            // $this->encodeing($user-> email),
            // $user-> phone_number ,
            
        ];
    }

    public function update_profile(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required',
        ]);
  
        $user = User::where('id', $fields['id'])->first();
        if ($image = $request->file('foto_pengguna')) {
            $destinationPath = 'img/profile_user';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $user-> foto_pengguna = "$profileImage";
        }
        $user->save();

        return[
            // 'message' => ' Berhasil Update Foto',
            'message' => ' Berhasil Mengubah Foto',
            // 'user' => 
            // $user-> name,
            // $user-> contact_name ,
            // $this->encodeing($user-> email),
            // $user-> phone_number ,
            
        ];
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

    public function cek_email(Request $request)
    {
        $fields = $request->validate([
                            'email' => 'required|string'
                        ]);
        $user = User::where('email', $this-> decodeing($fields['email']))->first();
        // $decrypted = $this->decodeing( $fields['email']);
        if(!$user) {
            return response([
                'message' => 'Alamat Surat Elektronik tidak ditemukan'
            ], 401);
        }
        return response([
            'message' => 'Link telah dikirim ke Alamat Surat Elektronik Anda'
        ]);
    }
}
