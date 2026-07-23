<?php
// app/controllers/ClientDashboardController.php

class ClientDashboardController {

    public function index() {
        // 1. Démarrage de la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_uuid']) || empty($_SESSION['user_uuid'])) {
            header('Location: index.php?url=login');
            exit();
        }

        // Récupération de l'identifiant de l'utilisateur connecté
        $user_id = $_SESSION['user_uuid'];

        // 3. Connexion à la base de données
        $host = 'localhost';
        $dbname = 'dbspa';
        $username = 'root';
        $password_db = '';

        try {
            $pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password_db
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }

        // 4. Chargement du modèle Appointment
        require_once __DIR__ . '/../models/appointment.php';

        $appointmentModel = new Appointment($pdo);

        try {
            $appointments = $appointmentModel->getAppointmentsByUser($user_id);
        } catch (Exception $e) {
            $appointments = [];
            $error_message = $e->getMessage();
        }

        // 5. Mémoriser la page actuelle
        $_SESSION['back_page'] = 'index.php?url=client-dashboard';

        // 6. Charger la vue
        require_once __DIR__ . '/../views/client/dashboard.php';
    }
}