<?php
// parametres.php
session_start();

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = "Les paramètres ont été mis à jour avec succès !";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Spa Dream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #FAF7F2 0%, #F5E6E8 50%, #EFE3E5 100%);
            background-attachment: fixed;
            color: #5C3A3C;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.75); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white/70 border-r border-[#F5E6E8]/80 h-screen sticky top-0 backdrop-blur-xl p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-2xl bg-[#8A5A5C] flex items-center justify-center text-white shadow-md shadow-[#8A5A5C]/30 text-xl">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-bold font-serif tracking-wide text-[#4A2E30]">Spa Dream</h1>
            </div>
            
            <nav class="space-y-1">
                <?php 
                $menu = [
                    ['Tableau de bord', 'fa-chart-pie', 'dashboard.php'],
                    ['Prestations', 'fa-spa', 'prestations.php'],
                    ['Clients', 'fa-users', 'clients.php'],
                    ['Esthéticiennes', 'fa-user-tie', 'estheticiennes.php'],
                    ['Rendez-vous', 'fa-calendar-check', 'rendezvous.php'],
                    ['Coupons', 'fa-tag', 'coupons.php'],
                    ['Paiements', 'fa-wallet', 'paiements.php']
                ];
                foreach($menu as $m): 
                ?>
                    <a href="<?php echo $m[2]; ?>" 
                       class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl transition font-medium text-sm text-[#A07173] hover:bg-[#F5E6E8]/60 hover:text-[#5C3A3C]">
                        <i class="fa <?php echo $m[1]; ?> w-5 text-center"></i> 
                        <span><?php echo $m[0]; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- SEKSYON PROFIL, PARAMÈTRES AK DÉCONNEXION -->
        <div class="pt-4 border-t border-[#F5E6E8] space-y-1">
            <a href="profil.php" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 hover:text-[#5C3A3C] transition font-medium text-sm">
                <i class="fas fa-user-circle w-5 text-center"></i>
                <span>Mon Profil</span>
            </a>
            <a href="parametres.php" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl bg-[#8A5A5C] text-white shadow-lg shadow-[#8A5A5C]/25 transition font-medium text-sm">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Paramètres</span>
            </a>
            <a href="logout.php" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-rose-600 hover:bg-rose-50 transition font-medium text-sm">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </aside>

    <!-- KONTNI PRINCIPAL -->
    <main class="flex-1 p-8">
        
        <!-- HEADER -->
        <header class="flex items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold font-serif text-[#4A2E30]">Paramètres Généraux</h2>
                <p class="text-sm text-[#A07173] mt-1">Configurez les informations et règles de fonctionnement du Spa</p>
            </div>
            
            <a href="dashboard.php" class="bg-white/80 hover:bg-white text-[#5C3A3C] px-4 py-2 rounded-2xl border border-[#F5E6E8] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Retour au Dashboard
            </a>
        </header>

        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl text-sm font-medium flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-600"></i>
                <span><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <form action="parametres.php" method="POST" class="space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- KOLEKSYON 1: INFORMATIONS DU SPA -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                        <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-6 flex items-center gap-2">
                            <i class="fas fa-store text-[#8A5A5C] text-sm"></i> Informations de l'Établissement
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Nom du Spa</label>
                                <input type="text" name="spa_name" value="Spa Dream" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#A07173] mb-1.5">Email de contact</label>
                                    <input type="email" name="spa_email" value="contact@spadream.com" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#A07173] mb-1.5">Téléphone principal</label>
                                    <input type="text" name="spa_phone" value="+509 37 00 0000" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Adresse physique</label>
                                <input type="text" name="spa_address" value="Rue Panaméricaine, Pétion-Ville, Haïti" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#A07173] mb-1.5">Devise par défaut</label>
                                    <select name="currency" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                                        <option value="HTG" selected>HTG (Gourde Haïtienne)</option>
                                        <option value="USD">USD (Dollar Américain)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#A07173] mb-1.5">Taxe / TVA (%)</label>
                                    <input type="number" name="tax_rate" value="10" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HEURES D'OUVERTURE -->
                    <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                        <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-6 flex items-center gap-2">
                            <i class="fas fa-clock text-[#8A5A5C] text-sm"></i> Horaires d'Ouverture
                        </h3>

                        <div class="space-y-3">
                            <?php 
                            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                            foreach($jours as $j):
                                $isSunday = ($j === 'Dimanche');
                            ?>
                                <div class="flex items-center justify-between gap-4 py-1.5 border-b border-[#F5E6E8]/50 last:border-0">
                                    <span class="text-xs font-bold text-[#4A2E30] w-24"><?php echo $j; ?></span>
                                    
                                    <div class="flex items-center gap-2">
                                        <input type="time" name="open_<?php echo strtolower($j); ?>" value="<?php echo $isSunday ? '' : '08:00'; ?>" <?php echo $isSunday ? 'disabled' : ''; ?> class="bg-white/80 border border-[#F5E6E8] rounded-xl px-2 py-1 text-xs text-[#5C3A3C]">
                                        <span class="text-xs text-[#A07173]">à</span>
                                        <input type="time" name="close_<?php echo strtolower($j); ?>" value="<?php echo $isSunday ? '' : '18:00'; ?>" <?php echo $isSunday ? 'disabled' : ''; ?> class="bg-white/80 border border-[#F5E6E8] rounded-xl px-2 py-1 text-xs text-[#5C3A3C]">
                                    </div>

                                    <label class="flex items-center gap-2 cursor-pointer text-xs text-[#A07173]">
                                        <input type="checkbox" name="closed_<?php echo strtolower($j); ?>" <?php echo $isSunday ? 'checked' : ''; ?> class="rounded text-[#8A5A5C] focus:ring-0">
                                        <span>Fermé</span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>

                <!-- KOLEKSYON 2: OPTIONS & NOTIFICATIONS -->
                <div class="space-y-6">
                    
                    <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                        <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-4 flex items-center gap-2">
                            <i class="fas fa-bell text-[#8A5A5C] text-sm"></i> Notifications
                        </h3>

                        <div class="space-y-4 text-xs">
                            <label class="flex items-center justify-between p-2 rounded-xl hover:bg-white/50 cursor-pointer transition">
                                <span class="font-medium">Rappels de RDV par Email</span>
                                <input type="checkbox" checked class="w-4 h-4 text-[#8A5A5C] rounded border-[#F5E6E8]">
                            </label>

                            <label class="flex items-center justify-between p-2 rounded-xl hover:bg-white/50 cursor-pointer transition">
                                <span class="font-medium">Rappels de RDV par SMS</span>
                                <input type="checkbox" checked class="w-4 h-4 text-[#8A5A5C] rounded border-[#F5E6E8]">
                            </label>

                            <label class="flex items-center justify-between p-2 rounded-xl hover:bg-white/50 cursor-pointer transition">
                                <span class="font-medium">Alerte de rupture de stock</span>
                                <input type="checkbox" checked class="w-4 h-4 text-[#8A5A5C] rounded border-[#F5E6E8]">
                            </label>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                        <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-4 flex items-center gap-2">
                            <i class="fas fa-[#8A5A5C] fa-calendar-alt text-sm text-[#8A5A5C]"></i> Réservations
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Délai d'annulation sans frais (heures)</label>
                                <input type="number" name="cancel_delay" value="24" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Nombre max de RDV / creneau</label>
                                <input type="number" name="max_rdv" value="4" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                            </div>
                        </div>
                    </div>

                    <!-- BOUTON ENREGISTRER -->
                    <button type="submit" class="w-full bg-[#8A5A5C] hover:bg-[#4A2E30] text-white py-3.5 rounded-2xl text-xs font-bold transition shadow-lg shadow-[#8A5A5C]/30 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Enregistrer les Paramètres
                    </button>

                </div>

            </div>

        </form>

    </main>

</body>
</html>