<?php

class Estheticienne {
    private $conn;
    private $table = "estheticiennes";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY nom ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUid($uid) {
        $sql = "SELECT * FROM {$this->table} WHERE uid = :uid LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $uid = uniqid('est_', true);
        $sql = "INSERT INTO {$this->table} (uid, nom, prenom, telephone, email, specialite, photo, disponibilite, created_at)
                VALUES (:uid, :nom, :prenom, :telephone, :email, :specialite, :photo, :disponibilite, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':telephone', $data['telephone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':specialite', $data['specialite']);
        $stmt->bindParam(':photo', $data['photo']);
        
        $disponibilite = isset($data['disponibilite']) ? $data['disponibilite'] : 1;
        $stmt->bindParam(':disponibilite', $disponibilite);

        return $stmt->execute();
    }

    public function update($uid, $data) {
        if (!empty($data['photo'])) {
            $sql = "UPDATE {$this->table}
                    SET nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, specialite = :specialite, photo = :photo, disponibilite = :disponibilite
                    WHERE uid = :uid";
        } else {
            $sql = "UPDATE {$this->table}
                    SET nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, specialite = :specialite, disponibilite = :disponibilite
                    WHERE uid = :uid";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':telephone', $data['telephone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':specialite', $data['specialite']);
        $stmt->bindParam(':disponibilite', $data['disponibilite']);

        if (!empty($data['photo'])) {
            $stmt->bindParam(':photo', $data['photo']);
        }

        return $stmt->execute();
    }

    public function delete($uid) {
        $sql = "DELETE FROM {$this->table} WHERE uid = :uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        return $stmt->execute();
    }

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