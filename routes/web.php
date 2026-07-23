<?php
// routes/web.php

return [
    // 🏠 Pages Principales
    'home'                          => ['controller' => 'HomeController', 'action' => 'index'],
    'contact'                       => ['controller' => 'HomeController', 'action' => 'contact'],
    
    // 🔐 Authentification & Inscription
    'login'                         => ['controller' => 'AuthController', 'action' => 'login'],
    'login.php'                     => ['controller' => 'AuthController', 'action' => 'login'], // Alias de sécurité
    'login/process'                 => ['controller' => 'AuthController', 'action' => 'loginProcess'], // 👈 AJOUTÉ ICI pour traiter le formulaire
    'register'                      => ['controller' => 'AuthController', 'action' => 'register'],
    'register.php'                  => ['controller' => 'AuthController', 'action' => 'register'], // Alias de sécurité
    'register/process'              => ['controller' => 'AuthController', 'action' => 'registerProcess'], // Traitement du formulaire d'inscription
    'logout'                        => ['controller' => 'AuthController', 'action' => 'logout'],
    
    // 📊 Tableaux de bord
    'client-dashboard'              => ['controller' => 'ClientDashboardController', 'action' => 'index'],
    'admin-dashboard'               => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    
    // 💆‍♀️ Services & Soins
    'sauna'                         => ['controller' => 'ServiceController', 'action' => 'showSauna'],
    'massage'                       => ['controller' => 'ServiceController', 'action' => 'showMassage'],
    'soins-visage'                  => ['controller' => 'ServiceController', 'action' => 'showSoinVisage'],
    'epilation'                     => ['controller' => 'ServiceController', 'action' => 'showEpilation'],
    'extensions'                    => ['controller' => 'ServiceController', 'action' => 'showExtensionCils'],
    'galerie'                       => ['controller' => 'GalleryController', 'action' => 'index'],
    
    // 💅 Manucure / Pédicure
    'manucure'                      => ['controller' => 'ServiceController', 'action' => 'manucure_pedicure'],
    'manucure_pedicure'             => ['controller' => 'ServiceController', 'action' => 'manucure_pedicure'],
    
    // 🎯 Tunnel de Réservation & Paiement
    'reservation/start'             => ['controller' => 'ReservationController', 'action' => 'start'],
    'reservation'                   => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'checkout'                      => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/checkout'          => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/paiement'          => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/confirmer'         => ['controller' => 'ReservationController', 'action' => 'confirmer'],
    'confirm-reservation-process'   => ['controller' => 'ReservationController', 'action' => 'confirmationProcess'],
];