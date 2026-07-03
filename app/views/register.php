<?php include __DIR__ . '/header.php'; ?>

<!-- Fond de page : Harmonisé avec le reste du site (Crème) et texte Vieux Rose foncé -->
<main class="flex-1 flex items-center justify-center p-4 my-10 bg-[#FAF7F2] text-[#5C3A3C]">

    <!-- Carte du formulaire : Fond blanc cassé pur, bordures et ombres rose poudré délicat -->
    <div id="register" class="w-full max-w-xl bg-white p-8 sm:p-10 rounded-[2rem] shadow-xl shadow-[#FCD7CC]/20 border border-[#FCD7CC]/40 relative overflow-hidden">
        
        <!-- Bulles de fond décoratives aux nuances douces de Pêche/Rose -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#FCECE7] rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#FCECE7] rounded-full blur-2xl pointer-events-none"></div>

        <!-- En-tête de la carte -->
        <div class="mb-8 text-center relative z-10">
            <h2 class="text-3xl font-serif font-black tracking-tight text-[#4A2E30]">Créer un compte</h2>
            <p class="text-sm text-[#5C3A3C]/80 mt-2 font-light">Rejoignez notre oasis de sérénité dès aujourd'hui.</p>
        </div>

        <!-- Formulaire -->
        <form action="../controllers/registerformControl.php?action=addUser" method="POST" class="space-y-5 relative z-10">
            
            <!-- Bloc Prénom & Nom -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Prénom -->
                <div>
                    <label for="firstname" class="block text-sm font-semibold text-[#4A2E30] mb-1.5">Prénom</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#C87A65]/70">
                            <i class="fa-regular fa-user text-sm"></i>
                        </span>
                        <input type="text" id="firstname" name="firstname" placeholder="Prénom" 
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#FCD7CC] bg-[#FAF7F2]/50 text-[#5C3A3C] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87A65]/20 focus:border-[#C87A65] transition-all placeholder:text-[#5C3A3C]/40 text-sm shadow-sm" required>
                    </div>
                </div>
                <!-- Nom -->
                <div>
                    <label for="lastname" class="block text-sm font-semibold text-[#4A2E30] mb-1.5">Nom</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#C87A65]/70">
                            <i class="fa-regular fa-user text-sm"></i>
                        </span>
                        <input type="text" id="lastname" name="lastname" placeholder="Nom" 
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#FCD7CC] bg-[#FAF7F2]/50 text-[#5C3A3C] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87A65]/20 focus:border-[#C87A65] transition-all placeholder:text-[#5C3A3C]/40 text-sm shadow-sm" required>
                    </div>
                </div>
            </div>

            <!-- Adresse e-mail -->
            <div>
                <label for="email" class="block text-sm font-semibold text-[#4A2E30] mb-1.5">Adresse e-mail</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#C87A65]/70">
                        <i class="fa-regular fa-envelope text-sm"></i>
                    </span>
                    <input type="email" id="email" name="email" placeholder="Email" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#FCD7CC] bg-[#FAF7F2]/50 text-[#5C3A3C] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87A65]/20 focus:border-[#C87A65] transition-all placeholder:text-[#5C3A3C]/40 text-sm shadow-sm" required>
                </div>
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-semibold text-[#4A2E30] mb-1.5">Mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#C87A65]/70">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <input type="password" id="password" name="password" placeholder="Mot de passe" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#FCD7CC] bg-[#FAF7F2]/50 text-[#5C3A3C] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87A65]/20 focus:border-[#C87A65] transition-all placeholder:text-[#5C3A3C]/40 text-sm shadow-sm" required>
                </div>
            </div>

            <!-- Confirmer le mot de passe -->
            <div>
                <label for="password_confirm" class="block text-sm font-semibold text-[#4A2E30] mb-1.5">Confirmer le mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#C87A65]/70">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirmer" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#FCD7CC] bg-[#FAF7F2]/50 text-[#5C3A3C] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87A65]/20 focus:border-[#C87A65] transition-all placeholder:text-[#5C3A3C]/40 text-sm shadow-sm" required>
                </div>
            </div>

            <!-- Cases à cocher des CGU (Teinte Terracotta) -->
            <div class="flex items-start gap-3 pt-2">
                <input type="checkbox" id="terms" name="terms" class="mt-1 h-4 w-4 rounded border-[#FCD7CC] text-[#C87A65] focus:ring-[#C87A65] transition-colors accent-[#C87A65]" required>
                <label for="terms" class="text-xs text-[#5C3A3C]/80 font-light leading-normal">
                    J'accepte les <a href="#" class="text-[#C87A65] underline font-medium hover:text-[#A3523D]">conditions générales d'utilisation</a> et la <a href="#" class="text-[#C87A65] underline font-medium hover:text-[#A3523D]">politique de confidentialité</a>.
                </label>
            </div>

            <!-- Bouton d'action Terracotta Signature -->
            <div class="pt-4 text-center">
                <button type="submit" name="btn_register" class="w-full sm:w-64 bg-[#C87A65] hover:bg-[#A3523D] text-white font-semibold py-3 rounded-xl transition-all duration-300 text-sm shadow-md shadow-[#C87A65]/20 tracking-wider hover:-translate-y-0.5 transform">
                    Créer mon compte
                </button>
            </div>

            <!-- Lien de bas de page -->
            <p class="text-xs text-center text-[#5C3A3C]/80 pt-2 font-light">
                Vous avez déjà un compte ? <a href="login.php" class="text-[#4A2E30] font-bold hover:underline">Connectez-vous</a>
            </p>
        </form>
    </div>

</main>

<?php include __DIR__ . '/footer.php'; ?>