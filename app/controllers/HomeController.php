<?php
// app/controllers/HomeController.php

class HomeController {
    public function index() {
        // C'est ici qu'on appelle la page d'accueil propre
        include __DIR__ . '/../views/home.php';
    }
}