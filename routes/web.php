<?php
// routes/web.php

return [
    // 🏠 Pages Principales
    'home'                                     => ['controller' => 'HomeController', 'action' => 'index'],
    'contact'                                  => ['controller' => 'HomeController', 'action' => 'contact'],
    
    // 🔐 Authentification & Inscription
    'login'                                    => ['controller' => 'AuthController', 'action' => 'login'],
    'login.php'                                => ['controller' => 'AuthController', 'action' => 'login'],
    'login/process'                            => ['controller' => 'AuthController', 'action' => 'loginProcess'],
    'register'                                 => ['controller' => 'AuthController', 'action' => 'register'],
    'register.php'                             => ['controller' => 'AuthController', 'action' => 'register'],
    'register/process'                         => ['controller' => 'AuthController', 'action' => 'registerProcess'],
    'logout'                                   => ['controller' => 'AuthController', 'action' => 'logout'],
    'logout.php'                               => ['controller' => 'AuthController', 'action' => 'logout'],
    
    // 📊 Tableaux de bord
    'client-dashboard'                         => ['controller' => 'ClientDashboardController', 'action' => 'index'],
    'admin-dashboard'                          => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    'dashboard'                                => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    'dashboard.php'                            => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    'app/views/admin/admin-dashboard'          => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    'app/views/admin/dashboard'                => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    
    // 💆‍♀️ Services & Soins
    'sauna'                                    => ['controller' => 'ServiceController', 'action' => 'showSauna'],
    'massage'                                  => ['controller' => 'ServiceController', 'action' => 'showMassage'],
    'soins-visage'                             => ['controller' => 'ServiceController', 'action' => 'showSoinVisage'],
    'epilation'                                => ['controller' => 'ServiceController', 'action' => 'showEpilation'],
    'extensions'                               => ['controller' => 'ServiceController', 'action' => 'showExtensionCils'],
    'galerie'                                  => ['controller' => 'GalleryController', 'action' => 'index'],
    
    // 💅 Manucure / Pédicure
    'manucure'                                 => ['controller' => 'ServiceController', 'action' => 'manucure_pedicure'],
    'manucure_pedicure'                        => ['controller' => 'ServiceController', 'action' => 'manucure_pedicure'],
    
    // 🎯 Tunnel de Réservation & Paiement
    'reservation/start'                        => ['controller' => 'ReservationController', 'action' => 'start'],
    'reservation'                              => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'checkout'                                 => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/checkout'                     => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/paiement'                     => ['controller' => 'ReservationController', 'action' => 'checkout'],
    'reservation/confirmer'                    => ['controller' => 'ReservationController', 'action' => 'confirmer'],
    'confirm-reservation-process'              => ['controller' => 'ReservationController', 'action' => 'confirmationProcess'],

    // ⚙️ WOUT ADMIN YO
    'users'                                    => ['controller' => 'UserController', 'action' => 'index'],
    'users.php'                                => ['controller' => 'UserController', 'action' => 'index'],
    'utilisateurs'                             => ['controller' => 'UserController', 'action' => 'index'],
    'utilisateurs.php'                         => ['controller' => 'UserController', 'action' => 'index'],
    'app/views/admin/utilisateurs'             => ['controller' => 'UserController', 'action' => 'index'],
    'app/views/admin/utilisateurs.php'         => ['controller' => 'UserController', 'action' => 'index'],
    
    // 🛠️ Prestations (Lis, Edit, Modifye)
    'prestations'                              => ['controller' => 'PrestationController', 'action' => 'index'],
    'prestations.php'                          => ['controller' => 'PrestationController', 'action' => 'index'],
    'prestations/edit'                         => ['controller' => 'PrestationController', 'action' => 'edit'],
    'prestations/modifier'                     => ['controller' => 'PrestationController', 'action' => 'edit'],
    
    'clients'                                  => ['controller' => 'ClientController', 'action' => 'index'],
    'clients.php'                              => ['controller' => 'ClientController', 'action' => 'index'],
    
    // ✨ Esthéticiennes (Wout konplè pou jere tout bagay)
    'estheticiennes'                           => ['controller' => 'EstheticienneController', 'action' => 'index'],
    'estheticiennes.php'                       => ['controller' => 'EstheticienneController', 'action' => 'index'],
    'estheticiennes/store'                     => ['controller' => 'EstheticienneController', 'action' => 'store'],
    'estheticiennes/edit'                      => ['controller' => 'EstheticienneController', 'action' => 'edit'],
    'estheticiennes/delete'                    => ['controller' => 'EstheticienneController', 'action' => 'delete'],

    // 📅 RENDEZ-VOUS (Lis ak Aksyon yo)
    'rendez_vous'                              => ['controller' => 'RendezVousController', 'action' => 'index'],
    'rendez_vous.php'                          => ['controller' => 'RendezVousController', 'action' => 'index'],
    'rendezvous'                               => ['controller' => 'RendezVousController', 'action' => 'index'],
    'rendezvous.php'                           => ['controller' => 'RendezVousController', 'action' => 'index'],
    'app/views/admin/rendez_vous'              => ['controller' => 'RendezVousController', 'action' => 'index'],

    // 🧾 Wout espesyal pou Randevou (Reçu, Edite / Modifye, Efase)
    'recu'                                     => ['controller' => 'RendezVousController', 'action' => 'recu'],
    'recu.php'                                 => ['controller' => 'RendezVousController', 'action' => 'recu'],
    'app/views/admin/recu'                     => ['controller' => 'RendezVousController', 'action' => 'recu'],
    'app/views/admin/recu.php'                 => ['controller' => 'RendezVousController', 'action' => 'recu'],
    'rendezvous/recu'                          => ['controller' => 'RendezVousController', 'action' => 'recu'],
    'rendez_vous/recu'                         => ['controller' => 'RendezVousController', 'action' => 'recu'],
    'app/views/admin/recu_rendezvous'          => ['controller' => 'RendezVousController', 'action' => 'recu'],
    'app/views/admin/recu_rendezvous.php'      => ['controller' => 'RendezVousController', 'action' => 'recu'],

    'modifier'                                 => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'modifier.php'                             => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'app/views/admin/modifier'                 => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'app/views/admin/modifier.php'             => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'rendezvous/edit'                          => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'rendez_vous/edit'                         => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'rendezvous/modifier'                      => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'app/views/admin/modifier_rendezvous'      => ['controller' => 'RendezVousController', 'action' => 'edit'],
    'app/views/admin/modifier_rendezvous.php'  => ['controller' => 'RendezVousController', 'action' => 'edit'],
    
    'supprimer'                                => ['controller' => 'RendezVousController', 'action' => 'delete'],
    'supprimer.php'                            => ['controller' => 'RendezVousController', 'action' => 'delete'],
    'app/views/admin/supprimer'                => ['controller' => 'RendezVousController', 'action' => 'delete'],
    'app/views/admin/supprimer.php'            => ['controller' => 'RendezVousController', 'action' => 'delete'],
    'rendezvous/delete'                        => ['controller' => 'RendezVousController', 'action' => 'delete'],
    'rendez_vous/delete'                       => ['controller' => 'RendezVousController', 'action' => 'delete'],
    'rendezvous/supprimer'                     => ['controller' => 'RendezVousController', 'action' => 'delete'],

    // 🎫 Lòt Modil Admin
    'coupons'                                  => ['controller' => 'CouponController', 'action' => 'index'],
    'coupons.php'                              => ['controller' => 'CouponController', 'action' => 'index'],
    'paiements'                                => ['controller' => 'PaiementController', 'action' => 'index'],
    'paiements.php'                            => ['controller' => 'PaiementController', 'action' => 'index'],
];