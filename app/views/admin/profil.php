<?php
// profil.php
session_start();

// Ti simulation pou mesaj siksè oswa erè lè yo voye fòm nan
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = "Modifikasyon yo anrejistre ak siksè !";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Spa Dream</title>
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
            <a href="profil.php" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl bg-[#8A5A5C] text-white shadow-lg shadow-[#8A5A5C]/25 transition font-medium text-sm">
                <i class="fas fa-user-circle w-5 text-center"></i>
                <span>Mon Profil</span>
            </a>
            <a href="parametres.php" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 hover:text-[#5C3A3C] transition font-medium text-sm">
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
                <h2 class="text-3xl font-bold font-serif text-[#4A2E30]">Mon Profil</h2>
                <p class="text-sm text-[#A07173] mt-1">Gérez vos informations personnelles et vos accès</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KAT ENFO ATYÈL / AVATAR -->
            <div class="lg:col-span-1 space-y-6">
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm text-center">
                    <div class="relative w-28 h-28 mx-auto mb-4">
                        <img id="avatar-preview" src="https://ui-avatars.com/api/?name=Admin+Spa&background=8A5A5C&color=fff" alt="Avatar Admin" class="w-full h-full rounded-2xl object-cover shadow-md border-2 border-white">
                        <label for="avatar-input" class="absolute -bottom-2 -right-2 bg-[#8A5A5C] text-white w-8 h-8 rounded-xl flex items-center justify-center cursor-pointer shadow-md hover:bg-[#4A2E30] transition">
                            <i class="fas fa-camera text-xs"></i>
                        </label>
                        <input type="file" id="avatar-input" class="hidden" accept="image/*">
                    </div>

                    <h3 class="text-lg font-bold text-[#4A2E30]">Admin Spa</h3>
                    <p class="text-xs text-[#A07173] font-medium mt-0.5">admin@spadream.com</p>
                    
                    <div class="mt-4 inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#F5E6E8] text-[#8A5A5C] border border-[#8A5A5C]/20">
                        <i class="fas fa-shield-alt mr-1"></i> Administrateur
                    </div>

                    <hr class="my-6 border-[#F5E6E8]">

                    <div class="text-left space-y-3 text-xs">
                        <div class="flex justify-between text-[#5C3A3C]">
                            <span class="text-[#A07173]">Statut kont:</span>
                            <span class="font-bold text-emerald-600">Actif</span>
                        </div>
                        <div class="flex justify-between text-[#5C3A3C]">
                            <span class="text-[#A07173]">Dernière connexion:</span>
                            <span class="font-medium">Aujourd'hui à 14:20</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FÒM MODIFIKASYON ENFÒMASYON AK MODPAS -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- 1. ENFÒMASYON PÈSONÈL -->
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-6 flex items-center gap-2">
                        <i class="fas fa-user text-[#8A5A5C] text-sm"></i> Informations Personnelles
                    </h3>

                    <form action="profil.php" method="POST" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Prénom</label>
                                <input type="text" name="firstname" value="Admin" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Nom</label>
                                <input type="text" name="lastname" value="Spa" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Adresse Email</label>
                                <input type="email" name="email" value="admin@spadream.com" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Téléphone</label>
                                <input type="text" name="phone" value="+509 37 00 0000" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition">
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-[#8A5A5C] hover:bg-[#4A2E30] text-white px-5 py-2.5 rounded-2xl text-xs font-bold transition shadow-md shadow-[#8A5A5C]/20 flex items-center gap-2">
                                <i class="fas fa-save"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 2. CHANJMAN MODPAS -->
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-6 flex items-center gap-2">
                        <i class="fas fa-lock text-[#8A5A5C] text-sm"></i> Changer le Mot de Passe
                    </h3>

                    <form action="profil.php" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-[#A07173] mb-1.5">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition" placeholder="••••••••">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Nouveau mot de passe</label>
                                <input type="password" name="new_password" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition" placeholder="••••••••">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#A07173] mb-1.5">Confirmer le nouveau mot de passe</label>
                                <input type="password" name="confirm_password" class="w-full bg-white/80 border border-[#F5E6E8] rounded-2xl px-4 py-2.5 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C] transition" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-[#8A5A5C] hover:bg-[#4A2E30] text-white px-5 py-2.5 rounded-2xl text-xs font-bold transition shadow-md shadow-[#8A5A5C]/20 flex items-center gap-2">
                                <i class="fas fa-key"></i> Mettre à jour le mot de passe
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </main>

    <script>
        // Preview imaj la lè itilizatè a chwazi yon foto
        document.getElementById('avatar-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>