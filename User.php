<?php

class User
{
    private string $username;
    private string $password;
    
    public function setUsername(string $username): self
    {
        $this->username = $username;
        
        return $this;
    }
    
    public function getUsername(): string
    {
        return $this->username;
    }
    
    public function setPassword(string $password): self
    {
        $this->password = $password;
        
        return $this;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }
    
    
}
