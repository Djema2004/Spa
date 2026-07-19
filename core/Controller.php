<?php
// core/Controller.php

class Controller {
    /**
     * Charge une vue et lui passe des données optionnelles
     *
     * @param string $viewName Le nom du fichier de la vue (ex: 'soins_visage' ou 'client/dashboard')
     * @param array $data Un tableau associatif de données à transmettre à la vue
     */
    public function view($viewName, $data = []) {
        // 1. Extrait les variables du tableau pour les rendre directement utilisables dans la vue
        // Exemple : ['nom' => 'Spa'] devient la variable $nom dans le fichier HTML/PHP
        if (!empty($data)) {
            extract($data);
        }

        // 2. Construit le chemin physique vers le fichier de la vue
        $viewFile = 'app/views/' . $viewName . '.php';

        // 3. Vérifie si le fichier existe avant de l'inclure pour éviter les plantages (Erreurs 500)
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            // Message d'erreur propre si tu as oublié de créer la vue ou si le nom est mal écrit
            echo "Erreur critique : La vue demandée [<strong>{$viewFile}</strong>] est introuvable.";
        }
    }
}