<?php
// app/controllers/ServiceController.php

// 🎯 On hérite de la classe Controller pour utiliser la méthode view()
class ServiceController extends Controller {
    
    // Le nom de la fonction correspond à ta route 'manucure_pedicure'
    public function manucure_pedicure() {
        // Cible le fichier app/views/manucure_pedicure.php
        $this->view('manucure_pedicure');
    }

    public function showSauna() {
        // Cible le fichier app/views/sauna.php
        $this->view('sauna'); 
    }

    public function showMassage() {
        // Cible le fichier app/views/massage.php
        $this->view('massage');
    }

    public function showSoinVisage() {
        // Cible le fichier app/views/soins_visage.php
        $this->view('soins_visage');
    }

    public function showEpilation() {
        // Cible le fichier app/views/epilation.php
        $this->view('epilation');
    }

    public function showExtensionCils() {
        // Cible le fichier app/views/extension_cils.php
        $this->view('extension_cils');
    }
}