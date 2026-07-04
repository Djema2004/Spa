<?php
// app/controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController {

    // Affiche la page de connexion
    public function login() {
        include __DIR__ . '/../views/login.php';
    }

    // Gère l'affichage et la soumission de l'inscription
    public function register() {
        $error = null;
        $success = null;

        // Si le formulaire est soumis (Méthode POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($name) && !empty($email) && !empty($password)) {
                $userModel = new User();
                $result = $userModel->register($name, $email, $password);

                if ($result === true) {
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                    // Optionnel : Rediriger vers la page login après 2 secondes
                    // header("Refresh: 2; url=index.php?url=login");
                } else {
                    $error = $result; // Récupère le message d'erreur
                }
            } else {
                $error = "Veuillez remplir tous les champs obligatoires.";
            }
        }

        // Charge la vue en lui passant les messages d'erreur ou de succès
        include __DIR__ . '/../views/register.php';
    }

    // Déconnexion
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: index.php?url=home");
        exit();
    }
}