<?php

class AdminDashboardController extends Controller {

    // Metòd index pou reponn ak wout ki mande 'index' la
    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $db = Database::getInstance();

        // 1. Chif d'Affaires
        $sqlCA = "SELECT SUM(montant) as total FROM paiements";
        $resCA = $db->query($sqlCA)->fetch();
        $chiffreAffaires = $resCA['total'] ?? 0;

        // 2. RDV Jòd a
        $sqlRdv = "SELECT COUNT(*) as total FROM rendez_vous WHERE DATE(date_heure) = CURDATE()";
        $resRdv = $db->query($sqlRdv)->fetch();
        $rdvJour = $resRdv['total'] ?? 0;

        // 3. Total Kliyan (Maintien ou adaptation selon votre table users unique)
        $sqlClients = "SELECT COUNT(*) as total FROM users WHERE role = 'client'";
        $resClients = $db->query($sqlClients)->fetch();
        $clientsActifs = $resClients['total'] ?? 0;

        // 4. Denye RDV yo pou tab la
        $sqlDerniersRdv = "SELECT r.*, u.firstname as client_firstname, u.lastname as client_lastname, 
                            p.nom as prestation_nom, est.firstname as esth_firstname 
                            FROM rendez_vous r 
                            LEFT JOIN users u ON r.client_id = u.id 
                            LEFT JOIN prestations p ON r.prestation_id = p.id 
                            LEFT JOIN users est ON r.estheticienne_id = est.id 
                            ORDER BY r.date_heure DESC LIMIT 5";
        $derniersRdv = $db->query($sqlDerniersRdv)->fetchAll();

        // 5. Top Prestations
        $sqlTop = "SELECT p.nom, COUNT(r.id) as total 
                   FROM rendez_vous r 
                   JOIN prestations p ON r.prestation_id = p.id 
                   GROUP BY p.id ORDER BY total DESC LIMIT 5";
        $topPrestations = $db->query($sqlTop)->fetchAll();

        // Chaje vi dashboard la
        require_once 'app/views/admin/dashboard.php';
    }

    // Nouvelle méthode pour ajouter un utilisateur avec le rôle de son choix ('admin', 'estheticienne', 'client')
    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = $_POST['firstname'] ?? '';
            $lastname  = $_POST['lastname'] ?? '';
            $email     = $_POST['email'] ?? '';
            $password  = $_POST['password'] ?? '';
            $role      = $_POST['role'] ?? 'estheticienne'; // Rôle par défaut si non spécifié

            // Vérification de la validité du rôle pour la sécurité
            $allowedRoles = ['admin', 'client', 'estheticienne'];
            if (!in_array($role, $allowedRoles)) {
                $role = 'estheticienne'; // Sécurité : force un rôle valide par défaut
            }

            if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
                // Inclusion et appel du UsersModel pour insérer dans la table unique 'users'
                require_once __DIR__ . '/../models/UsersModel.php';
                $userModel = new UsersModel();
                
                $result = $userModel->createUser($firstname, $lastname, $email, $password, $role);

                if ($result) {
                    // Redirection vers le dashboard après succès
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