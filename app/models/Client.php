<?php
// app/models/Client.php

class Client {
    private $db;

    public function __construct() {
        try {
            // ✅ Koneksyon korije ak dbspa pou WampServer
            $this->db = new PDO("mysql:host=localhost;dbname=dbspa;charset=utf8", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getAllClients() {
        try {
            $stmt = $this->db->query("SELECT * FROM clients ORDER BY id_client DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function create($uid, $nom, $prenom, $telephone, $email, $adresse) {
        try {
            $sql = "INSERT INTO clients (uid, nom, prenom, telephone, email, adresse) 
                    VALUES (:uid, :nom, :prenom, :telephone, :email, :adresse)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':uid' => $uid, ':nom' => $nom, ':prenom' => $prenom, 
                ':telephone' => $telephone, ':email' => $email, ':adresse' => $adresse
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id_client, $nom, $prenom, $telephone, $email, $adresse) {
        try {
            $sql = "UPDATE clients 
                    SET nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, adresse = :adresse 
                    WHERE id_client = :id_client";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':id_client' => $id_client, ':nom' => $nom, ':prenom' => $prenom, 
                ':telephone' => $telephone, ':email' => $email, ':adresse' => $adresse
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id_client) {
        try {
            $sql = "DELETE FROM clients WHERE id_client = :id_client";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id_client' => $id_client]);
        } catch (PDOException $e) {
            return false;
        }
    }
}