<?php
// 1. DÉMARRAGE DE LA SESSION (Optionnel mais recommandé si tu veux lier au client connecté)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. CONFIGURATION ET TRAITEMENT DU FORMULAIRE
$msg_status = "";
$msg_text = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et sécurisation des données pour éviter les failles XSS
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($name) || !$email || empty($subject) || empty($message)) {
        $msg_status = "error";
        $msg_text = "Veuillez remplir tous les champs correctement.";
    } else {
        // ICI : Tu peux ajouter une insertion en base de données si tu as une table `messages`
        // Ou simplement simuler l'envoi pour ton examen.
        $msg_status = "success";
        $msg_text = "Votre message a été envoyé avec succès ! Notre équipe vous répondra dans les plus brefs délais.";
    }
}

include __DIR__ . '/header.php'; 
?>

<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen font-sans flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto w-full bg-white rounded-3xl shadow-xl border border-[#F5E6E8] overflow-hidden grid grid-cols-1 md:grid-cols-2">
        
        <div class="bg-[#4A2E30] text-white p-8 md:p-12 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#FAF7F2]/70 block mb-2">Restons en contact</span>
                <h1 class="text-3xl font-serif font-bold mb-6">Contactez-nous</h1>
                <p class="text-sm text-[#FAF7F2]/80 leading-relaxed mb-8">
                    Une question sur nos soins, une demande spéciale ou besoin d'aide pour votre réservation ? Écrivez-nous, nous sommes à votre écoute.
                </p>
                
                <div class="space-y-6 text-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-[#8A5A5C] flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-location-dot text-[#FAF7F2]"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-[#FAF7F2]">Adresse</h4>
                            <p class="text-[#FAF7F2]/70 mt-0.5">12, Rue des Thermes, Cap-Haïtien, Haïti</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-[#8A5A5C] flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-phone text-[#FAF7F2]"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-[#FAF7F2]">Téléphone</h4>
                            <p class="text-[#FAF7F2]/70 mt-0.5">+509 3333-4444</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-[#8A5A5C] flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-envelope text-[#FAF7F2]"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-[#FAF7F2]">Email</h4>
                            <p class="text-[#FAF7F2]/70 mt-0.5">contact@dbspa.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-[#FAF7F2]/20 mt-8 md:mt-0">
                <h4 class="text-xs font-bold uppercase tracking-wider text-[#FAF7F2]/60 mb-2">Horaires d'ouverture</h4>
                <p class="text-xs text-[#FAF7F2]/80">Lundi - Samedi : 9h00 - 19h00</p>
                <p class="text-xs text-[#FAF7F2]/80">Dimanche : Fermé</p>
            </div>
        </div>

        <div class="p-8 md:p-12 flex flex-col justify-center">
            <h2 class="text-xl font-serif font-bold text-[#4A2E30] mb-6">Envoyer un message</h2>
            
            <?php if ($msg_status === "success"): ?>
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl flex items-start gap-2 animate-fade-in">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                    <span><?php echo $msg_text; ?></span>
                </div>
            <?php elseif ($msg_status === "error"): ?>
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-xl flex items-start gap-2 animate-fade-in">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5"></i>
                    <span><?php echo $msg_text; ?></span>
                </div>
            <?php endif; ?>

            <form action="contact.php" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase text-[#A07173] mb-1">Nom Complet</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full bg-[#FAF7F2] border border-[#F5E6E8] rounded-xl px-4 py-2.5 text-sm text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition-colors"
                           placeholder="Ex: Jean Dupont">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase text-[#A07173] mb-1">Adresse Email</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full bg-[#FAF7F2] border border-[#F5E6E8] rounded-xl px-4 py-2.5 text-sm text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition-colors"
                           placeholder="Ex: jean.dupont@email.com">
                </div>

                <div>
                    <label for="subject" class="block text-xs font-bold uppercase text-[#A07173] mb-1">Sujet</label>
                    <input type="text" id="subject" name="subject" required 
                           class="w-full bg-[#FAF7F2] border border-[#F5E6E8] rounded-xl px-4 py-2.5 text-sm text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition-colors"
                           placeholder="Ex: Demande de tarif de groupe">
                </div>

                <div>
                    <label for="message" class="block text-xs font-bold uppercase text-[#A07173] mb-1">Votre Message</label>
                    <textarea id="message" name="message" rows="4" required 
                              class="w-full bg-[#FAF7F2] border border-[#F5E6E8] rounded-xl px-4 py-2.5 text-sm text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition-colors resize-none"
                              placeholder="Écrivez votre message ici..."></textarea>
                </div>

                <button type="submit" 
                        class="w-full bg-[#8A5A5C] hover:bg-[#4A2E30] text-white text-sm font-semibold py-3 px-4 rounded-xl shadow-md transition-colors cursor-pointer border-0 mt-2">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Envoyer le message
                </button>
            </form>
        </div>

    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>