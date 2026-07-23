<?php
// app/models/usersModel.php

class UsersModel {
    private $pdo;

    public function __construct() {
        // Connexion BDD
        $this->pdo = new PDO("mysql:host=localhost;dbname=dbspa;charset=utf8mb4", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    /**
     * Authentifie un utilisateur par son email et son mot de passe
     */
    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // Vérification si l'utilisateur existe et si le mot de passe correspond
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    /**
     * Récupère un utilisateur par son email
     */
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Inscription d'un nouvel utilisateur avec firstname et lastname
     */
    public function register($firstname, $lastname, $email, $password) {
        try {
            // Vérifier si l'email existe déjà
            if ($this->getUserByEmail($email)) {
                return "Cet email est déjà utilisé.";
            }

            // Génération de l'UUID v4 pour l'ID utilisateur
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            // Hachage sécurisé du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Requête mise à jour avec firstname et lastname
            $sql = "INSERT INTO users (id, firstname, lastname, email, password, role, created_at) 
                    VALUES (:id, :firstname, :lastname, :email, :password, 'client', NOW())";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id'        => $uuid,
                ':firstname' => $firstname,
                ':lastname'  => $lastname,
                ':email'     => $email,
                ':password'  => $hashedPassword
            ]);

            return $uuid; // Retourne l'ID généré
        } catch (PDOException $e) {
            return "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}