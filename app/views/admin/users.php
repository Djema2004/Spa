<?php
// app/views/admin/users.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($users)) {
    try {
        $db = new PDO('mysql:host=localhost;dbname=dbspa;charset=utf8mb4', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    $message = "";
    $messageType = "success";

    // --- 1. SUPPRESSION ---
    if (isset($_GET['delete'])) {
        $id_to_delete = $_GET['delete'];
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$id_to_delete])) {
            $message = "Utilisateur supprimé avec succès !";
        }
    }

    // --- 2. TRAITEMENT DU FORMULAIRE ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'add_user') {
            $prenom = $_POST['prenom'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $email = $_POST['email'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $role = $_POST['role'] ?? 'Réceptionniste';

            if (!empty($prenom) && !empty($nom) && !empty($email) && !empty($mot_de_passe)) {
                $id = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                );

                $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

                $stmt = $db->prepare("INSERT INTO users (id, prenom, nom, email, password, role, statut) VALUES (?, ?, ?, ?, ?, ?, 'Actif')");
                if ($stmt->execute([$id, $prenom, $nom, $email, $hash, $role])) {
                    $message = "Utilisateur ajouté avec succès !";
                }
            }
        } elseif ($action === 'edit_user') {
            $id = $_POST['id'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? 'Réceptionniste';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';

            if (!empty($id) && !empty($prenom) && !empty($nom) && !empty($email)) {
                if (!empty($mot_de_passe)) {
                    $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
                    $stmt = $db->prepare("UPDATE users SET prenom = ?, nom = ?, email = ?, password = ?, role = ? WHERE id = ?");
                    $success = $stmt->execute([$prenom, $nom, $email, $hash, $role, $id]);
                } else {
                    $stmt = $db->prepare("UPDATE users SET prenom = ?, nom = ?, email = ?, role = ? WHERE id = ?");
                    $success = $stmt->execute([$prenom, $nom, $email, $role, $id]);
                }

                if ($success) {
                    $message = "Utilisateur modifié avec succès !";
                }
            }
        }
    }

    // --- 3. RÉCUPÉRATION DES DONNÉES ---
    $userToEdit = null;
    if (isset($_GET['edit'])) {
        $id_to_edit = $_GET['edit'];
        $stmtEdit = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmtEdit->execute([$id_to_edit]);
        $userToEdit = $stmtEdit->fetch(PDO::FETCH_ASSOC);
    }

    $stmt = $db->query("SELECT * FROM users ORDER BY prenom ASC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$users) {
        $users = [];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - Spa Dream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background-color: #FAF4EE;
            color: #6B4C4A;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .glass-card { 
            background: #FFFFFF; 
            border: 1px solid rgba(214, 188, 178, 0.3);
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#FAF4EE] border-r border-[#EADBD4] h-screen sticky top-0 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-2xl bg-[#C6856F] flex items-center justify-center text-white shadow-sm text-xl">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-bold font-serif tracking-wide text-[#6B4C4A]">Spa Dream</h1>
            </div>
            
            <nav class="space-y-1">
                <?php 
                $menu = [
                    ['Tableau de bord', 'fa-chart-pie', '/admin/dashboard'],
                    ['Users', 'fa-user-shield', '/admin/users'],
                    ['Prestations', 'fa-spa', '/admin/prestations'],
                    ['Clients', 'fa-users', '/admin/clients'],
                    ['Esthéticiennes', 'fa-user-tie', '/admin/estheticiennes'],
                    ['Rendez-vous', 'fa-calendar-check', '/admin/rendez_vous'],
                    ['Coupons', 'fa-tag', '/admin/coupons'],
                    ['Paiements', 'fa-wallet', '/admin/paiements']
                ];
                foreach($menu as $m): 
                    $isActive = ($m[0] == 'Users');
                ?>
                    <a href="<?php echo $m[2]; ?>" 
                        class="flex items-center gap-3.5 px-4 py-3 rounded-2xl transition font-medium text-sm <?php echo $isActive ? 'bg-[#C6856F] text-white shadow-md shadow-[#C6856F]/30' : 'text-[#8C6B68] hover:bg-[#EADBD4]/40 hover:text-[#6B4C4A]'; ?>">
                        <i class="fa <?php echo $m[1]; ?> w-5 text-center"></i> 
                        <span><?php echo $m[0]; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <div class="pt-4 border-t border-[#EADBD4] space-y-1">
            <a href="/admin/profil" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#8C6B68] hover:bg-[#EADBD4]/40 hover:text-[#6B4C4A] transition font-medium text-sm">
                <i class="fas fa-user-circle w-5 text-center"></i>
                <span>Mon Profil</span>
            </a>
            <a href="/admin/parametres" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[#8C6B68] hover:bg-[#EADBD4]/40 hover:text-[#6B4C4A] transition font-medium text-sm">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Paramètres</span>
            </a>
            <a href="/logout" class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-rose-600 hover:bg-rose-50 transition font-medium text-sm">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="flex-1 p-8">
        
        <header class="flex items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold font-serif text-[#6B4C4A]">Gestion des Utilisateurs</h2>
                <p class="text-sm text-[#8C6B68] mt-1">Gérez les accès et les comptes enregistrés sur le système</p>
            </div>
            
            <a href="/admin/dashboard" class="bg-white hover:bg-[#FAF4EE] text-[#6B4C4A] px-4 py-2 rounded-2xl border border-[#EADBD4] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Retour au Dashboard
            </a>
        </header>

        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-medium flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-600"></i>
                <span><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- FORMULAIRE AJOUTER OU MODIFIER UN UTILISATEUR -->
            <div class="lg:col-span-1">
                <div class="glass-card p-6 rounded-3xl shadow-sm sticky top-8">
                    <h3 class="font-bold font-serif text-lg text-[#6B4C4A] mb-6 flex items-center gap-2">
                        <i class="fas <?php echo (isset($userToEdit) && $userToEdit) ? 'fa-user-edit' : 'fa-user-plus'; ?> text-[#C6856F] text-sm"></i> 
                        <?php echo (isset($userToEdit) && $userToEdit) ? 'Modifier Utilisateur' : 'Nouvel Utilisateur'; ?>
                    </h3>

                    <form action="/admin/users" method="POST" class="space-y-4">
                        <?php if (isset($userToEdit) && $userToEdit): ?>
                            <input type="hidden" name="action" value="edit_user">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($userToEdit['id']); ?>">
                        <?php else: ?>
                            <input type="hidden" name="action" value="add_user">
                        <?php endif; ?>
                        
                        <div>
                            <label class="block text-xs font-bold text-[#8C6B68] mb-1.5">Prénom</label>
                            <input type="text" name="prenom" value="<?php echo (isset($userToEdit) && $userToEdit) ? htmlspecialchars($userToEdit['prenom']) : ''; ?>" required class="w-full bg-[#FAF4EE] border border-[#EADBD4] rounded-2xl px-4 py-2.5 text-xs text-[#6B4C4A] focus:outline-none focus:border-[#C6856F] transition" placeholder="Jean">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#8C6B68] mb-1.5">Nom</label>
                            <input type="text" name="nom" value="<?php echo (isset($userToEdit) && $userToEdit) ? htmlspecialchars($userToEdit['nom']) : ''; ?>" required class="w-full bg-[#FAF4EE] border border-[#EADBD4] rounded-2xl px-4 py-2.5 text-xs text-[#6B4C4A] focus:outline-none focus:border-[#C6856F] transition" placeholder="Dupont">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#8C6B68] mb-1.5">Email</label>
                            <input type="email" name="email" value="<?php echo (isset($userToEdit) && $userToEdit) ? htmlspecialchars($userToEdit['email']) : ''; ?>" required class="w-full bg-[#FAF4EE] border border-[#EADBD4] rounded-2xl px-4 py-2.5 text-xs text-[#6B4C4A] focus:outline-none focus:border-[#C6856F] transition" placeholder="j.dupont@spadream.com">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#8C6B68] mb-1.5">Mot de passe <?php echo (isset($userToEdit) && $userToEdit) ? '<span class="text-[10px] font-normal text-gray-400">(Laisser vide si vous ne souhaitez pas le changer)</span>' : ''; ?></label>
                            <input type="password" name="mot_de_passe" <?php echo (isset($userToEdit) && $userToEdit) ? '' : 'required'; ?> class="w-full bg-[#FAF4EE] border border-[#EADBD4] rounded-2xl px-4 py-2.5 text-xs text-[#6B4C4A] focus:outline-none focus:border-[#C6856F] transition" placeholder="••••••••">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#8C6B68] mb-1.5">Rôle / Pouvoir</label>
                            <select name="role" class="w-full bg-[#FAF4EE] border border-[#EADBD4] rounded-2xl px-4 py-2.5 text-xs text-[#6B4C4A] focus:outline-none focus:border-[#C6856F] transition">
                                <option value="Admin" <?php echo (isset($userToEdit) && $userToEdit && $userToEdit['role'] == 'Admin') ? 'selected' : ''; ?>>Administrateur</option>
                                <option value="Gérant" <?php echo (isset($userToEdit) && $userToEdit && $userToEdit['role'] == 'Gérant') ? 'selected' : ''; ?>>Gérant</option>
                                <option value="Réceptionniste" <?php echo (isset($userToEdit) && $userToEdit && $userToEdit['role'] == 'Réceptionniste') ? 'selected' : ''; ?>>Réceptionniste</option>
                                <option value="Client" <?php echo (isset($userToEdit) && $userToEdit && $userToEdit['role'] == 'Client') ? 'selected' : ''; ?>>Client</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="w-full bg-[#C6856F] hover:bg-[#B0735E] text-white py-3 rounded-2xl text-xs font-bold transition shadow-md shadow-[#C6856F]/20 flex items-center justify-center gap-2">
                                <i class="fas <?php echo (isset($userToEdit) && $userToEdit) ? 'fa-save' : 'fa-plus'; ?>"></i> 
                                <?php echo (isset($userToEdit) && $userToEdit) ? 'Mettre à jour' : 'Créer le compte'; ?>
                            </button>
                            <?php if (isset($userToEdit) && $userToEdit): ?>
                                <a href="/admin/users" class="bg-[#EADBD4] hover:bg-[#D4C4BD] text-[#6B4C4A] px-4 py-3 rounded-2xl text-xs font-bold transition flex items-center justify-center">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TABLEAU LISTE DES UTILISATEURS -->
            <div class="lg:col-span-2">
                <div class="glass-card p-6 rounded-3xl shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold font-serif text-lg text-[#6B4C4A]">Comptes Enregistrés</h3>
                        <span class="text-xs bg-[#FAF4EE] text-[#C6856F] border border-[#EADBD4] font-bold px-3 py-1 rounded-full"><?php echo count($users); ?> Comptes</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="text-[#8C6B68] border-b border-[#EADBD4] text-xs uppercase tracking-wider">
                                    <th class="pb-3 font-semibold">Utilisateur</th>
                                    <th class="pb-3 font-semibold">Rôle</th>
                                    <th class="pb-3 font-semibold">Statut</th>
                                    <th class="pb-3 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EADBD4]/50">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $u): ?>
                                    <tr class="hover:bg-[#FAF4EE]/50 transition">
                                        <td class="py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-xl bg-[#C6856F]/10 text-[#C6856F] border border-[#C6856F]/20 flex items-center justify-center font-bold text-xs">
                                                    <?php echo strtoupper(substr($u['prenom'] ?? '', 0, 1) . substr($u['nom'] ?? '', 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-[#6B4C4A] text-xs"><?php echo htmlspecialchars(($u['prenom'] ?? '') . ' ' . ($u['nom'] ?? '')); ?></p>
                                                    <p class="text-[11px] text-[#8C6B68]"><?php echo htmlspecialchars($u['email'] ?? ''); ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#FAF4EE] text-[#C6856F] border border-[#EADBD4]">
                                                <?php echo htmlspecialchars($u['role'] ?? 'Client'); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <?php echo htmlspecialchars($u['statut'] ?? 'Actif'); ?>
                                            </span>
                                        </td>
                                        <td class="text-right space-x-1">
                                            <a href="/admin/users?edit=<?php echo $u['id']; ?>" class="p-1.5 hover:bg-[#FAF4EE] rounded-lg text-[#8C6B68] hover:text-[#C6856F] inline-block transition" title="Modifier"><i class="fas fa-edit text-xs"></i></a>
                                            <a href="/admin/users?delete=<?php echo $u['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="p-1.5 hover:bg-rose-50 rounded-lg text-rose-400 hover:text-rose-600 inline-block transition" title="Supprimer"><i class="fas fa-trash text-xs"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-[#8C6B68] text-xs">Aucun compte enregistré pour le moment.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </main>

</body>
</html>