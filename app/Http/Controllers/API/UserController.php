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
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function user(Request $request){
        // auth()->user()->tokens();

        return [
            'message' =>auth()->user(),
        ];
    }

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'username' => 'required|string',
            'phone_number' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'username' => $fields['username'],
            'phone_number' => $fields['phone_number'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'message' => 'Berhasil daftar',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    // public function login(Request $request) {
    //     $fields = $request->validate([
    //         'email' => 'required|string',
    //         'password' => 'required|string'
    //     ]);

    //     // Check email
    //     $user = User::where('email', $fields['email'])->first();

    //     // Check password
    //     if(!$user || !Hash::check($fields['password'], $user->password)) {
    //         return response([
    //             'message' => 'Email atau Password salah'
    //         ], 401);
    //     }

    //     $token = $user->createToken('token')->plainTextToken;

    //     $response = [
    //         'message' => 'Success',
    //         'token' => $token,
    //         'token_type' => 'Bearer',
    //         'user' => $user
    //     ];

    //     return response($response, 201);
    // }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Berhasil Keluar'
        ];
    }
   
    // public function register(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'name' => ['required', 'string', 'max:255'],
    //             // 'username' => ['required', 'string', 'max:255', 'unique:companies'],
    //             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //             // 'phone_number' => ['required', 'string', 'max:255'],
    //             'password' => ['required', 'string', 'max:255'],
    //         ]);
    //         User::create([
    //             'name' => $request->name,
    //             // 'username' => $request->username,
    //             'email' => $request->email,
    //             // 'phone_number' => $request->phone_number,
    //             'password' => Hash::make($request->password),
    //         ]);

    //         $user = User::where('email', $request->email)->first();
    //         $tokenResult = $user->createToken('authToken')->plainTextToken;
    //         return ResponseFormatter::success([
    //             'access_token' => $tokenResult,
    //             'token_type' => 'Bearer',
    //             'user' => $user
    //         ], 'User Registered');
    //     } catch (Exception $error) {
    //         return ResponseFormatter::error([
    //             'message' => 'something wrong',
    //             'error' => $error
    //         ], 'Authentication Failed', 500);
    //     }
    // }

    public function login(Request $request)
    {
        // try {
        //     $request->validate([
        //         'email' => 'email|required',
        //         'password' => 'required'
        //     ]);

        //     $credentials = request(['email', 'password']);
        //     if (!Auth::attempt($credentials)) {
        //         return ResponseFormatter::error([
        //             'message' => 'Unauthorized'
        //         ], 'Authentication Failed', 500);
        //     }

        //     $user = User::where('email', $request->email)->first();
        //     if (!Hash::check($request->password, $user->password, [])) {
        //         throw new \Exception('Invalid Credentials');
        //     }

        //     $tokenResult = $user->createToken('authToken')->plainTextToken;
        //     return ResponseFormatter::success([
        //         'access_token' => $tokenResult,
        //         'token_type' => 'Bearer',
        //         'user' => $user
        //     ], 'Authenticated');
        // } catch (Exception $error) {
        //     return ResponseFormatter::error([
        //         'message' => 'Something went wrong',
        //         'error' => $error,
        //     ], 'Authentication Failed', 500);
        // }
        
        // if (!Auth::attempt($request->only('email', 'password'))) {
        //     return response([
        //         'message' => 'Invalid'
        //     ], Response::HTTP_UNAUTHORIZED);
        // }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'message' => 'Success',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ])->withCookie($cookie);


        // if (!Auth::attempt($request->only('email', 'password')))
        // {
        //     return response()
        //         ->json(['message' => 'Unauthorized'], 401);
        // }

        // $user = User::where('email', $request['email'])->firstOrFail();

        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()
        //     ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer','user' => $user ]);
    
    }

    // public function logout()
    // {
    //     auth()->user()->tokens()->delete();

    //     return [
    //         'message' => 'You have successfully logged out and the token was successfully deleted'
    //     ];
    // }
    
    // public function login(Request $request) {
    //     $fields = $request->validate([
    //         'email' => 'required|string',
    //         'password' => 'required|string'
    //     ]);

    //     // Check email
    //     $user = User::where('email', $fields['email'])->first();

    //     // Check password
    //     if(!$user || !Hash::check($fields['password'], $user->password)) {
    //         return response([
    //             'message' => 'Invalid'
    //         ], 401);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];

    //     return response($response, 201);
    // }
    
}
