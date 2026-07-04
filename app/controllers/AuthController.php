<?php
require_once __DIR__ . '/../models/usersModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        // On instancie le modèle qui parle à la base de données
        $this->userModel = new UsersModel();
    }

    /**
     * GÈRE L'INSCRIPTION DES UTILISATEURS
     */
    public function register() {
        // Sécurité : On accepte uniquement les requêtes POST du formulaire
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../views/register.php');
            exit();
        }

        // Récupération et nettoyage des données (XSS)
        $firstName = trim($_POST['firstname'] ?? '');
        $lastName = trim($_POST['lastname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        // Validation des champs obligatoires
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            die("Tous les champs sont requis.");
        }

        // Vérification de la correspondance des mots de passe
        if ($password !== $password_confirm) {
            die("Les mots de passe ne correspondent pas.");
        }

        // Hachage sécurisé du mot de passe (Exigence du barème)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion dans la base de données via le modèle
        // (Note: Ton modèle s'occupera d'attribuer un UUID unique pour cet utilisateur)
        $result = $this->userModel->addUsers($firstName, $lastName, $email, $hashedPassword);

        if ($result) {
            header('Location: ../views/login.php');
            exit();
        } else {
            die("Erreur lors de l'inscription.");
        }
    }

    /**
     * GÈRE LA CONNEXION DES UTILISATEURS (CLIENTS & ADMINS)
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../views/login.php');
            exit();
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            die("Veuillez remplir tous les champs.");
        }

        // Recherche de l'utilisateur par son email via le modèle
        $user = $this->userModel->getUserByEmail($email);

        // Vérification du mot de passe haché (Exigence du barème)
        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Stockage de l'UUID et du rôle dans la session globale
            $_SESSION['user_uuid'] = $user['id'];
            $_SESSION['user_role'] = $user['role'] ?? 'client'; // admin ou client

            // Redirection dynamique selon le rôle
            if ($_SESSION['user_role'] === 'admin') {
                header('Location: index.php?url=admin-dashboard');
            } else {
                header('Location: index.php?url=client-dashboard');
            }
            exit();
        } else {
            die("Email ou mot de passe incorrect.");
        }
    }

    /**
     * GÈRE LA DÉCONNEXION (Destruction de session)
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_destroy();
        header('Location: ../views/login.php');
        exit();
    }
}