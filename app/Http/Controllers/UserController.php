<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
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
                    'otp'    => $otp,

                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'msg'    => 'User with the provided email not found.',
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


public function verifyOTPCode(Request $request)
{
    $email = $request->input('email');
    $otp = $request->input('otp');

    // Check if the OTP is valid and hasn't expired
    $user = User::where('email', $email)->where('otp', $otp)->first();

    if ($user && !$this->isOTPOutdated($user->updated_at)) {
        // Mark the OTP as used
        USER::where('email', $email)->update(['otp' => "0"]);

        // Generate a token for setting the password
        $token = JWTToken::createTokenForSetPassword($email);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Verify token successful',
            'token'  => $token,
        ], 200);
    } else {
        return response()->json([
            'status' => 'failed',
            'msg'    => 'Verification token failed',
        ], 200);
    }
}

// Helper function to check if OTP is outdated
private function isOTPOutdated($updatedAt)
{
    $expirationTime = Carbon::parse($updatedAt)->addMinutes(5);
    return now()->gt($expirationTime);
}


    public function resetPassword(Request $request)
    {

        try {
            $email = $request->header('email');
            $password = $request->input('password');

            USER::where('email', $email)->update(['password' => $password]);
            return response()->json([
                'status'   => 'success',
                'msg'      => 'Password Reset Successful',
                'password' => $password,
            ], 200);

        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'msg'    => 'Password Reset failed',
                'reason' => $error->getMessage(),
            ], 500);
        }
    }
}
