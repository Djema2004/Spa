<?php
// app/controllers/HomeController.php

class HomeController {
    public function index() {
        // dirname(__DIR__) pointe sur 'app/', donc on accède directement à 'views/home.php'
        include dirname(__DIR__) . '/views/home.php';
    }
}