<?php
// app/controllers/ClientController.php

class ClientController extends Controller {

    public function index() {
        $db = Database::getInstance();
        
        // Récupérer la liste des utilisateurs ayant le rôle 'client' (ou toute la table users selon votre structure)
        $sql = "SELECT * FROM users WHERE role = 'client' ORDER BY created_at DESC";
        $clients = $db->query($sql)->fetchAll();

        // Charger la vue correspondante dans votre dashboard admin
        require_once 'app/views/admin/clients.php';
    }
}