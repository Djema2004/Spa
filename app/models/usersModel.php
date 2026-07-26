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
        $stmt = $this->db->query("SELECT * FROM utilisateurs ORDER BY prenom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metòd pou enskri yon nouvo itilizatè/kliyan otomatikman kòm 'client'
    public function register($prenom, $nom, $email, $password) {
        // Tcheke si imèl la deja egziste
        $stmtCheck = $this->db->prepare("SELECT id FROM utilisateurs WHERE email = ?");
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
        
        // N ap mete role a sou 'client' ekzateman pou l ka monte nan paj itilizatè yo
        $stmt = $this->db->prepare("INSERT INTO utilisateurs (id, prenom, nom, email, password, role, statut) VALUES (?, ?, ?, ?, ?, 'client', 'Actif')");
        
        if ($stmt->execute([$id, $prenom, $nom, $email, $hashedPassword])) {
            return $id;
        }
        return "Erreur lors de l'inscription.";
    }

    // Metòd pou jwenn yon itilizatè pa imèl li
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Metòd pou koneksyon an (login)
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
        $stmt = $this->db->prepare("INSERT INTO utilisateurs (id, prenom, nom, email, password, role, statut) VALUES (?, ?, ?, ?, ?, ?, 'Actif')");
        return $stmt->execute([$id, $prenom, $nom, $email, $hashedPassword, $role]);
    }

    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM utilisateurs WHERE id = ?");
        return $stmt->execute([$id]);
    }
}