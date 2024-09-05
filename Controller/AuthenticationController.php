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
