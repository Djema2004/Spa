<?php
// app/controllers/ServiceController.php

class ServiceController extends Controller {

    // --- PARTIE ADMINISTRATION ---
    public function index() {
        $db = Database::getInstance();
        
        // Récupérer tous les services de la table 'services' avec les bonnes colonnes
        $sql = "SELECT * FROM services ORDER BY id DESC";
        $services = $db->query($sql)->fetchAll();

        // Charger la vue du dashboard admin pour les services
        $this->view('admin/services', ['services' => $services]);
    }

    // --- PARTIE PUBLIQUE (EXISTANTE) ---
    public function manucure_pedicure() {
        $this->view('manucure_pedicure');
    }

    public function showSauna() {
        $this->view('sauna'); 
    }

    public function showMassage() {
        $this->view('massage');
    }

    public function showSoinVisage() {
        $this->view('soins_visage');
    }

    public function showEpilation() {
        $this->view('epilation');
    }

    public function showExtensionCils() {
        $this->view('extension_cils');
    }
}