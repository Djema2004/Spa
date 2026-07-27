<?php
// app/controllers/PaiementController.php

class PaiementController extends Controller {

    public function index() {
        $db = Database::getInstance();
        
        // Remplacer 'paiements' par 'payments' pour correspondre à la base de données
        $sql = "SELECT * FROM payments ORDER BY id DESC";
        $paiements = $db->query($sql)->fetchAll();

        // Charger la vue correspondante
        require_once 'app/views/admin/paiements.php';
    }
}