<?php

include_once __DIR__ . '/../Entity/User.php';

class UserRepository
{
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
    
    public function addUser(string $username, string $password): void
    {
        $user = (new User)
            ->setUsername($username)
            ->setPassword($password);
        
        $encodedUser = json_encode($user->expose());
        
        $users = $this->getUsers();
        $users[] = $encodedUser;
        file_put_contents($this->fileName, json_encode($users));
    }
    
    public function findUserByUsername(string $username): ?User
    {
        $users = $this->getUsers();
        
        $key = array_search(
            $username,
            array_column($users, 'username')
        );
        
        if (is_int($key) || is_string($key)) {
            return $users[$key];
        }
        
        return null;
    }
}
