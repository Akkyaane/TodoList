<?php

require __DIR__ . '/../Models/UserModel.php';

class AuthController
{
    private UserModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new UserModel($pdo);
    }

    public function register(User $user): array
    {
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

    public function login(string $email, string $password): array
    {
        $user = new User($email, $password);
        $errors = [];

        if (empty($email) || empty($password)) {
            $errors[] = "Veuillez saisir votre email et votre mot de passe.";
        } elseif (!$user->isEmailValid()) {
            $errors[] = "L'email est invalide.";
        }

        if (!empty($errors)) {
            return ['success' => false, 'messages' => $errors];
        }

        $found = $this->model->verifyCredentials($email, $password);

        if (!$found) {
            return ['success' => false, 'messages' => ["Identifiants incorrects."]];
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user_id'] = $found['id'];
        $_SESSION['email'] = $found['email'];

        return ['success' => true, 'messages' => ["Connexion réussie."]];
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }

        session_destroy();
    }
}
