<?php
// app/controllers/AuthController.php

require_once dirname(__DIR__) . '/models/usersModel.php';

class AuthController {

    public function login() {
        include dirname(__DIR__) . '/views/login.php';
    }

    public function register() {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($name) && !empty($email) && !empty($password)) {
                $userModel = new UsersModel(); 
                $result = $userModel->register($name, $email, $password);

                if ($result === true) {
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                } else {
                    $error = $result; 
                }
            } else {
                $error = "Veuillez remplir tous les champs obligatoires.";
            }
        }

        include dirname(__DIR__) . '/views/register.php';
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: index.php?url=home");
        exit();
    }
}