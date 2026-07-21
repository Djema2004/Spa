<?php
// views/admin/paiements.php
// Données: $paiements, $clients, $rendez_vous
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA DREAM - Paiements</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #FAF5F5;
            --sidebar-bg: #F5E6E6;
            --primary-color: #8C5353;
            --text-dark: #4A3B3B;
            --card-bg: #FFFFFF;
            --accent-color: #DDA7A5;
            --danger-color: #C0392B;
            --success-color: #2ECC71;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-dark); display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar { width: 260px; background-color: var(--sidebar-bg); padding: 25px 15px; display: flex; flex-direction: column; justify-content: space-between; border-right: 1px solid rgba(140, 83, 83, 0.1); position: fixed; height: 100vh; }
        .sidebar-top { display: flex; flex-direction: column; gap: 30px; }
        .logo-container { display: flex; align-items: center; gap: 12px; padding-left: 10px; }
        .logo-container i { font-size: 24px; color: var(--primary-color); }
        .logo-container h1 { font-size: 22px; font-weight: 700; color: var(--primary-color); letter-spacing: 1px; }
        .menu-list { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .menu-item a { display: flex; align-items: center; gap: 15px; padding: 12px 15px; color: var(--text-dark); text-decoration: none; font-size: 15px; font-weight: 500; border-radius: 8px; transition: all 0.3s; }
        .menu-item a:hover { background-color: rgba(140, 83, 83, 0.08); color: var(--primary-color); }
        .menu-item.active a { background-color: var(--primary-color); color: white; }
        .menu-item.logout a { color: var(--danger-color); }
        .menu-item.logout a:hover { background-color: rgba(192, 57, 43, 0.1); }

        /* MAIN CONTENT */
        .main-content { flex: 1; margin-left: 260px; padding: 40px; display: flex; flex-direction: column; gap: 30px; }
        .header-section { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .header-section h2 { font-size: 28px; color: var(--primary-color); }
        .header-section p { color: #887474; font-size: 15px; }

        .btn-add { background-color: var(--primary-color); color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: background 0.3s; border: none; cursor: pointer; }
        .btn-add:hover { background-color: #703f3f; }

        .btn-action { padding: 8px 12px; border-radius: 6px; font-size: 13px; cursor: pointer; border: none; font-weight: 600; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-view { background: #3498db; color: white; }
        .btn-view:hover { background: #2980b9; }
        .btn-edit { background: #f39c12; color: white; }
        .btn-edit:hover { background: #e67e22; }
        .btn-delete { background: var(--danger-color); color: white; }
        .btn-delete:hover { background: #a93226; }

        /* TABLE PAIEMENT */
        .table-box { background-color: var(--card-bg); border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02); border: 1px solid rgba(140, 83, 83, 0.05); overflow-x: auto; }
        .pay-table { width: 100%; border-collapse: collapse; text-align: left; }
        .pay-table th { font-size: 13px; text-transform: uppercase; color: #887474; padding: 15px; border-bottom: 2px solid rgba(140, 83, 83, 0.1); background: rgba(140, 83, 83, 0.02); }
        .pay-table td { padding: 15px; border-bottom: 1px solid rgba(140, 83, 83, 0.05); font-size: 14px; }
        .pay-table tr:hover { background-color: rgba(140, 83, 83, 0.02); }
        .pay-table tr:last-child td { border-bottom: none; }

        .badge-montant { background-color: var(--success-color); color: white; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 13px; }
        .badge-mode { background-color: rgba(140, 83, 83, 0.1); color: var(--primary-color); padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 12px; }
        .badge-status { padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; }
        .badge-completed { background: rgba(46, 204, 113, 0.2); color: #27ae60; }
        .badge-pending { background: rgba(241, 196, 15, 0.2); color: #f39c12; }

        /* MODAL */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 1000; }
        .modal-content { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .modal-header h3 { color: var(--primary-color); font-size: 20px; }
        .modal-header .close { font-size: 28px; cursor: pointer; color: #999; border: none; background: none; }
        .modal-header .close:hover { color: var(--primary-color); }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; color: var(--primary-color); font-weight: 600; font-size: 13px; text-transform: uppercase; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; font-family: inherit; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(140, 83, 83, 0.1); }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

        .btn-submit { background: var(--primary-color); color: white; padding: 12px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%; transition: background 0.3s; }
        .btn-submit:hover { background: #703f3f; }
        .btn-cancel { background: #ddd; color: #333; padding: 12px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%; margin-top: 10px; }
        .btn-cancel:hover { background: #bbb; }

        /* RECEIPT */
        .receipt-container { background: white; padding: 30px; border-radius: 12px; max-width: 500px; margin: 0 auto; border: 2px solid var(--primary-color); }
        .receipt-header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 15px; }
        .receipt-header h2 { color: var(--primary-color); font-size: 24px; margin-bottom: 5px; }
        .receipt-header p { color: #666; font-size: 13px; }
        .receipt-body { margin-bottom: 20px; }
        .receipt-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .receipt-row.total { font-weight: bold; background: rgba(140, 83, 83, 0.05); padding: 12px 8px; border-radius: 6px; font-size: 16px; }
        .receipt-footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }

        .print-btn { background: var(--primary-color); color: white; padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; margin: 20px auto; display: block; }
        .print-btn:hover { background: #703f3f; }

        @media print {
            body { display: block; }
            .sidebar, .main-content > .header-section, .main-content > .table-box, .btn-action, .modal { display: none !important; }
            .receipt-container { border: none; margin: 0; padding: 0; }
            .print-btn { display: none; }
        }

        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .main-content { margin-left: 70px; padding: 20px; }
            .form-row { grid-template-columns: 1fr; }
            .header-section { flex-direction: column; align-items: flex-start; }
            .pay-table { font-size: 12px; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-top">
            <div class="logo-container">
                <i class="fa-solid fa-spa"></i>
                <h1>SPA DREAM</h1>
            </div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="index.php?route=dashboard">
                        <i class="fa-solid fa-chart-simple"></i> Tableau de Bord
                    </a>
                </li>
                <li class="menu-item">
                    <a href="index.php?route=clients">
                        <i class="fa-solid fa-users"></i> Clients
                    </a>
                </li>
                <li class="menu-item">
                    <a href="index.php?route=prestations">
                        <i class="fa-solid fa-sparkles"></i> Prestations
                    </a>
                </li>
                <li class="menu-item">
                    <a href="index.php?route=estheticiennes">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Esthéticiennes
                    </a>
                </li>
                <li class="menu-item">
                    <a href="index.php?route=rendez_vous">
                        <i class="fa-solid fa-calendar-days"></i> Rendez-vous
                    </a>
                </li>
                <li class="menu-item active">
                    <a href="index.php?route=paiements">
                        <i class="fa-solid fa-credit-card"></i> Paiements
                    </a>
                </li>
            </ul>
        </div>
        <ul class="menu-list">
            <li class="menu-item logout">
                <a href="logout.php" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                    <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                </a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="header-section">
            <div>
                <h2>💳 Suivi des Paiements</h2>
                <p>Enregistrez et contrôlez la comptabilité de l'établissement</p>
            </div>
            <button class="btn-add" onclick="openAddModal()">
                <i class="fa-solid fa-plus"></i> Nouveau Paiement
            </button>
        </div>

        <!-- TABLE PAIEMENTS -->
        <div class="table-box">
            <table class="pay-table">
                <thead>
                    <tr>
                        <th>📋 ID Facture</th>
                        <th>👤 Client</th>
                        <th>📅 Date</th>
                        <th>💰 Montant</th>
                        <th>🔄 Mode</th>
                        <th>✅ Statut</th>
                        <th>⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($paiements)): ?>
                        <?php foreach ($paiements as $pay): ?>
                            <tr>
                                <td><strong>#FAC-<?= str_pad($pay['id'], 4, '0', STR_PAD_LEFT) ?></strong></td>
                                <td><?= htmlspecialchars($pay['client_nom'] ?? 'N/A') ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($pay['date_paiement'] ?? 'now')) ?></td>
                                <td><span class="badge-montant"><?= number_format($pay['montant'] ?? 0, 2) ?> HTG</span></td>
                                <td><span class="badge-mode"><?= htmlspecialchars($pay['mode_paiement'] ?? 'N/A') ?></span></td>
                                <td>
                                    <span class="badge-status <?= ($pay['statut'] ?? 'pending') === 'completed' ? 'badge-completed' : 'badge-pending' ?>">
                                        <?= ($pay['statut'] ?? 'pending') === 'completed' ? '✓ Complété' : '⏳ En attente' ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-action btn-view" onclick="viewReceipt(<?= json_encode($pay) ?>)" title="Voir reçu">
                                        <i class="fa-solid fa-eye"></i> Reçu
                                    </button>
                                    <button class="btn-action btn-edit" onclick="openEditModal(<?= json_encode($pay) ?>)" title="Modifier">
                                        <i class="fa-solid fa-edit"></i> Éditer
                                    </button>
                                    <button class="btn-action btn-delete" onclick="deletePaiement(<?= $pay['id'] ?>)" title="Supprimer">
                                        <i class="fa-solid fa-trash"></i> Supprimer
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #887474; padding: 40px;">
                                <i class="fa-solid fa-inbox" style="font-size: 40px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                                Aucun paiement enregistré pour le moment.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ✅ MODAL AJOUTER PAIEMENT -->
    <div id="modalAjouter" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa-solid fa-plus"></i> Ajouter un Paiement</h3>
                <button class="close" onclick="closeModal('modalAjouter')">&times;</button>
            </div>
            <form method="POST" action="index.php?route=store_paiement">
                <div class="form-group">
                    <label>Sélectionner un Client</label>
                    <select name="client_id" required>
                        <option value="">-- Choisir un client --</option>
                        <?php if (!empty($clients)): ?>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id'] ?>">
                                    <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Montant (HTG)</label>
                        <input type="number" name="montant" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label>Date de Paiement</label>
                        <input type="datetime-local" name="date_paiement" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mode de Paiement</label>
                    <select name="mode_paiement" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Espèces">💵 Espèces</option>
                        <option value="Carte Bancaire">💳 Carte Bancaire</option>
                        <option value="Virement">🏦 Virement</option>
                        <option value="Chèque">📄 Chèque</option>
                        <option value="Mobile Money">📱 Mobile Money</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Statut</label>
                    <select name="statut" required>
                        <option value="pending">⏳ En attente</option>
                        <option value="completed">✅ Complété</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Description (Optionnel)</label>
                    <textarea name="description" placeholder="Notes supplémentaires..." rows="3"></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save"></i> Enregistrer Paiement
                </button>
                <button type="button" class="btn-cancel" onclick="closeModal('modalAjouter')">
                    Annuler
                </button>
            </form>
        </div>
    </div>

    <!-- ✏️ MODAL MODIFIER PAIEMENT -->
    <div id="modalModifier" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa-solid fa-edit"></i> Modifier le Paiement</h3>
                <button class="close" onclick="closeModal('modalModifier')">&times;</button>
            </div>
            <form method="POST" action="index.php?route=update_paiement">
                <input type="hidden" name="id" id="edit_id">

                <div class="form-group">
                    <label>Client</label>
                    <select name="client_id" id="edit_client_id" required>
                        <option value="">-- Choisir un client --</option>
                        <?php if (!empty($clients)): ?>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id'] ?>">
                                    <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Montant (HTG)</label>
                        <input type="number" name="montant" id="edit_montant" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Date de Paiement</label>
                        <input type="datetime-local" name="date_paiement" id="edit_date" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mode de Paiement</label>
                    <select name="mode_paiement" id="edit_mode" required>
                        <option value="Espèces">💵 Espèces</option>
                        <option value="Carte Bancaire">💳 Carte Bancaire</option>
                        <option value="Virement">🏦 Virement</option>
                        <option value="Chèque">📄 Chèque</option>
                        <option value="Mobile Money">📱 Mobile Money</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Statut</label>
                    <select name="statut" id="edit_statut" required>
                        <option value="pending">⏳ En attente</option>
                        <option value="completed">✅ Complété</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit_description" rows="3"></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-save"></i> Mettre à jour
                </button>
                <button type="button" class="btn-cancel" onclick="closeModal('modalModifier')">
                    Annuler
                </button>
            </form>
        </div>
    </div>

    <!-- 📄 MODAL REÇU -->
    <div id="modalReceipt" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa-solid fa-receipt"></i> Reçu de Paiement</h3>
                <button class="close" onclick="closeModal('modalReceipt')">&times;</button>
            </div>

            <div id="receiptContent" class="receipt-container">
                <div class="receipt-header">
                    <h2>🏨 SPA DREAM</h2>
                    <p>Reçu de Paiement</p>
                </div>

                <div class="receipt-body">
                    <div class="receipt-row">
                        <span><strong>Numéro Facture:</strong></span>
                        <span id="receipt_id"></span>
                    </div>
                    <div class="receipt-row">
                        <span><strong>Client:</strong></span>
                        <span id="receipt_client"></span>
                    </div>
                    <div class="receipt-row">
                        <span><strong>Date:</strong></span>
                        <span id="receipt_date"></span>
                    </div>
                    <div class="receipt-row">
                        <span><strong>Mode:</strong></span>
                        <span id="receipt_mode"></span>
                    </div>
                    <div class="receipt-row">
                        <span><strong>Statut:</strong></span>
                        <span id="receipt_status"></span>
                    </div>
                    <div class="receipt-row total">
                        <span>Montant Total:</span>
                        <span id="receipt_montant"></span>
                    </div>
                    <div class="receipt-row">
                        <span><strong>Notes:</strong></span>
                        <span id="receipt_notes"></span>
                    </div>
                </div>

                <div class="receipt-footer">
                    <p>Merci de votre confiance!</p>
                    <p style="font-size: 11px; margin-top: 10px;">
                        <?= date('d/m/Y H:i') ?>
                    </p>
                </div>
            </div>

            <button class="print-btn" onclick="printReceipt()">
                <i class="fa-solid fa-print"></i> Imprimer
            </button>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        // ✅ OUVRIR MODAL AJOUTER
        function openAddModal() {
            document.getElementById('modalAjouter').style.display = 'flex';
        }

        // ✏️ OUVRIR MODAL MODIFIER
        function openEditModal(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_client_id').value = data.client_id;
            document.getElementById('edit_montant').value = data.montant;
            document.getElementById('edit_date').value = data.date_paiement.replace(' ', 'T');
            document.getElementById('edit_mode').value = data.mode_paiement;
            document.getElementById('edit_statut').value = data.statut || 'pending';
            document.getElementById('edit_description').value = data.description || '';

            document.getElementById('modalModifier').style.display = 'flex';
        }

        // 📄 VOIR REÇU
        function viewReceipt(data) {
            document.getElementById('receipt_id').textContent = '#FAC-' + String(data.id).padStart(4, '0');
            document.getElementById('receipt_client').textContent = data.client_nom;
            document.getElementById('receipt_date').textContent = new Date(data.date_paiement).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });
            document.getElementById('receipt_mode').textContent = data.mode_paiement;
            document.getElementById('receipt_status').textContent = (data.statut === 'completed') ? '✅ Complété' : '⏳ En attente';
            document.getElementById('receipt_montant').textContent = parseFloat(data.montant).toFixed(2) + ' HTG';
            document.getElementById('receipt_notes').textContent = data.description || 'Aucune note';

            document.getElementById('modalReceipt').style.display = 'flex';
        }

        // 🗑️ SUPPRIMER PAIEMENT
        function deletePaiement(id) {
            if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce paiement ?')) {
                window.location.href = 'index.php?route=delete_paiement&id=' + id;
            }
        }

        // ❌ FERMER MODAL
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // 🖨️ IMPRIMER REÇU
        function printReceipt() {
            window.print();
        }

        // Fermer modal en cliquant dehors
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });

        // Set today's date in paiement form
        document.addEventListener('DOMContentLoaded', () => {
            const now = new Date().toISOString().slice(0, 16);
            const dateInputs = document.querySelectorAll('input[type="datetime-local"]');
            dateInputs.forEach(input => {
                if (!input.value) input.value = now;
            });
        });
    </script>
</body>
</html>