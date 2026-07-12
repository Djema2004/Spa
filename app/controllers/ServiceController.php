<?php
// app/controllers/ServiceController.php

class ServiceController {
    
    // Le nom de la fonction doit être exactement "manucure_pedicure"
    public function manucure_pedicure() {
        // Cible le nom de ton fichier de vue dans app/views/
        include dirname(__DIR__) . '/views/manucure_pedicure.php';
    }

    // Ajoute aussi tes autres fonctions si tu veux éviter de futures erreurs :
    public function showSauna() {
        include dirname(__DIR__) . '/views/sauna.php'; // ou le nom de ta vue sauna
    }

    public function showMassage() {
        include dirname(__DIR__) . '/views/massage.php';
    }

    public function showSoinVisage() {
        include dirname(__DIR__) . '/views/soins_visage.php';
    }

    public function showEpilation() {
        include dirname(__DIR__) . '/views/epilation.php';
    }

    public function showExtensionCils() {
        include dirname(__DIR__) . '/views/extension_cils.php';
    }
}