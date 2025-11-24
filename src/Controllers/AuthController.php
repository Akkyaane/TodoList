<?php

require __DIR__ . '/../Models/UserModel.php';

class AuthController {
    private UserModel $model;

    public function __construct(PDO $pdo) {
        $this->model = new UserModel($pdo);
    }

    public function register(User $user): array {
        $errors = $user->validate(8);
        if (!empty($errors)) {
            return ['success' => false, 'messages' => $errors];
        }

        if ($this->model->isEmailAlreadyExists($user->getEmail())) {
            return ['success' => false, 'messages' => ["Cet email est déjà enregistré."]];
        }

        $ok = $this->model->register($user);
        
        if ($ok) {
            return ['success' => true, 'messages' => ["Inscription réussie !"]];
        } else {
            return ['success' => false, 'messages' => ["Erreur lors de l'inscription."]];
        }
    }

    public function login() {
        try {
            return;
        } catch (PDOException $e) {
            $error = "Erreur lors de la connexion : " . $e->getMessage();
            return $error;
        }
    }

    public function logout() {
        try {
            return;
        } catch (PDOException $e) {
            $error = "Erreur lors de la déconnexion : " . $e->getMessage();
            return $error;
        }
    }
}
