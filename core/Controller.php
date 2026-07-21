<?php
// core/Controller.php

// 1. Inclusion manuelle des dépendances PHPMailer


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Controller {

    /**
     * Charge une vue et lui passe des données optionnelles
     *
     * @param string $viewName Le nom du fichier de la vue (ex: 'soins_visage' ou 'client/dashboard')
     * @param array $data Un tableau associatif de données à transmettre à la vue
     */
    public function view($viewName, $data = []) {
        if (!empty($data)) {
            extract($data);
        }

        $viewFile = 'app/views/' . $viewName . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Erreur critique : La vue demandée [<strong>{$viewFile}</strong>] est introuvable.";
        }
    }

    /**
     * Calcule l'acompte obligatoire de 30% requis pour valider une réservation
     * 
     * @param float $prixTotal Le prix total de la prestation
     * @return array Un tableau contenant l'acompte, le reste à payer et les montants formatés
     */
    protected function calculerAcompte($prixTotal) {
        $tauxAcompte = 0.30; // 30% requis
        $montantAcompte = round($prixTotal * $tauxAcompte, 2);
        $resteAPayer = round($prixTotal - $montantAcompte, 2);

        return [
            'prixTotal'      => $prixTotal,
            'montantAcompte' => $montantAcompte,
            'resteAPayer'    => $resteAPayer,
            'montantCentimes' => (int)($montantAcompte * 100) // Pour Stripe / Passerelles bancaires
        ];
    }

    /**
     * Prépare le paiement de l'acompte avec Stripe (API Simulation ou Réelle)
     * 
     * @param int $montantCentimes Le montant de l'acompte en centimes
     * @return string|null La clé secrète du paiement (Client Secret)
     */
    protected function preparerPaiementStripe($montantCentimes) {
        // Si tu utilises la bibliothèque officielle Stripe :
        if (file_exists('vendor/stripe/init.php')) {
            require_once 'vendor/stripe/init.php';
            \Stripe\Stripe::setApiKey('sk_test_VOTRE_CLE_SECRETE_ICI');

            try {
                $intent = \Stripe\PaymentIntent::create([
                    'amount'   => $montantCentimes,
                    'currency' => 'eur',
                    'metadata' => ['type' => 'acompte_reservation']
                ]);
                return $intent->client_secret;
            } catch (Exception $e) {
                return null;
            }
        }

        // Si tu es en mode simulation pour l'examen :
        return 'sim_secret_' . bin2hex(random_bytes(10));
    }

    /**
     * Envoie un e-mail de confirmation après la validation de l'acompte
     */
    protected function sendEmail($to, $subject, $messageHtml) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io'; // Serveur SMTP de test
            $mail->SMTPAuth   = true;
            $mail->Username   = 'votre_username_mailtrap';
            $mail->Password   = 'votre_password_mailtrap';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('noreply@beautyhair-spa.com', 'BeautyHair Spa');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $messageHtml;
            $mail->AltBody = strip_tags($messageHtml);

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}