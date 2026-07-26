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
    ['Users', 'fa-users', 'clients.php'],
    ['Esthéticiennes', 'fa-user-tie', 'estheticiennes.php'],
    ['Rendez-vous', 'fa-calendar-check', 'rendezvous.php'],
    ['Paiements', 'fa-wallet', 'paiements.php']
];

// REKIPERE SÈLMAN ITILIZATÈ KI GEN WÒL 'client' NAN BAZ DONE A
$stmt = $pdo->query("SELECT * FROM users WHERE role = 'client' ORDER BY created_at DESC");
$users = $stmt->fetchAll();

$total_users = count($users);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spa Dream - Gestion des Clients</title>
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
                <?php foreach($menu as $m): $isActive = ($m[0] == 'Users'); ?>
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
                    <h1 class="text-3xl font-bold font-serif-custom text-[#4A2E2B]">Gestion des Clients</h1>
                    <p class="text-xs text-[#8C6D68] mt-1">Liste complète de vos clients enregistrés</p>
                </div>
            </div>
        </div>

        <!-- TABLO USERS -->
        <div class="glass-card overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="usersTable">
                    <thead class="uppercase text-[#A38F88] font-bold border-b border-[#F0E8E1] bg-[#FAF7F2]">
                        <tr>
                            <th class="px-6 py-4">UID / ID</th>
                            <th class="px-6 py-4">Nom (Lastname)</th>
                            <th class="px-6 py-4">Prénom (Firstname)</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Rôle</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F0E8E1]" id="tableBody">
                        <?php if($total_users > 0): ?>
                            <?php foreach($users as $user): ?>
                            <tr class="hover:bg-[#FAF7F2]/50 transition" id="row-<?php echo $user['id']; ?>">
                                <td class="px-6 py-4 font-bold text-[#9C413D] leading-tight w-48">
                                    <?php echo htmlspecialchars($user['uid'] ?? $user['id']); ?>
                                </td>
                                <td class="px-6 py-4 font-bold text-[#4A2E2B] text-sm font-serif-custom">
                                    <?php echo htmlspecialchars($user['lastname'] ?? ''); ?>
                                </td>
                                <td class="px-6 py-4 text-[#4A2E2B] font-medium">
                                    <?php echo htmlspecialchars($user['firstname'] ?? ''); ?>
                                </td>
                                <td class="px-6 py-4 text-[#6B5B52]">
                                    <?php echo htmlspecialchars($user['email'] ?? ''); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold badge-actif inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#065F46]"></span> Actif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" title="Modifye" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center text-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-center text-[#8C6D68]">Okenn kliyan pa disponib nan baz done a pou kounye a.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-[#F0E8E1] text-xs text-[#8C6D68]">
                Affichage de <span class="font-bold text-[#4A2E2B]"><?php echo $total_users; ?></span> client(s) au total
            </div>
        </div>
    </main>

</body>
</html>