<?php
// ==========================================
// 1. LOGIQUE BACKEND (client_details.php)
// ==========================================
session_start();

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=dbspa;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // Si pa gen konneksyon DB, nap kontinye pou kòd la ka toujou afiche ak done test yo
}

$id_client = intval($_GET['id'] ?? 1);

// Récupérer les informations du client
$client = null;
if (isset($pdo)) {
    try {
        $stmtClient = $pdo->prepare("SELECT * FROM clients WHERE id_client = ?");
        $stmtClient->execute([$id_client]);
        $client = $stmtClient->fetch();
    } catch (Exception $e) {
        $client = null;
    }
}

// Données client par défaut si la base de données est vide ou inaccessible
if (!$client) {
    $client = [
        'id_client' => $id_client > 0 ? $id_client : 1,
        'nom' => 'Jean',
        'prenom' => 'Pierre',
        'sexe' => 'M',
        'telephone' => '50932222222',
        'email' => 'jean@gmail.com',
        'date_inscription' => '2026-07-15',
        'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80'
    ];
}

// Fonction pour formater le téléphone
function formatPhone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (empty($phone)) return '-';
    if (strpos($phone, '509') === 0) return '+' . $phone;
    if (strlen($phone) === 8) return '+509' . $phone;
    return '+' . $phone;
}

$phone_formatted = formatPhone($client['telephone'] ?? '');
$clean_whatsapp = preg_replace('/[^0-9]/', '', $phone_formatted);
$uid_display = !empty($client['uid']) ? $client['uid'] : 'CLI-' . str_pad($client['id_client'], 3, '0', STR_PAD_LEFT);

// Foto ak Non konplè client (Prénom swit pa Nom pou l toujou inifòm)
$client_fullname = trim(($client['prenom'] ?? '') . ' ' . ($client['nom'] ?? 'Client'));
$client_photo_db = $client['photo'] ?? $client['avatar'] ?? $client['image'] ?? '';

// Foto pa defo selon Sexe
$is_male = (strtoupper($client['sexe'] ?? '') === 'M');
$client_default_photo = $is_male 
    ? "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&auto=format&fit=crop&q=80"
    : "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80";

$client_photo_src = !empty($client_photo_db) ? $client_photo_db : $client_default_photo;

// ==========================================
// 2. RÉCUPÉRATION DES RENDEZ-VOUS
// ==========================================
$rendezvous = [];

if (isset($pdo)) {
    try {
        $sqlRdv = "SELECT r.*, p.nom_prestation, p.prix, p.image AS image_prestation, 
                           e.nom AS estheticienne_nom, e.prenom AS estheticienne_prenom, e.photo AS estheticienne_photo
                    FROM rendezvous r
                    LEFT JOIN prestations p ON r.id_prestation = p.id_prestation
                    LEFT JOIN estheticiennes e ON r.id_estheticienne = e.id_estheticienne
                    WHERE r.id_client = ?
                    ORDER BY r.id_rendezvous DESC";
        $stmtRdv = $pdo->prepare($sqlRdv);
        $stmtRdv->execute([$client['id_client']]);
        $rendezvous = $stmtRdv->fetchAll();
    } catch (Exception $e) {
        $rendezvous = [];
    }
}

// Tableau foto pa defo pou Esthéticiennes
$default_estheticienne_photos = [
    "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80",
    "https://images.unsplash.com/photo-1580489944761-15a19d654956?w=150&auto=format&fit=crop&q=80",
    "https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?w=150&auto=format&fit=crop&q=80",
    "https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80",
    "https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=150&auto=format&fit=crop&q=80",
    "https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=150&auto=format&fit=crop&q=80"
];

$default_prestation_img = "https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=150&auto=format&fit=crop&q=80";

// Done dekolorasyon ak rdv varye si baz de done an vid
if (empty($rendezvous)) {
    $rendezvous = [
        [
            'id_rendezvous' => 101,
            'id_estheticienne' => 1,
            'date_rendezvous' => '2026-07-25',
            'heure_rendezvous' => '10:00:00',
            'nom_prestation' => 'Soin du Visage Hydratant & Eclat',
            'image_prestation' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=150&auto=format&fit=crop&q=80',
            'estheticienne_prenom' => 'Florence',
            'estheticienne_nom' => 'Saint-Louis',
            'estheticienne_photo' => $default_estheticienne_photos[0],
            'prix' => 3500.00,
            'statut' => 'CONFIRMÉ'
        ],
        [
            'id_rendezvous' => 102,
            'id_estheticienne' => 2,
            'date_rendezvous' => '2026-07-18',
            'heure_rendezvous' => '14:30:00',
            'nom_prestation' => 'Manucure & Pedicure Spa Luxe',
            'image_prestation' => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=150&auto=format&fit=crop&q=80',
            'estheticienne_prenom' => 'Nathalie',
            'estheticienne_nom' => 'Joseph',
            'estheticienne_photo' => $default_estheticienne_photos[1],
            'prix' => 2500.00,
            'statut' => 'TERMINÉ'
        ],
        [
            'id_rendezvous' => 103,
            'id_estheticienne' => 3,
            'date_rendezvous' => '2026-07-10',
            'heure_rendezvous' => '11:15:00',
            'nom_prestation' => 'Massage Relaxant aux Huiles Essentielles',
            'image_prestation' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=150&auto=format&fit=crop&q=80',
            'estheticienne_prenom' => 'Vanessa',
            'estheticienne_nom' => 'Pierre',
            'estheticienne_photo' => $default_estheticienne_photos[2],
            'prix' => 4500.00,
            'statut' => 'TERMINÉ'
        ]
    ];
}

// Statistiques rapides
$total_rdv = count($rendezvous);
$total_depense = 0;
foreach ($rendezvous as $rdv) {
    $prix = floatval($rdv['prix'] ?? $rdv['montant'] ?? 0);
    if (isset($rdv['statut']) && in_array(strtolower($rdv['statut']), ['terminé', 'termine', 'effectué', 'confirmé', 'confirme'])) {
        $total_depense += $prix;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Client - <?php echo htmlspecialchars($client_fullname); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #FDFBF7; 
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="text-[#4A3E3D] flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white/80 backdrop-blur-md border-r border-[#EBE3D5] min-h-screen p-6 sticky top-0 flex flex-col justify-between shadow-sm">
        <div>
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-2xl bg-[#C3765F]/10 border border-[#C3765F]/20 flex items-center justify-center text-[#C3765F] text-xl font-bold shadow-inner">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-bold font-serif text-[#C3765F] tracking-wide">Spa Dream</h1>
            </div>
            <nav class="space-y-2 text-xs font-semibold">
                <a href="dashboard.php" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition-all"><i class="fa fa-chart-pie w-4 text-center"></i> Tableau de bord</a>
                <a href="prestations.php" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition-all"><i class="fa fa-spa w-4 text-center"></i> Prestations</a>
                <a href="clients.php" class="flex items-center gap-3.5 px-4 py-3 rounded-xl bg-[#C3765F] text-white shadow-md shadow-[#C3765F]/20"><i class="fa fa-users w-4 text-center"></i> Clients</a>
                <a href="estheticiennes.php" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition-all"><i class="fa fa-user-check w-4 text-center"></i> Esthéticiennes</a>
                <a href="rendezvous.php" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition-all"><i class="fa fa-calendar-alt w-4 text-center"></i> Rendez-vous</a>
                <a href="paiements.php" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[#8C7A6B] hover:bg-[#C3765F]/10 hover:text-[#C3765F] transition-all"><i class="fa fa-wallet w-4 text-center"></i> Paiements</a>
            </nav>
        </div>
    </aside>

    <!-- CONTENT MAIN -->
    <main class="flex-1 p-10 space-y-8 max-w-7xl">

        <!-- HEADER & RETOUR -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="clients.php" class="w-12 h-12 bg-white border border-[#EBE3D5] rounded-2xl flex items-center justify-center text-[#8C7A6B] hover:text-[#C3765F] hover:border-[#C3765F]/30 hover:shadow-md transition-all">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                
                <!-- FOTO PROFIL ANWO A -->
                <div class="relative">
                    <img src="<?php echo htmlspecialchars($client_photo_src); ?>" 
                         onerror="this.src='<?php echo $client_default_photo; ?>';" 
                         alt="<?php echo htmlspecialchars($client_fullname); ?>" 
                         onclick="openImageModal(this.src, '<?php echo htmlspecialchars($client_fullname, ENT_QUOTES); ?>')"
                         class="w-16 h-16 rounded-2xl object-cover border-2 border-[#C3765F]/20 shadow-md cursor-pointer hover:scale-105 transition-transform">
                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 border-2 border-white absolute -bottom-0.5 -right-0.5"></span>
                </div>

                <div>
                    <h2 class="text-3xl font-bold font-serif text-[#C3765F]">
                        <?php echo htmlspecialchars($client_fullname); ?>
                    </h2>
                    <p class="text-xs text-[#8C7A6B] font-medium">Profil détaillé du client et historique des prestations</p>
                </div>
            </div>

            <?php if (!empty($clean_whatsapp)): ?>
                <a href="https://wa.me/<?php echo $clean_whatsapp; ?>" target="_blank" class="bg-[#00A884] hover:bg-[#008f70] text-white px-5 py-3 rounded-2xl text-xs font-bold flex items-center gap-2.5 shadow-md shadow-[#00A884]/20 transition-all hover:-translate-y-0.5">
                    <i class="fab fa-whatsapp text-base"></i> Contacter via WhatsApp
                </a>
            <?php endif; ?>
        </div>

        <!-- CARDS INFO CLIENT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- BLOC INFORMATIONS PERSONNELLES -->
            <div class="bg-white rounded-3xl border border-[#EBE3D5] p-6 shadow-sm hover:shadow-md transition-shadow space-y-4">
                <div class="flex items-center justify-between border-b border-[#EBE3D5]/60 pb-3">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-[#8C7A6B]">Informations Personnelles</h3>
                    <span class="w-2 h-2 rounded-full bg-[#C3765F]"></span>
                </div>
                
                <div class="flex items-center gap-4 py-2 border-b border-stone-50">
                    <!-- FOTO PROFIL ANNDAN KAT LA -->
                    <img src="<?php echo htmlspecialchars($client_photo_src); ?>" 
                         onerror="this.src='<?php echo $client_default_photo; ?>';" 
                         alt="<?php echo htmlspecialchars($client_fullname); ?>" 
                         onclick="openImageModal(this.src, '<?php echo htmlspecialchars($client_fullname, ENT_QUOTES); ?>')"
                         class="w-14 h-14 rounded-2xl object-cover border border-[#EBE3D5] shadow-xs cursor-pointer hover:scale-105 transition-transform">
                    <div>
                        <p class="font-bold text-sm text-[#4A3E3D]"><?php echo htmlspecialchars($client_fullname); ?></p>
                        <p class="text-[11px] text-[#8C7A6B] font-medium"><?php echo $is_male ? 'Homme' : 'Femme'; ?></p>
                    </div>
                </div>

                <div class="text-xs space-y-3">
                    <div class="flex justify-between items-center py-1 border-b border-stone-50">
                        <span class="text-stone-400 font-medium">Identifiant (UID)</span>
                        <span class="font-mono font-bold text-[#C3765F] bg-[#C3765F]/10 px-2 py-0.5 rounded-md text-[11px]"><?php echo htmlspecialchars($uid_display); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-stone-50">
                        <span class="text-stone-400 font-medium">Téléphone</span>
                        <span class="font-mono font-bold text-stone-700"><?php echo htmlspecialchars($phone_formatted); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-stone-50">
                        <span class="text-stone-400 font-medium">Email</span>
                        <span class="font-semibold text-stone-700"><?php echo htmlspecialchars($client['email'] ?? '-'); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-stone-400 font-medium">Inscrit(e) le</span>
                        <span class="font-semibold text-stone-700"><?php echo !empty($client['date_inscription']) ? date('d/m/Y', strtotime($client['date_inscription'])) : date('d/m/Y'); ?></span>
                    </div>
                </div>
            </div>

            <!-- STATISTIQUE 1 -->
            <div class="bg-white rounded-3xl border border-[#EBE3D5] p-6 shadow-sm hover:shadow-md transition-shadow flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-[#C3765F]/10 text-[#C3765F] flex items-center justify-center text-2xl flex-shrink-0">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <p class="text-xs text-[#8C7A6B] font-semibold uppercase tracking-wider">Total Rendez-vous</p>
                    <p class="text-3xl font-bold font-serif text-[#4A3E3D] mt-1"><?php echo $total_rdv; ?></p>
                </div>
            </div>

            <!-- STATISTIQUE 2 -->
            <div class="bg-white rounded-3xl border border-[#EBE3D5] p-6 shadow-sm hover:shadow-md transition-shadow flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl flex-shrink-0">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <p class="text-xs text-[#8C7A6B] font-semibold uppercase tracking-wider">Dépenses Totales (Validées)</p>
                    <p class="text-3xl font-bold font-serif text-emerald-700 mt-1"><?php echo number_format($total_depense, 2); ?> HTG</p>
                </div>
            </div>

        </div>

        <!-- TABLEAU HISTORIQUE RENDEZ-VOUS -->
        <div class="bg-white rounded-3xl border border-[#EBE3D5] shadow-sm overflow-hidden">
            <div class="p-6 border-b border-[#EBE3D5] bg-[#FDFBF7] flex justify-between items-center">
                <h3 class="text-base font-bold text-[#C3765F] font-serif">Historique des Rendez-vous</h3>
                <span class="text-xs bg-white border border-[#EBE3D5] px-3.5 py-1.5 rounded-full text-[#8C7A6B] font-semibold shadow-xs">
                    <?php echo count($rendezvous); ?> enregistrement(s)
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#FDFBF7]/60 text-[#8C7A6B] uppercase text-[10px] tracking-wider font-bold border-b border-[#EBE3D5]">
                            <th class="py-4 px-6">Date & Heure</th>
                            <th class="py-4 px-6">Prestation</th>
                            <th class="py-4 px-6">Esthéticienne</th>
                            <th class="py-4 px-6">Montant</th>
                            <th class="py-4 px-6 text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EBE3D5]/50">
                        <?php if (!empty($rendezvous)): ?>
                            <?php 
                            $index = 0;
                            foreach ($rendezvous as $r): 
                                $index++;
                            ?>
                                <tr class="hover:bg-[#FDFBF7]/80 transition-colors">
                                    <td class="py-4 px-6 font-bold text-[#4A3E3D]">
                                        <?php 
                                        $dateRdv = $r['date_rendezvous'] ?? $r['date_rdv'] ?? $r['created_at'] ?? '';
                                        echo !empty($dateRdv) ? date('d/m/Y', strtotime($dateRdv)) : '-'; 
                                        ?> 
                                        <span class="text-stone-400 font-normal ml-1">
                                            <?php echo !empty($r['heure_rendezvous']) ? 'à ' . substr($r['heure_rendezvous'], 0, 5) : ''; ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-bold text-[#C3765F]">
                                        <div class="flex items-center gap-3">
                                            <?php 
                                            $nomPrestation = $r['nom_prestation'] ?? $r['prestation'] ?? 'Service Standard';
                                            $prestationImage = $r['image_prestation'] ?? $r['photo_prestation'] ?? $r['image'] ?? '';
                                            $imgSrcToDisplay = !empty($prestationImage) ? $prestationImage : $default_prestation_img;
                                            ?>
                                            
                                            <img src="<?php echo htmlspecialchars($imgSrcToDisplay); ?>" 
                                                 alt="<?php echo htmlspecialchars($nomPrestation); ?>" 
                                                 onerror="this.src='<?php echo $default_prestation_img; ?>';" 
                                                 onclick="openImageModal(this.src, '<?php echo htmlspecialchars($nomPrestation, ENT_QUOTES); ?>')"
                                                 class="w-10 h-10 rounded-xl object-cover border border-[#EBE3D5] shadow-xs flex-shrink-0 cursor-pointer hover:scale-105 transition-transform">

                                            <span><?php echo htmlspecialchars($nomPrestation); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-stone-600 font-medium">
                                        <?php 
                                        $nomE = $r['estheticienne_nom'] ?? '';
                                        $prenomE = $r['estheticienne_prenom'] ?? '';
                                        $esth = trim($prenomE . ' ' . $nomE);
                                        if (empty($esth)) { $esth = "Non assigné"; }
                                        
                                        $esthPhoto = $r['estheticienne_photo'] ?? $r['photo_estheticienne'] ?? '';
                                        if (empty($esthPhoto)) {
                                            $photoIndex = (($r['id_estheticienne'] ?? $index) - 1) % count($default_estheticienne_photos);
                                            $esthPhotoSrc = $default_estheticienne_photos[$photoIndex];
                                        } else {
                                            $esthPhotoSrc = $esthPhoto;
                                        }
                                        ?>
                                        <div class="flex items-center gap-2.5">
                                            <img src="<?php echo htmlspecialchars($esthPhotoSrc); ?>" 
                                                 onerror="this.src='<?php echo $default_estheticienne_photos[0]; ?>';" 
                                                 alt="<?php echo htmlspecialchars($esth); ?>" 
                                                 onclick="openImageModal(this.src, '<?php echo htmlspecialchars($esth, ENT_QUOTES); ?>')"
                                                 class="w-8 h-8 rounded-full object-cover border border-[#EBE3D5] shadow-xs flex-shrink-0 cursor-pointer hover:scale-105 transition-transform">
                                            <span><?php echo htmlspecialchars($esth); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 font-mono font-bold text-stone-700 text-sm">
                                        <?php echo number_format($r['prix'] ?? $r['montant'] ?? 0, 2); ?> HTG
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <?php 
                                        $st = strtolower($r['statut'] ?? 'en attente');
                                        $badge = 'bg-amber-50 text-amber-700 border-amber-200';
                                        if (in_array($st, ['terminé', 'termine', 'effectué', 'confirmé', 'confirme'])) {
                                            $badge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                        } elseif (in_array($st, ['annulé', 'annule'])) {
                                            $badge = 'bg-rose-50 text-rose-700 border-rose-200';
                                        }
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border <?php echo $badge; ?>">
                                            <?php echo htmlspecialchars($r['statut'] ?? 'En attente'); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-12 text-center text-stone-400 font-medium">
                                    <i class="fas fa-calendar-times text-2xl mb-2 block text-stone-300"></i>
                                    Aucun rendez-vous enregistré pour ce client.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- MODAL POPUP POUR AFFICHER L'IMAGE EN GRAND -->
    <div id="imageModal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden items-center justify-center p-4 transition-all duration-300" onclick="closeImageModal()">
        <div class="relative bg-white rounded-3xl p-4 max-w-xl w-full shadow-2xl border border-[#EBE3D5]" onclick="event.stopPropagation()">
            <button onclick="closeImageModal()" class="absolute -top-3 -right-3 w-10 h-10 bg-[#C3765F] text-white rounded-full flex items-center justify-center shadow-lg hover:bg-[#a85f4a] transition-colors focus:outline-none">
                <i class="fas fa-times text-lg"></i>
            </button>
            <div class="overflow-hidden rounded-2xl bg-stone-100 flex items-center justify-center max-h-[75vh]">
                <img id="modalImage" src="" alt="Agrandissement" class="w-full h-full object-contain">
            </div>
            <p id="modalCaption" class="text-center text-sm font-bold text-[#4A3E3D] mt-3 font-serif"></p>
        </div>
    </div>

    <!-- JAVASCRIPT MODAL -->
    <script>
        function openImageModal(src, title) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            const caption = document.getElementById('modalCaption');
            
            img.src = src;
            caption.textContent = title || '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>

</body>
</html>