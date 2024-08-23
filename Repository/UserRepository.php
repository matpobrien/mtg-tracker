<?php

class UserRepository
{
    // new stuff that will be needed:
    // render login page
    // process login request & set cookie
    // to authenticate:
    //
    private string $fileName;
    
    public function __construct(string $fileName)
    {
        if (!file_exists($fileName)) {
            throw new RuntimeException('File doesn\'t exist!');
        }
        
        $this->fileName = $fileName;
    }
    
    public function getUsers()
    {
        $json = file_get_contents($this->fileName);
        
        return json_decode($json);
    }
    
    public function addUser(string $username, string $password)
    {
//        $user = (new User)
//            ->setUsername($username)
//            ->setPassword($password);
        
        $user = [
            'username' => $username,
            'password' => $password
        ];
        
        $users = $this->getUsers();
        $users[] = $user;
        file_put_contents($this->fileName, json_encode($users));
    }
}
