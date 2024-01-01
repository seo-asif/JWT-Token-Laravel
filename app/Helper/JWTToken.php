<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{

    public static function createToken($userEmail): string
    {

        $key = env('JWT_KEY');

        $payload = [
            'iss'       => 'Asif',
            'iat'       => time(),
            'exp'       => time() + 60 * 60,
            'userEmail' => $userEmail,
        ];

        return JWT::encode($payload, $key, 'HS256');

    }

    public static function createTokenForSetPassword($userEmail): string
    {

        $key = env('JWT_KEY');

        $payload = [
            'iss'       => 'Asif',
            'iat'       => time(),
            'exp'       => time() + 60 * 5,
            'userEmail' => $userEmail,
        ];

        return JWT::encode($payload, $key, 'HS256');

    }

    public static function verifyToken($token): string
    {
        try {
            $key = env('JWT_KEY');
            $token = JWT::decode($token, new Key($key, 'HS256'));

            return $token->userEmail;
        } catch (Exception $error) {
            return "Unauthorized";
        }
    }

}
