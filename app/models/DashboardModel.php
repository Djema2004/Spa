<?php
class DashboardModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection; // Koneksyon PDO ou an
    }

    // 1. Kalkile Chif D'afè total (oswa pou mwa a)
    public function getChiffreAffaires() {
        $stmt = $this->db->query("SELECT SUM(montant) as total FROM paiements");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // 2. Kantite Randevou pou jodi a
    public function getRdvAujourdhui() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM rendez_vous WHERE DATE(date_heure) = CURDATE()");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // 3. Total Kliyan ki anrejistre
    public function getTotalClients() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM clients");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // 4. Prochains Rendez-vous (Avèk tout enfòmasyon kliyan, sèvis ak estheticienne)
    public function getProchainsRdv() {
        $sql = "SELECT r.date_heure, 
                       c.nom as client_nom, c.photo as client_photo, 
                       p.nom as prestation_nom, p.photo as prestation_photo, 
                       e.nom as esth_nom, e.photo as esth_photo,
                       r.statut 
                FROM rendez_vous r
                JOIN clients c ON r.client_id = c.id
                JOIN prestations p ON r.prestation_id = p.id
                JOIN estheticiennes e ON r.estheticienne_id = e.id
                WHERE r.date_heure >= NOW()
                ORDER BY r.date_heure ASC
                LIMIT 5";
                
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>