<?php

include_once __DIR__ . '/../Repository/UserRepository.php';
include_once __DIR__ . '/../Entity/User.php';

class AuthenticationService
{
    public function __construct(
        protected readonly UserRepository $userRepository
    ){}

    public function authenticate(string $username, string $password): bool
    {
        $user = $this->userRepository->findUserByUsername($username);
        
        if (null === $user) {
            return false;
        }
        
        if (0 === strcmp($password, $user->getPassword())) {
            return setcookie('jwt', $this->generateJwt($username));
        }
        return false;
    }
    
    public function generateJwt(string $username): string
    {
        // Token structure: header.payload.signature
        
        // Create token header and payload as JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['username' => $username]);
        
        
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
    
    public function isAuthenticated(bool $isLoggedIn): bool
    {
        if (!$isLoggedIn) {
            return false;
        }

        $jwtArray = explode('.', $_COOKIE['jwt']);
        $base64Header = $jwtArray[0];
        $base64Payload = $jwtArray[1];
        // get payload from jwt
        
        // generate new signature
        $newSignature = hash_hmac(
            'sha256',
            $base64Header . '.' . $base64Payload,
            '849021jasionfjasd9isdopaj1',
            true
        );
        
        
        $originalSignature = $jwtArray[2];
        
        return strcmp($originalSignature, $newSignature) === 0;
    }
    
    public function getCurrentUser(): ?User
    {
        if (!isset($_COOKIE['jwt'])) {
            return (new User())
                ->setUsername('none')
                ->setPassword('13214213');
        }
        $jwtArray = explode('.', $_COOKIE['jwt']);
        $payload = $jwtArray[1];
        // get the JWT and then decode the payload
        $encodedUsername = (str_replace(['-', '_', ''], ['+', '/', '='], base64_decode($payload)));
        $username = json_decode($encodedUsername, true)['username'];
        echo '<p>' . $username . '</p>';
        
        return $this->userRepository->findUserByUsername($username);
    }
}
