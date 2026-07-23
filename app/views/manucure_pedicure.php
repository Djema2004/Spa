<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php'; 
?>

<!-- Fond de page crème et texte Vieux Rose -->
<main class="flex-1 bg-[#FAF7F2] text-[#5C3A3C] py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- En-tête de la catégorie -->
    <div class="max-w-3xl mx-auto text-center mb-16">
        <span class="text-xs font-semibold tracking-widest uppercase text-[#C87A65] bg-[#FCECE7] px-4 py-1.5 rounded-full">Soin des Mains & des Pieds</span>
        <h1 class="text-4xl sm:text-5xl font-serif font-black text-[#4A2E30] mt-4 mb-4">Manucure & Pédicure</h1>
        <div class="w-24 h-0.5 bg-[#FCD7CC] mx-auto mb-4"></div>
        <p class="text-base sm:text-lg text-[#5C3A3C]/80 font-light leading-relaxed">
            Offrez à vos mains et vos pieds une parenthèse de douceur. Des soins attentionnés, des rituels relaxants et une finition parfaite pour sublimer votre beauté naturelle.
        </p>
    </div>

    <!-- Grille des prestations (Cartes) -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <!-- Prestation 1 : Manucure Spa Signature -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-[#FCD7CC]/10 border border-[#FCD7CC]/30 overflow-hidden flex flex-col group transition-all duration-300 hover:shadow-2xl hover:shadow-[#FCD7CC]/20">
            <div class="relative overflow-hidden h-64">
                <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?auto=format&fit=crop&q=80&w=600" 
                     alt="Manucure Spa" 
                     class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105">
                <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-md text-[#4A2E30] font-serif font-black px-4 py-1.5 rounded-full text-sm shadow-sm border border-[#FCD7CC]/30">1 350 gdes</span>
            </div>
            <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-serif font-bold text-[#4A2E30] mb-2">Manucure Rituel Douceur</h3>
                    <p class="text-xs text-[#C87A65] font-medium mb-3"><i class="fa-regular fa-clock mr-1"></i> 45 minutes</p>
                    <p class="text-sm text-[#5C3A3C]/80 font-light leading-relaxed mb-6">
                        Un soin complet comprenant le limage, le traitement des cuticules, un gommage exfoliant au sucre de canne et un modelage relaxant aux huiles essentielles.
                    </p>
                </div>
                
                <!-- Formulaire vers reservation/start -->
                <form action="index.php?url=reservation/start" method="POST" class="mt-auto">
                    <input type="hidden" name="service_nom" value="Manucure Rituel Douceur">
                    <input type="hidden" name="prix_soin" value="1350.00">
                    
                    <button type="submit" 
                            class="w-full block text-center bg-[#C87A65] hover:bg-[#A3523D] text-white font-semibold py-3 rounded-xl transition-all duration-300 text-sm shadow-md shadow-[#C87A65]/10 tracking-wider hover:-translate-y-0.5 transform cursor-pointer">
                        <i class="fa-regular fa-calendar-check mr-1.5"></i> Réserver (Acompte 30%)
                    </button>
                </form>
            </div>
        </div>

        <!-- Prestation 2 : Pédicure Spa Relaxante -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-[#FCD7CC]/10 border border-[#FCD7CC]/30 overflow-hidden flex flex-col group transition-all duration-300 hover:shadow-2xl hover:shadow-[#FCD7CC]/20">
            <div class="relative overflow-hidden h-64">
                <img src="https://images.unsplash.com/photo-1519415510236-8a5d6404652c?auto=format&fit=crop&q=80&w=600" 
                     alt="Pédicure Spa" 
                     class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105">
                <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-md text-[#4A2E30] font-serif font-black px-4 py-1.5 rounded-full text-sm shadow-sm border border-[#FCD7CC]/30">1 650 gdes</span>
            </div>
            <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-serif font-bold text-[#4A2E30] mb-2">Pédicure Spa Sensorielle</h3>
                    <p class="text-xs text-[#C87A65] font-medium mb-3"><i class="fa-regular fa-clock mr-1"></i> 60 minutes</p>
                    <p class="text-sm text-[#5C3A3C]/80 font-light leading-relaxed mb-6">
                        Bain de pieds relaxant aux sels de l'Himalaya, gommage, soin des callosités et des ongles, suivi d'un massage divin hydratant au beurre de karité.
                    </p>
                </div>
                
                <!-- Formulaire vers reservation/start -->
                <form action="index.php?url=reservation/start" method="POST" class="mt-auto">
                    <input type="hidden" name="service_nom" value="Pédicure Spa Sensorielle">
                    <input type="hidden" name="prix_soin" value="1650.00">
                    
                    <button type="submit" 
                            class="w-full block text-center bg-[#C87A65] hover:bg-[#A3523D] text-white font-semibold py-3 rounded-xl transition-all duration-300 text-sm shadow-md shadow-[#C87A65]/10 tracking-wider hover:-translate-y-0.5 transform cursor-pointer">
                        <i class="fa-regular fa-calendar-check mr-1.5"></i> Réserver (Acompte 30%)
                    </button>
                </form>
            </div>
        </div>

        <!-- Prestation 3 : Pose de Vernis Semi-Permanent -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-[#FCD7CC]/10 border border-[#FCD7CC]/30 overflow-hidden flex flex-col group transition-all duration-300 hover:shadow-2xl hover:shadow-[#FCD7CC]/20">
            <div class="relative overflow-hidden h-64">
                <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?auto=format&fit=crop&q=80&w=600"
                     alt="Pose de vernis" 
                     class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105">
                <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-md text-[#4A2E30] font-serif font-black px-4 py-1.5 rounded-full text-sm shadow-sm border border-[#FCD7CC]/30">1 050 gdes</span>
            </div>
            <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-serif font-bold text-[#4A2E30] mb-2">Beauté & Semi-Permanent</h3>
                    <p class="text-xs text-[#C87A65] font-medium mb-3"><i class="fa-regular fa-clock mr-1"></i> 40 minutes</p>
                    <p class="text-sm text-[#5C3A3C]/80 font-light leading-relaxed mb-6">
                        Mise en forme des ongles suivie d'une pose de vernis semi-permanent avec la couleur de votre choix parmi notre large gamme prestigieuse. Tenue 2 semaines.
                    </p>
                </div>
                
                <!-- Formulaire vers reservation/start -->
                <form action="index.php?url=reservation/start" method="POST" class="mt-auto">
                    <input type="hidden" name="service_nom" value="Beauté & Semi-Permanent">
                    <input type="hidden" name="prix_soin" value="1050.00">
                    
                    <button type="submit" 
                            class="w-full block text-center bg-[#C87A65] hover:bg-[#A3523D] text-white font-semibold py-3 rounded-xl transition-all duration-300 text-sm shadow-md shadow-[#C87A65]/10 tracking-wider hover:-translate-y-0.5 transform cursor-pointer">
                        <i class="fa-regular fa-calendar-check mr-1.5"></i> Réserver (Acompte 30%)
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Note d'information complémentaire en bas -->
    <div class="max-w-3xl mx-auto text-center mt-16 p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-[#FCD7CC]/40">
        <p class="text-xs text-[#5C3A3C]/70 italic">
            * Pour toute annulation ou modification de rendez-vous, merci de nous prévenir au minimum 24 heures à l'avance. Tous nos outils de soin sont rigoureusement stérilisés avant chaque séance.
        </p>
    </div>

</main>

<?php include __DIR__ . '/footer.php'; ?>