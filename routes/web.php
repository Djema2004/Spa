<?php
// routes/web.php

return [
    'home'              => ['controller' => 'HomeController', 'action' => 'index'],
    'contact'           => ['controller' => 'HomeController', 'action' => 'contact'],
    'login'             => ['controller' => 'AuthController', 'action' => 'login'],
    'register'          => ['controller' => 'AuthController', 'action' => 'register'],
    'logout'            => ['controller' => 'AuthController', 'action' => 'logout'],
    'client-dashboard'  => ['controller' => 'ClientDashboardController', 'action' => 'index'],
    'admin-dashboard'   => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    
    // Services / Soins
    'sauna'             => ['controller' => 'ServiceController', 'action' => 'showSauna'],
    'massage'           => ['controller' => 'ServiceController', 'action' => 'showMassage'],
    'soins-visage'      => ['controller' => 'ServiceController', 'action' => 'showSoinVisage'],
    'epilation'         => ['controller' => 'ServiceController', 'action' => 'showEpilation'],
    'extensions'        => ['controller' => 'ServiceController', 'action' => 'showExtensionCils'],
    'galerie'           => ['controller' => 'GalleryController', 'action' => 'index'],
    
    // Alias Manucure / Pédicure
    'manucure'          => ['controller' => 'ServiceController', 'action' => 'manucure_pedicure'],
    'manucure_pedicure' => ['controller' => 'ServiceController', 'action' => 'manucure_pedicure'],
    
    // 🎯 Réservations & Paiement
    // Permet de gérer la redirection simple 'reservation' et le tunnel de paiement 'checkout'/'paiement'
    'reservation'          => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'checkout'              => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/checkout' => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/paiement' => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/confirmer' => ['controller' => 'ReservationController', 'action' => 'confirmer'],
];