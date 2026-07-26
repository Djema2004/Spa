<?php

class AdminDashboardController extends Controller {

    // Metòd index pou reponn ak wout ki mande 'index' la
    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $db = Database::getInstance();

        // 1. Chif d'Affaires
        $sqlCA = "SELECT SUM(montant) as total FROM paiements";
        $resCA = $db->query($sqlCA)->fetch();
        $chiffreAffaires = $resCA['total'] ?? 0;

        // 2. RDV Jòd a
        $sqlRdv = "SELECT COUNT(*) as total FROM rendez_vous WHERE DATE(date_heure) = CURDATE()";
        $resRdv = $db->query($sqlRdv)->fetch();
        $rdvJour = $resRdv['total'] ?? 0;

        // 3. Total Kliyan
        $sqlClients = "SELECT COUNT(*) as total FROM clients";
        $resClients = $db->query($sqlClients)->fetch();
        $clientsActifs = $resClients['total'] ?? 0;

        // 4. Denye RDV yo pou tab la
        $sqlDerniersRdv = "SELECT r.*, c.nom as client_nom, c.photo as client_photo, 
                            p.nom as prestation_nom, e.nom as esth_nom 
                            FROM rendez_vous r 
                            LEFT JOIN clients c ON r.client_id = c.id 
                            LEFT JOIN prestations p ON r.prestation_id = p.id 
                            LEFT JOIN estheticiennes e ON r.estheticienne_id = e.id 
                            ORDER BY r.date_heure DESC LIMIT 5";
        $derniersRdv = $db->query($sqlDerniersRdv)->fetchAll();

        // 5. Top Prestations
        $sqlTop = "SELECT p.nom, COUNT(r.id) as total 
                   FROM rendez_vous r 
                   JOIN prestations p ON r.prestation_id = p.id 
                   GROUP BY p.id ORDER BY total DESC LIMIT 5";
        $topPrestations = $db->query($sqlTop)->fetchAll();

        // Chaje vi dashboard la
        require_once 'app/views/admin/dashboard.php';
    }
}