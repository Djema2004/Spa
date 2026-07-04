<?php
// app/controllers/GalleryController.php

class GalleryController {
    
    public function index() {
        // Appelle la vue de la galerie
        // Ajuste le chemin si ton architecture est légèrement différente
        include __DIR__ . '/../views/galerie.php';
    }
}