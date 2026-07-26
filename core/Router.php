<?php

class Router {
    private $routes = [];

    public function __construct(array $routes) {
        $this->routes = $routes;
    }

    public function dispatch(string $url) {
        // Nettoyage de l'URL
        $url = trim($url, '/');
        if (empty($url)) {
            $url = 'home';
        }

        // Vérification de l'existence de la route dans web.php
        if (array_key_exists($url, $this->routes)) {
            $controllerName = $this->routes[$url]['controller'];
            $actionName     = $this->routes[$url]['action'];

            // Tcheke plizyè chemen posib pou kontwolè a
            $possiblePaths = [
                __DIR__ . '/../app/controllers/' . $controllerName . '.php',
                __DIR__ . '/../app/controllers/admin/' . $controllerName . '.php',
                __DIR__ . '/../app/Controllers/' . $controllerName . '.php'
            ];

            $controllerPath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $controllerPath = $path;
                    break;
                }
            }

            if ($controllerPath && file_exists($controllerPath)) {
                require_once $controllerPath;

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();

                    if (method_exists($controller, $actionName)) {
                        // Appelle la méthode
                        $controller->$actionName();
                        return;
                    } else {
                        die("Erreur : La méthode <b>{$actionName}</b> n'existe pas dans <b>{$controllerName}</b>.");
                    }
                } else {
                    die("Erreur : La classe <b>{$controllerName}</b> est introuvable.");
                }
            } else {
                die("Erreur : Le fichier contrôleur pour <b>{$controllerName}</b> est introuvable.");
            }
        }

        // Si la route n'est pas définie dans routes/web.php
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Page non trouvée (404)</h1>";
        echo "<p>La route <strong>" . htmlspecialchars($url) . "</strong> n'existe pas dans routes/web.php.</p>";
        exit();
    }
}