<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclusion propre pour le routeur global MVC
include 'header.php'; 
?>

<!-- Fond de page : Blanc cassé/Crème (bg-[#FAF7F2]) et texte Vieux Rose foncé (text-[#5C3A3C]) -->
<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen font-sans flex flex-col justify-between">

    <!-- 1. EN-TÊTE DE LA PAGE (Hero de la catégorie) -->
    <header class="relative bg-[#FCECE7] py-16 px-6 border-b border-[#FCD7CC]/40 text-center space-y-4 shadow-inner">
        <span class="text-xs font-semibold tracking-widest uppercase bg-[#FCD7CC] px-4 py-1.5 rounded-full inline-block">
            ✨ Éclat & Jeunesse
        </span>
        <h1 class="text-4xl md:text-5xl font-serif font-black text-[#4A2E30]">
            Soins du Visage Signatures
        </h1>
        <p class="text-base md:text-lg text-[#5C3A3C]/90 font-light max-w-2xl mx-auto leading-relaxed">
            Offrez à votre peau une véritable cure de jouvence. Nos soins du visage sur-mesure allient techniques expertes et produits délicats pour révéler votre éclat naturel.
        </p>
        <div class="w-16 h-0.5 bg-[#C87A65] mx-auto pt-0.5"></div>
    </header>

    <!-- 2. SECTION DES SOINS (Grille des prestations) -->
    <main class="max-w-7xl mx-auto px-6 py-16 w-full flex-1">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Soin 1 : Pureté Radiance -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=600&q=80" alt="Soin Visage Purifiant" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">45 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Pureté Radiance</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Un nettoyage en profondeur combinant gommage doux, bain de vapeur et masque détoxifiant pour libérer la peau des impuretés et affiner le grain.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">1 500 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Visage - Pureté Radiance">
                        <input type="hidden" name="prix_soin" value="1500.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

            <!-- Soin 2 : Bain d'Hydratation Absolue -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600&q=80" alt="Soin Hydratation Visage" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">60 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Bain d'Hydratation Absolue</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Idéal pour les peaux assoiffées. Ce soin infuse de l'acide hyaluronique et des sérums botaniques grâce à un modelage hautement ressourçant.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">2 500 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Visage - Bain d'Hydratation Absolue">
                        <input type="hidden" name="prix_soin" value="2500.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

            <!-- Soin 3 : Le Rituel Suprême Lift -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=600&q=80" alt="Soin Visage Anti-âge" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">75 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Le Rituel Suprême Lift</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Inspiré des rituels japonais, ce massage facial liftant stimule intensément le collagène, redessine l'ovale du visage et lisse les ridules.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">4 000 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Visage - Le Rituel Suprême Lift">
                        <input type="hidden" name="prix_soin" value="4000.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- 3. ZONE D'INFORMATION -->
        <div class="mt-16 bg-[#FCECE7]/60 rounded-3xl p-8 border border-[#FCD7CC]/30 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-4">
                <h3 class="text-2xl font-serif font-bold text-[#4A2E30]">Diagnostic de peau offert</h3>
                <p class="text-sm font-light leading-relaxed">
                    Avant de commencer votre soin, nos praticiennes réalisent une analyse complète de votre épiderme pour adapter précisément les masques, huiles et sérums appliqués à la nature de votre peau.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">🧪 Formules Sur-Mesure</span>
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">🌿 Extraits Naturels & Bio</span>
                </div>
            </div>
            <div class="text-center md:text-right">
                <p class="text-xs uppercase tracking-widest text-[#C87A65] font-semibold mb-2">Besoin d'un conseil ?</p>
                <a href="index.php?url=home#contact" class="inline-block text-[#4A2E30] hover:text-[#C87A65] font-medium underline text-sm transition-colors">
                    Demander une recommandation personnalisée
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
// Inclusion propre pour le routeur global MVC
include 'footer.php'; 
?>