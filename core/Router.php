<?php
// core/Router.php

class router {
    protected $routes = [];

    // 1. On charge le tableau de routes (ex: routes/web.php) dans le routeur
    public function __construct($routes) {
        $this->routes = $routes;
    }

    // 2. On analyse l'URL et on lance le bon contrôleur et la bonne action
    public function dispatch($url) {
        // Si l'URL est vide (ex: localhost/spa/), on charge la page 'home' par défaut
        if (empty($url)) {
            $url = 'home';
        }

        // On vérifie si la route demandée existe dans notre fichier routes/web.php
        if (array_key_exists($url, $this->routes)) {
            $controllerName = $this->routes[$url]['controller'];
            $actionName = $this->routes[$url]['action'];

            // On inclut physiquement le fichier du contrôleur demandé
            $controllerFile = 'app/controllers/' . $controllerName . '.php';
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                // On instancie le contrôleur (ex: $controller = new ServiceController();)
                $controller = new $controllerName();

                // On exécute la méthode/action (ex: $controller->showSoinVisage();)
                if (method_exists($controller, $actionName)) {
                    $controller->$actionName();
                } else {
                    echo "Erreur : La méthode {$actionName} n'existe pas dans le contrôleur {$controllerName}.";
                }
            } else {
                echo "Erreur : Le fichier contrôleur {$controllerFile} est introuvable.";
            }
        } else {
            // Si la route n'existe pas du tout dans le tableau (Erreur 404)
            header("HTTP/1.0 404 Not Found");
            echo "<h1>404 Not Found</h1>";
            echo "La page '<strong>" . htmlspecialchars($url) . "</strong>' n'existe pas sur ce site.";
        }
    }
}