<?php

include_once '../Template/LoginTemplate.php';
include_once '../Repository/UserRepository.php';
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
