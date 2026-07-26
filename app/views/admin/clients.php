<?php
// ==========================================
// 1. LOGIQUE BACKEND & BASE DE DONNÉES (PHP)
// ==========================================
session_start();

// Connexion à la base de données dbspa
try {
    $pdo = new PDO('mysql:host=localhost;dbname=dbspa;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$message = "";
$message_type = "";

// A. LOGIQUE EXPORT CSV (Téléchargement direct)
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=clients_spadream_' . date('Y-m-d') . '.csv');
    
    $output = fopen('php://output', 'w');
    // En-tête du fichier CSV
    fputcsv($output, ['UID', 'Nom', 'Prénom', 'Téléphone', 'Email', 'Sexe', 'Date Inscription']);
    
    $stmtExp = $pdo->prepare("SELECT uid, nom, prenom, telephone, email, sexe, date_inscription FROM clients ORDER BY id_client DESC");
    $stmtExp->execute();
    
    while ($row = $stmtExp->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}

// Fonction pour formater le numéro de téléphone avec +509
function formatTelephone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone); // Supprime tous les caractères non numériques
    if (empty($phone)) return '';
    
    // Si le numéro commence déjà par 509
    if (strpos($phone, '509') === 0) {
        return '+' . $phone;
    }
    // Si c'est un numéro à 8 chiffres (ex: 37123456)
    if (strlen($phone) === 8) {
        return '+509' . $phone;
    }
    return '+' . $phone;
}

// B. LOGIQUE POUR AJOUTER ET MODIFIER UN CLIENT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    // Ajouter un client
    if ($_POST['action'] === 'add_client') {
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $telephone = formatTelephone(trim($_POST['telephone'] ?? ''));
        $email = trim($_POST['email'] ?? '');
        $sexe = $_POST['sexe'] ?? 'F';
        
        $date_now = date('Y-m-d H:i:s');

        if (!empty($nom) && !empty($prenom)) {
            try {
                // Obtenir le prochain ID pour générer un UID structuré (ex: CLI-001)
                $stmtNext = $pdo->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'dbspa' AND TABLE_NAME = 'clients'");
                $nextId = $stmtNext->fetchColumn() ?: rand(1, 99);
                $uid = 'CLI-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

                // Génération automatique de l'email s'il est vide
                if (empty($email)) {
                    $cleanNom = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nom));
                    $cleanPrenom = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $prenom));
                    $email = $cleanPrenom . '.' . $cleanNom . $nextId . '@spadream.com';
                }

                $stmt = $pdo->prepare("INSERT INTO clients (uid, nom, prenom, telephone, email, sexe, date_inscription, date_creation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$uid, $nom, $prenom, $telephone, $email, $sexe, $date_now, $date_now]);
                
                $_SESSION['flash_msg'] = "Le client $nom $prenom a été ajouté avec succès !";
                $_SESSION['flash_type'] = "success";
                header("Location: clients.php");
                exit();
            } catch (PDOException $e) {
                $message = "Erreur SQL : " . $e->getMessage();
                $message_type = "error";
            }
        } else {
            $message = "Veuillez remplir tous les champs obligatoires (Nom et Prénom).";
            $message_type = "error";
        }
    }

    // Modifier un client
    if ($_POST['action'] === 'edit_client') {
        $id_client = intval($_POST['id_client'] ?? 0);
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $telephone = formatTelephone(trim($_POST['telephone'] ?? ''));
        $email = trim($_POST['email'] ?? '');
        $sexe = $_POST['sexe'] ?? 'F';

        if ($id_client > 0 && !empty($nom) && !empty($prenom)) {
            
            // Génération automatique de l'email si vidé lors de la modification
            if (empty($email)) {
                $cleanNom = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nom));
                $cleanPrenom = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $prenom));
                $email = $cleanPrenom . '.' . $cleanNom . $id_client . '@spadream.com';
            }

            $stmt = $pdo->prepare("UPDATE clients SET nom = ?, prenom = ?, telephone = ?, email = ?, sexe = ? WHERE id_client = ?");
            $stmt->execute([$nom, $prenom, $telephone, $email, $sexe, $id_client]);
            
            $_SESSION['flash_msg'] = "Mise à jour du client $nom effectuée avec succès !";
            $_SESSION['flash_type'] = "success";
            header("Location: clients.php");
            exit();
        }
    }
}

// C. LOGIQUE DE SUPPRESSION
if (isset($_GET['delete_id'])) {
    $del_id = intval($_GET['delete_id']);
    $stmt = $pdo->prepare("DELETE FROM clients WHERE id_client = ?");
    $stmt->execute([$del_id]);

    $_SESSION['flash_msg'] = "Le client a été supprimé de la base de données !";
    $_SESSION['flash_type'] = "success";
    header("Location: clients.php");
    exit();
}

// D. LOGIQUE RECHERCHE, FILTRE & PAGINATION
$search = trim($_GET['search'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$whereClauses = ["1=1"];
$params = [];

if (!empty($search)) {
    $whereClauses[] = "(nom LIKE ? OR prenom LIKE ? OR email LIKE ? OR telephone LIKE ? OR uid LIKE ?)";
    $params = ["%$search%", "%$search%", "%$search%", "%$search%", "%$search%"];
}

$whereSql = implode(" AND ", $whereClauses);

// Compter le nombre total de clients
$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM clients WHERE $whereSql");
$stmtCount->execute($params);
$total_clients = $stmtCount->fetchColumn();
$total_pages = ceil($total_clients / $limit) ?: 1;

// Récupérer les données
$sql = "SELECT * FROM clients WHERE $whereSql ORDER BY id_client DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$clients = $stmt->fetchAll();

// Messages Flash
if (isset($_SESSION['flash_msg'])) {
    $message = $_SESSION['flash_msg'];
    $message_type = $_SESSION['flash_type'];
    unset($_SESSION['flash_msg'], $_SESSION['flash_type']);
}
?>

<!-- ========================================== -->
<!-- 2. INTERFACE VISUELLE (HTML5 / TAILWIND)   -->
<!-- ========================================== -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients - Spa Dream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> 
        body { background-color: #FAF6F0; } 
    </style>
</head>
<body class="text-[#5C4D4A] flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white/90 border-r border-[#E0D5C1] min-h-screen p-6 sticky top-0 flex flex-col justify-between shadow-sm">
        <div>
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-2xl bg-[#C3765F]/10 flex items-center justify-center text-[#C3765F] text-xl font-bold">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-bold font-serif text-[#C3765F]">Spa Dream</h1>
            </div>
            <nav class="space-y-1.5 text-xs font-medium">
                <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition"><i class="fa fa-chart-pie w-4"></i> Tableau de bord</a>
                <a href="prestations.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition"><i class="fa fa-spa w-4"></i> Prestations</a>
                <a href="clients.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#C3765F]/15 text-[#C3765F] font-bold"><i class="fa fa-users w-4"></i> Clients</a>
                <a href="estheticiennes.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition"><i class="fa fa-user-check w-4"></i> Esthéticiennes</a>
                <a href="rendezvous.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition"><i class="fa fa-calendar-alt w-4"></i> Rendez-vous</a>
                <a href="paiements.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition"><i class="fa fa-wallet w-4"></i> Paiements</a>
            </nav>
        </div>
    </aside>

    <!-- CONTENT MAIN -->
    <main class="flex-1 p-8 space-y-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-extrabold font-serif text-[#C3765F]">Gestion des Clients</h2>
                <p class="text-[#8C7A6B] text-xs mt-1">Liste complète de vos clients enregistrés</p>
            </div>

            <div class="flex items-center gap-2">
                <button onclick="openAddModal()" class="bg-[#C3765F] hover:bg-[#A85B46] text-white px-5 py-2.5 rounded-full text-xs font-bold flex items-center gap-2 shadow-md transition duration-200">
                    <i class="fas fa-plus"></i> Ajouter un Client
                </button>
            </div>
        </div>

        <!-- NOTIFICATION ALERT -->
        <?php if (!empty($message)): ?>
            <div class="p-3.5 rounded-xl text-xs font-medium flex items-center justify-between <?php echo $message_type === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-red-50 text-red-800 border border-red-200'; ?>">
                <span><i class="fas <?php echo $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i><?php echo htmlspecialchars($message); ?></span>
                <button onclick="this.parentElement.remove()" class="text-xs font-bold opacity-60">✕</button>
            </div>
        <?php endif; ?>

        <!-- BARRE DE RECHERCHE ET EXPORTATION -->
        <form method="GET" action="clients.php" class="flex gap-2">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#8C7A6B]/60">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Rechercher un client (Nom, Email, Téléphone, UID...)" class="w-full pl-9 pr-4 py-2.5 bg-white border border-[#E0D5C1] rounded-xl text-xs text-[#5C4D4A] focus:outline-none focus:ring-2 focus:ring-[#C3765F]/30 shadow-sm">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-white border border-[#E0D5C1] rounded-xl text-xs font-bold text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] flex items-center gap-2 shadow-sm transition">
                <i class="fas fa-filter text-xs"></i> Filtrer
            </button>
            <a href="clients.php?export=csv" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition" title="Télécharger la liste au format Excel/CSV">
                <i class="fas fa-file-excel text-xs"></i> Export CSV
            </a>
            <?php if (!empty($search)): ?>
                <a href="clients.php" class="px-3.5 py-2.5 bg-stone-200 text-stone-700 rounded-xl text-xs font-bold flex items-center justify-center" title="Réinitialiser la recherche">
                    <i class="fas fa-undo"></i>
                </a>
            <?php endif; ?>
        </form>

        <!-- TABLEAU CLIENTS -->
        <div class="bg-white rounded-2xl border border-[#E0D5C1] shadow-sm overflow-hidden">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#FAF6F0] text-[#8C7A6B] uppercase text-[10px] font-bold border-b border-[#E0D5C1]">
                        <th class="py-3.5 px-5">UID</th>
                        <th class="py-3.5 px-5">Nom</th>
                        <th class="py-3.5 px-5">Prénom</th>
                        <th class="py-3.5 px-5">Téléphone</th>
                        <th class="py-3.5 px-5">Email</th>
                        <th class="py-3.5 px-5">Sexe</th>
                        <th class="py-3.5 px-5">Inscription</th>
                        <th class="py-3.5 px-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E0D5C1]/40">
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $c): 
                            // UID structuré
                            $uid_display = !empty($c['uid']) ? $c['uid'] : 'CLI-' . str_pad($c['id_client'], 3, '0', STR_PAD_LEFT);
                            
                            // Numéro de téléphone avec +509
                            $phone_display = !empty($c['telephone']) ? formatTelephone($c['telephone']) : '-';
                            
                            // Email
                            $email_display = !empty($c['email']) ? $c['email'] : strtolower($c['prenom'] . '.' . $c['nom'] . $c['id_client'] . '@spadream.com');
                            
                            $date_format = !empty($c['date_inscription']) ? date('d/m/Y', strtotime($c['date_inscription'])) : '-';
                            
                            // Nettoyage du numéro pour le lien WhatsApp
                            $clean_whatsapp = preg_replace('/[^0-9]/', '', $phone_display);
                        ?>
                        <tr class="hover:bg-[#FAF6F0]/60 transition">
                            <td class="py-3.5 px-5 font-bold text-[#C3765F] font-mono text-xs"><?php echo htmlspecialchars($uid_display); ?></td>
                            <td class="py-3.5 px-5 font-bold text-[#5C4D4A]"><?php echo htmlspecialchars($c['nom']); ?></td>
                            <td class="py-3.5 px-5 text-[#5C4D4A]"><?php echo htmlspecialchars($c['prenom']); ?></td>
                            
                            <!-- COLONNE TÉLÉPHONE AVEC DÉTECTION WHATSAPP -->
                            <td class="py-3.5 px-5 text-stone-600 font-mono font-bold">
                                <?php if (!empty($phone_display) && $phone_display !== '-'): ?>
                                    <a href="https://wa.me/<?php echo $clean_whatsapp; ?>" 
                                       target="_blank" 
                                       class="hover:text-emerald-600 flex items-center gap-1.5 transition" 
                                       title="Ouvrir dans WhatsApp">
                                        <i class="fab fa-whatsapp text-emerald-500 text-sm"></i>
                                        <?php echo htmlspecialchars($phone_display); ?>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td class="py-3.5 px-5 text-stone-600"><?php echo htmlspecialchars($email_display); ?></td>
                            <td class="py-3.5 px-5 text-stone-600 font-bold"><?php echo htmlspecialchars($c['sexe'] ?? 'F'); ?></td>
                            <td class="py-3.5 px-5 text-stone-500"><?php echo $date_format; ?></td>
                            <td class="py-3.5 px-5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Bouton Fiche Client complète (historique) -->
                                    <a href="client_details.php?id=<?php echo $c['id_client']; ?>" class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Fiche complète & Historique">
                                        <i class="far fa-id-card"></i>
                                    </a>
                                    <!-- Bouton Quick View (Modal) -->
                                    <button onclick="openViewModal(<?php echo htmlspecialchars(json_encode(array_merge($c, ['uid' => $uid_display, 'telephone' => $phone_display, 'email' => $email_display]))); ?>)" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Aperçu rapide">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <!-- Bouton Modifier -->
                                    <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode(array_merge($c, ['telephone' => $phone_display, 'email' => $email_display]))); ?>)" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Modifier">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <!-- Bouton Supprimer -->
                                    <a href="clients.php?delete_id=<?php echo $c['id_client']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="py-8 text-center text-stone-400">Aucun client trouvé dans la base de données.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- FOOTER ET PAGINATION -->
            <div class="p-4 border-t border-[#E0D5C1] flex flex-col md:flex-row justify-between items-center text-[11px] text-stone-500 gap-2">
                <div>
                    Affichage de <b><?php echo count($clients); ?></b> sur <b><?php echo $total_clients; ?></b> client(s) au total
                </div>
                
                <?php if ($total_pages > 1): ?>
                    <div class="flex gap-1">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="clients.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="px-2.5 py-1 border rounded-lg font-bold <?php echo ($i === $page) ? 'bg-[#C3765F] text-white border-[#C3765F]' : 'bg-white text-stone-600 hover:bg-stone-50'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>

    <!-- MODAL AJOUTER / MODIFIER -->
    <div id="clientModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl border border-[#E0D5C1]">
            <h3 id="modalTitle" class="text-xl font-bold font-serif text-[#C3765F] mb-4">Ajouter un Client</h3>
            
            <form action="clients.php" method="POST" class="space-y-3 text-xs">
                <input type="hidden" name="action" id="formAction" value="add_client">
                <input type="hidden" name="id_client" id="clientId" value="">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-[#8C7A6B] mb-1">Nom *</label>
                        <input type="text" name="nom" id="clientNom" required class="w-full px-3 py-2 border border-[#E0D5C1] rounded-xl bg-[#FAF6F0] text-xs focus:outline-none focus:ring-1 focus:ring-[#C3765F]">
                    </div>
                    <div>
                        <label class="block font-bold text-[#8C7A6B] mb-1">Prénom *</label>
                        <input type="text" name="prenom" id="clientPrenom" required class="w-full px-3 py-2 border border-[#E0D5C1] rounded-xl bg-[#FAF6F0] text-xs focus:outline-none focus:ring-1 focus:ring-[#C3765F]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-[#8C7A6B] mb-1">Téléphone (+509)</label>
                    <input type="text" name="telephone" id="clientTelephone" placeholder="+509 37000000" class="w-full px-3 py-2 border border-[#E0D5C1] rounded-xl bg-[#FAF6F0] text-xs focus:outline-none focus:ring-1 focus:ring-[#C3765F]">
                </div>

                <div>
                    <label class="block font-bold text-[#8C7A6B] mb-1">Email (Laissez vide pour générer automatiquement)</label>
                    <input type="email" name="email" id="clientEmail" placeholder="nom.prenom@spadream.com" class="w-full px-3 py-2 border border-[#E0D5C1] rounded-xl bg-[#FAF6F0] text-xs focus:outline-none focus:ring-1 focus:ring-[#C3765F]">
                </div>

                <div>
                    <label class="block font-bold text-[#8C7A6B] mb-1">Sexe</label>
                    <select name="sexe" id="clientSexe" class="w-full px-3 py-2 border border-[#E0D5C1] rounded-xl bg-[#FAF6F0] text-xs font-bold focus:outline-none focus:ring-1 focus:ring-[#C3765F]">
                        <option value="F">Féminin (F)</option>
                        <option value="M">Masculin (M)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3">
                    <button type="button" onclick="closeModal('clientModal')" class="px-4 py-2 bg-stone-200 text-stone-700 font-bold rounded-xl hover:bg-stone-300 transition">Annuler</button>
                    <button type="submit" class="px-5 py-2 bg-[#C3765F] text-white font-bold rounded-xl hover:bg-[#A85B46] transition">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL VOIR LES DÉTAILS -->
    <div id="viewModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl border border-[#E0D5C1] text-xs space-y-3">
            <h3 class="text-base font-bold font-serif text-[#C3765F] border-b pb-2">Fiche du Client</h3>
            <div id="viewContent" class="space-y-2"></div>
            <div class="flex justify-end pt-2">
                <button type="button" onclick="closeModal('viewModal')" class="px-4 py-2 bg-[#5C4D4A] text-white font-bold rounded-xl hover:bg-stone-800 transition">Fermer</button>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('formAction').value = 'add_client';
            document.getElementById('modalTitle').innerText = 'Ajouter un Client';
            document.getElementById('clientId').value = '';
            document.getElementById('clientNom').value = '';
            document.getElementById('clientPrenom').value = '';
            document.getElementById('clientTelephone').value = '+509 ';
            document.getElementById('clientEmail').value = '';
            document.getElementById('clientSexe').value = 'F';
            document.getElementById('clientModal').classList.remove('hidden');
            document.getElementById('clientModal').classList.add('flex');
        }

        function openEditModal(c) {
            document.getElementById('formAction').value = 'edit_client';
            document.getElementById('modalTitle').innerText = 'Modifier le Client';
            document.getElementById('clientId').value = c.id_client;
            document.getElementById('clientNom').value = c.nom;
            document.getElementById('clientPrenom').value = c.prenom;
            document.getElementById('clientTelephone').value = c.telephone || '+509 ';
            document.getElementById('clientEmail').value = c.email || '';
            document.getElementById('clientSexe').value = c.sexe || 'F';
            document.getElementById('clientModal').classList.remove('hidden');
            document.getElementById('clientModal').classList.add('flex');
        }

        function openViewModal(c) {
            const content = `
                <p class="py-1 border-b border-stone-100"><strong>UID :</strong> <span class="text-[#C3765F] font-mono font-bold">${c.uid}</span></p>
                <p class="py-1 border-b border-stone-100"><strong>Nom Complet :</strong> ${c.nom} ${c.prenom}</p>
                <p class="py-1 border-b border-stone-100"><strong>Téléphone :</strong> <span class="font-mono font-bold">${c.telephone}</span></p>
                <p class="py-1 border-b border-stone-100"><strong>Email :</strong> ${c.email}</p>
                <p class="py-1 border-b border-stone-100"><strong>Sexe :</strong> ${c.sexe || 'F'}</p>
                <p class="py-1"><strong>Date d'inscription :</strong> ${c.date_inscription || '-'}</p>
            `;
            document.getElementById('viewContent').innerHTML = content;
            document.getElementById('viewModal').classList.remove('hidden');
            document.getElementById('viewModal').classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
    </script>
</body>
</html>