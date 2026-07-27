<?php
// app/controllers/ServiceController.php

class ServiceController extends Controller {

    // --- PARTIE PUBLIQUE ---
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