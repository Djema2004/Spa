<?php

class Estheticienne {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} WHERE role = 'estheticienne' ORDER BY lastname ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUid($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id AND role = 'estheticienne' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        // Génération d'un ID unique si votre colonne 'id' est un varchar(36)
        $id = uniqid('est_', true);
        $passwordHash = password_hash($data['password'] ?? 'default123', PASSWORD_BCRYPT);

        $sql = "INSERT INTO {$this->table} (id, firstname, lastname, email, password, role, created_at)
                VALUES (:id, :firstname, :lastname, :email, :password, 'estheticienne', NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstname', $data['prenom']); // Correspond au champ du formulaire
        $stmt->bindParam(':lastname', $data['nom']);   // Correspond au champ du formulaire
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $passwordHash);

        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table}
                SET firstname = :firstname, lastname = :lastname, email = :email
                WHERE id = :id AND role = 'estheticienne'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstname', $data['prenom']);
        $stmt->bindParam(':lastname', $data['nom']);
        $stmt->bindParam(':email', $data['email']);

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id AND role = 'estheticienne'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getPlanning($id) {
        $sql = "SELECT r.* FROM rendez_vous r
                INNER JOIN {$this->table} e ON e.id = r.estheticienne_id
                WHERE e.id = :id AND e.role = 'estheticienne'
                ORDER BY r.date_rdv ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}