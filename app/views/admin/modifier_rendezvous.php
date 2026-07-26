<?php
// app/views/admin/modifier_rendezvous.php

// 1. Koneksyon ak baz done a (Ajiste non baz done a si sa nesesè)
try {
    $db = new PDO('mysql:host=localhost;dbname=spa_dream;charset=utf8mb4', 'root', '');
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// 2. Rekipere ID randevou a ki pase nan URL la (ex: modifier_rendezvous.php?id=4)
$id = $_GET['id'] ?? null;
$rendezvous = null;

if ($id) {
    $stmt = $db->prepare("SELECT * FROM rendezvous WHERE id = ?");
    $stmt->execute([$id]);
    $rendezvous = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Si nou pa jwenn randevou a, nou ka sispann oswa mete valè vid
if (!$rendezvous) {
    $client_val = "";
    $prestation_val = "";
    $estheticienne_val = "";
    $date_val = "";
    $statut_val = "";
} else {
    // Ranpli ak vrè done ki soti nan baz done a
    $client_val = $rendezvous['client'] ?? '';
    $prestation_val = $rendezvous['prestation'] ?? '';
    $estheticienne_val = $rendezvous['estheticienne'] ?? '';
    $date_val = $rendezvous['date'] ?? '';
    $statut_val = $rendezvous['statut'] ?? '';
}

// 3. Trete mizajou a lè yo soumèt fòmilè a (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_rdv = $_POST['id'] ?? '';
    $client = $_POST['client'] ?? '';
    $service = $_POST['service'] ?? '';
    $estheticienne = $_POST['estheticienne'] ?? '';
    $date = $_POST['date'] ?? '';
    $statut = $_POST['statut'] ?? '';

    if (!empty($id_rdv)) {
        $updateStmt = $db->prepare("UPDATE rendezvous SET client = ?, prestation = ?, estheticienne = ?, date = ?, statut = ? WHERE id = ?");
        $updateStmt->execute([$client, $service, $estheticienne, $date, $statut, $id_rdv]);
        
        // Retounen nan paj lis randevou yo apre w fin sove
        header('Location: index.php?page=rendezvous');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Rendez-vous #<?php echo htmlspecialchars($id); ?> - Spa Dream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #FAF7F2 0%, #F5E6E8 50%, #EFE3E5 100%);
            min-height: 100vh;
            color: #5C3A3C;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(16px); 
        }
    </style>
</head>
<body class="flex items-center justify-center p-6">

    <div class="glass-card max-w-xl w-full p-8 rounded-3xl border border-white/80 shadow-xl">
        <div class="flex items-center justify-between pb-4 border-b border-[#F5E6E8] mb-6">
            <h2 class="text-2xl font-bold font-serif text-[#4A2E30]">
                <i class="fas fa-edit text-[#8A5A5C] mr-2"></i> Modifier le Rendez-vous #<?php echo htmlspecialchars($id); ?>
            </h2>
            <a href="index.php?page=rendezvous" class="text-sm font-semibold text-[#A07173] hover:text-[#4A2E30] transition">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <!-- Fòmilè a ap poste sou menm paj la pou l fè treteman an -->
        <form action="" method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div>
                <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Client</label>
                <input type="text" name="client" value="<?php echo htmlspecialchars($client_val); ?>" required class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#F5E6E8] text-sm focus:outline-none focus:border-[#8A5A5C]">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Prestation</label>
                    <select name="service" class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#F5E6E8] text-sm focus:outline-none focus:border-[#8A5A5C]">
                        <?php 
                        $services = ["Massage Relaxant", "Soin Visage Hydratant", "Manucure & Pédicure", "Épilation Complète", "Sauna & Spa Deluxe"];
                        foreach ($services as $s) {
                            $selected = ($prestation_val === $s) ? 'selected' : '';
                            echo "<option value=\"$s\" $selected>$s</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Esthéticienne</label>
                    <select name="estheticienne" class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#F5E6E8] text-sm focus:outline-none focus:border-[#8A5A5C]">
                        <?php 
                        $estheticiennes = ["Sophie", "Nathalie"];
                        foreach ($estheticiennes as $est) {
                            $selected = ($estheticienne_val === $est) ? 'selected' : '';
                            echo "<option value=\"$est\" $selected>$est</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Date & Heure</label>
                    <input type="datetime-local" name="date" value="<?php echo date('Y-m-d\TH:i', strtotime($date_val)); ?>" class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#F5E6E8] text-sm focus:outline-none focus:border-[#8A5A5C]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#A07173] uppercase mb-1">Statut</label>
                    <select name="statut" class="w-full p-3 bg-[#FAF7F2] rounded-xl border border-[#F5E6E8] text-sm focus:outline-none focus:border-[#8A5A5C]">
                        <?php 
                        $statuts = ["Confirmé", "En attente", "Annulé"];
                        foreach ($statuts as $st) {
                            $selected = ($statut_val === $st) ? 'selected' : '';
                            echo "<option value=\"$st\" $selected>$st</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-[#F5E6E8] mt-6">
                <a href="index.php?page=rendezvous" class="px-5 py-2.5 rounded-xl border border-[#F5E6E8] text-xs font-bold text-[#6B5B52] hover:bg-white transition">Annuler</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#8A5A5C] text-white text-xs font-bold hover:bg-[#4A2E30] transition shadow-md">Enregistrer les modifications</button>
            </div>
        </form>
    </div>

</body>
</html>