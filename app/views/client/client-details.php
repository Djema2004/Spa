<?php
require 'connect.php';

if (!isset($_GET['uid']) || empty($_GET['uid'])) {
    header("Location: clients.php");
    exit;
}

$uid = $_GET['uid'];

$stmt = $pdo->prepare("SELECT * FROM clients WHERE uid = ?");
$stmt->execute([$uid]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    header("Location: clients.php");
    exit;
}

$rendezVous = [];
try {
    $stmtRdv = $pdo->prepare("
        SELECT r.*, p.nom_prestation, e.nom AS nom_estheticienne
        FROM rendez_vous r
        LEFT JOIN prestations p ON r.prestation_id = p.id
        LEFT JOIN estheticiennes e ON r.estheticienne_id = e.id
        WHERE r.client_id = ?
        ORDER BY r.date_rdv DESC
    ");
    $stmtRdv->execute([$client['id']]);
    $rendezVous = $stmtRdv->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $rendezVous = [];
}

$paiements = [];
try {
    $stmtPay = $pdo->prepare("SELECT * FROM paiements WHERE client_id = ? ORDER BY date_paiement DESC");
    $stmtPay->execute([$client['id']]);
    $paiements = $stmtPay->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $paiements = [];
}

$totalRdv = count($rendezVous);
$totalPaye = 0;
foreach ($paiements as $p) {
    if (isset($p['statut']) && $p['statut'] === 'payé') {
        $totalPaye += $p['montant'];
    }
}
$dernierRdv = $rendezVous[0]['date_rdv'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails Client - <?= htmlspecialchars($client['nom']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #FAF5F5; padding: 20px; }
        .table-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 1000px; margin: auto; }
        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-action { background-color: #8C5353; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; cursor: pointer; }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px; }
        .info-box { background: #fdf3f0; padding: 15px; border-radius: 10px; }
        .info-box label { font-size: 12px; color: #999; display: block; }
        .info-box span { font-size: 16px; font-weight: bold; color: #333; }
        .stats-row { display: flex; gap: 15px; margin-bottom: 25px; }
        .stat-box { flex: 1; background: #8C5353; color: white; border-radius: 10px; padding: 15px; text-align: center; }
        .stat-box h3 { margin: 0 0 5px; font-size: 22px; }
        .stat-box p { margin: 0; font-size: 13px; opacity: 0.9; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        h3.section-title { margin-top: 30px; color: #8C5353; border-bottom: 2px solid #eee; padding-bottom: 8px; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; color: #fff; }
        .badge-terminé, .badge-payé, .badge-confirmé { background: #27ae60; }
        .badge-en_attente { background: #f39c12; }
        .badge-annulé { background: #c0392b; }
        .empty-msg { color: #999; text-align: center; padding: 20px; }
    </style>
</head>
<body>

<div class="table-container">
    <div class="header-section">
        <h2>Détails Client</h2>
        <a href="clients.php" class="btn-action" style="background:#666;">← Retour Clients</a>
    </div>

    <div class="info-grid">
        <div class="info-box"><label>UID</label><span><?= htmlspecialchars($client['uid']); ?></span></div>
        <div class="info-box"><label>Nom Complet</label><span><?= htmlspecialchars($client['nom'] . ' ' . $client['prenom']); ?></span></div>
        <div class="info-box"><label>Email</label><span><?= htmlspecialchars($client['email']); ?></span></div>
        <div class="info-box"><label>Téléphone</label><span><?= htmlspecialchars($client['telephone'] ?? 'N/A'); ?></span></div>
    </div>

    <div class="stats-row">
        <div class="stat-box"><h3><?= $totalRdv; ?></h3><p>Rendez-vous</p></div>
        <div class="stat-box"><h3><?= number_format($totalPaye, 2); ?> HTG</h3><p>Total Payé</p></div>
        <div class="stat-box"><h3><?= $dernierRdv ? date('d/m/Y', strtotime($dernierRdv)) : 'N/A'; ?></h3><p>Dernier RDV</p></div>
    </div>

    <h3 class="section-title">Historique des Rendez-vous</h3>
    <?php if (empty($rendezVous)): ?>
        <p class="empty-msg">Aucun rendez-vous trouvé pour ce client.</p>
    <?php else: ?>
    <table>
        <thead><tr><th>Date</th><th>Heure</th><th>Prestation</th><th>Esthéticienne</th><th>Statut</th></tr></thead>
        <tbody>
            <?php foreach ($rendezVous as $r): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($r['date_rdv'])); ?></td>
                <td><?= htmlspecialchars($r['heure_rdv'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($r['nom_prestation'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($r['nom_estheticienne'] ?? '-'); ?></td>
                <td><span class="badge badge-<?= $r['statut']; ?>"><?= $r['statut']; ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <h3 class="section-title">Historique des Paiements</h3>
    <?php if (empty($paiements)): ?>
        <p class="empty-msg">Aucun paiement trouvé pour ce client.</p>
    <?php else: ?>
    <table>
        <thead><tr><th>Date</th><th>Montant</th><th>Statut</th></tr></thead>
        <tbody>
            <?php foreach ($paiements as $p): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($p['date_paiement'])); ?></td>
                <td><?= number_format($p['montant'], 2); ?> HTG</td>
                <td><span class="badge badge-<?= $p['statut']; ?>"><?= $p['statut']; ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

</div>

</body>
</html>