<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php'; 

// Récupération des données du formulaire ou de la session
$serviceNom = $_POST['service_nom'] ?? ($_SESSION['booking_draft']['service_nom'] ?? 'Soin Spa');
$prixTotal  = floatval($_POST['prix_soin'] ?? ($_POST['prix_total'] ?? ($_SESSION['booking_draft']['prix_soin'] ?? 0)));

// Récupération de la date, l'heure et l'ID si envoyés au préalable
$serviceId = $_POST['service_id'] ?? ($_SESSION['booking_draft']['service_id'] ?? '');
$dateRdv   = $_POST['date'] ?? ($_SESSION['booking_draft']['date'] ?? date('Y-m-d'));
$timeRdv   = $_POST['time'] ?? ($_SESSION['booking_draft']['time'] ?? '09:00');

// Calcul de l'acompte de 30%
$acompte = $prixTotal * 0.30;
$soldeRestant = $prixTotal - $acompte;
?>

<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen py-12 px-6 font-sans">
    <div class="max-w-4xl mx-auto mt-6">
        
        <!-- En-tête -->
        <div class="text-center mb-10">
            <span class="text-xs font-semibold tracking-widest uppercase bg-[#FCD7CC] px-4 py-1.5 rounded-full inline-block mb-3">
                Finalisation de la réservation
            </span>
            <h1 class="text-3xl md:text-4xl font-serif font-black text-[#4A2E30]">Paiement de l'Acompte (30%)</h1>
            <p class="text-sm text-[#5C3A3C]/80 mt-2">Choisissez votre créneau horaire et réglez l'acompte requis pour bloquer votre réservation.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
            
            <!-- Récapitulatif de la commande & Choix de la date/heure -->
            <div class="md:col-span-2 bg-white p-6 rounded-3xl border border-[#FCD7CC]/40 shadow-sm flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-serif font-bold text-[#4A2E30] mb-4 border-b border-[#FCD7CC]/30 pb-2">Récapitulatif</h2>
                    
                    <div class="space-y-4 text-sm">
                        <div>
                            <span class="text-xs text-[#C87A65] font-semibold uppercase block">Prestation</span>
                            <span class="font-bold text-[#4A2E30]"><?= htmlspecialchars($serviceNom) ?></span>
                        </div>

                        <!-- Formulaire imbriqué ou lié pour les inputs dynamiques : On met le choix de date/heure relié au formulaire de droite via l'attribut form="payment-form" -->
                        <div class="pt-2 border-t border-[#FAF7F2] space-y-3">
                            <div>
                                <label class="block text-xs font-semibold uppercase text-[#5C3A3C] mb-1">Date du rendez-vous</label>
                                <input type="date" name="date" form="payment-form" value="<?= htmlspecialchars($dateRdv) ?>" min="<?= date('Y-m-d') ?>" required 
                                       class="w-full px-3 py-2 rounded-xl border border-[#FCD7CC] text-sm focus:outline-none focus:ring-2 focus:ring-[#C87A65] bg-white">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase text-[#5C3A3C] mb-1">Heure souhaitée</label>
                                <select name="time" form="payment-form" required 
                                        class="w-full px-3 py-2 rounded-xl border border-[#FCD7CC] text-sm focus:outline-none focus:ring-2 focus:ring-[#C87A65] bg-white">
                                    <option value="">-- Choisir une heure --</option>
                                    <?php 
                                    $heuresDisponibles = ['09:00', '10:30', '12:00', '13:30', '15:00', '16:30', '18:00'];
                                    foreach($heuresDisponibles as $h) {
                                        $selected = ($timeRdv === $h) ? 'selected' : '';
                                        echo "<option value=\"$h\" $selected>$h</option>";
                                    }
                                    ?>
                                </select>
                                <p class="text-[11px] text-[#5C3A3C]/70 italic mt-1">Un délai d'1h est requis entre chaque rdv.</p>
                            </div>
                        </div>
                        
                        <div class="pt-2 border-t border-[#FAF7F2]">
                            <span class="text-xs text-gray-500 block">Tarif total du soin</span>
                            <span class="font-medium"><?= number_format($prixTotal, 2, ',', ' ') ?> gdes</span>
                        </div>

                        <div class="pt-2 border-t border-[#FAF7F2]">
                            <span class="text-xs text-gray-500 block">Solde à payer sur place</span>
                            <span class="font-medium text-gray-600"><?= number_format($soldeRestant, 2, ',', ' ') ?> gdes</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-[#FCD7CC]/40 bg-[#FCECE7]/50 p-4 rounded-2xl">
                    <span class="text-xs font-bold text-[#C87A65] uppercase block">Acompte à régler maintenant</span>
                    <span class="text-2xl font-black text-[#4A2E30]"><?= number_format($acompte, 2, ',', ' ') ?> gdes</span>
                </div>
            </div>

            <!-- Formulaire de règlement -->
            <div class="md:col-span-3 bg-white p-6 rounded-3xl border border-[#FCD7CC]/40 shadow-sm">
                <h2 class="text-lg font-serif font-bold text-[#4A2E30] mb-4 border-b border-[#FCD7CC]/30 pb-2">Informations de règlement</h2>
                
                <!-- ID ajouté pour faire le lien avec les champs de date/heure situés dans l'autre bloc -->
                <form id="payment-form" action="index.php?url=reservation/confirmer" method="POST" class="space-y-4">
                    <!-- Champs cachés nécessaires pour la BDD -->
                    <input type="hidden" name="service_id" value="<?= htmlspecialchars($serviceId) ?>">
                    <input type="hidden" name="service_nom" value="<?= htmlspecialchars($serviceNom) ?>">
                    <input type="hidden" name="prix_total" value="<?= htmlspecialchars($prixTotal) ?>">
                    <input type="hidden" name="montant_acompte" value="<?= htmlspecialchars($acompte) ?>">

                    <div>
                        <label class="block text-xs font-semibold uppercase text-[#5C3A3C] mb-1">Nom sur la carte</label>
                        <input type="text" name="nom_client" required placeholder="Ex: Marie Dupont" class="w-full px-4 py-2.5 rounded-xl border border-[#FCD7CC] text-sm focus:outline-none focus:ring-2 focus:ring-[#C87A65]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-[#5C3A3C] mb-1">Numéro de carte</label>
                        <input type="text" name="numero_carte" required placeholder="4242 •••• •••• 4242" class="w-full px-4 py-2.5 rounded-xl border border-[#FCD7CC] text-sm focus:outline-none focus:ring-2 focus:ring-[#C87A65]">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-[#5C3A3C] mb-1">Expiration</label>
                            <input type="text" name="exp_date" required placeholder="MM/YY" class="w-full px-4 py-2.5 rounded-xl border border-[#FCD7CC] text-sm focus:outline-none focus:ring-2 focus:ring-[#C87A65]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-[#5C3A3C] mb-1">CVC</label>
                            <input type="text" name="cvc" required placeholder="123" class="w-full px-4 py-2.5 rounded-xl border border-[#FCD7CC] text-sm focus:outline-none focus:ring-2 focus:ring-[#C87A65]">
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-[#C87A65] hover:bg-[#A3523D] text-white font-bold py-3 px-6 rounded-xl transition duration-300 shadow-md text-sm cursor-pointer">
                        Payer l'acompte de <?= number_format($acompte, 2, ',', ' ') ?> gdes
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>