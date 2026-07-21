<?php
// app/controllers/ReservationController.php

class ReservationController extends Controller {

    // 1. Étape d'initialisation du paiement de l'acompte
    public function checkout() {
        $prixSoin = 100.00; // Exemple de tarif pour un soin

        // On calcule automatiquement les 30% d'acompte (30.00 €)
        $detailPaiement = $this->calculerAcompte($prixSoin);

        // On prépare le paiement Stripe pour ces 30.00 € (3000 centimes)
        $clientSecret = $this->preparerPaiementStripe($detailPaiement['montantCentimes']);

        // On affiche la vue avec l'obligation de payer les 30%
        $this->view('reservation/paiement', [
            'paiement'     => $detailPaiement,
            'clientSecret' => $clientSecret
        ]);
    }

    // 2. Étape d'enregistrement : bloquée si l'acompte n'est pas payé !
    public function confirmer() {
        $statutPaiement = $_POST['stripe_payment_status'] ?? 'echec';

        // SÉCURITÉ : Si l'acompte de 30% n'a pas été réglé, on bloque la réservation !
        if ($statutPaiement !== 'succeeded' && $statutPaiement !== 'simule_ok') {
            echo "Erreur : La réservation ne peut pas être confirmée sans le versement de l'acompte de 30%.";
            return;
        }

        // Si l'acompte est payé, on enregistre en BDD avec le statut "acompte_paye"
        // ... Code SQL pour insérer la réservation ...

        // On envoie le mail de confirmation
        $this->sendEmail(
            $_POST['email_client'], 
            "Confirmation de réservation - BeautyHair Spa", 
            "<h1>Réservation confirmée !</h1><p>Acompte de 30% bien reçu. Le reste sera à régler sur place.</p>"
        );

        $this->view('reservation/confirmation');
    }
}