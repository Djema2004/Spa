<?php

class ClientDashboardController {
    
    public function index() {
        // 1. DÉMARRAGE DE LA SESSION ET SÉCURITÉ
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si l'utilisateur n'est pas connecté avec son UUID, éjection vers le login
        if (!isset($_SESSION['user_uuid'])) {
            header('Location: login.php');
            exit();
        }

        $user_uuid = $_SESSION['user_uuid'];

        // 2. CONNEXION À LA BASE DE DONNÉES (À adapter selon ton système de connexion global)
        $host = 'localhost';
        $dbname = 'dbspa';
        $username = 'root';
        $password_db = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion dans le contrôleur : " . $e->getMessage());
        }

        // 3. CHARGEMENT DU MODÈLE ET RÉCUPÉRATION DES APPOINTMENTS
        require_once __DIR__ . '/../models/appointment.php';
        $appointmentModel = new Appointment($pdo);
        
        try {
            // Récupère tous les rendez-vous de ce client spécifique
            $appointments = $appointmentModel->getAppointmentsByUser($user_uuid);
        } catch (Exception $e) {
            $appointments = [];
            $error_message = $e->getMessage();
        }

        // Stocker la page actuelle pour la gestion des retours dynamiques (Annuler/Modifier)
        $_SESSION['back_page'] = 'client/dashboard.php';

        // 4. CHARGEMENT DE LA VUE CLIENT
        require_once __DIR__ . '/../views/client/dashboard.php';
    }
}