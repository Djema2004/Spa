<header class="flex justify-between items-center bg-white p-6 border-b border-[#EADEA7]/20">
    <div>
        <h1 class="text-xl font-bold text-[#5C3A35]">Bonjour, <?= htmlspecialchars($adminName) ?></h1>
        <p class="text-sm text-[#8A7977]"><?= $messageBienvenue ?></p>
    </div>
    <div class="flex items-center gap-6">
        <div class="text-right">
            <p class="text-sm font-bold"><?= date('d M Y') ?></p>
            <p class="text-xs text-[#A39290]" id="clock"></p>
        </div>
        <div class="relative">
            <i class="fa-solid fa-bell text-[#8C5E58]"></i>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-1 rounded-full"><?= $notifCount ?></span>
        </div>
        <div class="flex gap-4">
            <a href="/admin/profile" title="Mon Profil"><i class="fa-solid fa-user"></i></a>
            <a href="/admin/settings" title="Paramètres"><i class="fa-solid fa-cog"></i></a>
            <a href="/logout" class="text-red-600" title="Déconnexion"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </div>
</header>