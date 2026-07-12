<?php
// app/controllers/HomeController.php

class HomeController {
    public function index() {
        // dirname(__DIR__) pointe sur 'app/', donc on accède directement à 'views/home.php'
        include dirname(__DIR__) . '/views/home.php';
    }
    public function contact() {
    // Ta logique (ex: traiter le formulaire en POST ou simplement afficher la vue)
    include 'app/views/contact.php'; 
}
}