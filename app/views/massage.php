<?php 
// Inclusion du header (ajustez le chemin selon l'emplacement exact de ce fichier)
include __DIR__ . '/header.php'; 
?>

<!-- Fond de page : Blanc cassé/Crème (bg-[#FAF7F2]) et texte Vieux Rose foncé (text-[#5C3A3C]) -->
<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen font-sans flex flex-col justify-between">

    <!-- 1. EN-TÊTE DE LA PAGE (Hero de la catégorie) -->
    <header class="relative bg-[#FCECE7] py-16 px-6 border-b border-[#FCD7CC]/40 text-center space-y-4 shadow-inner">
        <span class="text-xs font-semibold tracking-widest uppercase bg-[#FCD7CC] px-4 py-1.5 rounded-full inline-block">
            ✨ Rituels Corporels
        </span>
        <h1 class="text-4xl md:text-5xl font-serif font-black text-[#4A2E30]">
            Nos Massages Relaxants
        </h1>
        <p class="text-base md:text-lg text-[#5C3A3C]/90 font-light max-w-2xl mx-auto leading-relaxed">
            Évadez-vous le temps d'un soin unique. Nos massages sont conçus pour harmoniser le corps et l'esprit, libérer les tensions et vous offrir un moment de pure plénitude.
        </p>
        <div class="w-16 h-0.5 bg-[#C87A65] mx-auto pt-0.5"></div>
    </header>

    <!-- 2. SECTION DE LA CARTE DES SOINS (Grille des différents massages) -->
    <main class="max-w-7xl mx-auto px-6 py-16 w-full flex-1">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Massage 1 : Massage Suédois / Relaxant Classique -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?auto=format&fit=crop&w=600&q=80" alt="Massage Suédois" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">60 ou 90 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Le Relaxant Suédois</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Un massage fluide et enveloppant combinant effleurages et pétrissages pour dénouer les nœuds musculaires et stimuler la circulation sanguine.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">10 000 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Le Relaxant Suédois">
                        <input type="hidden" name="prix_soin" value="10000.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

            <!-- Massage 2 : Massage aux Pierres Chaudes -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&w=600&q=80" alt="Massage Pierres Chaudes" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">75 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Rituel aux Pierres Chaudes</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            La chaleur volcanique des pierres de basalte fond sur votre peau, diffusant une relaxation thermique profonde qui élimine le stress accumulé.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">12 500 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Rituel aux Pierres Chaudes">
                        <input type="hidden" name="prix_soin" value="12500.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

            <!-- Massage 3 : Massage Aromatique aux Huiles Essentielles -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=600&q=80" alt="Massage Aromatique" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">60 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Évasion Aromatique</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Un voyage sensoriel sur-mesure. Choisissez votre synergie d’huiles essentielles (lavande apaisante, agrumes énergisants ou eucalyptus).
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">11 000 gdes</span>
                    
                    <!-- Formulaire de réservation corrigé vers reservation/start -->
                    <form action="index.php?url=reservation/start" method="POST">
                        <input type="hidden" name="service_nom" value="Évasion Aromatique">
                        <input type="hidden" name="prix_soin" value="11000.00">
                        
                        <button type="submit" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors cursor-pointer">
                            Réserver
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- 3. ZONE D'INFORMATION ADDITIONNELLE -->
        <div class="mt-16 bg-[#FCECE7]/60 rounded-3xl p-8 border border-[#FCD7CC]/30 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-4">
                <h3 class="text-2xl font-serif font-bold text-[#4A2E30]">Personnalisez votre instant</h3>
                <p class="text-sm font-light leading-relaxed">
                    Chaque soin peut être adapté selon vos préférences de pression (douce, moyenne, profonde) et vos zones de tensions spécifiques. Signalez-le à votre thérapeute lors de votre arrivée.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">🍃 Produits 100% Organiques</span>
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">🎵 Ambiance Sonore au Choix</span>
                </div>
            </div>
            <div class="text-center md:text-right">
                <p class="text-xs uppercase tracking-widest text-[#C87A65] font-semibold mb-2">Une question avant de réserver ?</p>
                <a href="#contact" class="inline-block text-[#4A2E30] hover:text-[#C87A65] font-medium underline text-sm transition-colors">
                    Consulter notre FAQ ou nous contacter
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
// Inclusion du footer
include __DIR__ . '/footer.php'; 
?>