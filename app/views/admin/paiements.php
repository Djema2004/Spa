<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiements - Spa Dream Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #FAF7F2 0%, #F5E6E8 50%, #EFE3E5 100%); color: #5C3A3C; }
        .glass-card { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(16px); }
        .modal { display: none; align-items: center; justify-content: center; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 50; }
        .modal.active { display: flex; }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- 🌟 SIDEBAR MENU AK LYEN KI KONEKTE AK LÒT PAJ YO -->
    <aside class="w-64 bg-white/70 border-r border-[#F5E6E8] h-screen sticky top-0 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-2xl bg-[#8A5A5C] flex items-center justify-center text-white text-xl shadow-lg shadow-[#8A5A5C]/20">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="text-xl font-bold font-serif text-[#4A2E30]">Spa Dream</h1>
            </div>
            <nav class="space-y-1 text-sm font-medium">
                <a href="dashboard.php" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 transition"><i class="fas fa-chart-pie w-5"></i> Tableau de bord</a>
                <a href="users.php" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 transition"><i class="fas fa-user-shield w-5"></i> Utilisateurs</a>
                <a href="prestations.php" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 transition"><i class="fas fa-spa w-5"></i> Prestations</a>
                <a href="clients.php" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 transition"><i class="fas fa-users w-5"></i> Clients</a>
                <a href="estheticiennes.php" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 transition"><i class="fas fa-user-tie w-5"></i> Esthéticiennes</a>
                <a href="rendez_vous.php" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 transition"><i class="fas fa-calendar-check w-5"></i> Rendez-vous</a>
                <a href="coupons.php" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-[#A07173] hover:bg-[#F5E6E8]/60 transition"><i class="fas fa-tag w-5"></i> Coupons</a>
                <a href="paiements.php" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-[#8A5A5C] text-white shadow-md shadow-[#8A5A5C]/20"><i class="fas fa-credit-card w-5"></i> Paiements</a>
            </nav>
        </div>
        <a href="logout.php" onclick="return confirm('Voulez-vous vraiment vous déconnecter ?');" class="flex items-center gap-3 px-4 py-2.5 text-rose-600 font-medium text-sm hover:bg-rose-50 rounded-2xl transition">
            <i class="fas fa-sign-out-alt w-5"></i> Déconnexion
        </a>
    </aside>

    <!-- 📄 KONTNI PRENSIPAL -->
    <main class="flex-1 p-8 space-y-6">
        
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-3xl font-bold font-serif text-[#4A2E30]">💳 Suivi des Paiements</h2>
                <p class="text-xs text-[#A07173] mt-1">Gérez et enregistrez toutes les transactions de l'établissement</p>
            </div>
            <button onclick="openAddModal()" class="bg-[#8A5A5C] hover:bg-[#4A2E30] text-white px-5 py-2.5 rounded-2xl text-xs font-bold transition shadow-md shadow-[#8A5A5C]/20 flex items-center gap-2">
                <i class="fas fa-plus"></i> Nouveau Paiement
            </button>
        </div>

        <!-- 🔍 RECHÈCH AK FILTRAG -->
        <div class="glass-card p-4 rounded-3xl border border-white/60">
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4" onsubmit="event.preventDefault();">
                <div class="relative">
                    <i class="fas fa-search absolute left-3.5 top-3 text-[#A07173] text-xs"></i>
                    <input type="text" placeholder="Rechercher client ou ID..." class="w-full bg-white/80 border border-[#F5E6E8] rounded-xl pl-9 pr-4 py-2 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C]">
                </div>
                <div>
                    <select class="w-full bg-white/80 border border-[#F5E6E8] rounded-xl px-4 py-2 text-xs text-[#5C3A3C] focus:outline-none focus:border-[#8A5A5C]">
                        <option value="">Tous les modes de paiement</option>
                        <option value="Espèces">💵 Espèces</option>
                        <option value="Carte Bancaire">💳 Carte Bancaire</option>
                        <option value="MonCash">📱 MonCash</option>
                        <option value="Virement">🏦 Virement</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="flex-1 bg-[#8A5A5C] text-white rounded-xl text-xs font-bold hover:bg-[#4A2E30] transition py-2">Filtrer</button>
                    <button type="reset" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-gray-300 transition flex items-center justify-center">Réinitialiser</button>
                </div>
            </form>
        </div>

        <!-- 📊 TABLO PAIEMENTS -->
        <div class="glass-card p-6 rounded-3xl border border-white/60 overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead>
                    <tr class="text-[#A07173] border-b border-[#F5E6E8] uppercase tracking-wider font-bold">
                        <th class="pb-3 px-2">ID Facture</th>
                        <th class="pb-3 px-2">Client</th>
                        <th class="pb-3 px-2">Rendez-vous</th>
                        <th class="pb-3 px-2">Montant</th>
                        <th class="pb-3 px-2">Mode</th>
                        <th class="pb-3 px-2">Date</th>
                        <th class="pb-3 px-2">Statut</th>
                        <th class="pb-3 px-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F5E6E8]">
                    <tr class="hover:bg-white/40 transition">
                        <td class="py-3 px-2 font-bold text-[#4A2E30]">#FAC-0001</td>
                        <td class="py-3 px-2 font-bold">Jean Pierre</td>
                        <td class="py-3 px-2 text-gray-600">#RDV-12 (Soin du visage)</td>
                        <td class="py-3 px-2 font-black text-emerald-700">2,500.00 HTG</td>
                        <td class="py-3 px-2">
                            <span class="px-2.5 py-1 rounded-lg bg-[#F5E6E8] text-[#8A5A5C] font-bold text-[10px]">MonCash</span>
                        </td>
                        <td class="py-3 px-2 text-gray-500">23/07/2026 14:30</td>
                        <td class="py-3 px-2">
                            <span class="px-2 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">✓ Complété</span>
                        </td>
                        <td class="py-3 px-2 text-right space-x-1">
                            <button onclick="viewReceipt({id:'FAC-0001', client:'Jean Pierre', mode:'MonCash', date:'23/07/2026 14:30', montant:'2500.00'})" class="bg-sky-500 hover:bg-sky-600 text-white p-1.5 rounded-lg text-xs transition" title="Voir reçu">
                                <i class="fas fa-eye"></i> Reçu
                            </button>
                            <button onclick="openEditModal({id:'1', client_id:'1', montant:'2500', mode:'MonCash', date:'2026-07-23T14:30', statut:'completed'})" class="bg-amber-500 hover:bg-amber-600 text-white p-1.5 rounded-lg text-xs transition" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="alert('Suppression démo');" class="bg-rose-500 hover:bg-rose-600 text-white p-1.5 rounded-lg text-xs transition inline-block" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-white/40 transition">
                        <td class="py-3 px-2 font-bold text-[#4A2E30]">#FAC-0002</td>
                        <td class="py-3 px-2 font-bold">Marie Carmel</td>
                        <td class="py-3 px-2 text-gray-400">Paiement Direct</td>
                        <td class="py-3 px-2 font-black text-emerald-700">4,000.00 HTG</td>
                        <td class="py-3 px-2">
                            <span class="px-2.5 py-1 rounded-lg bg-[#F5E6E8] text-[#8A5A5C] font-bold text-[10px]">Espèces</span>
                        </td>
                        <td class="py-3 px-2 text-gray-500">22/07/2026 10:15</td>
                        <td class="py-3 px-2">
                            <span class="px-2 py-1 rounded-full text-[10px] bg-amber-100 text-amber-800 font-bold">⏳ En attente</span>
                        </td>
                        <td class="py-3 px-2 text-right space-x-1">
                            <button onclick="viewReceipt({id:'FAC-0002', client:'Marie Carmel', mode:'Espèces', date:'22/07/2026 10:15', montant:'4000.00'})" class="bg-sky-500 hover:bg-sky-600 text-white p-1.5 rounded-lg text-xs transition" title="Voir reçu">
                                <i class="fas fa-eye"></i> Reçu
                            </button>
                            <button onclick="openEditModal({id:'2', client_id:'2', montant:'4000', mode:'Espèces', date:'2026-07-22T10:15', statut:'pending'})" class="bg-amber-500 hover:bg-amber-600 text-white p-1.5 rounded-lg text-xs transition" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="alert('Suppression démo');" class="bg-rose-500 hover:bg-rose-600 text-white p-1.5 rounded-lg text-xs transition inline-block" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- ➕ MODAL AJOUTER PAIEMENT -->
    <div id="modalAjouter" class="modal">
        <div class="bg-white p-6 rounded-3xl shadow-xl w-full max-w-md border border-[#F5E6E8] space-y-4">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif font-bold text-lg text-[#4A2E30]"><i class="fas fa-plus mr-1"></i> Nouveau Paiement</h3>
                <button onclick="closeModal('modalAjouter')" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>
            <form onsubmit="event.preventDefault(); closeModal('modalAjouter');" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-[#A07173] mb-1">Sélectionner Client</label>
                    <select required class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                        <option value="">-- Choisir un client --</option>
                        <option value="1">Jean Pierre</option>
                        <option value="2">Marie Carmel</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#A07173] mb-1">Lier à un Rendez-vous (Optionnel)</label>
                    <select class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                        <option value="">-- Sans Rendez-vous (Paiement Direct) --</option>
                        <option value="12">RDV #12 - Jean Pierre (Soin du visage)</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] mb-1">Montant (HTG)</label>
                        <input type="number" step="0.01" required placeholder="0.00" class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] mb-1">Mode de paiement</label>
                        <select required class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                            <option value="Espèces">Espèces</option>
                            <option value="Carte Bancaire">Carte Bancaire</option>
                            <option value="MonCash">MonCash</option>
                            <option value="Virement">Virement</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] mb-1">Date</label>
                        <input type="datetime-local" required class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] mb-1">Statut</label>
                        <select class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                            <option value="completed">Complété</option>
                            <option value="pending">En attente</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#8A5A5C] text-white py-2.5 rounded-xl text-xs font-bold hover:bg-[#4A2E30] transition mt-2">Enregistrer Paiement</button>
            </form>
        </div>
    </div>

    <!-- ✏️ MODAL MODIFIER PAIEMENT -->
    <div id="modalModifier" class="modal">
        <div class="bg-white p-6 rounded-3xl shadow-xl w-full max-w-md border border-[#F5E6E8] space-y-4">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif font-bold text-lg text-[#4A2E30]"><i class="fas fa-edit mr-1"></i> Modifier Paiement</h3>
                <button onclick="closeModal('modalModifier')" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>
            <form onsubmit="event.preventDefault(); closeModal('modalModifier');" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-[#A07173] mb-1">Client</label>
                    <select id="edit_client_id" required class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                        <option value="1">Jean Pierre</option>
                        <option value="2">Marie Carmel</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] mb-1">Montant (HTG)</label>
                        <input type="number" step="0.01" id="edit_montant" required class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] mb-1">Mode</label>
                        <select id="edit_mode" required class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                            <option value="Espèces">Espèces</option>
                            <option value="Carte Bancaire">Carte Bancaire</option>
                            <option value="MonCash">MonCash</option>
                            <option value="Virement">Virement</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] mb-1">Date</label>
                        <input type="datetime-local" id="edit_date" required class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#A07173] mb-1">Statut</label>
                        <select id="edit_statut" class="w-full bg-white border border-[#F5E6E8] rounded-xl px-3 py-2 text-xs text-[#5C3A3C]">
                            <option value="completed">Complété</option>
                            <option value="pending">En attente</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#8A5A5C] text-white py-2.5 rounded-xl text-xs font-bold hover:bg-[#4A2E30] transition mt-2">Mettre à jour</button>
            </form>
        </div>
    </div>

    <!-- 🧾 MODAL REÇU -->
    <div id="modalReceipt" class="modal">
        <div class="bg-white p-6 rounded-3xl shadow-xl w-full max-w-sm border border-[#F5E6E8] space-y-4">
            <div class="text-center border-b pb-3">
                <h3 class="font-serif font-bold text-xl text-[#4A2E30]">🏨 SPA DREAM</h3>
                <p class="text-[10px] text-[#A07173]">Reçu de Paiement Officiel</p>
            </div>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between"><span class="font-bold">N° Facture:</span><span id="rc_id" class="text-gray-600"></span></div>
                <div class="flex justify-between"><span class="font-bold">Client:</span><span id="rc_client" class="text-gray-600"></span></div>
                <div class="flex justify-between"><span class="font-bold">Mode:</span><span id="rc_mode" class="text-gray-600"></span></div>
                <div class="flex justify-between"><span class="font-bold">Date:</span><span id="rc_date" class="text-gray-600"></span></div>
                <div class="flex justify-between border-t pt-2 text-sm"><span class="font-bold text-[#4A2E30]">Total Payé:</span><span id="rc_montant" class="font-black text-emerald-700"></span></div>
            </div>
            <div class="flex gap-2 pt-3">
                <button onclick="window.print()" class="flex-1 bg-[#8A5A5C] text-white py-2 rounded-xl text-xs font-bold hover:bg-[#4A2E30] transition"><i class="fas fa-print mr-1"></i> Imprimer</button>
                <button onclick="closeModal('modalReceipt')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-gray-300 transition">Fermer</button>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() { document.getElementById('modalAjouter').classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }

        function openEditModal(data) {
            document.getElementById('edit_client_id').value = data.client_id;
            document.getElementById('edit_montant').value = data.montant;
            document.getElementById('edit_mode').value = data.mode;
            document.getElementById('edit_statut').value = data.statut;
            document.getElementById('edit_date').value = data.date;
            document.getElementById('modalModifier').classList.add('active');
        }

        function viewReceipt(data) {
            document.getElementById('rc_id').textContent = '#' + data.id;
            document.getElementById('rc_client').textContent = data.client;
            document.getElementById('rc_mode').textContent = data.mode;
            document.getElementById('rc_date').textContent = data.date;
            document.getElementById('rc_montant').textContent = data.montant + ' HTG';
            document.getElementById('modalReceipt').classList.add('active');
        }
    </script>
</body>
</html>