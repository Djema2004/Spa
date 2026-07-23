<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclusion simplifiée pour le routeur global MVC
include 'header.php'; 
?>

<!-- Fond de page : Blanc cassé/Crème (bg-[#FAF7F2]) et texte Vieux Rose foncé (text-[#5C3A3C]) -->
<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen font-sans flex flex-col justify-between">

    <!-- 1. EN-TÊTE DE LA PAGE (Hero de la catégorie) -->
    <header class="relative bg-[#FCECE7] py-16 px-6 border-b border-[#FCD7CC]/40 text-center space-y-4 shadow-inner">
        <span class="text-xs font-semibold tracking-widest uppercase bg-[#FCD7CC] px-4 py-1.5 rounded-full inline-block">
            ✨ Douceur Absolue
        </span>
        <h1 class="text-4xl md:text-5xl font-serif font-black text-[#4A2E30]">
            Épilation Délicate
        </h1>
        <p class="text-base md:text-lg text-[#5C3A3C]/90 font-light max-w-2xl mx-auto leading-relaxed">
            Prenez soin de votre peau grâce à nos techniques d'épilation ultra-douces. Nous utilisons des cires tièdes de haute qualité, enrichies en agents apaisants, pour un confort optimal et un résultat soyeux de longue durée.
        </p>
        <div class="w-16 h-0.5 bg-[#C87A65] mx-auto pt-0.5"></div>
    </header>

    <!-- 2. SECTION DES PRESTATIONS (Grille des différentes formules) -->
    <main class="max-w-7xl mx-auto px-6 py-16 w-full flex-1">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Prestation 1 : Zones Visage -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=600&q=80" alt="Épilation Visage" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">15-20 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Zones Visage</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Dessin ou entretien des sourcils à la cire et à la pince, épilation de la lèvre supérieure ou du menton. Idéal pour restructurer et illuminer le visage.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">750 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Épilation - Zones Visage">
                        <input type="hidden" name="prix_soin" value="750.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

            <!-- Prestation 2 : Demi-Jambes ou Bras -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&w=600&q=80" alt="Épilation Jambes" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">30 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Demi-Jambes ou Bras</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Épilation rapide et soignée des demi-jambes ou des bras complets. Application d'une huile post-épilatoire au calendula pour apaiser instantanément.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">1 500 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Épilation - Demi-Jambes ou Bras">
                        <input type="hidden" name="prix_soin" value="1500.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

            <!-- Prestation 3 : Forfait Corps Complet -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80" alt="Forfait Épilation" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">60 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Forfait Corps Complet</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Notre forfait complet incluant jambes entières, maillot (au choix) et aisselles. Une formule avantageuse pour une tranquillité d'esprit absolue pendant des semaines.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">3 500 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Épilation - Forfait Corps Complet">
                        <input type="hidden" name="prix_soin" value="3500.00">
                        
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
                <h3 class="text-2xl font-serif font-bold text-[#4A2E30]">Une Charte de Qualité Rigoureuse</h3>
                <p class="text-sm font-light leading-relaxed">
                    Parce que votre santé et votre confort cutané sont notre priorité absolue, nous utilisons exclusivement de la cire jetable à usage unique et appliquons un protocole rigoureux de désinfection avant et après chaque séance.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">✨ Cire Hydratante Haute Tolérance</span>
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">🧼 Hygiène Stricte & Matériel Jetable</span>
                </div>
            </div>
            <div class="text-center md:text-right">
                <p class="text-xs uppercase tracking-widest text-[#C87A65] font-semibold mb-2">Des exigences particulières ?</p>
                <a href="index.php?url=home#contact" class="inline-block text-[#4A2E30] hover:text-[#C87A65] font-medium underline text-sm transition-colors">
                    Contactez-nous pour un forfait personnalisé
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
// Inclusion simplifiée pour le routeur global MVC
include 'footer.php'; 
?>