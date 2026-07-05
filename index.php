<?php
// C:\wamp64\www\Spa\index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Charger les routes
$routesPath = __DIR__ . '/routes/web.php';
if (!file_exists($routesPath)) {
    die("Fichier des routes introuvable.");
}
$routes = require_once $routesPath;

// 2. Récupérer l'URL demandée
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'home';

// 3. Traiter le routage
if (array_key_exists($url, $routes)) {
    $controllerName = $routes[$url]['controller'];
    $actionName = $routes[$url]['action'];

    // Chemin correct puisque 'controllers' est dans 'app'
    $controllerPath = __DIR__ . '/app/controllers/' . $controllerName . '.php';

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                die("Erreur : L'action {$actionName} n'existe pas.");
            }
        } else {
            die("Erreur : La classe {$controllerName} est introuvable.");
        }
    } else {
        die("Erreur : Le fichier contrôleur [ {$controllerName}.php ] est introuvable.");
    }
} else {
    http_response_code(404);
    die("<h1>Page non trouvée (404)</h1>La route '" . htmlspecialchars($url) . "' n'existe pas.");
}