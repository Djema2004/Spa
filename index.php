<?php
// index.php (à la racine du projet)

// 1. Démarrage de la session globale pour tout le site (évite les warnings orange)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Inclusion des composants du Noyau (Core) et du tableau de routes
require_once 'core/Controller.php'; // 🎯 Ajouté ici pour que tous tes contrôleurs puissent en hériter !
require_once 'core/Database.php';      // 🎯 Ajouté ici pour que tous tes modèles puissent en hériter !
require_once 'core/Router.php';
$routes = require_once 'routes/web.php';

// 3. Initialisation du Routeur avec tes routes
$router = new Router($routes);

// 4. Récupération de l'URL demandée (ex: index.php?url=client-dashboard)
$url = isset($_GET['url']) ? $_GET['url'] : 'home';

// 5. On lance l'application !
$router->dispatch($url);