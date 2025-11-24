<?php
class User {
    private $email;
    private $password;
    private $userType;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function getUserType() {
        return $this->userType;
    }
}