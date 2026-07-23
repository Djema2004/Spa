<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclusion simple pour le routeur global MVC
include 'header.php'; 
?>

<!-- Fond de page et conteneur principal -->
<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen font-sans flex flex-col justify-between">

    <!-- 1. EN-TÊTE DE LA PAGE (Hero de la catégorie) -->
    <header class="relative bg-[#FCECE7] py-16 px-6 border-b border-[#FCD7CC]/40 text-center space-y-4 shadow-inner">
        <span class="text-xs font-semibold tracking-widest uppercase bg-[#FCD7CC] px-4 py-1.5 rounded-full inline-block">
            ✨ Regard Sublimé
        </span>
        <h1 class="text-4xl md:text-5xl font-serif font-black text-[#4A2E30]">
            Extension de Cils
        </h1>
        <p class="text-base md:text-lg text-[#5C3A3C]/90 font-light max-w-2xl mx-auto leading-relaxed">
            Offrez de l'intensité et de la profondeur à votre regard grâce à nos poses d'extensions sur-mesure. Des cils plus longs, plus denses et parfaitement courbés pour un résultat naturel ou sophistiqué.
        </p>
        <div class="w-16 h-0.5 bg-[#C87A65] mx-auto pt-0.5"></div>
    </header>

    <!-- 2. SECTION DES PRESTATIONS (Grille des offres) -->
    <main class="max-w-7xl mx-auto px-6 py-16 w-full flex-1">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            
            <!-- Prestation 1 : Pose Naturelle -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl p-8 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase bg-[#FCECE7] px-3 py-1 rounded-full inline-block mb-4">60-90 min</span>
                    <h3 class="text-2xl font-serif font-bold text-[#4A2E30] mb-3">Pose Naturelle (Cil à Cil)</h3>
                    <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed mb-6">
                        Idéal pour un effet mascara quotidien, subtil et élégant sans abîmer vos cils naturels. Pose poil par poil d'une grande précision.
                    </p>
                </div>
                <div class="flex items-center justify-between pt-6 border-t border-[#FCD7CC]/30 mt-4">
                    <span class="text-lg font-black text-[#C87A65]">1 800 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Cils - Pose Naturelle (Cil à Cil)">
                        <input type="hidden" name="prix_soin" value="1800.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-5 py-2.5 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

            <!-- Prestation 2 : Volume Russe -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl p-8 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase bg-[#FCECE7] px-3 py-1 rounded-full inline-block mb-4">120 min</span>
                    <h3 class="text-2xl font-serif font-bold text-[#4A2E30] mb-3">Volume Russe</h3>
                    <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed mb-6">
                        Pour un regard intense, glamour et volumineux grâce à l'application de bouquets de cils ultra-légers faits à la main.
                    </p>
                </div>
                <div class="flex items-center justify-between pt-6 border-t border-[#FCD7CC]/30 mt-4">
                    <span class="text-lg font-black text-[#C87A65]">2 500 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Cils - Volume Russe">
                        <input type="hidden" name="prix_soin" value="2500.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-5 py-2.5 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

            <!-- Prestation 3 : Remplissage -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl p-8 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase bg-[#FCECE7] px-3 py-1 rounded-full inline-block mb-4">45-60 min</span>
                    <h3 class="text-2xl font-serif font-bold text-[#4A2E30] mb-3">Remplissage (3 semaines)</h3>
                    <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed mb-6">
                        Entretien indispensable pour combler les chutes naturelles de la cilgenèse et redonner toute la fraîcheur et la densité à votre pose.
                    </p>
                </div>
                <div class="flex items-center justify-between pt-6 border-t border-[#FCD7CC]/30 mt-4">
                    <span class="text-lg font-black text-[#C87A65]">1 350 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Cils - Remplissage (3 semaines)">
                        <input type="hidden" name="prix_soin" value="1350.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-5 py-2.5 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- 3. BANNIÈRE CONSEILS & HYGIÈNE -->
        <div class="mt-16 bg-[#FCECE7]/60 rounded-3xl p-8 border border-[#FCD7CC]/30 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-4">
                <h3 class="text-2xl font-serif font-bold text-[#4A3E30]">Colles Médicales & Hypoallergéniques</h3>
                <p class="text-sm font-light leading-relaxed">
                    Nous portons une attention particulière à la santé de vos yeux. Nos colles sont certifiées, sans formaldéhyde et adaptées aux yeux les plus sensibles.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">👁️ Testé Dermatologiquement</span>
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">💧 Résistant à l'Eau (après 24h)</span>
                </div>
            </div>
            <div class="text-center md:text-right">
                <p class="text-xs uppercase tracking-widest text-[#C87A65] font-semibold mb-2">Première pose d'extensions ?</p>
                <a href="index.php?url=home#contact" class="inline-block text-[#4A2E30] hover:text-[#C87A65] font-medium underline text-sm transition-colors">
                    Posez vos questions à nos praticiennes
                </a>
            </div>
        </div>
    </main>

    <!-- 4. BOUTON DE RETOUR RAPIDE -->
    <div class="text-center pb-12">
        <a href="index.php?url=home" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#C87A65] hover:text-[#A3523D] transition-colors group">
            <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Retour à l'accueil
        </a>
    </div>

</div>

<?php 
// Inclusion simple pour le routeur global MVC
include 'footer.php'; 
?>