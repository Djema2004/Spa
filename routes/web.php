<?php
// routes/web.php

// On liste toutes les routes disponibles dans le Spa et le contrôleur associé
return [
    'home'             => ['controller' => 'HomeController', 'action' => 'index'],
    'login'            => ['controller' => 'AuthController', 'action' => 'login'],
    'register'         => ['controller' => 'AuthController', 'action' => 'register'],
    'logout'           => ['controller' => 'AuthController', 'action' => 'logout'],
    'client-dashboard' => ['controller' => 'ClientDashboardController', 'action' => 'index'],
    'admin-dashboard'  => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    'sauna'            => ['controller' => 'ServiceController', 'action' => 'showSauna'],
    'massage'          => ['controller' => 'ServiceController', 'action' => 'showMassage'],
    
    // AJOUT : Route pour la galerie de photos
    'galerie'   => ['controller' => 'GalleryController', 'action' => 'index'],
];