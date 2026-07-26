<?php
// ==========================================
// 1. KONEKSYON AK BAZ DONE A (PDO)
// ==========================================
$host = 'localhost';
$dbname = 'dbspa';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erè koneksyon baz done : " . $e->getMessage());
}

// ==========================================
// 2. REKIPERASYON DONE POU DASHBOARD LA
// ==========================================

// Randevou jodi a
$stmtRdvJour = $pdo->query("SELECT COUNT(*) as total FROM appointments WHERE appointment_date = CURDATE()");
$rdvJour = $stmtRdvJour->fetch()['total'] ?? 0;

// Total Itilizatè yo (nan tab users)
$stmtClients = $pdo->query("SELECT COUNT(*) as total FROM users");
$clientsActifs = $stmtClients->fetch()['total'] ?? 0;

// Total Sèvis yo (nan tab services)
$stmtPrestTotal = $pdo->query("SELECT COUNT(*) as total FROM services");
$totalPrestations = $stmtPrestTotal->fetch()['total'] ?? 0;

// Lis Pwochen Randevou soti nan tab appointments
$stmtDerniersRdv = $pdo->query("
    SELECT * FROM appointments 
    ORDER BY appointment_date ASC, appointment_time ASC 
    LIMIT 5
");
$derniersRdv = $stmtDerniersRdv->fetchAll();

// Sèvis yo ki pi mande (baze sou service_nom oswa name)
$stmtTopPrest = $pdo->query("
    SELECT service_nom as nom, COUNT(*) as total 
    FROM appointments 
    WHERE service_nom IS NOT NULL 
    GROUP BY service_nom 
    ORDER BY total DESC 
    LIMIT 5
");
$topPrestations = $stmtTopPrest->fetchAll();
?>
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
                    ['Tableau de bord', 'fa-chart-pie', 'dashboard.php'],
                    ['Prestations', 'fa-spa', 'prestations.php'],
                    ['Clients', 'fa-users', 'clients.php'],
                    ['Esthéticiennes', 'fa-user-tie', 'estheticiennes.php'],
                    ['Administrateurs', 'fa-user-shield', 'admins.php'],
                    ['Rendez-vous', 'fa-calendar-check', 'rendez_vous.php'],
                    ['Coupons', 'fa-tag', 'coupons.php'],
                    ['Paiements', 'fa-credit-card', 'paiements.php']
                ];
                foreach($menu as $m): 
                    $isActive = ($m[0] == 'Tableau de bord');
                ?>
                    <a href="<?php echo $m[2]; ?>" 
                       class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl transition font-medium text-sm <?php echo $isActive ? 'bg-[#C87A65] text-white shadow-lg shadow-[#C87A65]/25' : 'text-[#A88B7D] hover:bg-[#F4EBE1]/60 hover:text-[#6B5B52]'; ?>">
                        <i class="fa <?php echo $m[1]; ?> w-5 text-center"></i> 
                        <span><?php echo $m[0]; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <div class="pt-4 border-t border-[#EFE1D3] space-y-1">
            <a href="profil.php" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#A88B7D] hover:bg-[#F4EBE1]/60 hover:text-[#6B5B52] transition font-medium text-sm">
                <i class="fas fa-user-circle w-5 text-center"></i>
                <span>Mon Profil</span>
            </a>
            <a href="parametres.php" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#A88B7D] hover:bg-[#F4EBE1]/60 hover:text-[#6B5B52] transition font-medium text-sm">
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
    <main class="flex-1 p-8 overflow-y-auto">
        
        <!-- HEADER -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold font-serif text-[#A65B47]">Tableau de bord</h2>
                <p class="text-sm text-[#A88B7D] mt-1">Bienvenue sur votre espace d'administration</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex gap-2 bg-white/60 p-1.5 rounded-2xl border border-[#EFE1D3]/80 shadow-sm">
                    <a href="clients.php" class="bg-[#C87A65] text-white w-9 h-9 rounded-xl hover:bg-[#A65B47] transition shadow-sm flex items-center justify-center" title="Nouveau Client">
                        <i class="fas fa-user-plus text-xs"></i>
                    </a>
                    <a href="prestations.php" class="bg-[#C87A65] text-white w-9 h-9 rounded-xl hover:bg-[#A65B47] transition shadow-sm flex items-center justify-center" title="Nouvelle Prestation">
                        <i class="fas fa-spa text-xs"></i>
                    </a>
                    <a href="rendez_vous.php" class="bg-[#C87A65] text-white w-9 h-9 rounded-xl hover:bg-[#A65B47] transition shadow-sm flex items-center justify-center" title="Nouveau Rendez-vous">
                        <i class="fas fa-calendar-plus text-xs"></i>
                    </a>
                    <a href="admins.php" class="bg-[#A65B47] text-white w-9 h-9 rounded-xl hover:bg-[#854737] transition shadow-sm flex items-center justify-center" title="Ajouter / Jere Administratè">
                        <i class="fas fa-user-shield text-xs"></i>
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
                        <a href="profil.php" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-[#6B5B52] hover:bg-[#FAF6F0] hover:text-[#C87A65] transition">
                            <i class="fas fa-user-circle text-sm text-[#A88B7D]"></i> Mon Profil
                        </a>
                        <a href="admins.php" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-[#6B5B52] hover:bg-[#FAF6F0] hover:text-[#C87A65] transition">
                            <i class="fas fa-user-shield text-sm text-[#A88B7D]"></i> Jere Administratè
                        </a>
                        <a href="parametres.php" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-[#6B5B52] hover:bg-[#FAF6F0] hover:text-[#C87A65] transition">
                            <i class="fas fa-cog text-sm text-[#A88B7D]"></i> Paramètres
                        </a>
                        <hr class="my-1 border-[#EFE1D3]">
                        <a href="logout.php" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium text-rose-600 hover:bg-rose-50 transition">
                            <i class="fas fa-sign-out-alt text-sm"></i> Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- KONTNI STATISTIK -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                
                <!-- KAT KPI YO -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">RDV Aujourd'hui</p>
                        <p class="text-2xl font-black mt-2 text-[#A65B47]"><?= $rdvJour ?></p>
                        <p class="text-[11px] text-emerald-600 mt-1 font-semibold"><i class="fas fa-check-circle"></i> Confirmés</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">Total Utilisateurs</p>
                        <p class="text-2xl font-black mt-2 text-[#A65B47]"><?= $clientsActifs ?></p>
                        <p class="text-[11px] text-[#A88B7D] mt-1">Inscrits</p>
                    </div>

                    <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm hover:shadow-md transition">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#A88B7D]">Services</p>
                        <p class="text-2xl font-black mt-2 text-[#A65B47]"><?= $totalPrestations ?></p>
                        <p class="text-[11px] text-[#A88B7D] mt-1">Disponibles</p>
                    </div>

                </div>

                <!-- TABLO PROCHAINS RENDEZ-VOUS -->
                <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-bold font-serif text-lg text-[#A65B47]">Prochains Rendez-vous</h3>
                        <a href="rendez_vous.php" class="text-xs font-bold text-[#C87A65] hover:underline">Voir tout</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-[#A88B7D] border-b border-[#EFE1D3] text-left">
                                    <th class="pb-3 font-semibold">Date & Heure</th>
                                    <th class="pb-3 font-semibold">Client</th>
                                    <th class="pb-3 font-semibold">Service</th>
                                    <th class="pb-3 font-semibold">Montant</th>
                                    <th class="pb-3 font-semibold">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EFE1D3]/50">

                                <?php if(empty($derniersRdv)): ?>
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-[#A88B7D]">Aucun rendez-vous trouvé dans la base de données.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($derniersRdv as $rdv): ?>
                                    <tr class="hover:bg-white/40 transition">
                                        <td class="py-4 font-semibold text-[#A65B47]">
                                            <?php echo htmlspecialchars($rdv['appointment_date'] . ' ' . $rdv['appointment_time']); ?>
                                        </td>
                                        
                                        <!-- CLIENT -->
                                        <td class="font-medium text-[#6B5B52] py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-[#C87A65]/20 text-[#C87A65] flex items-center justify-center font-bold">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <span class="font-bold text-[#A65B47]"><?php echo htmlspecialchars($rdv['nom_client'] ?? 'Non spécifié'); ?></span>
                                            </div>
                                        </td>
                                        
                                        <!-- SERVICE -->
                                        <td class="text-[#6B5B52] py-3 font-medium">
                                            <span class="font-semibold text-[#A88B7D]"><?php echo htmlspecialchars($rdv['service_nom'] ?? 'Service'); ?></span>
                                        </td>
                                        
                                        <!-- PRIX -->
                                        <td class="text-[#6B5B52] py-3 font-bold text-[#C87A65]">
                                            <?php echo number_format($rdv['prix_total'] ?? 0, 0, ',', ' '); ?> HTG
                                        </td>
                                        
                                        <!-- STATUT -->
                                        <td>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border bg-emerald-50 text-emerald-700 border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> 
                                                <?php echo htmlspecialchars($rdv['status'] ?? 'pending'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

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
                        <?php if(empty($topPrestations)): ?>
                            <p class="text-xs text-[#A88B7D]">Aucune donnée pour le moment.</p>
                        <?php else: ?>
                            <?php foreach($topPrestations as $item): ?>
                                <div class="flex justify-between items-center text-sm py-1.5 border-b border-[#EFE1D3]/40 last:border-0">
                                    <span class="font-medium text-[#6B5B52]"><?php echo htmlspecialchars($item['nom'] ?? 'Service'); ?></span>
                                    <span class="font-bold text-[#C87A65] bg-[#F4EBE1]/60 px-3 py-0.5 rounded-full text-xs"><?php echo $item['total']; ?> rés.</span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                            <i class="fas fa-calendar-check text-emerald-500 w-4 text-center"></i>
                            <span>Nouveau rendez-vous enregistré</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>
</html>