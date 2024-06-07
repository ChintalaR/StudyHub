<?php

// Include the JwtManager class
require 'vendor/autoload.php';
use JwtManager;
// Your secret key (keep this secure)
$secretKey = 'your_secret_key';
// Create an instance of JwtManager
$jwtManager = new JwtManager($secretKey);
// Create a JWT
$payload = [
    "user_id" => 123,
    "username" => "john_doe",
    "exp" => time() + 3600, // Token expiration time (1 hour)
];
$jwt = $jwtManager->createToken($payload);
echo "JWT Token: " . $jwt . PHP_EOL;
// Validate and decode the JWT
if ($jwtManager->validateToken($jwt)) {
    echo "JWT is valid." . PHP_EOL;
    $decodedPayload = $jwtManager->decodeToken($jwt);
    echo "Decoded Payload: " . json_encode($decodedPayload, JSON_PRETTY_PRINT);
} else {
    echo "JWT is invalid.";
}