<?php

require_once __DIR__ . '/../Classes/User.php';

class UserModel {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function isEmailAlreadyExists(string $email): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function register(User $user): bool {
        if ($this->isEmailAlreadyExists($user->getEmail())) {
            return false;
        }

        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        return $stmt->execute([
            ':email' => $user->getEmail(),
            ':password' => $hashedPassword
        ]);
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function verifyCredentials(string $email, string $password): ?array {
        $user = $this->findByEmail($email);
        if (!$user) {
            return null;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }
}
