<?php
// index.php (à la racine du projet)

// 0. Activation du tampon de sortie pour autoriser les redirections header() à tout moment
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/vendor/autoload.php';

// 1. Démarrage de la session globale pour tout le site
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Inclusion des composants du Noyau (Core) et du tableau de routes
require_once 'core/Controller.php'; 
require_once 'core/Database.php';   
require_once 'core/Router.php';
$routes = require_once 'routes/web.php';

// 3. Initialisation du Routeur avec tes routes
$router = new Router($routes);

// 4. Récupération et nettoyage de l'URL demandée
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'home';

// 5. Lancement de l'application
$router->dispatch($url);


// (Optionnel selon ton router) ob_end_flush();