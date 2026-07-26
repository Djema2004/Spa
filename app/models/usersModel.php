<?php
// app/models/UsersModel.php

class UsersModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=dbspa;charset=utf8mb4', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY prenom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function register($prenom, $nom, $email, $password) {
        $stmtCheck = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmtCheck->execute([$email]);
        if ($stmtCheck->rowCount() > 0) {
            return "Cet email est déjà utilisé.";
        }

        $id = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $this->db->prepare("INSERT INTO users (id, prenom, nom, email, password, role, statut) VALUES (?, ?, ?, ?, ?, 'client', 'Actif')");
        
        if ($stmt->execute([$id, $prenom, $nom, $email, $hashedPassword])) {
            return $id;
        }
        return "Erreur lors de l'inscription.";
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $password) {
        $user = $this->getUserByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function createUser($prenom, $nom, $email, $password, $role) {
        $id = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (id, prenom, nom, email, password, role, statut) VALUES (?, ?, ?, ?, ?, ?, 'Actif')");
        return $stmt->execute([$id, $prenom, $nom, $email, $hashedPassword, $role]);
    }

    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}