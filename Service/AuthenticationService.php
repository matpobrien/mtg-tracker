<?php

include_once __DIR__ . '/Repository/UserRepository.php';

class AuthenticationService
{
    public function authenticate(string $username, string $password)
    {
    
    }
    
    public function generateJwt(string $username, string $password)
    {
        // Token structure: header.payload.signature
        
        // Create token header and payload as JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['username' => $username, 'password' => $password]);
        
        
        // Encode to Base64Url String
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        // Create signature hash
        $signature = hash_hmac(
            'sha256',
            $base64Header . '.' . $base64Payload,
            '849021jasionfjasd9isdopaj1',
            true
        );
        $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }
    // authenticate:
    // take username and password
    // return true or false depending on if u:pw pair exists in json
    // set userId in the cookie
    // authenticate user before they can do anything
    
    // create user?
    
    // get current user:
    // for use in controllers and other services
    // needs to parse the cookie (
    // can just put the user id in the cookie for now and return the user from the json file
}
