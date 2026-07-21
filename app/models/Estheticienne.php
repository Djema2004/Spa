<?php

class Estheticienne {
    private $conn;
    private $table = "estheticiennes";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lis tout esthéticiennes
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY nom ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Jwenn yon sèl selon uid
    public function getByUid($uid) {
        $sql = "SELECT * FROM {$this->table} WHERE uid = :uid LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajoute yon nouvo esthéticienne
    public function create($data) {
        $uid = uniqid('est_', true);
        $sql = "INSERT INTO {$this->table} (uid, nom, prenom, telephone, specialite, created_at)
                VALUES (:uid, :nom, :prenom, :telephone, :specialite, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':telephone', $data['telephone']);
        $stmt->bindParam(':specialite', $data['specialite']);
        return $stmt->execute();
    }

    // Modifye yon esthéticienne selon uid
    public function update($uid, $data) {
        $sql = "UPDATE {$this->table}
                SET nom = :nom, prenom = :prenom, telephone = :telephone, specialite = :specialite
                WHERE uid = :uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':telephone', $data['telephone']);
        $stmt->bindParam(':specialite', $data['specialite']);
        return $stmt->execute();
    }

    // Suprime yon esthéticienne selon uid
    public function delete($uid) {
        $sql = "DELETE FROM {$this->table} WHERE uid = :uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        return $stmt->execute();
    }

    // Planning yon esthéticienne (rendez-vous li)
    public function getPlanning($uid) {
        $sql = "SELECT r.* FROM rendez_vous r
                INNER JOIN {$this->table} e ON e.uid = r.estheticienne_uid
                WHERE e.uid = :uid
                ORDER BY r.date_rdv ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}