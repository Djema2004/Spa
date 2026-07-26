<?php

class AdminDashboardController {

    public function index() {
        // Nou ka chaje view dashboard a pou admin an
        // Si w gen yon fonksyon render/view nan Controller prensipal la ou ka itilize l tou
        $viewPath = __DIR__ . '/../views/admin/admin-dashboard.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            // Si fichye view a gen yon lòt non tankou dashboard.php
            $altViewPath = __DIR__ . '/../views/admin/dashboard.php';
            if (file_exists($altViewPath)) {
                require_once $altViewPath;
            } else {
                echo "Erreur : La vue du tableau de bord est introuvable.";
            }
        }
    }
}