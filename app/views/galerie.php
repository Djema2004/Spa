<?php 
// app/views/galerie.php

// Inclusion du header partagé
include __DIR__ . '/header.php'; 
?>

<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen font-sans py-20 px-6">
    <div class="max-w-6xl mx-auto space-y-12">
        
        <div class="text-center space-y-2">
            <span class="text-[#C87A65] text-xs tracking-widest uppercase font-semibold">Immersion Visuelle</span>
            <h1 class="text-4xl md:text-5xl font-serif font-black text-[#4A2E30] tracking-tight">Notre Havre de Paix</h1>
            <div class="w-12 h-0.5 bg-[#C87A65] mx-auto mt-4"></div>
            <p class="text-sm sm:text-base text-[#5C3A3C]/80 font-light max-w-md mx-auto pt-2">
                Découvrez l'atmosphère chaleureuse et raffinée de nos cabines de soins et espaces de relaxation.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-6">
            
            <div class="group relative overflow-hidden rounded-3xl shadow-sm hover:shadow-md border-4 border-white aspect-square bg-[#FCECE7] transition-all duration-300 hover:-translate-y-1">
                <img src="public/images/photo1.jpg" alt="Espace accueil" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <span class="text-white text-sm font-medium tracking-wide">L'Accueil Privé & Chaleureux</span>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-3xl shadow-sm hover:shadow-md border-4 border-white aspect-square bg-[#FCECE7] transition-all duration-300 hover:-translate-y-1">
                <img src="public/images/photo2.jpg" alt="Cabine de soin" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <span class="text-white text-sm font-medium tracking-wide">Les Cabines de Soin Tamisées</span>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-3xl shadow-sm hover:shadow-md border-4 border-white aspect-square bg-[#FCECE7] transition-all duration-300 hover:-translate-y-1">
                <img src="public/images/photo3.jpg" alt="Salon de relaxation" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <span class="text-white text-sm font-medium tracking-wide">Le Salon de Relaxation</span>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-3xl shadow-sm hover:shadow-md border-4 border-white aspect-square bg-[#FCECE7] transition-all duration-300 hover:-translate-y-1">
                <img src="public/images/photo4.jpg" alt="Huiles et produits" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <span class="text-white text-sm font-medium tracking-wide">Produits & Huiles Aromatiques</span>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-3xl shadow-sm hover:shadow-md border-4 border-white aspect-square bg-[#FCECE7] transition-all duration-300 hover:-translate-y-1">
                <img src="public/images/photo5.jpg" alt="Soin du visage" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <span class="text-white text-sm font-medium tracking-wide">Soins d'Élite Rituels</span>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-3xl shadow-sm hover:shadow-md border-4 border-white aspect-square bg-[#FCECE7] transition-all duration-300 hover:-translate-y-1">
                <img src="public/images/photo6.jpg" alt="Espace Yoga et détente" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <span class="text-white text-sm font-medium tracking-wide">Harmonie & Yoga</span>
                </div>
            </div>

        </div>

        <div class="text-center pt-8">
            <a href="index.php?url=home" class="inline-flex items-center gap-2 text-sm font-semibold text-[#C87A65] hover:text-[#A3523D] transition-colors underline">
                <i class="fa-solid fa-arrow-left-long"></i> Retour à l'accueil
            </a>
        </div>

    </div>
</div>

<?php 
// Inclusion du footer partagé
include __DIR__ . '/footer.php'; 
?>