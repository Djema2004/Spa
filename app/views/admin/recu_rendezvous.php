<?php
// Koneksyon ak baz de done a
$configPath = __DIR__ . '/../../config/connect.php';
if (file_exists($configPath)) {
    require_once $configPath;
}
$db = $pdo ?? $conn ?? null;

$id_rdv = isset($_GET['id']) ? intval($_GET['id']) : 1;
$rdv = null;

if ($db) {
    try {
        $stmt = $db->prepare("
            SELECT 
                r.id_rendezvous AS id,
                CONCAT(c.nom, ' ', c.prenom) AS client,
                c.telephone AS client_tel,
                c.email AS client_email,
                r.service,
                CONCAT(e.nom, ' ', e.prenom) AS estheticienne,
                r.montant,
                r.mode_paiement AS mode,
                r.date_rendezvous AS date,
                r.statut
            FROM rendezvous r
            LEFT JOIN clients c ON r.id_client = c.id_client
            LEFT JOIN estheticiennes e ON r.id_estheticienne = e.id_estheticienne
            WHERE r.id_rendezvous = ?
        ");
        $stmt->execute([$id_rdv]);
        $rdv = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $rdv = null;
    }
}

// Fallback si pa gen done nan baz la pou ID sa a
if (!$rdv) {
    $rdv = [
        'id' => $id_rdv,
        'client' => 'Marie Jean',
        'client_tel' => '+509 3123-4567',
        'client_email' => 'marie.jean@email.com',
        'service' => 'Massage Relaxant',
        'estheticienne' => 'Sophie',
        'montant' => 3500.00,
        'mode' => 'Carte Bancaire',
        'date' => '2026-07-21 14:00:00',
        'statut' => 'Confirmé'
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Rendez-vous - Spa Dream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #FAF7F2 0%, #F5E6E8 50%, #EFE3E5 100%);
            background-attachment: fixed;
            color: #5C3A3C;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
        }
        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-shadow { box-shadow: none !important; border: 1px solid #ddd !important; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6">

    <!-- ACTION BUTTONS (NON ENPRIMAB) -->
    <div class="no-print mb-6 flex items-center gap-3">
        <a href="rendezvous.php" class="bg-white/80 hover:bg-white text-[#5C3A3C] px-4 py-2 rounded-xl text-sm font-semibold border border-[#F5E6E8] shadow-sm transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Retounen nan Lis la
        </a>
        <button onclick="window.print()" class="bg-[#8A5A5C] hover:bg-[#4A2E30] text-white px-5 py-2 rounded-xl text-sm font-bold shadow-md transition flex items-center gap-2">
            <i class="fas fa-print"></i> Enprime Reçu a
        </button>
    </div>

    <!-- RESI KÒMÈS LA -->
    <div class="glass-card print-shadow w-full max-w-xl rounded-3xl border border-white/80 shadow-xl p-8 relative overflow-hidden">
        
        <!-- DEKORASYON BACKGROUND -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#F5E6E8] rounded-full blur-2xl opacity-65 pointer-events-none"></div>

        <!-- HEADER RESI -->
        <div class="flex items-center justify-between pb-6 border-b border-[#F5E6E8]">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[#8A5A5C] flex items-center justify-center text-white shadow-md shadow-[#8A5A5C]/30 text-2xl">
                    <i class="fas fa-spa"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold font-serif text-[#4A2E30]">Spa Dream</h1>
                    <p class="text-xs text-[#A07173]">Reçu de Réservation officiel</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs font-bold text-[#A07173] uppercase tracking-wider block">Reçu #</span>
                <span class="text-lg font-bold text-[#4A2E30]">SRV-<?php echo str_pad($rdv['id'], 4, '0', STR_PAD_LEFT); ?></span>
            </div>
        </div>

        <!-- ENFÒMASYON KLIYAN AK ESTHÉTICIENNE -->
        <div class="grid grid-cols-2 gap-6 my-6 text-sm">
            <div class="bg-white/50 p-4 rounded-2xl border border-[#F5E6E8]">
                <span class="text-xs font-bold text-[#A07173] uppercase tracking-wider block mb-1">Client(e)</span>
                <p class="font-bold text-[#4A2E30] text-base"><?php echo htmlspecialchars($rdv['client']); ?></p>
                <p class="text-xs text-[#A07173] mt-0.5"><?php echo htmlspecialchars($rdv['client_tel'] ?? 'Tel non disponib'); ?></p>
                <p class="text-xs text-[#A07173]"><?php echo htmlspecialchars($rdv['client_email'] ?? ''); ?></p>
            </div>
            
            <div class="bg-white/50 p-4 rounded-2xl border border-[#F5E6E8]">
                <span class="text-xs font-bold text-[#A07173] uppercase tracking-wider block mb-1">Esthéticienne</span>
                <p class="font-bold text-[#4A2E30] text-base"><?php echo htmlspecialchars($rdv['estheticienne']); ?></p>
                <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    • <?php echo htmlspecialchars($rdv['statut']); ?>
                </span>
            </div>
        </div>

        <!-- DETAY SÈVIS LA -->
        <div class="mb-6">
            <h3 class="text-xs font-bold text-[#A07173] uppercase tracking-wider mb-3">Détails de la prestation</h3>
            <div class="bg-white/70 rounded-2xl border border-[#F5E6E8] overflow-hidden">
                <table class="w-full text-sm">
                    <tr class="border-b border-[#F5E6E8]/60">
                        <td class="p-4 font-semibold text-[#5C3A3C]">Service</td>
                        <td class="p-4 text-right font-bold text-[#4A2E30]"><?php echo htmlspecialchars($rdv['service']); ?></td>
                    </tr>
                    <tr class="border-b border-[#F5E6E8]/60">
                        <td class="p-4 font-semibold text-[#5C3A3C]">Date et Heure</td>
                        <td class="p-4 text-right text-[#A07173] font-semibold">
                            <?php echo date('d/m/Y à H:i', strtotime($rdv['date'])); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4 font-semibold text-[#5C3A3C]">Mode de Paiement</td>
                        <td class="p-4 text-right text-[#8A5A5C] font-semibold">
                            <i class="fas fa-wallet mr-1"></i> <?php echo htmlspecialchars($rdv['mode']); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- TOTAL -->
        <div class="bg-[#8A5A5C]/10 rounded-2xl p-4 flex items-center justify-between border border-[#8A5A5C]/20 mb-6">
            <span class="font-bold text-[#4A2E30] text-base">Total Payé</span>
            <span class="font-serif font-bold text-2xl text-[#8A5A5C]">
                <?php echo number_format($rdv['montant'], 2, '.', ','); ?> HTG
            </span>
        </div>

        <!-- FOOTER RESI -->
        <div class="text-center pt-4 border-t border-[#F5E6E8] text-xs text-[#A07173]">
            <p>Mèsi dèske ou chwazi Spa Dream pou moman detant ou!</p>
            <p class="mt-1">Kontak: +509 2200-0000 | info@spadream.ht</p>
        </div>

    </div>

</body>
</html>