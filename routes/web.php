<?php
// routes/web.php

return [
    'home'             => ['controller' => 'HomeController', 'action' => 'index'],
    'login'            => ['controller' => 'AuthController', 'action' => 'login'],
    'register'         => ['controller' => 'AuthController', 'action' => 'register'],
    'logout'           => ['controller' => 'AuthController', 'action' => 'logout'],
    'client-dashboard' => ['controller' => 'ClientDashboardController', 'action' => 'index'],
    'admin-dashboard'  => ['controller' => 'AdminDashboardController', 'action' => 'index'],
    
    // Services / Soins
    'sauna'            => ['controller' => 'ServiceController', 'action' => 'showSauna'],
    'massage'          => ['controller' => 'ServiceController', 'action' => 'showMassage'],
    'soin_visage'      => ['controller' => 'ServiceController', 'action' => 'showSoinVisage'],
    'soins-visage'       => ['controller' => 'ServiceController', 'action' => 'showSoinVisage'],
    'epilation'        => ['controller' => 'ServiceController', 'action' => 'showEpilation'],
    'extension_cils'    => ['controller' => 'ServiceController', 'action' => 'showExtensionCils'],
    'galerie'          => ['controller' => 'GalleryController', 'action' => 'index'],
    
    // 🎯 Les deux routes pointent vers la même action pour éviter les erreurs !
    'manucure'          => ['controller' => 'ServiceController', 'action' => 'manucure_pedicure'],
    'manucure_pedicure' => ['controller' => 'ServiceController', 'action' => 'manucure_pedicure'],
];