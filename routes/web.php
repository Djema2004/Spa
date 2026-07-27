<?php
// routes/web.php

return [
    // 🏠 Pages Principales
    'home'                                => ['controller' => 'HomeController', 'action' => 'index'],
    'contact'                             => ['controller' => 'HomeController', 'action' => 'contact'],
    
    // 🔐 Authentification & Inscription
    'login'                               => ['controller' => 'AuthController', 'action' => 'login'],
    'login/process'                       => ['controller' => 'AuthController', 'action' => 'loginProcess'],
    'register'                            => ['controller' => 'AuthController', 'action' => 'register'],
    'register/process'                    => ['controller' => 'AuthController', 'action' => 'registerProcess'],
    'logout'                              => ['controller' => 'AuthController', 'action' => 'logout'],
    
    // 📊 Tableaux de bord
    'dashboard'                           => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    'admin-dashboard'                     => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    'admin/dashboard'                     => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    'client-dashboard'                    => ['controller' => 'ClientDashboardController', 'action' => 'index'],
    
    // 💆‍♀️ Services & Soins (Front-office)
    'sauna'                               => ['controller' => 'ServiceController', 'action' => 'showSauna'],
    'massage'                             => ['controller' => 'ServiceController', 'action' => 'showMassage'],
    'soins-visage'                        => ['controller' => 'ServiceController', 'action' => 'showSoinVisage'],
    'epilation'                           => ['controller' => 'ServiceController', 'action' => 'showEpilation'],
    'extensions'                          => ['controller' => 'ServiceController', 'action' => 'showExtensionCils'],
    'manucure'                            => ['controller' => 'PrestationController', 'action' => 'manucure'],
    'galerie'                             => ['controller' => 'GalleryController', 'action' => 'index'],
    
    // 🎯 Tunnel de Réservation & Paiement
    'reservation/start'                   => ['controller' => 'ReservationController', 'action' => 'start'],
    'reservation'                         => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'checkout'                            => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/checkout'                => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/paiement'                => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/confirmer'               => ['controller' => 'ReservationController', 'action' => 'confirmer'],
    'confirm-reservation-process'         => ['controller' => 'ReservationController', 'action' => 'confirmationProcess'],

    // ⚙️ Gestion des Utilisateurs (Admin)
    'utilisateurs'                        => ['controller' => 'UserController', 'action' => 'index'],
    'admin/users'                         => ['controller' => 'UserController', 'action' => 'index'],
    
    // 🛡️ Gestion des Administrateurs
    'admin/admins'                        => ['controller' => 'AdminController', 'action' => 'admins'],
    'admin/profil'                        => ['controller' => 'AdminDashboardController', 'action' => 'profil'],
    'admin/parametres'                    => ['controller' => 'AdminDashboardController', 'action' => 'parametres'],

    // 🛠️ Prestations & Services (Admin)
    'admin/prestations'                   => ['controller' => 'PrestationController', 'action' => 'index'],
    'admin/prestations/create'            => ['controller' => 'PrestationController', 'action' => 'create'],
    'prestations/edit'                    => ['controller' => 'PrestationController', 'action' => 'edit'],

    // 👥 Clients (Admin)
    'admin/clients'                       => ['controller' => 'ClientController', 'action' => 'index'],

    // ✨ Esthéticiennes (Admin)
    'admin/estheticiennes'                => ['controller' => 'EstheticienneController', 'action' => 'index'],
    'estheticiennes/store'                => ['controller' => 'EstheticienneController', 'action' => 'store'],
    'estheticiennes/edit'                 => ['controller' => 'EstheticienneController', 'action' => 'edit'],
    'estheticiennes/delete'               => ['controller' => 'EstheticienneController', 'action' => 'delete'],

    // 📅 Rendez-vous (Admin)
    'admin/appointments'                  => ['controller' => 'RendezVousController', 'action' => 'index'],
    'rendezvous/recu'                     => ['controller' => 'RendezVousController', 'action' => 'recu'],
    'rendezvous/edit'                     => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'rendezvous/delete'                   => ['controller' => 'RendezVousController', 'action' => 'delete'],

    // 🎫 Coupons & Paiements (Admin)
    'admin/coupons'                       => ['controller' => 'CouponController', 'action' => 'index'],
    'admin/paiements'                     => ['controller' => 'PaiementController', 'action' => 'index'],
];