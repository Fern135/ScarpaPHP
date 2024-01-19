<?php 

namespace Scarpa\Cryptography\JWT;

include "../../lib/env_loader/env_loader.php";

class JWT {
    private $secretKey;

    public function __construct() {
        $loaded = loadEnv();
        if ($loaded) {
            echo "Environment variables loaded successfully from envFile.\n";
        } else {
            echo "No .env file found or failed to load environment variables.\n";
        }

        $this->secretKey = $_ENV['secret_key'];
    }

    private function __destruct(){
        $this->secretKey = null;
    }

    public function generateToken($data) {
        $header  = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($data);

        $base64UrlHeader  = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }

    public function verifyToken($token) {
        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = explode('.', $token);
        $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlSignature));

        $verified = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $this->secretKey, true);

        if ($signature === $verified) {
            $data = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);
            return $data;
        }

        return null;
    }
}

// Example of usage
// $secretKey = 'your_secret_key';
// $jwtHandler = new JwtHandler($secretKey);

// $data = [
//     'user_id' => 123, 
//     'username' => 'john_doe'
//     , 'exp' => time() + 3600
// ];

// $token = $jwtHandler->generateToken($data);

// Output the token
// echo $token;

// Verify the token
// $verifiedData = $jwtHandler->verifyToken($token);
// if ($verifiedData) {
//     print_r($verifiedData);
// } else {
//     echo 'Token is invalid.';
// }
