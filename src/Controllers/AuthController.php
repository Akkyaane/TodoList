<?php

require '../Models/UserModel.php';

class AuthController {
    public function register() {
        try {
            $result = register();
        } catch (PDOException $e) {
            $error = "Erreur lors de l'inscription : " . $e->getMessage();
            return $error;
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