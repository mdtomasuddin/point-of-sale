<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserRegistration(Request $request)
    {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => $request->input('password'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully ',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'User Registration Failed ',
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function UserLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();
        // return $count;

        if ($count == 1) {
            //user login /jwt issue create
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'User login successfully',
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Unauthorized',
                
            ]);
        }
    }
}
