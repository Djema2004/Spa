<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclusion du header situé dans le même sous-dossier des vues
include __DIR__ . '/header.php'; 
?>

<!-- Fond de page : Blanc cassé/Crème (bg-[#FAF7F2]) et texte Vieux Rose foncé (text-[#5C3A3C]) -->
<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen font-sans flex flex-col justify-between">

    <!-- 1. EN-TÊTE DE LA PAGE (Hero de la catégorie) -->
    <header class="relative bg-[#FCECE7] py-16 px-6 border-b border-[#FCD7CC]/40 text-center space-y-4 shadow-inner">
        <span class="text-xs font-semibold tracking-widest uppercase bg-[#FCD7CC] px-4 py-1.5 rounded-full inline-block">
            🔥 Chaleur Bienfaisante
        </span>
        <h1 class="text-4xl md:text-5xl font-serif font-black text-[#4A2E30]">
            Le Sauna Finlandais
        </h1>
        <p class="text-base md:text-lg text-[#5C3A3C]/90 font-light max-w-2xl mx-auto leading-relaxed">
            Plongez dans l'expérience authentique de la chaleur sèche nordique. Une parenthèse idéale pour purifier votre épiderme, stimuler vos défenses naturelles et relâcher instantanément les tensions nerveuses et musculaires.
        </p>
        <div class="w-16 h-0.5 bg-[#C87A65] mx-auto pt-0.5"></div>
    </header>

    <!-- 2. SECTION DES OFFRES (Grille des différentes formules d'accès) -->
    <main class="max-w-7xl mx-auto px-6 py-16 w-full flex-1">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Formule 1 : Session Découverte Solo -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=600&q=80" alt="Sauna Solo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">30 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Instant Solo</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Profitez d'un accès individuel à notre cabine en bois de cèdre. Une pause détente rapide mais hautement réparatrice après une longue journée. Servie avec une boisson détox.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">2 000 gdes</span>
                    <a href="/spa/app/views/register.php" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors">
                        Réserver
                    </a>
                </div>
            </div>

            <!-- Formule 2 : Escale Harmonie (Solo étendu) -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&w=600&q=80" alt="Sauna Harmonie" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">60 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Rituel Harmonie</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Prenez le temps d'effectuer plusieurs cycles de sudation entrecoupés de douches fraîches et de repos. Un drap de bain soyeux et une infusion bio fine vous sont fournis.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">3 500 gdes</span>
                    <a href="/spa/app/views/register.php" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors">
                        Réserver
                    </a>
                </div>
            </div>

            <!-- Formule 3 : Session Privative Duo -->
            <div class="bg-white border border-[#FCD7CC]/40 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?auto=format&fit=crop&w=600&q=80" alt="Sauna Duo Privé" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 right-4 bg-[#FAF7F2]/95 backdrop-blur-sm text-[#C87A65] text-xs font-bold px-3 py-1 rounded-full border border-[#FCD7CC]/30">60 min</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-xl font-bold text-[#4A2E30]">Parenthèse Complice</h3>
                        <p class="text-sm font-light text-[#5C3A3C]/90 leading-relaxed">
                            Partagez ce moment de bien-être absolu à deux. La cabine de sauna vous est entièrement privatisée. Comprend deux cocktails rafraîchissants maison et un assortiment de fruits.
                        </p>
                    </div>
                </div>
                <div class="p-6 pt-0 flex items-center justify-between border-t border-[#FCD7CC]/20 mt-4">
                    <span class="text-sm font-black text-[#C87A65]">5 500 gdes</span>
                    <a href="/spa/app/views/register.php" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors">
                        Réserver
                    </a>
                </div>
            </div>

        </div>

        <!-- 3. ZONE D'INFORMATION ET CONSEILS DE PRATIQUE -->
        <div class="mt-16 bg-[#FCECE7]/60 rounded-3xl p-8 border border-[#FCD7CC]/30 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-4">
                <h3 class="text-2xl font-serif font-bold text-[#4A2E30]">Le Rituel du Bien-Être</h3>
                <p class="text-sm font-light leading-relaxed">
                    Pour bénéficier au maximum des bienfaits du sauna, nous vous conseillons de respecter l'alternance chaud-froid : une douche tiède ou fraîche après chaque passage en cabine, suivie d'une phase de repos d'au moins 10 minutes.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">🌡️ Température Maîtrisée (75°C-85°C)</span>
                    <span class="text-xs bg-white px-3 py-1.5 rounded-full shadow-xs font-medium">🍊 Hydratation & Jus Frais Inclus</span>
                </div>
            </div>
            <div class="text-center md:text-right">
                <p class="text-xs uppercase tracking-widest text-[#C87A65] font-semibold mb-2">Des contre-indications ?</p>
                <a href="index.php#contact" class="inline-block text-[#4A2E30] hover:text-[#C87A65] font-medium underline text-sm transition-colors">
                    Consulter notre équipe ou poser une question
                </a>
            </div>
        </div>
    </main>

    <!-- 4. BOUTON DE RETOUR RAPIDE -->
    <div class="text-center pb-12">
        <a href="index.php" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#C87A65] hover:text-[#A3523D] transition-colors group">
            <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Retour à l'accueil
        </a>
    </div>

</div>

<?php 
// Inclusion du footer
include __DIR__ . '/footer.php'; 
?>