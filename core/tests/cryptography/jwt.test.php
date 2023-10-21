<?php

// require 'JWT.php'; // Assuming your JWT class is in a separate file.
use \Oracle\Cryptography\JWT\JWT;

$jwt = new JWT();

// Test the generateToken method
$dataToEncode = ['user_id' => 123, 'username' => 'john_doe'];
$token = $jwt->generateToken($dataToEncode);

assert(is_string($token), 'generateToken should return a string');
assert($jwt->verifyToken($token) !== null, 'Generated token should be verifiable');

// Test the verifyToken method
$invalidToken = 'invalid.token.invalid';
assert($jwt->verifyToken($invalidToken) === null, 'verifyToken should return null for an invalid token');

echo "All tests passed!\n";
