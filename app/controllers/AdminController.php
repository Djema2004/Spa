<?php

class AdminController extends Controller {

    public function admins() {
        $db = Database::getInstance();
        $message = "";
        
        // Traitement de l'ajout d'un administrateur
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_admin'])) {
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($nom) && !empty($email) && !empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Génération d'un UUID unique pour la colonne 'id' de type varchar(36)
                $id = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                );

                try {
                    $stmt = $db->prepare("INSERT INTO users (id, firstname, email, password, role) VALUES (?, ?, ?, ?, 'admin')");
                    $stmt->execute([$id, $nom, $email, $hashedPassword]);
                    $message = "<p class='text-emerald-600 text-xs font-semibold mb-4'>Administrateur ajouté avec succès !</p>";
                } catch (PDOException $e) {
                    $message = "<p class='text-rose-600 text-xs font-semibold mb-4'>Erreur : " . $e->getMessage() . "</p>";
                }
            } else {
                $message = "<p class='text-rose-600 text-xs font-semibold mb-4'>Veuillez remplir tous les champs.</p>";
            }
        }

        // Récupérer la liste des administrateurs
        $stmtAdmins = $db->query("SELECT * FROM users WHERE role = 'admin' ORDER BY created_at DESC");
        $adminsList = $stmtAdmins->fetchAll();

        // Chargement de la vue
        $this->view('admin/admins', [
            'message' => $message,
            'adminsList' => $adminsList
        ]);
    }
}