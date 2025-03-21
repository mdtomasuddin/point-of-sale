<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function LoginPage()
    {
        return view('pages.auth.login-page');
    }
    public function RegistationPage()
    {
        return view('pages.auth.registration-page');
    }
    public function SendOTPPage()
    {
        return view('pages.auth.send-otp-page');
    }
    public function VerifyOTPPage()
    {
        return view('pages.auth.verify-otp-page');
    }
    public function resetPasswordPage()
    {
        return view('pages.auth.reset-pass-page');
    }
    public function profilePage()
    {
        return view('pages.dashboard.profile-page');
    }

    //------------------------------------------

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
            ->select('id')->first();
        // return $count;

        if ($count !== null) {
            //user login /jwt issue create
            $token = JWTToken::CreateToken($request->input('email'), $count->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User login successfully',
                // 'token' => $token,
            ])->cookie('token', $token, 60 * 24 * 60);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized',
            ]);
        }
    }

    public function SendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            // OTP code send user email
            Mail::to($email)->send(new  OTPMail($otp));
            // OTP code insert user table
            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 digits otp send your email successfully ',
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized',
            ]);
        }
    }

    public function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)
            ->count();

        if ($count == 1) {
            //database otp update 
            User::where('email', '=', $email)->update(['otp' => '0']);

            //User reset token issue 
            $token = JWTToken::CreateTokenSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification successfully',
                // 'token' => $token,
            ])->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized',
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $password = $request->input('password');

            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Something Went Wrong ',
                'message' => $e->getMessage(),

            ]);
        }
    }

    public function UserLogout()
    {
        return redirect('/userLogin')->cookie('token', '', -1);
    }


    public function userProfile(Request $request)
    {
        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Request successfully',
            'data' => $user,
        ]);
    }

    function UpdateProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $phone = $request->input('phone');
            $password = $request->input('password');
            User::where('email', '=', $email)->update([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'phone' => $phone,
                'password' => $password
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ], 200);
        }
    }
}
