<?php
// ==========================================
// KONEKSYON AK BAZ DONE A (dbspa)
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

// MENI LIYEN YO
$menu = [
    ['Tableau de bord', 'fa-chart-pie', 'dashboard.php'],
    ['Services', 'fa-spa', 'services.php'],
    ['Clients', 'fa-users', 'clients.php'],
    ['Esthéticiennes', 'fa-user-tie', 'estheticiennes.php'],
    ['Rendez-vous', 'fa-calendar-check', 'rendezvous.php'],
    ['Paiements', 'fa-wallet', 'paiements.php']
];

// REKIPERE SÈVIS YO DIREK NAN BAZ DONE A (tab: services)
$stmt = $pdo->query("SELECT * FROM services ORDER BY id DESC");
$services = $stmt->fetchAll();

$total_services = count($services);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spa Dream - Services</title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #FAF7F2; color: #4A2E2B; font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-custom { font-family: 'Playfair Display', serif; }
        .bg-terracotta { background-color: #9C413D; }
        .bg-terracotta:hover { background-color: #823430; }
        .text-terracotta { color: #9C413D; }
        .glass-card { background: #FFFFFF; border: 1px solid #F0E8E1; border-radius: 20px; }
        .badge-actif { background-color: #D1FAE5; color: #065F46; }
        .badge-cat { background-color: #FAF0E6; color: #7A5C55; }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#FAF7F2] border-r border-[#E6DAD4] h-screen sticky top-0 p-6 flex flex-col justify-between z-20">
        <div>
            <!-- LOGO SPA DREAM -->
            <div class="flex items-center gap-3 mb-10">
                <div class="w-8 h-8 rounded-full bg-[#9C413D] flex items-center justify-center text-white text-sm">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-bold font-serif-custom text-[#4A2E2B]">Spa Dream</h1>
            </div>
            
            <!-- MENI -->
            <nav class="space-y-2">
                <?php foreach($menu as $m): $isActive = ($m[0] == 'Services'); ?>
                    <a href="<?php echo $m[2]; ?>" 
                       class="flex items-center gap-3.5 px-4 py-3 rounded-2xl transition font-medium text-sm <?php echo $isActive ? 'bg-[#F2E8DF] text-[#4A2E2B] font-semibold' : 'text-[#8C6D68] hover:bg-[#F2E8DF]/50'; ?>">
                        <i class="fa <?php echo $m[1]; ?> w-5 text-center"></i> 
                        <span><?php echo $m[0]; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <div class="text-xs text-[#A38F88]">
            Spa Dream v2.0 © 2026
        </div>
    </aside>

    <!-- KONTNI PRINCIPAL -->
    <main class="flex-1 p-8">
        
        <!-- HEADER TOP CARD -->
        <div class="glass-card p-6 mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-2 h-10 bg-[#9C413D] rounded-full"></div>
                <div>
                    <h1 class="text-3xl font-bold font-serif-custom text-[#4A2E2B]">Gestion des Services</h1>
                    <p class="text-xs text-[#8C6D68] mt-1">Aperçu analytique et contrôle du catalogue des soins du spa</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button onclick="openAddModal()" class="px-5 py-2.5 rounded-xl bg-terracotta text-white text-xs font-bold flex items-center gap-2 shadow-md hover:bg-[#823430] transition">
                    <i class="fas fa-plus"></i> Ajouter un service
                </button>
            </div>
        </div>

        <!-- STATISTIQUES -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-5 relative overflow-hidden flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#E68A00] text-white flex items-center justify-center text-xl font-bold">
                    <i class="fas fa-list-check"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#8C6D68]">TOTAL SERVICES</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-3xl font-black text-[#4A2E2B] font-serif-custom" id="statTotal"><?php echo $total_services; ?></span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold badge-actif">Actifs</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLO SERVICES -->
        <div class="glass-card overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="servicesTable">
                    <thead class="uppercase text-[#A38F88] font-bold border-b border-[#F0E8E1] bg-[#FAF7F2]">
                        <tr>
                            <th class="px-6 py-4">UID</th>
                            <th class="px-6 py-4">Nom Service</th>
                            <th class="px-6 py-4">Catégorie</th>
                            <th class="px-6 py-4">Prix</th>
                            <th class="px-6 py-4">Durée</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F0E8E1]" id="tableBody">
                        <?php if($total_services > 0): ?>
                            <?php foreach($services as $s): ?>
                            <tr class="hover:bg-[#FAF7F2]/50 transition" id="row-<?php echo $s['id']; ?>">
                                <td class="px-6 py-4 font-bold text-[#9C413D] leading-tight w-32 cell-uid">
                                    <?php echo htmlspecialchars($s['uid'] ?? 'N/A'); ?>
                                </td>
                                <td class="px-6 py-4 font-bold text-[#4A2E2B] text-sm font-serif-custom cell-nom">
                                    <?php echo htmlspecialchars($s['nom'] ?? ''); ?>
                                </td>
                                <td class="px-6 py-4 cell-cat">
                                    <span class="px-3 py-1 rounded-full badge-cat font-medium border border-[#E6DAD4]">
                                        <?php echo htmlspecialchars($s['categorie'] ?? ''); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-black text-[#4A2E2B] text-sm cell-prix">
                                    <?php echo number_format($s['prix'] ?? 0, 2, '.', ','); ?> <span class="text-[10px] font-bold text-[#8C6D68]">HTG</span>
                                </td>
                                <td class="px-6 py-4 text-[#6B5B52] font-medium cell-duree">
                                    <i class="far fa-clock text-[#A38F88] mr-1"></i> <?php echo htmlspecialchars($s['duree'] ?? '0'); ?> min
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold badge-actif inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#065F46]"></span> <?php echo htmlspecialchars($s['statut'] ?? 'Actif'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="rendezvous.php?service=<?php echo urlencode($s['nom'] ?? ''); ?>" title="Réserver" class="w-7 h-7 rounded-lg bg-[#EAF7F2] text-[#0D7A5F] hover:bg-[#0D7A5F] hover:text-white transition flex items-center justify-center text-xs">
                                            <i class="fas fa-calendar-plus"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-center text-[#8C6D68]">Okenn sèvis pa disponib nan baz done a pou kounye a.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-[#F0E8E1] text-xs text-[#8C6D68]">
                Affichage de <span class="font-bold text-[#4A2E2B]" id="displayCount"><?php echo $total_services; ?></span> service(s)
            </div>
        </div>
    </main>

    <!-- MODAL POU AJOUTE SÈVIS -->
    <div id="addModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-[#E6DAD4]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold font-serif-custom text-[#4A2E2B]">Nouveau Service</h3>
                <button onclick="closeAddModal()" class="text-[#8C6D68] hover:text-[#4A2E2B]"><i class="fas fa-times"></i></button>
            </div>
            <form action="ajout_service.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Nom Service</label>
                    <input type="text" name="nom" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Catégorie</label>
                    <select name="categorie" class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                        <option value="Massage">Massage</option>
                        <option value="Manucure">Manucure</option>
                        <option value="Soin du Visage">Soin du Visage</option>
                        <option value="Extension Cils">Extension Cils</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Prix (HTG)</label>
                        <input type="text" name="prix" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Durée (Min)</label>
                        <input type="number" name="duree" value="60" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-xl border border-[#E6DAD4] text-xs font-bold">Annuler</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#9C413D] text-white text-xs font-bold">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }
    </script>
</body>
</html>