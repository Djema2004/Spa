<?php

class AdminDashboardController extends Controller {

    // Metòd index pou reponn ak wout ki mande 'index' la
    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $db = Database::getInstance();

        // 1. Chif d'Affaires
        $sqlCA = "SELECT SUM(amount) as total FROM payments";
        $resCA = $db->query($sqlCA)->fetch();
        $chiffreAffaires = $resCA['total'] ?? 0;

        // 2. RDV Jòd a
        $sqlRdv = "SELECT COUNT(*) as total FROM appointments WHERE DATE(appointment_date) = CURDATE()";
        $resRdv = $db->query($sqlRdv)->fetch();
        $rdvJour = $resRdv['total'] ?? 0;

        // 3. Total Kliyan
        $sqlClients = "SELECT COUNT(*) as total FROM users WHERE role = 'client'";
        $resClients = $db->query($sqlClients)->fetch();
        $clientsActifs = $resClients['total'] ?? 0;

        // 4. Denye RDV yo pou tab la
        $sqlDerniersRdv = "SELECT r.*, u.firstname as client_firstname, u.lastname as client_lastname 
                            FROM appointments r 
                            LEFT JOIN users u ON r.user_id = u.id 
                            ORDER BY r.appointment_date DESC, r.appointment_time DESC LIMIT 5";
        $derniersRdv = $db->query($sqlDerniersRdv)->fetchAll();

        // 5. Top Prestations
        $sqlTop = "SELECT service_nom as nom, COUNT(*) as total 
                   FROM appointments 
                   WHERE service_nom IS NOT NULL 
                   GROUP BY service_nom 
                   ORDER BY total DESC LIMIT 5";
        $topPrestations = $db->query($sqlTop)->fetchAll();

        // Chaje vi dashboard la
        require_once 'app/views/admin/dashboard.php';
    }

    // Metòd pou ajoute yon itilizatè
    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = $_POST['firstname'] ?? '';
            $lastname  = $_POST['lastname'] ?? '';
            $email     = $_POST['email'] ?? '';
            $password  = $_POST['password'] ?? '';
            $role      = $_POST['role'] ?? 'estheticienne';

            $allowedRoles = ['admin', 'client', 'estheticienne'];
            if (!in_array($role, $allowedRoles)) {
                $role = 'estheticienne';
            }

            if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
                require_once __DIR__ . '/../models/UsersModel.php';
                $userModel = new UsersModel();
                
                $result = $userModel->createUser($firstname, $lastname, $email, $password, $role);

                if ($result) {
                    header('Location: index.php?url=admin/dashboard&success=user_added');
                    exit();
                } else {
                    echo "Erreur : Impossible de créer l'utilisateur (cet email existe peut-être déjà).";
                }
            } else {
                echo "Erreur : Tous les champs sont obligatoires.";
            }
        }
    }
}