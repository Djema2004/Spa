<?php
// MENI LIYEN YO DIRECTEMENT
$menu = [
    ['Tableau de bord', 'fa-chart-pie', 'dashboard.php'],
    ['Prestations', 'fa-spa', 'prestations.php'],
    ['Clients', 'fa-users', 'clients.php'],
    ['Esthéticiennes', 'fa-user-tie', 'estheticiennes.php'],
    ['Rendez-vous', 'fa-calendar-check', 'rendezvous.php'],
    ['Paiements', 'fa-wallet', 'paiements.php']
];

// DONE EXACT KI NAN FOTO YO
$prestations = [
    [
        'uid' => 'PRE-6A579209ABC1E',
        'nom' => 'Massage Relaxant',
        'categorie' => 'Massage',
        'prix' => '2,500.00',
        'duree' => '60',
        'statut' => 'Actif'
    ],
    [
        'uid' => 'PRE-6A579209B0640',
        'nom' => 'Massage Relaxant',
        'categorie' => 'Massage',
        'prix' => '50.00',
        'duree' => '60',
        'statut' => 'Actif'
    ],
    [
        'uid' => 'PRE-6A579209B2170',
        'nom' => 'Pose Classique',
        'categorie' => 'Manucure',
        'prix' => '75.00',
        'duree' => '45',
        'statut' => 'Actif'
    ],
    [
        'uid' => 'PRE-6A579209AD415',
        'nom' => 'Soin du Visage Gold',
        'categorie' => 'Soin du Visage',
        'prix' => '3,500.00',
        'duree' => '45',
        'statut' => 'Actif'
    ],
    [
        'uid' => 'PRE-6A579209B3020',
        'nom' => 'Volume Russe',
        'categorie' => 'Extension Cils',
        'prix' => '90.00',
        'duree' => '60',
        'statut' => 'Actif'
    ]
];

$total_prestations = count($prestations);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spa Dream - Prestations</title>
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
                <?php foreach($menu as $m): $isActive = ($m[0] == 'Prestations'); ?>
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
                    <h1 class="text-3xl font-bold font-serif-custom text-[#4A2E2B]">Gestion des Prestations</h1>
                    <p class="text-xs text-[#8C6D68] mt-1">Aperçu analytique et contrôle du catalogue des soins du spa</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button class="px-4 py-2.5 rounded-xl border border-[#D1EBE1] bg-[#EAF7F2] text-[#0D7A5F] text-xs font-bold flex items-center gap-2 hover:bg-[#d8f3e9] transition">
                    <i class="fas fa-file-excel"></i> Export CSV
                </button>
                <button onclick="window.print()" class="px-4 py-2.5 rounded-xl border border-[#E6DAD4] bg-white text-[#6B5B52] text-xs font-bold flex items-center gap-2 hover:bg-gray-50 transition">
                    <i class="fas fa-print"></i> Exporter / Imprimer
                </button>
                <button onclick="openAddModal()" class="px-5 py-2.5 rounded-xl bg-terracotta text-white text-xs font-bold flex items-center gap-2 shadow-md hover:bg-[#823430] transition">
                    <i class="fas fa-plus"></i> Ajouter une prestation
                </button>
            </div>
        </div>

        <!-- STATISTIQUES (3 CARDS) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-5 relative overflow-hidden flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#E68A00] text-white flex items-center justify-center text-xl font-bold">
                    <i class="fas fa-list-check"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#8C6D68]">TOTAL PRESTATIONS</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-3xl font-black text-[#4A2E2B] font-serif-custom" id="statTotal"><?php echo $total_prestations; ?></span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold badge-actif">Actifs</span>
                    </div>
                </div>
            </div>

            <div class="glass-card p-5 relative overflow-hidden flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#D1F2E8] text-[#0D7A5F] flex items-center justify-center text-xl font-bold">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#8C6D68]">PRIX MOYEN</p>
                    <div class="flex items-baseline gap-1 mt-1">
                        <span class="text-3xl font-black text-[#4A2E2B] font-serif-custom">1,243.00</span>
                        <span class="text-xs font-bold text-[#8C6D68]">HTG</span>
                    </div>
                </div>
            </div>

            <div class="glass-card p-5 relative overflow-hidden flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#FCE8E6] text-[#9C413D] flex items-center justify-center text-xl font-bold">
                    <i class="fas fa-crown"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#8C6D68]">CATÉGORIE MAJEURE</p>
                    <span class="text-2xl font-black text-[#4A2E2B] font-serif-custom block mt-1">Massage</span>
                </div>
            </div>
        </div>

        <!-- FILTRES ET RECHERCHE -->
        <div class="glass-card p-4 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="relative flex-1 w-full">
                <i class="fas fa-search absolute left-4 top-3.5 text-[#A38F88] text-sm"></i>
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Rechercher une prestation par nom..." class="w-full pl-10 pr-4 py-2.5 bg-[#FAF7F2] border-none rounded-xl text-xs focus:outline-none text-[#4A2E2B]">
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select id="catFilter" onchange="filterTable()" class="px-4 py-2.5 bg-[#FAF7F2] border-none rounded-xl text-xs font-medium text-[#6B5B52] focus:outline-none">
                    <option value="">Toutes les catégories</option>
                    <option value="Massage">Massage</option>
                    <option value="Manucure">Manucure</option>
                    <option value="Soin du Visage">Soin du Visage</option>
                    <option value="Extension Cils">Extension Cils</option>
                </select>

                <select class="px-4 py-2.5 bg-[#FAF7F2] border-none rounded-xl text-xs font-medium text-[#6B5B52] focus:outline-none">
                    <option>Nom (A-Z)</option>
                    <option>Prix (Plus bas)</option>
                    <option>Prix (Plus haut)</option>
                </select>

                <button onclick="filterTable()" class="px-5 py-2.5 rounded-xl bg-[#4A2E2B] text-white text-xs font-bold flex items-center gap-2 hover:bg-[#36211F] transition">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
            </div>
        </div>

        <!-- TABLO PRESTATIONS -->
        <div class="glass-card overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="prestationsTable">
                    <thead class="uppercase text-[#A38F88] font-bold border-b border-[#F0E8E1] bg-[#FAF7F2]">
                        <tr>
                            <th class="px-6 py-4">UID</th>
                            <th class="px-6 py-4">Nom Prestation</th>
                            <th class="px-6 py-4">Catégorie</th>
                            <th class="px-6 py-4">Prix</th>
                            <th class="px-6 py-4">Durée</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F0E8E1]" id="tableBody">
                        <?php foreach($prestations as $index => $p): ?>
                        <tr class="hover:bg-[#FAF7F2]/50 transition" id="row-<?php echo $index; ?>">
                            <td class="px-6 py-4 font-bold text-[#9C413D] leading-tight w-32 cell-uid">
                                <?php echo $p['uid']; ?>
                            </td>
                            <td class="px-6 py-4 font-bold text-[#4A2E2B] text-sm font-serif-custom cell-nom">
                                <?php echo $p['nom']; ?>
                            </td>
                            <td class="px-6 py-4 cell-cat">
                                <span class="px-3 py-1 rounded-full badge-cat font-medium border border-[#E6DAD4]">
                                    <?php echo $p['categorie']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black text-[#4A2E2B] text-sm cell-prix">
                                <?php echo $p['prix']; ?> <span class="text-[10px] font-bold text-[#8C6D68]">HTG</span>
                            </td>
                            <td class="px-6 py-4 text-[#6B5B52] font-medium cell-duree">
                                <i class="far fa-clock text-[#A38F88] mr-1"></i> <?php echo $p['duree']; ?> min
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold badge-actif inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#065F46]"></span> <?php echo $p['statut']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- BOUTON RÉSERVER (REDIRECT RENDEZVOUS) -->
                                    <a href="rendezvous.php?service=<?php echo urlencode($p['nom']); ?>" title="Réserver" class="w-7 h-7 rounded-lg bg-[#EAF7F2] text-[#0D7A5F] hover:bg-[#0D7A5F] hover:text-white transition flex items-center justify-center text-xs">
                                        <i class="fas fa-calendar-plus"></i>
                                    </a>

                                    <!-- BOUTON VOIR -->
                                    <button onclick="openViewModal('<?php echo $p['uid']; ?>', '<?php echo addslashes($p['nom']); ?>', '<?php echo $p['categorie']; ?>', '<?php echo $p['prix']; ?>', '<?php echo $p['duree']; ?>')" title="Voir" class="w-7 h-7 rounded-lg bg-[#EEF2FF] text-[#4F46E5] hover:bg-[#4F46E5] hover:text-white transition flex items-center justify-center text-xs">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- BOUTON MODIFIER -->
                                    <button onclick="openEditModal(<?php echo $index; ?>, '<?php echo addslashes($p['nom']); ?>', '<?php echo $p['prix']; ?>', '<?php echo $p['categorie']; ?>', '<?php echo $p['duree']; ?>')" title="Modifier" class="w-7 h-7 rounded-lg bg-[#FEF3C7] text-[#D97706] hover:bg-[#D97706] hover:text-white transition flex items-center justify-center text-xs">
                                        <i class="fas fa-pen"></i>
                                    </button>

                                    <!-- BOUTON SUPPRIMER -->
                                    <button onclick="deletePrestation(<?php echo $index; ?>)" title="Supprimer" class="w-7 h-7 rounded-lg bg-[#FEE2E2] text-[#DC2626] hover:bg-[#DC2626] hover:text-white transition flex items-center justify-center text-xs">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-[#F0E8E1] text-xs text-[#8C6D68]">
                Affichage de <span class="font-bold text-[#4A2E2B]" id="displayCount"><?php echo $total_prestations; ?></span> prestation(s) sur un total de <span class="font-bold text-[#4A2E2B]"><?php echo $total_prestations; ?></span>
            </div>
        </div>
    </main>

    <!-- 1. MODAL POU AJOUTE PRESTATION -->
    <div id="addModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-[#E6DAD4]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold font-serif-custom text-[#4A2E2B]">Nouvelle Prestation</h3>
                <button onclick="closeAddModal()" class="text-[#8C6D68] hover:text-[#4A2E2B]"><i class="fas fa-times"></i></button>
            </div>
            <form onsubmit="saveAdd(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Nom Prestation</label>
                    <input type="text" id="addNom" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Catégorie</label>
                    <select id="addCat" class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                        <option value="Massage">Massage</option>
                        <option value="Manucure">Manucure</option>
                        <option value="Soin du Visage">Soin du Visage</option>
                        <option value="Extension Cils">Extension Cils</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Prix (HTG)</label>
                        <input type="text" id="addPrix" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Durée (Min)</label>
                        <input type="number" id="addDuree" value="60" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-xl border border-[#E6DAD4] text-xs font-bold">Annuler</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#9C413D] text-white text-xs font-bold">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MODAL POU MODIFIER PRESTATION -->
    <div id="editModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-[#E6DAD4]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold font-serif-custom text-[#4A2E2B]">Modifier la Prestation</h3>
                <button onclick="closeEditModal()" class="text-[#8C6D68] hover:text-[#4A2E2B]"><i class="fas fa-times"></i></button>
            </div>
            <form onsubmit="saveEdit(event)" class="space-y-4">
                <input type="hidden" id="editRowId">
                <div>
                    <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Nom Prestation</label>
                    <input type="text" id="editNom" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Catégorie</label>
                    <select id="editCat" class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                        <option value="Massage">Massage</option>
                        <option value="Manucure">Manucure</option>
                        <option value="Soin du Visage">Soin du Visage</option>
                        <option value="Extension Cils">Extension Cils</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Prix (HTG)</label>
                        <input type="text" id="editPrix" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#8C6D68] uppercase mb-1">Durée (Min)</label>
                        <input type="number" id="editDuree" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#E6DAD4] text-xs focus:outline-none">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl border border-[#E6DAD4] text-xs font-bold">Annuler</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#9C413D] text-white text-xs font-bold">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. MODAL POU VOIR (👁️) -->
    <div id="viewModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-[#E6DAD4]">
            <div class="flex justify-between items-center pb-3 border-b border-[#E6DAD4] mb-4">
                <h3 class="text-base font-bold font-serif-custom text-[#4A2E2B]" id="viewUid">PRE-XXXXX</h3>
                <button onclick="closeViewModal()" class="text-[#8C6D68] hover:text-[#4A2E2B]"><i class="fas fa-times"></i></button>
            </div>
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-[#8C6D68] uppercase font-bold text-[10px]">Nom Prestation</span>
                    <p class="font-bold text-sm text-[#4A2E2B]" id="viewNom"></p>
                </div>
                <div class="flex justify-between">
                    <div>
                        <span class="text-[#8C6D68] uppercase font-bold text-[10px]">Catégorie</span>
                        <p class="font-semibold text-[#4A2E2B]" id="viewCat"></p>
                    </div>
                    <div>
                        <span class="text-[#8C6D68] uppercase font-bold text-[10px]">Durée</span>
                        <p class="font-semibold text-[#4A2E2B]" id="viewDuree"></p>
                    </div>
                </div>
                <div class="bg-[#FAF7F2] p-3 rounded-xl border border-[#E6DAD4] flex justify-between items-center">
                    <span class="font-bold text-[#8C6D68]">Prix Total</span>
                    <span class="text-base font-black text-[#9C413D]" id="viewPrix"></span>
                </div>
            </div>
            <button onclick="closeViewModal()" class="w-full mt-4 py-2 bg-[#4A2E2B] text-white text-xs font-bold rounded-xl">Fermer</button>
        </div>
    </div>

    <!-- JAVASCRIPT FONKSYONÈL -->
    <script>
        // ADD MODAL
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }
        function saveAdd(e) {
            e.preventDefault();
            alert('Prestation ajoutée avec succès!');
            closeAddModal();
        }

        // EDIT MODAL
        function openEditModal(index, nom, prix, cat, duree) {
            document.getElementById('editRowId').value = index;
            document.getElementById('editNom').value = nom;
            document.getElementById('editPrix').value = prix;
            document.getElementById('editCat').value = cat;
            document.getElementById('editDuree').value = duree;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
        function saveEdit(e) {
            e.preventDefault();
            const index = document.getElementById('editRowId').value;
            const row = document.getElementById('row-' + index);
            if (row) {
                row.querySelector('.cell-nom').innerText = document.getElementById('editNom').value;
                row.querySelector('.cell-prix').innerHTML = document.getElementById('editPrix').value + ' <span class="text-[10px] font-bold text-[#8C6D68]">HTG</span>';
                row.querySelector('.cell-cat').innerHTML = `<span class="px-3 py-1 rounded-full badge-cat font-medium border border-[#E6DAD4]">${document.getElementById('editCat').value}</span>`;
                row.querySelector('.cell-duree').innerHTML = `<i class="far fa-clock text-[#A38F88] mr-1"></i> ${document.getElementById('editDuree').value} min`;
                alert('Prestation modifiée avec succès!');
            }
            closeEditModal();
        }

        // VIEW MODAL (👁️)
        function openViewModal(uid, nom, cat, prix, duree) {
            document.getElementById('viewUid').innerText = uid;
            document.getElementById('viewNom').innerText = nom;
            document.getElementById('viewCat').innerText = cat;
            document.getElementById('viewDuree').innerText = duree + ' minutes';
            document.getElementById('viewPrix').innerText = prix + ' HTG';
            document.getElementById('viewModal').classList.remove('hidden');
            document.getElementById('viewModal').classList.add('flex');
        }
        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
            document.getElementById('viewModal').classList.remove('flex');
        }

        // DELETE
        function deletePrestation(index) {
            if (confirm('Voulez-vous vraiment supprimer cette prestation ?')) {
                const row = document.getElementById('row-' + index);
                if (row) {
                    row.remove();
                    alert('Prestation supprimée avec succès!');
                }
            }
        }

        // FILTER & SEARCH
        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const cat = document.getElementById('catFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#prestationsTable tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const nom = row.querySelector('.cell-nom').innerText.toLowerCase();
                const categorie = row.querySelector('.cell-cat').innerText.toLowerCase();
                
                const matchesSearch = nom.includes(search);
                const matchesCat = cat === '' || categorie.includes(cat);

                if (matchesSearch && matchesCat) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('displayCount').innerText = visibleCount;
        }
    </script>
</body>
</html>