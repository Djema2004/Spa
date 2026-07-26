<?php
class AdminDashboardController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Chemin corrigé pointant vers app/views/admin/dashboard.php
        require_once __DIR__ . '/../views/admin/dashboard.php'; 
    }
}