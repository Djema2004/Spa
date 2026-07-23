<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php'; 
?>

<!-- Fond crème et texte Vieux Rose -->
<main class="flex-1 bg-[#FAF7F2] text-[#5C3A3C] py-16 px-4 sm:px-6 lg:px-8 flex items-center justify-center min-h-[75vh]">
    
    <div class="max-w-xl w-full bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-[#FCD7CC]/20 border border-[#FCD7CC]/40 text-center relative overflow-hidden">
        
        <!-- Élément décoratif en arrière-plan -->
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#FCECE7] rounded-full blur-2xl pointer-events-none"></div>

        <!-- Icône de succès animée -->
        <div class="w-20 h-20 bg-[#FCECE7] text-[#C87A65] rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-[#FCD7CC]/50">
            <i class="fa-solid fa-circle-check text-4xl"></i>
        </div>

        <!-- Titre -->
        <span class="text-xs font-semibold tracking-widest uppercase text-[#C87A65] bg-[#FCECE7] px-4 py-1.5 rounded-full inline-block mb-3">
            Réservation Confirmée
        </span>
        <h1 class="text-3xl sm:text-4xl font-serif font-black text-[#4A2E30] mb-4">
            Merci pour votre confiance !
        </h1>
        
        <div class="w-16 h-0.5 bg-[#FCD7CC] mx-auto mb-6"></div>

        <!-- Message flash ou message par défaut -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="text-base sm:text-lg text-[#5C3A3C] font-medium leading-relaxed mb-8 bg-[#FAF7F2] p-4 rounded-2xl border border-[#FCD7CC]/30">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
            </p>
            <?php unset($_SESSION['success_message']); ?>
        <?php else: ?>
            <p class="text-base sm:text-lg text-[#5C3A3C]/80 font-light leading-relaxed mb-8">
                Votre rendez-vous a bien été enregistré dans notre planning. Nous avons hâte de vous accueillir pour ce moment de bien-être.
            </p>
        <?php endif; ?>

        <!-- Détails / Instructions complémentaires -->
        <div class="text-left bg-[#FAF7F2]/60 rounded-2xl p-5 mb-8 border border-[#FCD7CC]/30 space-y-3">
            <div class="flex items-start gap-3">
                <i class="fa-regular fa-bell text-[#C87A65] mt-1"></i>
                <p class="text-xs text-[#5C3A3C]/80 leading-relaxed">
                    Un e-mail de confirmation détaillant votre soin et votre acompte vous sera envoyé sous peu.
                </p>
            </div>
            <div class="flex items-start gap-3">
                <i class="fa-regular fa-clock text-[#C87A65] mt-1"></i>
                <p class="text-xs text-[#5C3A3C]/80 leading-relaxed">
                    Merci d'arriver 10 minutes avant l'heure de votre rendez-vous.
                </p>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="index.php?url=client-dashboard" 
               class="w-full sm:w-auto px-6 py-3.5 bg-[#C87A65] hover:bg-[#A3523D] text-white font-semibold rounded-xl transition-all duration-300 text-sm shadow-md shadow-[#C87A65]/10 tracking-wider hover:-translate-y-0.5 transform">
                <i class="fa-solid fa-calendar-days mr-2"></i> Voir mes rendez-vous
            </a>
            
            <a href="index.php?url=home" 
               class="w-full sm:w-auto px-6 py-3.5 bg-white border border-[#FCD7CC] hover:bg-[#FCECE7]/50 text-[#4A2E30] font-semibold rounded-xl transition-all duration-300 text-sm tracking-wider">
                <i class="fa-solid fa-house mr-2"></i> Retour à l'accueil
            </a>
        </div>

    </div>

</main>

<?php include __DIR__ . '/footer.php'; ?>