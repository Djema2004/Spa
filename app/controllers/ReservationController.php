<?php

class ReservationController {

    /**
     * Affiche la page de paiement / checkout
     */
    public function checkout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $serviceNom = $_POST['service_nom'] ?? ($_SESSION['booking_draft']['service_nom'] ?? 'Soin Spa');
        $prixSoin   = $_POST['prix_soin'] ?? ($_SESSION['booking_draft']['prix_soin'] ?? '0.00');
        $serviceId  = $_POST['service_id'] ?? ($_SESSION['booking_draft']['service_id'] ?? null);

        $_SESSION['booking_draft'] = [
            'service_nom' => $serviceNom,
            'prix_soin'   => $prixSoin,
            'service_id'  => $serviceId
        ];

        require_once __DIR__ . '/../views/checkout.php';
    }

    /**
     * Traite la soumission du formulaire de paiement et enregistre en BDD
     */
    public function confirmer() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données POST du formulaire
            $serviceNom     = $_POST['service_nom'] ?? ($_SESSION['booking_draft']['service_nom'] ?? 'Soin Spa');
            $prixTotal      = floatval($_POST['prix_total'] ?? ($_SESSION['booking_draft']['prix_soin'] ?? 0));
            $montantAcompte = floatval($_POST['montant_acompte'] ?? ($prixTotal * 0.30));
            $nomClient      = $_POST['nom_client'] ?? 'Client Invité';
            $dateRdv        = $_POST['date'] ?? date('Y-m-d');
            $timeRdv        = $_POST['time'] ?? date('H:i');

            // UUID : Récupère l'UUID utilisateur connecté OU génère un UUID v4 unique pour l'invité
            $userId = $_SESSION['user_id'] ?? $this->generateUuidV4();

            try {
                $pdo = new PDO("mysql:host=localhost;dbname=dbspa;charset=utf8mb4", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);

                // Insertion sécurisée via requête préparée
                $sql = "INSERT INTO appointments (user_id, nom_client, service_nom, prix_total, acompte, date_rdv, heure_rdv, status, created_at) 
                        VALUES (:user_id, :nom_client, :service_nom, :prix_total, :acompte, :date_rdv, :heure_rdv, 'confirme', NOW())";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':user_id'      => $userId,
                    ':nom_client'   => $nomClient,
                    ':service_nom'  => $serviceNom,
                    ':prix_total'   => $prixTotal,
                    ':acompte'      => $montantAcompte,
                    ':date_rdv'     => $dateRdv,
                    ':heure_rdv'    => $timeRdv
                ]);

                // Message de confirmation & nettoyage de la session
                $_SESSION['success_message'] = "Votre réservation pour « " . htmlspecialchars($serviceNom) . " » a été enregistrée avec succès !";
                unset($_SESSION['booking_draft']);

                // Redirection
                header('Location: index.php?url=reservation&status=success');
                exit();

            } catch (PDOException $e) {
                die("Erreur SQL lors de l'enregistrement : " . $e->getMessage());
            }

        } else {
            header('Location: index.php?url=checkout');
            exit();
        }
    }

    /**
     * Générateur d'UUID v4 standard (RFC 4122)
     */
    private function generateUuidV4() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}