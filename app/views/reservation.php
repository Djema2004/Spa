<?php
// 1. DÉMARRAGE DE LA SESSION ET VÉRIFICATION SÉCURISÉE
session_start();

// SÉCURITÉ STRICTE : Si l'UUID de l'utilisateur n'est pas en session, on redirige vers la connexion
if (!isset($_SESSION['user_uuid'])) {
    header('Location: login.php');
    exit();
}

// 2. RÉCUPÉRATION DYNAMIQUE DE LA PAGE PRÉCÉDENTE (REFERER)
// On stocke la page d'où vient le client en session pour ne pas la perdre si la page recharge
if (isset($_SERVER['HTTP_REFERER']) && !strpos($_SERVER['HTTP_REFERER'], 'confirm_reservation.php')) {
    // On extrait juste le nom du fichier (ex: massage.php) pour éviter les URL absolues complexes
    $_SESSION['back_page'] = basename($_SERVER['HTTP_REFERER']);
}

// Si la session ne contient rien, on met 'reservation.php' par défaut
$back_page = isset($_SESSION['back_page']) ? $_SESSION['back_page'] : "reservation.php";

// 3. RÉCUPÉRATION DES DONNÉES DU FORMULAIRE DE CHOIX
$service_name = isset($_POST['service_name']) ? htmlspecialchars($_POST['service_name']) : "Massage Relaxant aux Huiles";
$service_duration = isset($_POST['duration']) ? intval($_POST['duration']) : 60;
$service_price = isset($_POST['price']) ? floatval($_POST['price']) : 2500.00;
$appointment_date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : date('Y-m-d');
$appointment_time = isset($_POST['time']) ? htmlspecialchars($_POST['time']) : "14:00";

// Calcul du prix avec taxe (10%)
$tax = $service_price * 0.10; 
$total_price = $service_price + $tax;

// Inclusion de ton header global
include __DIR__ . '/header.php'; 
?>

<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen flex flex-col justify-between font-sans">

    <main class="flex-grow flex items-center justify-center p-6 my-8">
        <div class="bg-white rounded-2xl shadow-xl border border-[#F5E6E8] max-w-lg w-full p-8 transition-all hover:shadow-2xl">
            
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#FCEAEB] text-[#8A5A5C] mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-serif text-[#5C3A3C]">Vérifiez vos informations</h2>
                <p class="text-sm text-gray-500 mt-1">Dernière étape avant la confirmation de votre moment de détente.</p>
            </div>

            <hr class="border-[#F5E6E8] my-4">

            <div class="mb-5">
                <span class="text-xs font-bold uppercase tracking-wider text-[#A07173]">Prestation</span>
                <div class="flex justify-between items-center mt-1">
                    <span class="font-medium text-lg text-[#5C3A3C]"><?php echo $service_name; ?></span>
                    <span class="bg-[#FCEAEB] text-[#8A5A5C] text-xs px-2.5 py-1 rounded-full font-medium"><?php echo $service_duration; ?> min</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6 bg-[#FAF7F2] p-4 rounded-xl border border-[#F5E6E8]">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#A07173] block">Date</span>
                    <span class="font-medium text-[#5C3A3C]"><?php echo date('d/m/Y', strtotime($appointment_date)); ?></span>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#A07173] block">Heure</span>
                    <span class="font-medium text-[#5C3A3C]"><?php echo $appointment_time; ?></span>
                </div>
            </div>

            <div class="space-y-2 mb-6 text-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-[#A07173] block">Tarif</span>
                <div class="flex justify-between text-gray-600">
                    <span>Prix de base</span>
                    <span><?php echo number_format($service_price, 2); ?> HTG</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Frais de service (10%)</span>
                    <span><?php echo number_format($tax, 2); ?> HTG</span>
                </div>
                <hr class="border-dashed border-[#F5E6E8] My-2">
                <div class="flex justify-between items-center text-base font-bold text-[#5C3A3C]">
                    <span>Montant Total</span>
                    <span class="text-xl text-[#8A5A5C]"><?php echo number_format($total_price, 2); ?> HTG</span>
                </div>
            </div>

            <form action="confirm_reservation_process.php" method="POST" class="space-y-3">
                <input type="hidden" name="service_name" value="<?php echo $service_name; ?>">
                <input type="hidden" name="date" value="<?php echo $appointment_date; ?>">
                <input type="hidden" name="time" value="<?php echo $appointment_time; ?>">
                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">

                <button type="submit" class="w-full bg-[#8A5A5C] hover:bg-[#734A4C] text-white font-medium py-3 px-4 rounded-xl shadow-md transition-colors duration-200 cursor-pointer text-center block border-0">
                    Confirmer la réservation
                </button>
            </form>

            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-[#F5E6E8] mt-4">
    <!-- 🎯 Ajout de /spa/ devant index.php -->
    <a href="/spa/index.php?url=client-dashboard" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full font-semibold transition hover:bg-gray-300">
        Annuler
    </a>
    <a href="/spa/index.php?url=client-dashboard" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full font-semibold transition hover:bg-gray-300">
        Modifier
    </a>
</div>

        </div>
    </main>

</div>

<?php 
// Inclusion du footer global
include __DIR__ . '/footer.php'; 
?>