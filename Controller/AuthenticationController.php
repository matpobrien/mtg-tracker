<?php

include_once __DIR__ . '/../Template/LoginTemplate.php';
include_once __DIR__ .'/../Repository/UserRepository.php';

class AuthenticationController
{
    private LoginTemplate $template;
    
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly AuthenticationService $authService,
        protected string $baseUrl
    ) {
        $this->template = new LoginTemplate();
    }
    
    public function login(): void
    {
        if (!isset($_POST['login'])) {
            return;
        }
        
        $userData = $this->getPostData();
        
        
        $authenticated = $this->authService->authenticate(
            $userData['username'],
            $userData['password']
        );

        $this->authService->handleAuthenticationResults($authenticated);
    }
    
    public function signup(): void
    {
        if (!isset($_POST['signup'])) {
            return;
        }
        
        $userData = $this->getPostData();
        
        if (
            null !== $this->userRepository->findUserByUsername($userData['username'])
        ) {
            throw new RuntimeException('User already exists!');
        }
        
        $this->userRepository->addUser(
            $userData['username'],
            $userData['password']
        );
        
        $authenticated = $this->authService->authenticate(
            $userData['username'],
            $userData['password']
        );
        
        $this->authService->handleAuthenticationResults($authenticated);
    }


    public function signout(): void
    {
        if (!isset($_POST['signout'])) {
            return;
        }

        unset($_COOKIE['jwt']);
        setcookie('jwt', '', time(), -3600);
        
        header("Location: " . $this->baseUrl . 'login');
        exit;
    }
    
    public function renderLogin(): string
    {
        if (1 === $_REQUEST['failed']) {
            return $this->template->renderLoginForm(true);
        }
        return $this->template->renderLoginForm(false);
    }

    public function renderSignup(): string
    {
        return $this->template->renderSignupForm();
    }
    
    public function renderSignoutButton(): string
    {
        return $this->template->renderSignoutButton();
    }
    
    private function getPostData(): array
    {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        
        return [
            'username' => $username,
            'password' => $password,
            'hashedPassword' => password_hash($password, PASSWORD_DEFAULT),
        ];
    }
}
