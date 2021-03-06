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

class CompanyController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:companies'],
                'company_name' => ['required', 'string', 'max:255'],
                'phone_number' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:companies'],
                'password' => ['required', 'string', 'max:255'],
            ]);
            Company::create([
                'name' => $request->name,
                'username' => $request->username,
                'company_name' => $request->company_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $company = Company::where('email', $request->email)->first();
            $tokenResult = $company->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'company' => $company
            ], 'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'something wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }

            // return Company::create([
            //     'name' => $request->input('name'),
            //     'username' => $request->input('username'),
            //     'company_name' => $request->input('company_name'),
            //     'phone_number' => $request->input('phone_number'),
            //     'email' => $request->input('email'),
            //     'password' => Hash::make($request->input('password')),
            // ]);
    }

    public function login(Request $request)
    {

        // if (!Auth::attempt($request->only('email','password'))) {
        //     return response([
        //         'message' => 'Invalid'
        //     ], Response::HTTP_UNAUTHORIZED);
        // }

        // $company = Auth::company();
        // $token = $company->createToken('token')->plainTextToken;

        // $cookie = cookie('jwt', $token, 60*24);

        // return response([
        //     'message' => 'Success'
        // ])->withCookie($cookie);

        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $company = Company::where('email', $request->email)->first();
            if (!Hash::check($request->password, $company->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $company->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $company
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function loginc()
    {
        return 'ANDA MASUK';
    }
}
