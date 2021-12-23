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
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'username' => ['required', 'string', 'max:255', 'unique:companies'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // 'phone_number' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
            ]);
            User::create([
                'name' => $request->name,
                // 'username' => $request->username,
                'email' => $request->email,
                // 'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'something wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

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
        
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'message' => 'Success',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ])->withCookie($cookie);
    }
}