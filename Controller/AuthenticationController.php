<?php

include_once __DIR__ . '/../Template/LoginTemplate.php';
include_once __DIR__ .'/../Service/AuthenticationService.php';
class AuthenticationController
{
    private LoginTemplate $template;
    
    public function __construct(
        protected readonly AuthenticationService $authService,
    ) {
        $this->template = new LoginTemplate();
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
    
    public function isAuthenticated(bool $isLoggedIn): bool
    {
        return $this->authService->isAuthenticated($isLoggedIn);
    }
}
