<?php
// app/controllers/ReservationController.php

class ReservationController {

    /**
     * 1. Intercepte le clic "Réserver" sur les cartes de soins
     */
    public function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sauvegarde du soin sélectionné en session
            $_SESSION['booking_draft'] = [
                'service_nom' => $_POST['service_nom'] ?? 'Soin Spa',
                'prix_soin'   => $_POST['prix_soin'] ?? '0.00'
            ];
        }

        // Si l'utilisateur n'est pas connecté, redirection vers la page de login
        if (!isset($_SESSION['user_uuid'])) {
            header('Location: index.php?url=login');
            exit();
        }

        // Si l'utilisateur est déjà connecté, direction directe vers checkout
        header('Location: index.php?url=reservation/checkout');
        exit();
    }

    /**
     * 2. Affiche la page de paiement / checkout
     */
    public function checkout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Sécurité : Redirige vers le login si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['user_uuid'])) {
            header('Location: index.php?url=login');
            exit();
        }

        $serviceNom = $_SESSION['booking_draft']['service_nom'] ?? 'Soin Spa';
        $prixSoin   = $_SESSION['booking_draft']['prix_soin'] ?? '0.00';

        require_once __DIR__ . '/../views/checkout.php';
    }

    /**
     * 3. Valide le formulaire, vérifie les conflits horaires et insère en BDD
     */
    public function confirmer() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_uuid'])) {
            header('Location: index.php?url=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceNom     = $_POST['service_nom'] ?? ($_SESSION['booking_draft']['service_nom'] ?? 'Soin Spa');
            $prixTotal      = floatval($_POST['prix_total'] ?? ($_SESSION['booking_draft']['prix_soin'] ?? 0));
            $montantAcompte = floatval($_POST['montant_acompte'] ?? ($prixTotal * 0.30));
            $nomClient      = $_POST['nom_client'] ?? ($_SESSION['user_name'] ?? 'Client');
            $dateRdv        = $_POST['date'] ?? date('Y-m-d');
            $timeRdv        = $_POST['time'] ?? date('H:i');

            try {
                $pdo = new PDO("mysql:host=localhost;dbname=dbspa;charset=utf8mb4", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);

                // Anti-doublon : Vérification du créneau horaire (intervalle d'1 heure)
                $checkSql = "SELECT COUNT(*) FROM appointments 
                             WHERE service_nom = :service_nom 
                             AND date_rdv = :date_rdv 
                             AND status != 'annule'
                             AND ABS(TIMESTAMPDIFF(MINUTE, heure_rdv, :heure_rdv)) < 60";

                $checkStmt = $pdo->prepare($checkSql);
                $checkStmt->execute([
                    ':service_nom' => $serviceNom,
                    ':date_rdv'    => $dateRdv,
                    ':heure_rdv'   => $timeRdv
                ]);

                if ($checkStmt->fetchColumn() > 0) {
                    $_SESSION['error_message'] = "Ce créneau horaire est déjà réservé pour ce soin. Un délai d'une heure minimum est requis entre deux prestations. Veuillez choisir un autre horaire.";
                    header('Location: index.php?url=reservation/checkout');
                    exit();
                }

                // Génération des UUIDs uniques v4
                $appointmentId = $this->generateUuidV4();
                $userId        = $_SESSION['user_id'];

                // Insertion sécurisée dans la table appointments
                $sql = "INSERT INTO appointments (id, user_id, nom_client, service_nom, prix_total, acompte, date_rdv, heure_rdv, status, created_at) 
                        VALUES (:id, :user_id, :nom_client, :service_nom, :prix_total, :acompte, :date_rdv, :heure_rdv, 'confirme', NOW())";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id'           => $appointmentId,
                    ':user_id'      => $userId,
                    ':nom_client'   => $nomClient,
                    ':service_nom'  => $serviceNom,
                    ':prix_total'   => $prixTotal,
                    ':acompte'      => $montantAcompte,
                    ':date_rdv'     => $dateRdv,
                    ':heure_rdv'    => $timeRdv
                ]);

                // ---------------------------------------------------------
                // ENVOI DE L'EMAIL DE CONFIRMATION VIA RESEND
                // ---------------------------------------------------------
                $clientEmail = $_SESSION['user_email'] ?? 'client@example.com';
                $this->sendResendEmail($clientEmail, $nomClient, $serviceNom, $dateRdv, $timeRdv);

                // Message de succès & nettoyage de la réservation temporaire
                $_SESSION['success_message'] = "Votre réservation pour « " . htmlspecialchars($serviceNom) . " » a été enregistrée avec succès !";
                unset($_SESSION['booking_draft']);

                // Redirection vers la page finale de confirmation
                header('Location: index.php?url=confirm-reservation-process');
                exit();

            } catch (PDOException $e) {
                die("Erreur SQL lors de l'enregistrement : " . $e->getMessage());
            }

        } else {
            header('Location: index.php?url=reservation/checkout');
            exit();
        }
    }

    /**
     * 4. Affiche la page de confirmation de succès
     */
    public function confirmationProcess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../views/confirm_reservation_process.php';
    }

    /**
     * Envoi d'e-mail transactionnel via l'API cURL Resend
     */
   private function sendResendEmail($toEmail, $clientName, $serviceNom, $dateRdv, $heureRdv) {
        $configFile = __DIR__ . '/../../config/connect.php';
        
        // Debug direct pour voir si le fichier existe et afficher son contenu brut
        if (!file_exists($configFile)) {
            die("ERREUR ABSOLUE : Le fichier n'existe pas à cet emplacement : " . realpath($configFile));
        }
        
        require_once $configFile;
        
        // Vérification immédiate si la constante existe
        if (!defined('RESEND_API_KEY')) {
            die("ERREUR : Le fichier connect.php est bien chargé, mais la constante RESEND_API_KEY n'y est PAS définie !");
        }
        
        $apiKey = RESEND_API_KEY; 
        // ... le reste de ton code cURL ...
        $data = [
            'from'    => 'Spa & Bien-être <onboarding@resend.dev>',
            'to'      => [$toEmail],
            'subject' => 'Confirmation de votre réservation - ' . $serviceNom,
            'html'    => "
                <div style='font-family: Arial, sans-serif; color: #5C3A3C; padding: 20px; background-color: #FAF7F2; border-radius: 10px;'>
                    <h2 style='color: #4A2E30;'>Bonjour " . htmlspecialchars($clientName) . ",</h2>
                    <p>Nous avons le plaisir de vous confirmer votre réservation pour le soin : <strong>" . htmlspecialchars($serviceNom) . "</strong>.</p>
                    <div style='background: #ffffff; padding: 15px; border-radius: 8px; margin: 15px 0; border: 1px solid #FCD7CC;'>
                        <p style='margin: 5px 0;'>📅 <strong>Date :</strong> " . htmlspecialchars($dateRdv) . "</p>
                        <p style='margin: 5px 0;'>⏰ <strong>Heure :</strong> " . htmlspecialchars($heureRdv) . "</p>
                    </div>
                    <p>Merci de vous présenter 10 minutes avant l'heure de votre rendez-vous.</p>
                    <p style='font-size: 12px; color: #8A5A5C; margin-top: 20px;'>L'équipe de votre Salon de Bien-être</p>
                </div>
            "
        ];

        $ch = curl_init('https://api.resend.com/emails');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
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