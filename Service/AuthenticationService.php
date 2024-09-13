<?php

include_once __DIR__ . '/../Repository/UserRepository.php';
include_once __DIR__ . '/../Entity/User.php';

class AuthenticationService
{
    public const NONEXISTENT_USER = "NONEXISTENT_USER";
    public const INVALID_CREDENTIALS = "INVALID_CREDENTIALS";
    public const AUTHENTICATED = "AUTHENTICATED";
    
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected string $baseUrl
    ){}

    public function authenticate(string $username, string $password): string
    {
        $user = $this->userRepository->findUserByUsername($username);
        
        if (null === $user) {
            return self::NONEXISTENT_USER;
        }
        
        if (0 === strcmp($password, $user->getPassword())) {
            $_SERVER['REQUEST_METHOD'] = 'GET';
            setcookie('jwt', $this->generateJwt($username));
            return self::AUTHENTICATED;
        }
        return self::INVALID_CREDENTIALS;
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
    
    public function cookieExists(): bool
    {
        return isset($_COOKIE['jwt']);
    }
    
    public function isAuthenticated(): bool
    {
        // create php unit test for this
        if (!$this->cookieExists()) {
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
        $encoded = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($newSignature));
        
        $originalSignature = $jwtArray[2];
        
        return strcmp($originalSignature, $encoded) === 0;
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
        
        return $this->userRepository->findUserByUsername($username);
    }
    
    public function handleAuthenticationResults(string $authenticationResults): void
    {

        if ($authenticationResults === self::AUTHENTICATED) {
            header("Location: " . $this->baseUrl . 'games');
        }
        
        if ($authenticationResults === self::INVALID_CREDENTIALS) {
            header("Location: " . $this->baseUrl . 'login?failed=1');
            
        }
        
        if ($authenticationResults === self::NONEXISTENT_USER) {
            header("Location: " . $this->baseUrl . 'signup');
        }
    }
}
