<?php
// app/models/usersModel.php

// On remonte de deux niveaux pour sortir de 'models' et de 'app', afin d'atteindre la racine du projet
require_once __DIR__ . '/../../config/connect.php';

class UsersModel {
    private $db;

    public function __construct() {
        $connection = new Connect();
        $this->db = $connection->pdo;
    }
    
    // ... reste de ta fonction register() inchangée ...

    // Méthode pour inscrire un utilisateur avec un UUID
    public function register($name, $email, $password) {
        try {
            // 1. Vérifier si l'email existe déjà
            $checkQuery = "SELECT id FROM users WHERE email = :email";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->execute([':email' => $email]);
            
            if ($checkStmt->fetch()) {
                return "Cet email est déjà utilisé.";
            }

            // 2. Générer un UUID unique v4 pour l'identifiant
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            // 3. Hasher le mot de passe de manière sécurisée
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // 4. Insérer les données dans ta table 'users'
            $query = "INSERT INTO users (id, name, email, password, role) VALUES (:id, :name, :email, :password, 'client')";
            $stmt = $this->db->prepare($query);
            
            $success = $stmt->execute([
                ':id'       => $uuid,
                ':name'     => $name,
                ':email'    => $email,
                ':password' => $hashedPassword
            ]);

            return $success ? true : "Une erreur est survenue lors de l'enregistrement.";

        } catch (PDOException $e) {
            return "Erreur SQL : " . $e->getMessage();
        }
    }
}