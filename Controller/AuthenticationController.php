<?php

include_once __DIR__ . '/../Template/LoginTemplate.php';
include_once __DIR__ .'/../Repository/UserRepository.php';

class AuthenticationController
{
    private LoginTemplate $template;
    private AuthenticationService $authService;
    
    public function __construct(
        protected readonly UserRepository $userRepository
    ) {
        $this->template = new LoginTemplate();
        $this->authService = new AuthenticationService($userRepository);
    }
    
    public function login(): bool
    {
        if (!isset($_POST['login'])) {
            return false;
        }
        
        $userData = $this->getPostData();
        
        return $this->authService->authenticate(
            $userData['username'],
            $userData['hashedPassword']
        );
    }
    
    public function signup(): bool
    {
        if (!isset($_POST['signup'])) {
            return false;
        }
        
        $userData = $this->getPostData();
        
        if (
            null !== $this->userRepository->findUserByUsername($_POST['signup']['username'])
        ) {
            throw new RuntimeException('User already exists!');
        }
        
        $this->userRepository->addUser(
            $userData['username'],
            $userData['hashedPassword']
        );
        
        return $this->authService->authenticate(
            $userData['username'],
            $userData['hashedPassword']
        );
    }
    
    public function renderLogin(): string
    {
        return $this->template->renderLoginForm();
    }

    public function renderSignup(): string
    {
        return $this->template->renderSignupForm();
    }
    
    public function isAuthenticated(bool $isLoggedIn): bool
    {
        return $this->authService->isAuthenticated($isLoggedIn);
    }
    
    private function getPostData(): array
    {
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash(
            htmlspecialchars($_POST['opponentsDeck']),
            PASSWORD_DEFAULT
        );
        
        return [
            'username' => $username,
            'hashedPassword' => $password,
        ];
    }
}
