<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Spa Dream | Esthéticiennes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #FDFBF7; }
    </style>
</head>
<body class="text-[#4A2E30] flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white/50 border-r border-[#D2B48C]/20 min-h-screen p-6 sticky top-0 backdrop-blur-xl">
        <div class="flex items-center gap-3 mb-12">
            <div class="w-10 h-10 flex items-center justify-center text-[#BA4A43] text-2xl"><i class="fas fa-spa"></i></div>
            <h1 class="text-xl font-bold font-serif tracking-wide">Spa Dream</h1>
        </div>
        <nav class="space-y-2">
            <?php 
            $menu = [
                ['Tableau de bord', 'fa-chart-pie', 'dashboard.php'],
                ['Prestations', 'fa-spa', 'prestations.php'],
                ['Clients', 'fa-users', 'clients.php'],
                ['Esthéticiennes', 'fa-user-tie', 'estheticiennes.php'],
                ['Rendez-vous', 'fa-calendar-check', 'rendezvous.php'],
                ['Paiements', 'fa-wallet', 'paiements.php']
            ];
            foreach($menu as $m): 
                $isActive = ($m[0] == 'Esthéticiennes');
            ?>
                <a href="<?php echo $m[2]; ?>" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition font-medium <?php echo $isActive ? 'bg-[#D2B48C]/20 text-[#4A2E30]' : 'text-[#8E6E53] hover:bg-[#D2B48C]/10 hover:text-[#4A2E30]'; ?>">
                    <i class="fa <?php echo $m[1]; ?> w-5 opacity-70"></i> <?php echo $m[0]; ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>

    <!-- KONTNI PRINCIPAL -->
    <main class="flex-1 p-8">
        
        <!-- HEADER ESTHÉTICIENNES -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold font-serif text-[#4A2E30]">Gestion des Esthéticiennes</h2>
                <p class="text-[#8E6E53] text-sm">Liste complète de l'équipe et des spécialistes</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button class="bg-[#BA4A43] text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-[#A03D37] transition flex items-center gap-2 shadow-lg shadow-[#BA4A43]/20">
                    <i class="fas fa-plus"></i> Ajouter une esthéticienne
                </button>
                <div class="flex gap-1">
                    <button class="bg-white border border-[#8E6E53]/30 text-[#8E6E53] px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-[#8E6E53] hover:text-white transition"><i class="fas fa-file-pdf"></i></button>
                    <button class="bg-white border border-[#8E6E53]/30 text-[#8E6E53] px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-[#8E6E53] hover:text-white transition"><i class="fas fa-file-excel"></i></button>
                </div>
            </div>
        </div>

        <!-- RECHÈCH AK FILTRE -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-3.5 text-[#D2B48C]"></i>
                <input type="text" placeholder="Rechercher une esthéticienne (nom, spécialité...)" class="w-full pl-12 pr-4 py-3 rounded-2xl border border-[#D2B48C]/30 bg-white/50 focus:outline-none focus:ring-2 focus:ring-[#D2B48C]">
            </div>
            <button class="px-5 py-3 rounded-2xl border border-[#D2B48C]/30 text-[#8E6E53] bg-white/50 hover:bg-[#D2B48C]/10 transition flex items-center gap-2 font-medium">
                <i class="fas fa-filter"></i> Filtres
            </button>
        </div>

        <!-- TABLO ESTHÉTICIENNES -->
        <div class="bg-white/60 rounded-3xl border border-[#FCD7CC]/30 shadow-xl shadow-[#D2B48C]/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#D2B48C]/5 text-[#8E6E53] uppercase text-[10px] tracking-widest border-b border-[#FCD7CC]/50">
                        <tr>
                            <th class="py-4 px-6">UID</th>
                            <th class="py-4 px-6">Nom</th>
                            <th class="py-4 px-6">Prénom</th>
                            <th class="py-4 px-6">Téléphone</th>
                            <th class="py-4 px-6">Email</th>
                            <th class="py-4 px-6">Spécialité</th>
                            <th class="py-4 px-6">Disponibilité</th>
                            <th class="py-4 px-6 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#FCD7CC]/30">
                        <tr class="text-[#4A2E30] hover:bg-[#D2B48C]/10 transition">
                            <td class="py-4 px-6 font-mono font-bold text-[#BA4A43]">#E001</td>
                            <td class="py-4 px-6 font-semibold">Dupont</td>
                            <td class="py-4 px-6">Sophie</td>
                            <td class="py-4 px-6">+509 3xxx-xxxx</td>
                            <td class="py-4 px-6 text-gray-600">sophie@spa.com</td>
                            <td class="py-4 px-6">Facial / Soins</td>
                            <td class="py-4 px-6">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Disponible</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center gap-4">
                                    <button class="text-blue-500 hover:scale-125 transition" title="Voir"><i class="fas fa-eye"></i></button>
                                    <button class="text-amber-500 hover:scale-125 transition" title="Modifier"><i class="fas fa-edit"></i></button>
                                    <button class="text-red-500 hover:scale-125 transition" title="Supprimer"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-[#D2B48C]/5 text-center text-xs text-[#8E6E53] border-t border-[#FCD7CC]/30">
                Affichage de 1 à 1 sur 1 esthéticienne totale
            </div>
        </div>

    </main>
</body>
</html>