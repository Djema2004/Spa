<?php
// ==========================================
// 1. CONNEXION À LA BASE DE DONNÉES (PDO)
// ==========================================
$host = 'localhost';
$dbname = 'dbspa'; // Chanje si baz de données ou gen yon lòt non
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// ==========================================
// 2. TRAITEMENT DES ACTIONS ET FORMULAIRES
// ==========================================
$message = "";

if (isset($_GET['action']) && $_GET['action'] === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client = !empty($_POST['id_client']) ? $_POST['id_client'] : 1;
    $id_estheticienne = !empty($_POST['id_estheticienne']) ? $_POST['id_estheticienne'] : 1;
    $service = $_POST['service'] ?? '';
    $montant = $_POST['montant'] ?? 0;
    $mode_paiement = $_POST['mode_paiement'] ?? 'MonCash En Ligne';
    $date_rendezvous = $_POST['date_rendezvous'] ?? date('Y-m-d H:i:s');
    $statut = 'Confirmé';

    if (!empty($service) && !empty($montant) && !empty($date_rendezvous)) {
        try {
            // Tcheke si kolòn yo egziste, nou ensere dirèkteman
            $sql = "INSERT INTO rendezvous (id_client, id_estheticienne, service, montant, mode_paiement, date_rendezvous, statut) 
                    VALUES (:id_client, :id_estheticienne, :service, :montant, :mode_paiement, :date_rendezvous, :statut)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_client' => $id_client,
                ':id_estheticienne' => $id_estheticienne,
                ':service' => $service,
                ':montant' => $montant,
                ':mode_paiement' => $mode_paiement,
                ':date_rendezvous' => $date_rendezvous,
                ':statut' => $statut
            ]);
            header('Location: rendezvous.php');
            exit();
        } catch (PDOException $e) {
            $message = "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    } else {
        $message = "Tanpri ranpli tout chan obligatwa yo.";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM rendezvous WHERE id_rendezvous = ?");
        $stmt->execute([$del_id]);
    } catch (PDOException $e) {
        // Ignore or handle
    }
    header('Location: rendezvous.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'export') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=rendezvous_dbspa_' . date('Y-m-d') . '.csv');
    $output = fopen('php://output', 'w');
    fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($output, ['ID', 'Client', 'Service', 'Montant', 'Mode de Paiement', 'Date', 'Statut']);
    
    try {
        $queryExport = $pdo->query("SELECT r.*, c.nom as client_nom FROM rendezvous r LEFT JOIN clients c ON r.id_client = c.id");
        while ($row = $queryExport->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [$row['id_rendezvous'], $row['client_nom'] ?? 'Client', $row['service'], $row['montant'], $row['mode_paiement'], $row['date_rendezvous'], $row['statut']]);
        }
    } catch (Exception $ex) {
        // Fallback si la table clients n'existe pas encore
        $queryExport = $pdo->query("SELECT * FROM rendezvous");
        while ($row = $queryExport->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [$row['id_rendezvous'], 'Client #' . $row['id_client'], $row['service'], $row['montant'], $row['mode_paiement'], $row['date_rendezvous'], $row['statut']]);
        }
    }
    fclose($output);
    exit();
}

// ==========================================
// 3. RÉCUPÉRATION DES DONNÉES ET STATISTIQUES
// ==========================================
$menu = [
    ['Tableau de bord', 'fa-chart-pie', 'dashboard.php'],
    ['Prestations', 'fa-spa', 'prestations.php'],
    ['Clients', 'fa-users', 'clients.php'],
    ['Esthéticiennes', 'fa-user-tie', 'estheticiennes.php'],
    ['Rendez-vous', 'fa-calendar-check', 'rendezvous.php'],
    ['Paiements', 'fa-wallet', 'paiements.php']
];

$allRendezVous = [];
$clients_list = [];

try {
    $stmtRdv = $pdo->query("SELECT r.*, c.nom as client_nom, c.telephone as client_phone, c.photo as client_photo 
                            FROM rendezvous r 
                            LEFT JOIN clients c ON r.id_client = c.id 
                            ORDER BY r.date_rendezvous DESC");
    $allRendezVous = $stmtRdv->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    try {
        // Si la jointure échoue (ex: pas de table clients), on prend juste les rdv
        $stmtRdv = $pdo->query("SELECT * FROM rendezvous ORDER BY date_rendezvous DESC");
        $allRendezVous = $stmtRdv->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        $allRendezVous = [];
    }
}

try {
    $stmtClients = $pdo->query("SELECT * FROM clients");
    $clients_list = $stmtClients->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $clients_list = [];
}

$total_rdv_count = count($allRendezVous);
$chiffre_affaires = 0;
$unique_clients = [];

foreach ($allRendezVous as $rdv) {
    $raw_amount = (float) str_replace([',', ' HTG', '$', ' '], '', $rdv['montant']);
    $statut_clean = strtoupper(trim($rdv['statut'] ?? 'Confirmé'));
    if (in_array($statut_clean, ['CONFIRMÉ', 'CONFIRME', 'TERMINÉ', 'TERMINE', 'EFFECTUÉ', 'EFFECTUE'])) {
        $chiffre_affaires += $raw_amount;
    }
    $c_id_val = $rdv['client_nom'] ?? ($rdv['id_client'] ?? 'Inconnu');
    if (!in_array($c_id_val, $unique_clients)) {
        $unique_clients[] = $c_id_val;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Spa Dream | Gestion des Rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background-color: #FAF7F2;
            color: #5C3A3C;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.75); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
        }
        .profile-table-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .bg-terracotta {
            background-color: #C88573;
        }
        .bg-terracotta:hover {
            background-color: #B57463;
        }
        .text-terracotta {
            color: #C88573;
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white/70 border-r border-[#F5E6E8]/80 h-screen sticky top-0 backdrop-blur-xl p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-2xl bg-terracotta flex items-center justify-center text-white shadow-md shadow-[#C88573]/35 text-xl">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-bold font-serif tracking-wide text-[#4A2E30]">Spa Dream</h1>
            </div>
            
            <nav class="space-y-1">
                <?php 
                foreach($menu as $m): 
                    $isActive = ($m[0] == 'Rendez-vous');
                ?>
                    <a href="<?php echo $m[2]; ?>" 
                       class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl transition font-medium text-sm <?php echo $isActive ? 'bg-terracotta text-white shadow-lg shadow-[#C88573]/30' : 'text-[#A07173] hover:bg-[#F5E6E8]/60 hover:text-[#5C3A3C]'; ?>">
                        <i class="fa <?php echo $m[1]; ?> w-5 text-center"></i> 
                        <span><?php echo $m[0]; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <div class="pt-4 border-t border-[#F5E6E8] space-y-1">
            <a href="profil.php" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 hover:text-[#5C3A3C] transition font-medium text-sm">
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

    <!-- CONTENU PRINCIPAL -->
    <main class="flex-1 p-8">
        
        <!-- HEADER -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold font-serif text-[#4A2E30]">Gestion des Rendez-vous</h2>
                <p class="text-sm text-[#A07173] mt-1">Suivi des plannings, paiements en ligne et statuts des réservations</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex gap-2 bg-white/60 p-1.5 rounded-2xl border border-[#F5E6E8]/80 shadow-sm">
                    <a href="clients.php" class="bg-terracotta text-white w-9 h-9 rounded-xl hover:bg-[#B57463] transition shadow-sm flex items-center justify-center" title="Nouveau Client">
                        <i class="fas fa-user-plus text-xs"></i>
                    </a>
                    <a href="prestations.php" class="bg-terracotta text-white w-9 h-9 rounded-xl hover:bg-[#B57463] transition shadow-sm flex items-center justify-center" title="Nouvelle Prestation">
                        <i class="fas fa-spa text-xs"></i>
                    </a>
                    <button type="button" id="openModalBtn" class="bg-terracotta text-white w-9 h-9 rounded-xl hover:bg-[#B57463] transition shadow-sm flex items-center justify-center cursor-pointer" title="Nouveau Rendez-vous">
                        <i class="fas fa-calendar-plus text-xs"></i>
                    </button>
                    <a href="paiements.php" class="bg-terracotta text-white w-9 h-9 rounded-xl hover:bg-[#B57463] transition shadow-sm flex items-center justify-center" title="Nouveau Paiement">
                        <i class="fas fa-wallet text-xs"></i>
                    </a>
                </div>
            </div>
        </header>

        <!-- MESSAGE D'ERREUR EVENTUEL -->
        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-semibold">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- STATISTIQUES KPI -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
            <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Total Rendez-vous</p>
                <p class="text-3xl font-black mt-2 text-[#4A2E30]"><?php echo $total_rdv_count; ?></p>
            </div>
            <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Chiffre d'Affaires</p>
                <p class="text-3xl font-black mt-2 text-[#4A2E30]"><?php echo number_format($chiffre_affaires, 2); ?> HTG</p>
            </div>
            <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Total Clients</p>
                <p class="text-3xl font-black mt-2 text-[#4A2E30]"><?php echo count($unique_clients); ?></p>
            </div>
            <div class="glass-card p-5 rounded-3xl border border-white/60 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Prestations</p>
                <p class="text-3xl font-black mt-2 text-[#4A2E30]">15</p>
            </div>
        </div>

        <!-- RECHERCHE ET FILTRES -->
        <div class="flex flex-col md:flex-row gap-4 mb-6 justify-between">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-3.5 text-[#A07173]"></i>
                <input type="text" id="searchInput" placeholder="Rechercher un rendez-vous..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-white/80 rounded-2xl border border-[#F5E6E8]/80 text-sm focus:outline-none shadow-sm">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter" class="bg-white/80 px-4 py-2.5 rounded-2xl border border-[#F5E6E8]/80 text-[#6B5B52] font-semibold text-sm shadow-sm focus:outline-none">
                    <option value="">Tous les Statuts</option>
                    <option value="Confirmé">Confirmé</option>
                    <option value="En attente">En attente</option>
                    <option value="Annulé">Annulé</option>
                </select>
                <a href="rendezvous.php?action=export" class="bg-white/80 px-4 py-2.5 rounded-2xl border border-[#F5E6E8]/80 text-[#6B5B52] font-semibold text-sm flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-export text-[#A07173]"></i> Exporter CSV
                </a>
            </div>
        </div>

        <!-- TABLEAU -->
        <div class="glass-card rounded-3xl border border-white/60 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left" id="rdvTable">
                    <thead class="text-xs uppercase text-[#A88B7D] border-b border-[#F5E6E8]/80 bg-white/40">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Client</th>
                            <th class="px-6 py-4 font-semibold">Service</th>
                            <th class="px-6 py-4 font-semibold">Esthéticienne ID</th>
                            <th class="px-6 py-4 font-semibold">Montant</th>
                            <th class="px-6 py-4 font-semibold">Mode de Paiement</th>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold text-center">Statut</th>
                            <th class="px-6 py-4 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F5E6E8]/60 bg-white/20">
                        <?php if (empty($allRendezVous)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-6 text-sm text-[#A07173]">Aucun rendez-vous trouvé.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($allRendezVous as $rdv): 
                                $c_photo = !empty($rdv['client_photo']) ? $rdv['client_photo'] : 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80';
                                $c_name = $rdv['client_nom'] ?? ('Client #' . ($rdv['id_client'] ?? '1'));
                                $c_phone = $rdv['client_phone'] ?? '+50900000000';
                                $mode = $rdv['mode_paiement'] ?? 'MonCash En Ligne';
                                $rdv_id = $rdv['id_rendezvous'] ?? 1;
                                
                                $p_icon = 'fa-mobile-alt';
                                if ($mode === 'Carte bancaire') $p_icon = 'fa-credit-card';
                                elseif ($mode === 'Virement En Ligne') $p_icon = 'fa-globe';
                                elseif ($mode === 'En Espèces') $p_icon = 'fa-money-bill-wave';
                            ?>
                            <tr class="hover:bg-white/40 transition rdv-row">
                                <td class="px-6 py-4">
                                    <div class="profile-table-cell">
                                        <img src="<?php echo htmlspecialchars($c_photo); ?>" class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <p class="font-bold text-[#A65B47] client-name"><?php echo htmlspecialchars($c_name); ?></p>
                                            <p class="text-xs text-[#A88B7D]">ID: #CLI-00<?php echo $rdv_id; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-[#6B5B52] service-name"><?php echo htmlspecialchars($rdv['service']); ?></td>
                                <td class="px-6 py-4 font-semibold text-[#6B5B52]">ID: <?php echo htmlspecialchars($rdv['id_estheticienne']); ?></td>
                                <td class="px-6 py-4 font-bold text-[#6B5B52]"><?php echo htmlspecialchars($rdv['montant']); ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-2 bg-[#FAF7F2] text-[#6B5B52] px-3.5 py-1.5 rounded-full text-xs font-semibold border mode-name">
                                        <i class="fas <?php echo $p_icon; ?>"></i> <?php echo htmlspecialchars($mode); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-[#A88B7D]"><?php echo htmlspecialchars($rdv['date_rendezvous']); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border statut-text bg-emerald-50 text-emerald-700 border-emerald-200">
                                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($rdv['statut'] ?? 'Confirmé'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 text-base">
                                        <a href="https://wa.me/<?php echo $c_phone; ?>?text=<?php echo urlencode("Bonjour " . $c_name . ", nous vous rappelons votre rendez-vous pour " . $rdv['service'] . " le " . $rdv['date_rendezvous'] . " chez Spa Dream."); ?>" 
                                           target="_blank" 
                                           class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition flex items-center justify-center border border-emerald-200" 
                                           title="Rappel WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>

                                        <button type="button" 
                                                onclick="openRecuModal('<?php echo $rdv_id; ?>', '<?php echo htmlspecialchars($c_name, ENT_QUOTES); ?>', '<?php echo htmlspecialchars($rdv['service'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($rdv['montant'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($mode, ENT_QUOTES); ?>', '<?php echo htmlspecialchars($rdv['date_rendezvous'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($rdv['id_estheticienne'], ENT_QUOTES); ?>')"
                                                class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center border border-blue-200 cursor-pointer" 
                                                title="Voir reçu">
                                            <i class="fas fa-file-invoice font-semibold"></i>
                                        </button>

                                        <a href="rendezvous.php?action=delete&id=<?php echo $rdv_id; ?>" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?');" 
                                           class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition flex items-center justify-center border border-rose-200" 
                                           title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- MODAL AJOUTER RDV -->
    <div id="rdvModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-[#F5E6E8]">
            <div class="flex items-center justify-between pb-4 border-b border-[#F5E6E8]">
                <h3 class="text-lg font-bold font-serif text-[#4A2E30]">Nouveau Rendez-vous</h3>
                <button type="button" id="closeModalBtn" class="text-[#A07173] hover:text-[#4A2E30] cursor-pointer"><i class="fas fa-times text-lg"></i></button>
            </div>
            
            <form action="rendezvous.php?action=save" method="POST" class="mt-4 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Client ID (ou Sélection)</label>
                    <input type="number" name="id_client" required value="1" placeholder="ID du client" class="w-full p-3 bg-[#FAF7F2] rounded-xl border text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Service</label>
                        <input type="text" name="service" required placeholder="Ex: Massage Relaxant" class="w-full p-3 bg-[#FAF7F2] rounded-xl border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Esthéticienne ID</label>
                        <input type="number" name="id_estheticienne" required value="1" class="w-full p-3 bg-[#FAF7F2] rounded-xl border text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Montant</label>
                        <input type="text" name="montant" required placeholder="Ex: 3500.00" class="w-full p-3 bg-[#FAF7F2] rounded-xl border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Paiement</label>
                        <select name="mode_paiement" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border text-sm">
                            <option value="MonCash En Ligne">MonCash En Ligne</option>
                            <option value="Carte bancaire">Carte bancaire</option>
                            <option value="Virement En Ligne">Virement En Ligne</option>
                            <option value="En Espèces">En Espèces</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Date & Heure</label>
                    <input type="datetime-local" name="date_rendezvous" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border text-sm">
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-[#F5E6E8]">
                    <button type="button" id="cancelModalBtn" class="px-5 py-2.5 rounded-xl border text-xs font-bold text-[#6B5B52] cursor-pointer">Annuler</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-terracotta text-white text-xs font-bold cursor-pointer">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL REÇU -->
    <div id="recuModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-[#F5E6E8]">
            <div class="flex items-center justify-between pb-4 border-b border-[#F5E6E8]">
                <h3 class="text-lg font-bold font-serif text-[#4A2E30]"><i class="fas fa-receipt text-terracotta mr-2"></i> Reçu de Paiement</h3>
                <button type="button" onclick="closeRecuModal()" class="text-[#A07173] hover:text-[#4A2E30] cursor-pointer"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="mt-4 space-y-3 text-sm text-[#6B5B52]">
                <div class="flex justify-between border-b pb-2"><span class="text-[#A07173]">ID Rendez-vous :</span> <span id="recuId" class="font-bold"></span></div>
                <div class="flex justify-between border-b pb-2"><span class="text-[#A07173]">Client :</span> <span id="recuClient" class="font-bold"></span></div>
                <div class="flex justify-between border-b pb-2"><span class="text-[#A07173]">Service :</span> <span id="recuService" class="font-bold"></span></div>
                <div class="flex justify-between border-b pb-2"><span class="text-[#A07173]">Esthéticienne ID :</span> <span id="recuEstheticienne" class="font-bold"></span></div>
                <div class="flex justify-between border-b pb-2"><span class="text-[#A07173]">Date :</span> <span id="recuDate" class="font-bold"></span></div>
                <div class="flex justify-between border-b pb-2"><span class="text-[#A07173]">Mode de Paiement :</span> <span id="recuMode" class="font-bold"></span></div>
                <div class="flex justify-between pt-2 text-base font-bold text-terracotta"><span>Montant Total :</span> <span id="recuMontant"></span></div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-terracotta text-white text-xs font-bold cursor-pointer"><i class="fas fa-print mr-1"></i> Imprimer le Reçu</button>
            </div>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById('rdvModal');
            const openBtn = document.getElementById('openModalBtn');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');

            function openModal() {
                if(modal) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            }

            function closeModal() {
                if(modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            }

            if(openBtn) openBtn.addEventListener('click', openModal);
            if(closeBtn) closeBtn.addEventListener('click', closeModal);
            if(cancelBtn) cancelBtn.addEventListener('click', closeModal);

            const searchInput = document.getElementById("searchInput");
            const statusFilter = document.getElementById("statusFilter");

            function filterTable() {
                const query = searchInput ? searchInput.value.toLowerCase() : "";
                const statusQuery = statusFilter ? statusFilter.value.toLowerCase() : "";
                const rows = document.querySelectorAll(".rdv-row");

                rows.forEach(row => {
                    const client = row.querySelector(".client-name").textContent.toLowerCase();
                    const service = row.querySelector(".service-name").textContent.toLowerCase();
                    const mode = row.querySelector(".mode-name").textContent.toLowerCase();
                    const status = row.querySelector(".statut-text").textContent.toLowerCase();

                    const matchesSearch = client.includes(query) || service.includes(query) || mode.includes(query);
                    const matchesStatus = statusQuery === "" || status.includes(statusQuery);

                    if (matchesSearch && matchesStatus) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            if(searchInput) searchInput.addEventListener("keyup", filterTable);
            if(statusFilter) statusFilter.addEventListener("change", filterTable);
        });

        function openRecuModal(id, client, service, montant, mode, date, estheticienne) {
            document.getElementById('recuId').textContent = '#CLI-00' + id;
            document.getElementById('recuClient').textContent = client;
            document.getElementById('recuService').textContent = service;
            document.getElementById('recuMontant').textContent = montant;
            document.getElementById('recuMode').textContent = mode;
            document.getElementById('recuDate').textContent = date;
            document.getElementById('recuEstheticienne').textContent = estheticienne;

            const modal = document.getElementById('recuModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRecuModal() {
            const modal = document.getElementById('recuModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
</body>
</html>