<?php
// app/controllers/AuthController.php

require_once dirname(__DIR__) . '/models/usersModel.php';

class AuthController {

    /**
     * Affichage du formulaire d'inscription
     */
    public function register() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = null;
        $success = null;

        include dirname(__DIR__) . '/views/register.php';
    }

    /**
     * Traitement de l'inscription (appelé par la route register/process)
     */
    public function registerProcess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = trim($_POST['firstname'] ?? '');
            $lastname  = trim($_POST['lastname'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $password  = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
                if ($password === $password_confirm) {
                    $userModel = new UsersModel(); 
                    
                    $result = $userModel->register($firstname, $lastname, $email, $password);

                    if ($result === true || is_numeric($result) || is_string($result)) {
                        $user = method_exists($userModel, 'getUserByEmail') ? $userModel->getUserByEmail($email) : null;
                        
                        $_SESSION['user_uuid']  = $user['id'] ?? $result;
                        $_SESSION['user_name']  = $firstname . ' ' . $lastname;
                        $_SESSION['user_email'] = $email;
                        $_SESSION['user_role']  = $user['role'] ?? 'client';

                        if (isset($_SESSION['booking_draft'])) {
                            header('Location: index.php?url=reservation/checkout');
                            exit();
                        }

                        header('Location: index.php?url=client-dashboard');
                        exit();
                    } else {
                        $error = $result; 
                    }
                } else {
                    $error = "Les mots de passe ne correspondent pas.";
                }
            } else {
                $error = "Veuillez remplir tous les champs obligatoires.";
            }
        }

        include dirname(__DIR__) . '/views/register.php';
    }

    /**
     * Affichage du formulaire de connexion
     */
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = null;
        include dirname(__DIR__) . '/views/login.php';
    }

    /**
     * Traitement de la connexion (appelé par la route login/process)
     */
    public function loginProcess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($email) && !empty($password)) {
                $userModel = new UsersModel();
                $user = $userModel->login($email, $password);

                if ($user) {
                    $_SESSION['user_uuid']  = $user['id'];
                    $_SESSION['user_name']  = ($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '') ?: ($user['name'] ?? $user['nom'] ?? 'Client');
                    $_SESSION['user_email'] = $user['email'] ?? $email;
                    
                    // Récupération sécurisée du rôle depuis la base de données
                    $role = isset($user['role']) ? strtolower(trim($user['role'])) : 'client';
                    $_SESSION['user_role']  = $role;

                    // Redirection conditionnelle selon le rôle de l'utilisateur
                    if (isset($_SESSION['booking_draft'])) {
                        header('Location: index.php?url=reservation/checkout');
                        exit();
                    } elseif ($role === 'admin') {
                        header('Location: index.php?url=admin-dashboard');
                        exit();
                    } else {
                        header('Location: index.php?url=client-dashboard');
                        exit();
                    }
                } else {
                    $error = "Identifiants incorrects. Veuillez réessayer.";
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        // En cas d'échec, on réaffiche la vue login avec l'erreur
        include dirname(__DIR__) . '/views/login.php';
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_unset();
        session_destroy();
        
        header("Location: index.php?url=home");
        exit();
    }
}