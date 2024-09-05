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
        
        return $this->authService->authenticate(
            $_POST['login']['username'],
            $_POST['login']['password']
        );
    }
    
    public function signup(): bool
    {
        if (!isset($_POST['signup'])) {
            return false;
        }
        
        if (
            null !== $this->userRepository->findUserByUsername($_POST['login']['username'])
        ) {
            throw new RuntimeException('User already exists!');
        }
        
        $this->userRepository->addUser(
            $_POST['signup']['username'],
            password_hash($_POST['signup']['password'], PASSWORD_DEFAULT)
        );
        
        return $this->authService->authenticate(
            $_POST['signup']['username'],
            $_POST['signup']['password']
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
}
