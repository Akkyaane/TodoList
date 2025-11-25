<?php
class User
{
    private string $email;
    private string $password;
    private string $role;

    public function __construct(string $email = '', string $password = '')
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isEmailValid(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isPasswordValid(int $minLength = 8): bool
    {
        return strlen($this->password) >= $minLength;
    }

    public function validate(int $minPasswordLength = 8): array
    {
        $errors = [];
        if (empty($this->email)) {
            $errors[] = "L'email est requis.";
        } elseif (!$this->isEmailValid()) {
            $errors[] = "L'email est invalide.";
        }

        if (empty($this->password)) {
            $errors[] = "Le mot de passe est requis.";
        } elseif (!$this->isPasswordValid($minPasswordLength)) {
            $errors[] = "Le mot de passe doit contenir au moins $minPasswordLength caractères.";
        }

        return $errors;
    }
}
