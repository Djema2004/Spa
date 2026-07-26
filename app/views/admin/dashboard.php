<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Spa Dream | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #FAF6F0 0%, #F4EBE1 50%, #EFE1D3 100%);
            background-attachment: fixed;
            color: #6B5B52;
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
    <aside class="w-64 bg-white/70 border-r border-[#EFE1D3]/80 h-screen sticky top-0 backdrop-blur-xl p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-2xl bg-[#C87A65] flex items-center justify-center text-white shadow-md shadow-[#C87A65]/30 text-xl">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-bold font-serif tracking-wide text-[#A65B47]">Spa Dream</h1>
            </div>
            
            <nav class="space-y-1">
                <?php 
                $menu = [
                    ['Tableau de bord', 'fa-chart-pie', 'admin-dashboard'],
                    ['Utilisateurs', 'fa-user-shield', 'utilisateurs'],
                    ['Prestations', 'fa-spa', 'prestations'],
                    ['Clients', 'fa-users', 'clients'],
                    ['Esthéticiennes', 'fa-user-tie', 'estheticiennes'],
                    ['Rendez-vous', 'fa-calendar-check', 'rendez_vous'],
                    ['Coupons', 'fa-tag', 'coupons'],
                    ['Paiements', 'fa-wallet', 'paiements']
                ];
                foreach($menu as $m): 
                    $isActive = ($m[0] == 'Tableau de bord');
                ?>
                    <a href="index.php?url=<?php echo $m[2]; ?>" 
                       class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl transition font-medium text-sm <?php echo $isActive ? 'bg-[#C87A65] text-white shadow-lg shadow-[#C87A65]/25' : 'text-[#A88B7D] hover:bg-[#F4EBE1]/60 hover:text-[#6B5B52]'; ?>">
                        <i class="fa <?php echo $m[1]; ?> w-5 text-center"></i> 
                        <span><?php echo $m[0]; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <div class="pt-4 border-t border-[#EFE1D3] space-y-1">
            <a href="index.php?url=profil" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#A88B7D] hover:bg-[#F4EBE1]/60 hover:text-[#6B5B52] transition font-medium text-sm">
                <i class="fas fa-user-circle w-5 text-center"></i>
                <span>Mon Profil</span>
            </a>
            <a href="index.php?url=parametres" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#A88B7D] hover:bg-[#F4EBE1]/60 hover:text-[#6B5B52] transition font-medium text-sm">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Paramètres</span>
            </a>
            <a href="index.php?url=logout" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-rose-600 hover:bg-rose-50 transition font-medium text-sm">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </aside>

    <!-- KONTNI PRINCIPAL -->
    <main class="flex-1 p-8 overflow-y-auto">
        
        <!-- HEADER -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold font-serif text-[#A65B47]">Tableau de bord</h2>
                <p class="text-sm text-[#A88B7D] mt-1">Bienvenue sur votre espace d'administration</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex gap-2 bg-white/60 p-1.5 rounded-2xl border border-[#EFE1D3]/80 shadow-sm">
                    <a href="index.php?url=clients" class="bg-[#C87A65] text-white w-9 h-9 rounded-xl hover:bg-[#A65B47] transition shadow-sm flex items-center justify-center" title="Nouveau Client">
                        <i class="fas fa-user-plus text-xs"></i>
                    </a>
                    <a href="index.php?url=prestations" class="bg-[#C87A65] text-white w-9 h-9 rounded-xl hover:bg-[#A65B47] transition shadow-sm flex items-center justify-center" title="Nouvelle Prestation">
                        <i class="fas fa-spa text-xs"></i>
                    </a>
                    <a href="index.php?url=rendez_vous" class="bg-[#C87A65] text-white w-9 h-9 rounded-xl hover:bg-[#A65B47] transition shadow-sm flex items-center justify-center" title="Nouveau Rendez-vous">
                        <i class="fas fa-calendar-plus text-xs"></i>
                    </a>
                    <a href="index.php?url=paiements" class="bg-[#C87A65] text-white w-9 h-9 rounded-xl hover:bg-[#A65B47] transition shadow-sm flex items-center justify-center" title="Nouveau Paiement">
                        <i class="fas fa-wallet text-xs"></i>
                    </a>
                </div>

                <div class="relative group">
                    <button class="flex items-center gap-3 bg-white/80 p-1.5 pr-4 rounded-2xl border border-[#EFE1D3]/80 hover:border-[#C87A65]/40 transition shadow-sm">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=150" 
                             alt="Profil Admin" class="w-10 h-10 rounded-2xl object-cover border-2 border-[#C87A65]/30 shadow-sm">
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-bold text-[#A65B47]">Admin Spa</p>
                            <p class="text-[10px] text-[#A88B7D]">Gestionnaire</p>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-[#A88B7D] ml-1"></i>
                    </button>

                    <div class="absolute right-0 mt-2 w-48 bg-white/95 rounded-2xl shadow-xl border border-[#EFE1D3] py-2 hidden group-hover:block z-50 backdrop-blur-md">
                        <a href="index.php?url=profil" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-[#6B5B52] hover:bg-[#FAF6F0] hover:text-[#C87A65] transition">
                            <i class="fas fa-user-circle text-sm text-[#A88B7D]"></i> Mon Profil
                        </a>
                        <a href="index.php?url=parametres" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-[#6B5B52] hover:bg-[#FAF6F0] hover:text-[#C87A65] transition">
                            <i class="fas fa-cog text-sm text-[#A88B7D]"></i> Paramètres
                        </a>
                        <hr class="my-1 border-[#EFE1D3]">
                        <a href="index.php?url=logout" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-rose-600 hover:bg-rose-50 transition">
                            <i class="fas fa-sign-out-alt text-sm"></i> Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- KONTNI STATISTIK -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                
                <!-- KAT KPI YO (Konekte ak Controller la) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <!-- 1. Chiffre d'Affaires -->
                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">Chiffre d'Affaires</p>
                            <span class="w-8 h-8 rounded-xl bg-[#C87A65]/10 text-[#C87A65] flex items-center justify-center text-xs"><i class="fas fa-chart-line"></i></span>
                        </div>
                        <p class="text-2xl font-black mt-2 text-[#A65B47]"><?= number_format($chiffreAffaires ?? 0, 0, ',', ' ') ?> HTG</p>
                        <p class="text-[11px] text-emerald-600 mt-1 font-semibold"><i class="fas fa-arrow-up"></i> +12% ce mois</p>
                    </div>

                    <!-- 2. RDV Aujourd'hui -->
                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">RDV Aujourd'hui</p>
                        <p class="text-2xl font-black mt-2 text-[#A65B47]"><?= $rdvJour ?? 0 ?></p>
                        <p class="text-[11px] text-[#A88B7D] mt-1">Confirmés</p>
                    </div>

                    <!-- 3. Total Clients -->
                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">Total Clients</p>
                        <p class="text-2xl font-black mt-2 text-[#A65B47]"><?= $clientsActifs ?? 0 ?></p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">Prestations</p>
                        <p class="text-2xl font-black mt-2 text-[#A65B47]">15</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">Paiements Reçus</p>
                        <p class="text-2xl font-black mt-2 text-[#A65B47]">45k HTG</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">Fidélité</p>
                        <p class="text-2xl font-black mt-2 text-[#C87A65]">Gold</p>
                    </div>
                </div>

                <!-- TABLO PROCHAINS RENDEZ-VOUS -->
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-bold font-serif text-lg text-[#A65B47]">Prochains Rendez-vous</h3>
                        <a href="index.php?url=rendez_vous" class="text-xs font-bold text-[#C87A65] hover:underline">Voir tout</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-[#A88B7D] border-b border-[#EFE1D3] text-left">
                                    <th class="pb-3 font-semibold">Heure</th>
                                    <th class="pb-3 font-semibold">Client</th>
                                    <th class="pb-3 font-semibold">Service</th>
                                    <th class="pb-3 font-semibold">Esthéticienne</th>
                                    <th class="pb-3 font-semibold">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EFE1D3]/50">

                                <?php 
                                $rendezVousList = !empty($derniersRdv) ? $derniersRdv : [
                                    [
                                        'heure' => '09:00',
                                        'client_nom' => 'Marie Jean',
                                        'client_photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=150',
                                        'client_shape' => 'rounded-full',
                                        'service' => 'Soin Visage',
                                        'service_photo' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&q=80&w=150',
                                        'service_shape' => 'rounded-2xl',
                                        'esth_nom' => 'Sophie',
                                        'esth_photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=150',
                                        'esth_shape' => 'rounded-xl',
                                        'statut' => 'Confirmé',
                                        'badge_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'dot_color' => 'bg-emerald-500'
                                    ]
                                ];

                                foreach($rendezVousList as $rdv):
                                    $statutText = $rdv['statut'] ?? 'Confirmé';
                                    $badgeColor = $rdv['badge_color'] ?? 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    $dotColor = $rdv['dot_color'] ?? 'bg-emerald-500';
                                ?>

                                <tr class="hover:bg-white/40 transition">
                                    <td class="py-4 font-semibold text-[#A65B47]"><?php echo htmlspecialchars($rdv['heure'] ?? ($rdv['date_heure'] ?? '09:00')); ?></td>
                                    
                                    <!-- CLIENT -->
                                    <td class="font-medium text-[#6B5B52] py-3">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo $rdv['client_photo'] ?? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=150'; ?>" 
                                                 alt="<?php echo htmlspecialchars($rdv['client_nom'] ?? 'Client'); ?>" 
                                                 class="w-12 h-12 object-cover border-2 border-[#C87A65]/30 shadow-md transition hover:scale-105 <?php echo $rdv['client_shape'] ?? 'rounded-full'; ?>">
                                            <span class="font-bold text-[#A65B47]"><?php echo htmlspecialchars($rdv['client_nom'] ?? 'N/A'); ?></span>
                                        </div>
                                    </td>
                                    
                                    <!-- SERVICE -->
                                    <td class="text-[#6B5B52] py-3 font-medium">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo $rdv['service_photo'] ?? 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&q=80&w=150'; ?>" 
                                                 alt="<?php echo htmlspecialchars($rdv['service'] ?? ($rdv['prestation_nom'] ?? 'Service')); ?>" 
                                                 class="w-12 h-12 object-cover border-2 border-[#C87A65]/30 shadow-md transition hover:scale-105 <?php echo $rdv['service_shape'] ?? 'rounded-2xl'; ?>">
                                            <span class="font-semibold text-[#A88B7D]"><?php echo htmlspecialchars($rdv['service'] ?? ($rdv['prestation_nom'] ?? 'N/A')); ?></span>
                                        </div>
                                    </td>
                                    
                                    <!-- ESTHÉTICIENNE -->
                                    <td class="text-[#6B5B52] py-3">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo $rdv['esth_photo'] ?? 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=150'; ?>" 
                                                 alt="<?php echo htmlspecialchars($rdv['esth_nom'] ?? 'Esthéticienne'); ?>" 
                                                 class="w-12 h-12 object-cover border-2 border-[#C87A65]/30 shadow-md transition hover:scale-105 <?php echo $rdv['esth_shape'] ?? 'rounded-xl'; ?>">
                                            <span class="font-semibold"><?php echo htmlspecialchars($rdv['esth_nom'] ?? 'Sophie'); ?></span>
                                        </div>
                                    </td>
                                    
                                    <!-- STATUT -->
                                    <td>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border <?php echo $badgeColor; ?>">
                                            <span class="w-1.5 h-1.5 rounded-full <?php echo $dotColor; ?>"></span> 
                                            <?php echo $statutText; ?>
                                        </span>
                                    </td>
                                </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL DWAT -->
            <div class="space-y-6">
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <h3 class="font-bold font-serif text-lg text-[#A65B47] mb-4">Prestations les Plus Demandées</h3>
                    <div class="space-y-3">
                        <?php 
                        $prestationsPop = !empty($topPrestations) ? $topPrestations : ['Massage' => 45, 'Soin Visage' => 32, 'Épilation' => 28, 'Manucure' => 25, 'Pédicure' => 20];
                        foreach($prestationsPop as $k => $v): 
                            $nomPrest = is_array($v) ? ($v['nom'] ?? $k) : $k;
                            $countPrest = is_array($v) ? ($v['total'] ?? 0) : $v;
                        ?>
                            <div class="flex justify-between items-center text-sm py-1.5 border-b border-[#EFE1D3]/40 last:border-0">
                                <span class="font-medium text-[#6B5B52]"><?php echo htmlspecialchars($nomPrest); ?></span>
                                <span class="font-bold text-[#C87A65] bg-[#F4EBE1]/60 px-3 py-0.5 rounded-full text-xs"><?php echo $countPrest; ?> rés.</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <h3 class="font-bold font-serif text-lg text-[#A65B47] mb-3">Fidélité Client</h3>
                    <div class="flex items-center justify-between text-xs bg-white/60 p-3 rounded-2xl border border-[#EFE1D3]">
                        <div class="text-[#6B5B52]">Points: <span class="font-bold text-[#A65B47]">450</span></div>
                        <div class="text-[#6B5B52]">Niv: <span class="font-bold text-[#C87A65]">Gold</span></div>
                        <div class="text-[#6B5B52]">Coupons: <span class="font-bold text-[#A65B47]">2 disp.</span></div>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <h3 class="font-bold font-serif text-lg text-[#A65B47] mb-4">Notifications</h3>
                    <div class="text-xs space-y-3 text-[#6B5B52]">
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