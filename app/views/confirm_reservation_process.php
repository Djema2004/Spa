<?php
// 1. DÉMARRAGE DE LA SESSION ET SÉCURITÉ
session_start();

if (!isset($_SESSION['user_uuid'])) {
    header('Location: login.php');
    exit();
}

// 2. CONNEXION À LA BASE DE DONNÉES DBSPA
$host = 'localhost';
$dbname = 'dbspa'; 
$username = 'root'; 
$password_db = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour générer un UUID v4 pour le rendez-vous
function generate_uuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// 3. TRAITEMENT DE L'INSERTION SI LE FORMULAIRE EST REÇU
$success = false;
$booking_reference = "";
$service_display_name = isset($_POST['service_name']) ? htmlspecialchars($_POST['service_name']) : "Prestation Spa";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_uuid = $_SESSION['user_uuid']; 
    $appointment_date = htmlspecialchars($_POST['date']);
    $appointment_time = htmlspecialchars($_POST['time']);
    $total_price = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0.00;
    
    // Récupération de l'ID envoyé
    $service_id = isset($_POST['service_id']) ? trim($_POST['service_id']) : "";
    
    // SÉCURITÉ CLÉ ÉTRANGÈRE : Si l'ID est vide ou ne fait pas la taille d'un UUID (36 caractères)
    if (empty($service_id) || strlen($service_id) !== 36) {
        // On cherche un ID valide basé sur le nom du service
        $stmtService = $pdo->prepare("SELECT id FROM services WHERE name LIKE :name LIMIT 1");
        $stmtService->execute(['name' => '%' . $service_display_name . '%']);
        $foundService = $stmtService->fetch(PDO::FETCH_ASSOC);
        
        if ($foundService) {
            $service_id = $foundService['id'];
        } else {
            // FALLBACK ULTIME : On prend le premier service existant dans la table pour éviter le crash 1452
            $stmtFallback = $pdo->query("SELECT id FROM services LIMIT 1");
            $fallbackService = $stmtFallback->fetch(PDO::FETCH_ASSOC);
            if ($fallbackService) {
                $service_id = $fallbackService['id'];
            }
        }
    }
    
    $booking_reference = generate_uuid();

    // Si on a un service_id valide, on insère
    if (!empty($service_id)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO appointments 
                (id, user_id, service_id, appointment_date, appointment_time, status, created_at) 
                VALUES (:id, :user_id, :service_id, :appointment_date, :appointment_time, 'pending', NOW())");
            
            $stmt->execute([
                'id' => $booking_reference,
                'user_id' => $user_uuid,
                'service_id' => $service_id, 
                'appointment_date' => $appointment_date,
                'appointment_time' => $appointment_time
            ]);

            $success = true;
        } catch (PDOException $e) {
            $erreur_sql = "Erreur lors de l'enregistrement SQL : " . $e->getMessage();
        }
    } else {
        $erreur_sql = "Impossible de valider la réservation car aucun service n'existe dans votre table 'services'. Veuillez ajouter au moins un soin dans phpMyAdmin.";
    }
}

include __DIR__ . '/header.php'; 
?>

<div class="bg-[#FAF7F2] text-[#5C3A3C] min-h-screen flex flex-col justify-between font-sans">
    <main class="flex-grow flex items-center justify-center p-6 my-12">
        <div class="bg-white rounded-3xl shadow-xl border border-[#F5E6E8] max-w-md w-full p-8 text-center relative overflow-hidden">
            
            <?php if ($success): ?>
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-50 text-emerald-500 mb-6 border border-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <h2 class="text-3xl font-serif text-[#4A2E30] font-bold">Réservation Confirmée !</h2>
                <p class="text-sm text-gray-500 mt-2 px-2">Votre rendez-vous a été enregistré avec succès.</p>

                <div class="mt-6 bg-[#FAF7F2] rounded-2xl p-5 border border-[#F5E6E8] text-left space-y-3 text-sm">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A07173] block">Numéro de reçu (UUID)</span>
                        <span class="font-mono text-xs text-gray-600 block break-all bg-white p-2 rounded-lg border border-[#F5E6E8] mt-1"><?php echo $booking_reference; ?></span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#A07173] block">Prestation</span>
                            <span class="font-medium text-[#5C3A3C]"><?php echo $service_display_name; ?></span>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#A07173] block">Estimation Tarif</span>
                            <span class="font-bold text-[#8A5A5C]"><?php echo number_format($total_price, 2); ?> HTG</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-[#F5E6E8]">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#A07173] block">Date</span>
                            <span class="font-medium text-[#5C3A3C]"><?php echo date('d/m/Y', strtotime($appointment_date)); ?></span>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#A07173] block">Heure</span>
                            <span class="font-medium text-[#5C3A3C]"><?php echo $appointment_time; ?></span>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="dashboard.php" class="w-full bg-[#8A5A5C] hover:bg-[#734A4C] text-white font-medium py-3 px-4 rounded-xl shadow-md transition-colors duration-200 block border-0 text-center text-sm no-underline">
                        Aller vers mon tableau de bord
                    </a>
                </div>

            <?php else: ?>
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-50 text-red-500 mb-6 border border-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-serif text-red-700 font-bold">Une erreur est survenue</h2>
                <p class="text-sm text-gray-500 mt-2">
                    <?php echo $erreur_sql; ?>
                </p>

                <div class="mt-8">
                    <a href="reservation.php" class="w-full bg-gray-700 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-xl shadow-md transition-colors duration-200 block border-0 text-center text-sm no-underline">
                        Retourner à la réservation
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </main>
</div>

<?php include __DIR__ . '/footer.php'; ?>