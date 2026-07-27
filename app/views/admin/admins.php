<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Administrateurs - Spa</title>
    <!-- Tailwind CSS CDN pour appliquer le design -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Style personnalisé glass-card si nécessaire */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-[#FDFBF7] text-[#6B5B52] min-h-screen p-6">

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Bouton de retour ou En-tête de page -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-serif font-bold text-[#A65B47]">Espace Administrateur</h1>
            <a href="index.php?url=admin/dashboard" class="text-sm font-semibold text-[#C87A65] hover:underline">&larr; Retour au tableau de bord</a>
        </div>

        <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
            <h3 class="font-bold font-serif text-lg text-[#A65B47] mb-4">Ajouter un nouvel Administrateur</h3>
            
            <?= $message ?? '' ?>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#A88B7D] mb-1">Nom</label>
                    <input type="text" name="nom" required class="w-full px-4 py-2.5 rounded-xl border border-[#EFE1D3] bg-white/50 text-sm focus:outline-none focus:border-[#C87A65]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#A88B7D] mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-[#EFE1D3] bg-white/50 text-sm focus:outline-none focus:border-[#C87A65]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#A88B7D] mb-1">Mot de passe</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border border-[#EFE1D3] bg-white/50 text-sm focus:outline-none focus:border-[#C87A65]">
                </div>
                <button type="submit" name="ajouter_admin" class="bg-[#C87A65] text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-[#A65B47] transition shadow-sm">
                    Enregistrer l'administrateur
                </button>
            </form>
        </div>

        <!-- Liste des administrateurs -->
        <div class="glass-card p-6 rounded-3xl border border-white/60 shadow-sm">
            <h3 class="font-bold font-serif text-lg text-[#A65B47] mb-4">Liste des Administrateurs</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-[#A88B7D] border-b border-[#EFE1D3] text-left">
                            <th class="pb-3 font-semibold">Nom</th>
                            <th class="pb-3 font-semibold">Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EFE1D3]/50">
                        <?php if (empty($adminsList)): ?>
                            <tr><td colspan="2" class="py-4 text-center text-[#A88B7D]">Aucun administrateur trouvé.</td></tr>
                        <?php else: ?>
                            <?php foreach ($adminsList as $adm): ?>
                            <tr class="hover:bg-white/40 transition">
                                <td class="py-3 font-bold text-[#A65B47]"><?= htmlspecialchars($adm['firstname'] ?? $adm['nom'] ?? '') ?></td>
                                <td class="py-3 text-[#6B5B52]"><?= htmlspecialchars($adm['email'] ?? '') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>