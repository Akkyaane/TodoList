<?php

require_once __DIR__ . '/../Classes/User.php';

class UserModel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function existsByEmail(string $email): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function register(User $user): bool {
        if ($this->existsByEmail($user->getEmail())) {
            return false;
        }

        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        return $stmt->execute([
            ':email' => $user->getEmail(),
            ':password' => $hashedPassword
        ]);
    }
}
