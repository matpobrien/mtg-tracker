<?php

include_once __DIR__ . '/../Template/LoginTemplate.php';
include_once __DIR__ .'/../Repository/UserRepository.php';
class UserController
{
    private LoginTemplate $template;
    
    public function __construct(
        protected readonly UserRepository $userRepository,
    ) {
        $this->template = new LoginTemplate();
    }
    
    public function login(): string
    {
        return $this->template->renderLoginForm();
    }
}
