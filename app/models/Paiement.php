<?php
// models/PaiementModel.php

class PaiementModel {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAll() {
        $sql = "SELECT 
                    p.id,
                    p.client_id,
                    p.montant,
                    p.date_paiement,
                    p.mode_paiement,
                    p.statut,
                    p.description,
                    CONCAT(c.prenom, ' ', c.nom) as client_nom
                FROM paiements p
                INNER JOIN clients c ON p.client_id = c.id
                ORDER BY p.date_paiement DESC";
        
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }
    
    public function getById($id) {
        $sql = "SELECT p.*, CONCAT(c.prenom, ' ', c.nom) as client_nom
                FROM paiements p
                INNER JOIN clients c ON p.client_id = c.id
                WHERE p.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function add($client_id, $montant, $date_paiement, $mode_paiement, $statut, $description) {
        $sql = "INSERT INTO paiements (client_id, montant, date_paiement, mode_paiement, statut, description)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$client_id, $montant, $date_paiement, $mode_paiement, $statut, $description]);
    }
    
    public function update($id, $client_id, $montant, $date_paiement, $mode_paiement, $statut, $description) {
        $sql = "UPDATE paiements SET client_id = ?, montant = ?, date_paiement = ?, 
                mode_paiement = ?, statut = ?, description = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$client_id, $montant, $date_paiement, $mode_paiement, $statut, $description, $id]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM paiements WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>