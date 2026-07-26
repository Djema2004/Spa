<?php
// index.php (à la racine du projet)

// 0. Activation du tampon de sortie pour autoriser les redirections header() à tout moment
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Tcheke si Composer autoload egziste
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// 1. Démarrage de la session globale pour tout le site
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Inclusion sécurisée des composants du Noyau (Core) avec vérification
$coreFiles = [
    'core/Controller.php',
    'core/Database.php',
    'core/Router.php'
];

foreach ($coreFiles as $file) {
    if (file_exists($file)) {
        require_once $file;
    } else {
        die("Erreur critique : Impossible de trouver le fichier requis : <b>$file</b>");
    }
}

// Chargement des routes
$routesPath = 'routes/web.php';
if (file_exists($routesPath)) {
    $routes = require_once $routesPath;
} else {
    $routes = [];
}

// 3. Initialisation du Routeur avec vérification de l'existence de la classe
if (class_exists('Router')) {
    $router = new Router($routes);

    // 4. Récupération et nettoyage de l'URL demandée
    $url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'home';

    // 5. Lancement de l'application
    $router->dispatch($url);
} else {
    die("Erreur critique : La classe <b>Router</b> n'a pas été trouvée dans core/Router.php !");
}

// (Optionnel selon ton router) 
ob_end_flush();