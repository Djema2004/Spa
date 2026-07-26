<?php
// app/views/admin/estheticiennes.php

// Données fictives (Remplacer plus tard par une requête SQL depuis le Model)
$estheticiennes = [
    [
        'uid' => '#E001',
        'nom' => 'Dupont',
        'prenom' => 'Sophie',
        'telephone' => '+509 3xxx-xxxx',
        'email' => 'sophie@spa.com',
        'specialite' => 'Facial / Soins',
        'disponibilite' => 'Disponible'
    ]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Esthéticiennes - Spa Dream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#FAF6F0] text-[#786962] flex min-h-screen font-sans">

    <!-- ── SIDEBAR ────────────────────────────────────────── -->
    <aside class="w-64 bg-white/80 backdrop-blur-md border-r border-[#E8D8CD] h-screen sticky top-0 p-6 flex flex-col justify-between shadow-sm">
        <div>
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-full bg-[#C97A63] flex items-center justify-center text-white text-lg shadow-sm">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-serif font-bold text-[#B86D58]">Spa Dream</h1>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1.5 font-medium text-sm">
                <a href="admin-dashboard" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#786962] hover:bg-[#FAF6F0] hover:text-[#B86D58] transition">
                    <i class="fas fa-chart-pie w-5"></i> Tableau de bord
                </a>
                <a href="prestations" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#786962] hover:bg-[#FAF6F0] hover:text-[#B86D58] transition">
                    <i class="fas fa-leaf w-5"></i> Prestations
                </a>
                <a href="clients" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#786962] hover:bg-[#FAF6F0] hover:text-[#B86D58] transition">
                    <i class="fas fa-users w-5"></i> Clients
                </a>
                <a href="estheticiennes" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#F0E6DD] text-[#B86D58] font-bold shadow-sm">
                    <i class="fas fa-user-tie w-5"></i> Esthéticiennes
                </a>
                <a href="rendez_vous" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#786962] hover:bg-[#FAF6F0] hover:text-[#B86D58] transition">
                    <i class="fas fa-calendar-alt w-5"></i> Rendez-vous
                </a>
                <a href="paiements" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#786962] hover:bg-[#FAF6F0] hover:text-[#B86D58] transition">
                    <i class="fas fa-wallet w-5"></i> Paiements
                </a>
            </nav>
        </div>

        <!-- Déconnexion -->
        <a href="logout" class="flex items-center gap-3 px-4 py-3 text-rose-600 font-medium text-sm hover:bg-rose-50 rounded-2xl transition">
            <i class="fas fa-sign-out-alt w-5"></i> Déconnexion
        </a>
    </aside>

    <!-- ── MAIN CONTENT ───────────────────────────────────── -->
    <main class="flex-1 p-8 space-y-6">

        <!-- Header Title & Action Buttons -->
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-serif font-bold text-[#B86D58]">Gestion des Esthéticiennes</h2>
                <p class="text-xs text-[#9E8E85] mt-1">Liste complète de l'équipe et des spécialistes</p>
            </div>
            
            <div class="flex items-center gap-2">
                <button onclick="openModal()" class="bg-[#C97A63] hover:bg-[#B86D58] text-white px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-2 shadow-md">
                    <i class="fas fa-plus"></i> Ajouter une esthéticienne
                </button>
                <button class="bg-white border border-[#E8D8CD] text-[#786962] p-2.5 rounded-xl hover:bg-[#FAF6F0] text-xs shadow-sm">
                    <i class="fas fa-file-pdf"></i>
                </button>
                <button class="bg-white border border-[#E8D8CD] text-[#786962] p-2.5 rounded-xl hover:bg-[#FAF6F0] text-xs shadow-sm">
                    <i class="fas fa-file-excel"></i>
                </button>
            </div>
        </div>

        <!-- Search Bar & Filters -->
        <div class="flex justify-between items-center gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-[#9E8E85] text-xs"></i>
                <input type="text" placeholder="Rechercher une esthéticienne (nom, spécialité...)" 
                       class="w-full bg-white border border-[#E8D8CD] rounded-2xl pl-10 pr-4 py-3 text-xs text-[#786962] placeholder-[#9E8E85] focus:outline-none focus:border-[#C97A63]">
            </div>
            <button class="bg-white border border-[#E8D8CD] text-[#786962] px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2 hover:bg-[#FAF6F0]">
                <i class="fas fa-filter text-xs"></i> Filtres
            </button>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-3xl border border-[#E8D8CD] p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-[#9E8E85] uppercase border-b border-[#F0E6DD] font-bold tracking-wider">
                            <th class="pb-4">UID</th>
                            <th class="pb-4">Nom</th>
                            <th class="pb-4">Prénom</th>
                            <th class="pb-4">Téléphone</th>
                            <th class="pb-4">Email</th>
                            <th class="pb-4">Spécialité</th>
                            <th class="pb-4">Disponibilité</th>
                            <th class="pb-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#FAF6F0]">
                        <?php foreach ($estheticiennes as $e): ?>
                        <tr class="hover:bg-[#FAF6F0]/60 transition">
                            <td class="py-4 font-bold text-[#C97A63]"><?= $e['uid'] ?></td>
                            <td class="py-4 font-bold text-[#B86D58]"><?= $e['nom'] ?></td>
                            <td class="py-4 text-[#786962]"><?= $e['prenom'] ?></td>
                            <td class="py-4 text-[#9E8E85]"><?= $e['telephone'] ?></td>
                            <td class="py-4 text-[#9E8E85]"><?= $e['email'] ?></td>
                            <td class="py-4 font-medium text-[#786962]"><?= $e['specialite'] ?></td>
                            <td class="py-4">
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-bold border border-emerald-200">
                                    <?= $e['disponibilite'] ?>
                                </span>
                            </td>
                            <td class="py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="text-sky-500 hover:text-sky-700 p-1"><i class="fas fa-eye"></i></button>
                                    <button class="text-amber-500 hover:text-amber-700 p-1"><i class="fas fa-pen"></i></button>
                                    <button class="text-rose-500 hover:text-rose-700 p-1"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="mt-6 text-center text-xs text-[#9E8E85]">
                Affichage de 1 à <?= count($estheticiennes) ?> sur <?= count($estheticiennes) ?> esthéticienne totale
            </div>
        </div>
    </main>

    <!-- ── MODAL AJOUTER ESTHÉTICIENNE ────────────────────── -->
    <div id="addModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-[#FAF6F0] border border-[#E8D8CD] rounded-3xl p-6 w-full max-w-lg shadow-2xl space-y-4">
            <div class="flex justify-between items-center border-b border-[#E8D8CD] pb-3">
                <h3 class="font-serif font-bold text-lg text-[#B86D58]">Ajouter une Esthéticienne</h3>
                <button onclick="closeModal()" class="text-[#9E8E85] hover:text-[#B86D58]"><i class="fas fa-times"></i></button>
            </div>
            
            <form action="" method="POST" class="space-y-3 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-[#786962] mb-1">Nom</label>
                        <input type="text" required class="w-full bg-white border border-[#E8D8CD] rounded-xl p-2.5 focus:outline-none focus:border-[#C97A63]">
                    </div>
                    <div>
                        <label class="block font-bold text-[#786962] mb-1">Prénom</label>
                        <input type="text" required class="w-full bg-white border border-[#E8D8CD] rounded-xl p-2.5 focus:outline-none focus:border-[#C97A63]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-[#786962] mb-1">Téléphone</label>
                        <input type="text" placeholder="+509..." required class="w-full bg-white border border-[#E8D8CD] rounded-xl p-2.5 focus:outline-none focus:border-[#C97A63]">
                    </div>
                    <div>
                        <label class="block font-bold text-[#786962] mb-1">Email</label>
                        <input type="email" required class="w-full bg-white border border-[#E8D8CD] rounded-xl p-2.5 focus:outline-none focus:border-[#C97A63]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-[#786962] mb-1">Spécialité</label>
                    <input type="text" placeholder="ex: Facial, Massage, Manucure" class="w-full bg-white border border-[#E8D8CD] rounded-xl p-2.5 focus:outline-none focus:border-[#C97A63]">
                </div>

                <div class="pt-3 flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-white border border-[#E8D8CD] text-[#786962] rounded-full font-bold">Annuler</button>
                    <button type="submit" class="px-5 py-2 bg-[#C97A63] text-white rounded-full font-bold hover:bg-[#B86D58] shadow-md">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script pou ouvri/fèmen Modal la -->
    <script>
        function openModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }
        function closeModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }
    </script>
</body>
</html>