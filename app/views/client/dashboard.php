<?php 
// Inclusion de ton header global
include __DIR__ . '/../header.php'; 
?>

<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen flex flex-col justify-between font-sans">

    <main class="flex-grow max-w-6xl w-full mx-auto p-6 my-6">
        
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-[#F5E6E8] flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Espace Client</span>
                <h1 class="text-3xl font-serif text-[#4A2E30] font-bold mt-1">Mon Espace Bien-être</h1>
                <p class="text-sm text-gray-500 mt-1">Retrouvez ici vos rendez-vous et l'historique de vos moments de détente.</p>
            </div>
            <div>
                <a href="../reservation.php" class="inline-flex items-center justify-center bg-[#8A5A5C] hover:bg-[#734A4C] text-white text-sm font-medium py-3 px-6 rounded-xl shadow-md transition-colors duration-200 no-underline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Réserver un nouveau soin
                </a>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-[#F5E6E8] overflow-hidden">
            <div class="p-6 border-b border-[#F5E6E8]">
                <h2 class="text-xl font-serif text-[#5C3A3C] font-semibold">Mes Rendez-vous</h2>
            </div>

            <?php if (empty($appointments)): ?>
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#FAF7F2] text-[#A07173] mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm">Vous n'avez pas encore planifié de réservation.</p>
                    <a href="../reservation.php" class="text-[#8A5A5C] hover:text-[#734A4C] text-sm font-medium mt-2 inline-block underline">Prendre mon premier rendez-vous</a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#FAF7F2] text-[#A07173] text-xs font-bold uppercase tracking-wider border-b border-[#F5E6E8]">
                                <th class="py-4 px-6">Référence (UUID)</th>
                                <th class="py-4 px-6">Prestation</th>
                                <th class="py-4 px-6">Date & Heure</th>
                                <th class="py-4 px-6">Tarif</th>
                                <th class="py-4 px-6 text-center">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F5E6E8] text-sm text-gray-700">
                            <?php foreach ($appointments as $app): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-6 font-mono text-xs text-gray-400 select-all" title="<?php echo $app['id']; ?>">
                                        <?php echo substr($app['id'], 0, 8) . '...'; ?>
                                    </td>
                                    <td class="py-4 px-6 font-medium text-[#5C3A3C]">
                                        <?php echo htmlspecialchars($app['service_name']); ?>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium"><?php echo date('d/m/Y', strtotime($app['appointment_date'])); ?></div>
                                        <div class="text-xs text-gray-400 mt-0.5"><?php echo htmlspecialchars($app['appointment_time']); ?></div>
                                    </td>
                                    <td class="py-4 px-6 font-medium">
                                        <?php echo number_format($app['price'], 2); ?> HTG
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <?php if ($app['status'] === 'confirmed'): ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                Confirmé
                                            </span>
                                        <?php elseif ($app['status'] === 'cancelled'): ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                                Annulé
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                                En attente
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </main>

</div>

<?php 
// Inclusion de ton footer global
include __DIR__ . '/../footer.php'; 
?>