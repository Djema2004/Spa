<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Spa Dream | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Background jeneral anba ak gradyan dous ki trè elegant */
        body { 
            background: linear-gradient(135deg, #FAF7F2 0%, #F5E6E8 50%, #EFE3E5 100%);
            background-attachment: fixed;
            color: #5C3A3C;
            font-family: system-ui, -apple-system, sans-serif;
        }
        /* Efè vè (glassmorphism) amelyore */
        .glass-card { 
            background: rgba(255, 255, 255, 0.75); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white/70 border-r border-[#F5E6E8]/80 min-h-screen p-6 sticky top-0 backdrop-blur-xl">
        <div class="flex items-center gap-3 mb-10">
            <div class="w-10 h-10 rounded-2xl bg-[#8A5A5C] flex items-center justify-center text-white shadow-md shadow-[#8A5A5C]/30 text-xl">
                <i class="fas fa-spa"></i>
            </div>
            <h1 class="text-xl font-bold font-serif tracking-wide text-[#4A2E30]">Spa Dream</h1>
        </div>
        
        <nav class="space-y-1.5">
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
                $isActive = ($m[0] == 'Tableau de bord');
            ?>
                <a href="<?php echo $m[2]; ?>" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl transition font-medium text-sm <?php echo $isActive ? 'bg-[#8A5A5C] text-white shadow-lg shadow-[#8A5A5C]/25' : 'text-[#A07173] hover:bg-[#F5E6E8]/60 hover:text-[#5C3A3C]'; ?>">
                    <i class="fa <?php echo $m[1]; ?> w-5 text-center"></i> 
                    <span><?php echo $m[0]; ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>

    <!-- KONTNI PRINCIPAL -->
    <main class="flex-1 p-8">
        
        <!-- HEADER AK PROFIL & ACTIONS RAPIDES -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold font-serif text-[#4A2E30]">Tableau de bord</h2>
                <p class="text-sm text-[#A07173] mt-1">Bienvenue sur votre espace d'administration</p>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- AKSÈ RAPID AK IKON -->
                <div class="flex gap-2 bg-white/60 p-1.5 rounded-2xl border border-[#F5E6E8]/80 shadow-sm">
                    <a href="clients.php" class="bg-[#8A5A5C] text-white w-9 h-9 rounded-xl hover:bg-[#4A2E30] transition shadow-sm flex items-center justify-center" title="Nouveau Client">
                        <i class="fas fa-user-plus text-xs"></i>
                    </a>
                    <button class="bg-[#8A5A5C] text-white w-9 h-9 rounded-xl hover:bg-[#4A2E30] transition shadow-sm flex items-center justify-center" title="Nouvelle Prestation">
                        <i class="fas fa-spa text-xs"></i>
                    </button>
                    <button class="bg-[#8A5A5C] text-white w-9 h-9 rounded-xl hover:bg-[#4A2E30] transition shadow-sm flex items-center justify-center" title="Nouveau Rendez-vous">
                        <i class="fas fa-calendar-plus text-xs"></i>
                    </button>
                    <button class="bg-[#8A5A5C] text-white w-9 h-9 rounded-xl hover:bg-[#4A2E30] transition shadow-sm flex items-center justify-center" title="Nouveau Paiement">
                        <i class="fas fa-wallet text-xs"></i>
                    </button>
                </div>

                <!-- PROFIL & PARAMÈTRES (DROPDOWN) -->
                <div class="relative group">
                    <button class="flex items-center gap-3 bg-white/80 p-1.5 pr-4 rounded-2xl border border-[#F5E6E8]/80 hover:border-[#8A5A5C]/40 transition shadow-sm">
                        <img src="https://ui-avatars.com/api/?name=Admin+Spa&background=8A5A5C&color=fff" alt="Profil Admin" class="w-9 h-9 rounded-xl object-cover">
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-bold text-[#4A2E30]">Admin Spa</p>
                            <p class="text-[10px] text-[#A07173]">Gestionnaire</p>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-[#A07173] ml-1"></i>
                    </button>

                    <div class="absolute right-0 mt-2 w-48 bg-white/95 rounded-2xl shadow-xl border border-[#F5E6E8] py-2 hidden group-hover:block z-50 backdrop-blur-md">
                        <a href="profil.php" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-[#5C3A3C] hover:bg-[#FAF7F2] hover:text-[#8A5A5C] transition">
                            <i class="fas fa-user-circle text-sm text-[#A07173]"></i> Mon Profil
                        </a>
                        <a href="parametres.php" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-[#5C3A3C] hover:bg-[#FAF7F2] hover:text-[#8A5A5C] transition">
                            <i class="fas fa-cog text-sm text-[#A07173]"></i> Paramètres
                        </a>
                        <hr class="my-1 border-[#F5E6E8]">
                        <a href="logout.php" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-rose-600 hover:bg-rose-50 transition">
                            <i class="fas fa-sign-out-alt text-sm"></i> Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- KONTNI STATISTIK -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- GÒCH: STATS & TABLO -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- KAT KPI YO -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Chiffre d'Affaires</p>
                            <span class="w-8 h-8 rounded-xl bg-[#8A5A5C]/10 text-[#8A5A5C] flex items-center justify-center text-xs"><i class="fas fa-chart-line"></i></span>
                        </div>
                        <p class="text-2xl font-black mt-2 text-[#4A2E30]">120k HTG</p>
                        <p class="text-[11px] text-emerald-600 mt-1 font-semibold"><i class="fas fa-arrow-up"></i> +12% ce mois</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">RDV Aujourd'hui</p>
                        <p class="text-2xl font-black mt-2 text-[#4A2E30]">8</p>
                        <p class="text-[11px] text-[#A07173] mt-1">5 confirmés</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Total Clients</p>
                        <p class="text-2xl font-black mt-2 text-[#4A2E30]">120</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Prestations</p>
                        <p class="text-2xl font-black mt-2 text-[#4A2E30]">15</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Paiements Reçus</p>
                        <p class="text-2xl font-black mt-2 text-[#4A2E30]">45k HTG</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Fidélité</p>
                        <p class="text-2xl font-black mt-2 text-[#8A5A5C]">Gold</p>
                    </div>

                </div>

                <!-- TABLO PROCHAINS RENDEZ-VOUS -->
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-bold font-serif text-lg text-[#4A2E30]">Prochains Rendez-vous</h3>
                        <a href="rendezvous.php" class="text-xs font-bold text-[#8A5A5C] hover:underline">Voir tout</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-[#A07173] border-b border-[#F5E6E8] text-left">
                                    <th class="pb-3 font-semibold">Heure</th>
                                    <th class="pb-3 font-semibold">Client</th>
                                    <th class="pb-3 font-semibold">Service</th>
                                    <th class="pb-3 font-semibold">Esthéticienne</th>
                                    <th class="pb-3 font-semibold">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#F5E6E8]/50">
                                <tr class="hover:bg-white/40 transition">
                                    <td class="py-4 font-semibold text-[#4A2E30]">14:00</td>
                                    <td class="font-medium">Marie Jean</td>
                                    <td class="text-[#A07173]">Facial</td>
                                    <td>Sophie</td>
                                    <td>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Confirmé
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- DWAT: PANEL -->
            <div class="space-y-6">
                
                <!-- PRESTATIONS LES PLUS DEMANDÉES -->
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-4">Prestations les Plus Demandées</h3>
                    <div class="space-y-3">
                        <?php foreach(['Massage'=>45, 'Soin Visage'=>32, 'Épilation'=>28, 'Manucure'=>25, 'Pédicure'=>20] as $k=>$v): ?>
                            <div class="flex justify-between items-center text-sm py-1.5 border-b border-[#F5E6E8]/40 last:border-0">
                                <span class="font-medium"><?php echo $k; ?></span>
                                <span class="font-bold text-[#8A5A5C] bg-[#F5E6E8]/60 px-3 py-0.5 rounded-full text-xs"><?php echo $v; ?> rés.</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- FIDÉLITÉ CLIENT -->
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-3">Fidélité Client</h3>
                    <div class="flex items-center justify-between text-xs bg-white/60 p-3 rounded-2xl border border-[#F5E6E8]">
                        <div>Points: <span class="font-bold text-[#4A2E30]">450</span></div>
                        <div>Niv: <span class="font-bold text-[#8A5A5C]">Gold</span></div>
                        <div>Coupons: <span class="font-bold text-[#4A2E30]">2 disp.</span></div>
                    </div>
                </div>

                <!-- NOTIFICATIONS -->
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <h3 class="font-bold font-serif text-lg text-[#4A2E30] mb-4">Notifications</h3>
                    <div class="text-xs space-y-3 text-[#5C3A3C]">
                        <p class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white/50 transition">
                            <i class="fas fa-user-plus text-blue-500 w-4 text-center"></i>
                            <span>Nouveau client inscrit</span>
                        </p>
                        <p class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white/50 transition">
                            <i class="fas fa-wallet text-emerald-500 w-4 text-center"></i>
                            <span>Paiement reçu</span>
                        </p>
                        <p class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white/50 transition">
                            <i class="fas fa-calendar-times text-rose-500 w-4 text-center"></i>
                            <span>RDV annulé</span>
                        </p>
                        <p class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white/50 transition">
                            <i class="fas fa-tag text-amber-500 w-4 text-center"></i>
                            <span>Coupon expiré</span>
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </main>
</body>
</html>