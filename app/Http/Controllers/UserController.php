<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function registration(Request $request)
    {

        try {
            $validate = $request->validate([
                "name"     => 'required | string | min:4 | max:50',
                "email"    => 'required | email',
                "password" => 'required | string',
            ]);

            User::create($request->input());
            return response()->json([
                'status' => 'success',
                'msg'    => 'user created successfully',
            ], 201);

        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'msg'    => 'user registration Failed',
                'reason' => $error->getMessage(),
            ], 200);
        }

    }

    public function login(Request $request)
    {

        try {
            $count = User::where('email', $request->input('email'))->count();

            if ($count == 1) {
                $token = JWTToken::createToken($request->input('email'));
                return response()->json([
                    'status' => 'success',
                    'msg'    => "login successfull",
                    'token'  => $token,
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'msg'    => "login unsuccessfull",
                'reason' => $error->getMessage(),
            ], 401);
        }

    }

    public function sendOTPCode(Request $request)
    {
        try {
            $email = $request->input('email');
            $otp = rand(2500, 9999);

            $count = User::where('email', $email)->count();
            if ($count == 1) {
                Mail::to($email)->send(new OTPMail($otp));
                User::where('email', $email)->update(['otp' => $otp]);

                return response()->json([
                    'status' => 'success',
                    'msg'    => 'OTP send successfully',

                ], 200);

            } 
            

        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'msg'    => 'OTP send Failed',
                'reason' => $error->getMessage(),
            ], 200);
        }

    }
}
