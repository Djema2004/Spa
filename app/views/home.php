<?php 
// 1. CORRECTION INCLUSION : Inclusion propre depuis le dossier des vues partagées
include __DIR__ . '/header.php'; 
?>

<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen font-sans flex flex-col justify-between">

    <main class="hero flex-1 flex items-center justify-center px-6 py-16 sm:py-24 max-w-7xl mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">
            
            <div class="space-y-8 text-center lg:text-left">
                <span class="inline-flex items-center gap-2 bg-[#FCD7CC] text-[#5C3A3C] text-xs font-semibold tracking-widest uppercase px-5 py-2 rounded-full shadow-sm">
                    🌸 Une oasis de sérénité & de soin
                </span>

                <h1 class="text-4xl sm:text-5xl md:text-6xl font-serif font-black tracking-tight text-[#4A2E30] leading-tight">
                    L'Équilibre Parfait du <br class="hidden lg:inline">
                    <span class="bg-gradient-to-r from-[#C87A65] to-[#A3523D] bg-clip-text text-transparent">
                        Corps & de l'Esprit
                    </span>
                </h1>
                
                <p class="text-base sm:text-lg text-[#5C3A3C]/90 leading-relaxed max-w-xl mx-auto lg:mx-0 font-light">
                    Découvrez l'expérience ultime de la relaxation à travers nos rituels de soins d'exception. Laissez nos thérapeutes experts sublimer votre bien-être dans un cadre somptueux.
                </p>
                
                <div class="pt-4">
                    <a href="index.php?url=register" class="inline-block bg-[#C87A65] hover:bg-[#A3523D] text-white font-semibold text-sm sm:text-base px-10 py-4 rounded-full transition-all duration-300 shadow-md hover:shadow-lg shadow-[#C87A65]/20 tracking-wider hover:-translate-y-0.5 transform no-underline">
                        Réserver un Instant Privé
                    </a> 
                </div>
            </div>

            <div class="relative flex justify-center lg:justify-end">
                <div class="absolute -inset-2 bg-[#FCECE7] rounded-[2rem] transform rotate-3 scale-95 pointer-events-none border border-[#FCD7CC]/40"></div>
                
                <div class="relative overflow-hidden rounded-[2rem] shadow-xl border-4 border-white max-w-md sm:max-w-lg aspect-[4/3] lg:aspect-square w-full">
                    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80" 
                         alt="Ambiance relaxante Dream Spa" 
                         class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700 ease-out">
                </div>
            </div>

        </div>
    </main>

    <section id="services" class="px-6 py-20 bg-[#FCECE7] border-t border-[#FCD7CC]/40 shadow-inner">
        <div class="max-w-6xl mx-auto space-y-12">
            
            <div class="text-center space-y-2">
                <h2 class="text-3xl font-serif font-bold text-[#4A2E30] tracking-wide">Nos Prestations Signatures</h2>
                <p class="text-[#C87A65] text-xs tracking-widest uppercase font-semibold">Des rituels conçus exclusivement pour vous</p>
                <div class="w-12 h-0.5 bg-[#C87A65] mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6">
                
                <!-- Service 1: Manucure -->
                <a href="index.php?url=manucure" class="group bg-[#FAF7F2] border border-[#FCD7CC]/50 rounded-3xl p-8 transition-all duration-300 hover:-translate-y-1 shadow-sm hover:shadow-md hover:border-[#C87A65]/40 flex flex-col justify-between text-left no-underline">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FCECE7] flex items-center justify-center text-[#C87A65] text-xl group-hover:bg-[#C87A65] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-hand-sparkles"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-[#4A2E30]">Manucure & Pédicure</h3>
                            <i class="fa-solid fa-arrow-right text-sm text-[#C87A65] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                        </div>
                        <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed">
                            Soin complet des ongles, gommage hydratant et pose de vernis pour des mains et des pieds impeccables et sublimés.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-[#FCD7CC]/30 pt-4">
                        <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase">À partir de 1 000gdes</span>
                        <span class="text-xs font-semibold text-[#4A2E30] underline group-hover:text-[#C87A65] transition-colors">Découvrir les soins</span>
                    </div>
                </a>

                <!-- Service 2: Massage -->
                <a href="index.php?url=massage" class="group bg-[#FAF7F2] border border-[#FCD7CC]/50 rounded-3xl p-8 transition-all duration-300 hover:-translate-y-1 shadow-sm hover:shadow-md hover:border-[#C87A65]/40 flex flex-col justify-between text-left no-underline">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FCECE7] flex items-center justify-center text-[#C87A65] text-xl group-hover:bg-[#C87A65] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-spa"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-[#4A2E30]">Massage Relaxant</h3>
                            <i class="fa-solid fa-arrow-right text-sm text-[#C87A65] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                        </div>
                        <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed">
                            Un massage fluide aux huiles essentielles pour dénouer les tensions musculaires profondes et libérer complètement l'esprit.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-[#FCD7CC]/30 pt-4">
                        <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase">À partir de 10 000gdes</span>
                        <span class="text-xs font-semibold text-[#4A2E30] underline group-hover:text-[#C87A65] transition-colors">Découvrir les soins</span>
                    </div>
                </a>

                <!-- Service 3: Soins du Visage -->
                <a href="index.php?url=soins-visage" class="group bg-[#FAF7F2] border border-[#FCD7CC]/50 rounded-3xl p-8 transition-all duration-300 hover:-translate-y-1 shadow-sm hover:shadow-md hover:border-[#C87A65]/40 flex flex-col justify-between text-left no-underline">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FCECE7] flex items-center justify-center text-[#C87A65] text-xl group-hover:bg-[#C87A65] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-face-smile-beam"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-[#4A2E30]">Soins du Visage</h3>
                            <i class="fa-solid fa-arrow-right text-sm text-[#C87A65] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                        </div>
                        <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed">
                            Cure de jouvence sur-mesure combinant nettoyage délicat, hydratation intense et modelage liftant pour un teint éclatant.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-[#FCD7CC]/30 pt-4">
                        <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase">À partir de 1 500gdes</span>
                        <span class="text-xs font-semibold text-[#4A2E30] underline group-hover:text-[#C87A65] transition-colors">Découvrir les soins</span>
                    </div>
                </a>

                <!-- Service 4: Extension de Cils -->
                <a href="index.php?url=extensions" class="group bg-[#FAF7F2] border border-[#FCD7CC]/50 rounded-3xl p-8 transition-all duration-300 hover:-translate-y-1 shadow-sm hover:shadow-md hover:border-[#C87A65]/40 flex flex-col justify-between text-left no-underline">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FCECE7] flex items-center justify-center text-[#C87A65] text-xl group-hover:bg-[#C87A65] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-[#4A2E30]">Extension de Cils</h3>
                            <i class="fa-solid fa-arrow-right text-sm text-[#C87A65] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                        </div>
                        <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed">
                            Pose cil à cil ou volume russe pour intensifier et sublimer votre regard de manière naturelle, durable et glamour.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-[#FCD7CC]/30 pt-4">
                        <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase">À partir de 2 500gdes</span>
                        <span class="text-xs font-semibold text-[#4A2E30] underline group-hover:text-[#C87A65] transition-colors">Découvrir les soins</span>
                    </div>
                </a>

                <!-- Service 5: Épilation Délicate -->
                <a href="index.php?url=epilation" class="group bg-[#FAF7F2] border border-[#FCD7CC]/50 rounded-3xl p-8 transition-all duration-300 hover:-translate-y-1 shadow-sm hover:shadow-md hover:border-[#C87A65]/40 flex flex-col justify-between text-left no-underline">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FCECE7] flex items-center justify-center text-[#C87A65] text-xl group-hover:bg-[#C87A65] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-[#4A2E30]">Épilation Délicate</h3>
                            <i class="fa-solid fa-arrow-right text-sm text-[#C87A65] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                        </div>
                        <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed">
                            Technique douce à la cire tiède enrichie pour une peau soyeuse, parfaitement lisse et un confort cutané absolu.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-[#FCD7CC]/30 pt-4">
                        <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase">À partir de 750gdes</span>
                        <span class="text-xs font-semibold text-[#4A2E30] underline group-hover:text-[#C87A65] transition-colors">Découvrir les soins</span>
                    </div>
                </a>

                <!-- Service 6: Le Sauna Finlandais -->
                <a href="index.php?url=sauna" class="group bg-[#FAF7F2] border border-[#FCD7CC]/50 rounded-3xl p-8 transition-all duration-300 hover:-translate-y-1 shadow-sm hover:shadow-md hover:border-[#C87A65]/40 flex flex-col justify-between text-left no-underline">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FCECE7] flex items-center justify-center text-[#C87A65] text-xl group-hover:bg-[#C87A65] group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-fire-burner"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-[#4A2E30]">Le Sauna Finlandais</h3>
                            <i class="fa-solid fa-arrow-right text-sm text-[#C87A65] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                        </div>
                        <p class="text-sm text-[#5C3A3C]/90 font-light leading-relaxed">
                            Plongez dans une chaleur sèche bienfaisante. Idéal pour éliminer les impuretés de la peau, stimuler la circulation et relâcher les muscles.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-[#FCD7CC]/30 pt-4">
                        <span class="text-xs font-bold text-[#C87A65] tracking-wider uppercase">Session à partir de 2 000gdes</span>
                        <span class="text-xs font-semibold text-[#4A2E30] underline group-hover:text-[#C87A65] transition-colors">Découvrir l'espace</span>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <!-- SECTION GALERIE AVEC CAROUSEL À DEUX IMAGES ET BOUTON DE LIEN -->
    <section id="galerie" class="px-6 py-20 bg-[#FAF7F2]">
        <div class="max-w-6xl mx-auto space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-3xl font-serif font-bold text-[#4A2E30] tracking-wide">Visitez Notre Établissement</h2>
                <p class="text-[#C87A65] text-xs tracking-widest uppercase font-semibold">Un aperçu de votre futur havre de paix</p>
                <div class="w-12 h-0.5 bg-[#C87A65] mx-auto mt-4"></div>
            </div>

            <!-- Conteneur Principal du Slider -->
            <div class="relative overflow-hidden max-w-5xl mx-auto px-4">
                <!-- Fenêtre d'affichage (Track) -->
                <div id="carousel-track" class="flex gap-6 transition-transform duration-1000 ease-in-out">
                    
                    <!-- Image 1 -->
                    <div class="w-full md:w-1/2 flex-shrink-0 relative h-80 rounded-3xl overflow-hidden shadow-md border-2 border-white">
                        <img src="https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?auto=format&fit=crop&w=800&q=80" alt="Espace accueil raffiné" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/70 via-transparent to-transparent flex items-end p-6">
                            <span class="text-white text-base font-medium tracking-wide">L'Accueil Privé & Chaleureux</span>
                        </div>
                    </div>

                    <!-- Image 2 -->
                    <div class="w-full md:w-1/2 flex-shrink-0 relative h-80 rounded-3xl overflow-hidden shadow-md border-2 border-white">
                        <img src="https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&w=800&q=80" alt="Cabine de soin tamisée" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/70 via-transparent to-transparent flex items-end p-6">
                            <span class="text-white text-base font-medium tracking-wide">Les Cabines de Soin</span>
                        </div>
                    </div>

                    <!-- Image 3 -->
                    <div class="w-full md:w-1/2 flex-shrink-0 relative h-80 rounded-3xl overflow-hidden shadow-md border-2 border-white">
                        <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80" alt="Salon de thé et relaxation" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/70 via-transparent to-transparent flex items-end p-6">
                            <span class="text-white text-base font-medium tracking-wide">Le Salon de Relaxation</span>
                        </div>
                    </div>

                    <!-- Image 4 -->
                    <div class="w-full md:w-1/2 flex-shrink-0 relative h-80 rounded-3xl overflow-hidden shadow-md border-2 border-white">
                        <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=800&q=80" alt="Soins et huiles" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#4A2E30]/70 via-transparent to-transparent flex items-end p-6">
                            <span class="text-white text-base font-medium tracking-wide">Produits & Huiles Aromatiques</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- BOUTON AJOUTÉ : ESPACE POUR ENTRER DANS LA PAGE IMAGE -->
            <div class="text-center pt-4">
                <a href="index.php?url=galerie" class="inline-flex items-center gap-3 bg-[#FAF7F2] hover:bg-[#FCECE7] text-[#C87A65] hover:text-[#A3523D] border-2 border-[#C87A65]/40 hover:border-[#A3523D] font-semibold text-sm px-8 py-3.5 rounded-full transition-all duration-300 tracking-wider shadow-sm hover:shadow no-underline group">
                    <i class="fa-regular fa-images text-base group-hover:scale-110 transition-transform"></i>
                    Voir toute la galerie photos
                </a>
            </div>

        </div>
    </section>

    <section id="contact" class="bg-[#FAF7F2] border-t border-[#FCD7CC]/30 py-16">
        <div class="max-w-md mx-auto px-6 text-center space-y-2">
            <h2 class="text-2xl font-serif font-bold text-[#4A2E30]">Prendre Contact</h2>
        </div>
    </section>

<?php 
// Inclusion correcte du footer
include __DIR__ . '/footer.php'; 
?>

<!-- SCRIPT JAVASCRIPT POUR LE CAROUSEL -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const track = document.getElementById('carousel-track');
    let currentIndex = 0;

    function nextSlide() {
        const isMobile = window.innerWidth < 768;
        const totalSlides = track.children.length;
        const maxIndex = isMobile ? totalSlides - 1 : totalSlides - 2;

        if (currentIndex >= maxIndex) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }

        const slideWidth = track.children[0].getBoundingClientRect().width;
        const amountToMove = currentIndex * (slideWidth + 24); 

        track.style.transform = `translateX(-${amountToMove}px)`;
    }

    setInterval(nextSlide, 4000);

    window.addEventListener('resize', () => {
        track.style.transform = `translateX(0px)`;
        currentIndex = 0;
    });
});
</script>