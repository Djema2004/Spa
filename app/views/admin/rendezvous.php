<?php
// Koneksyon ak baz done a lè l sèvi avèk PDO
$host = 'localhost';
$dbname = 'spa_dream';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erè koneksyon: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chwazi yon Sèvis - Spa Dream</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome pou ikon yo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #F0E8E1;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-[#FAF7F2] font-sans antialiased text-[#4A2E2B]">

    <div class="max-w-6xl mx-auto px-4 py-10">
        <header class="text-center mb-10">
            <h1 class="text-3xl font-bold font-serif-custom text-[#4A2E2B]">Dekouvri Sèvis Nou Yo</h1>
            <p class="text-sm text-[#8C6D68] mt-2">Chwazi sèvis ou vle a pou kontinye randevou ou an</p>
        </header>

        <!-- Lis Sèvis yo sou fòm Kat (Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php 
            $stmt = $pdo->query("SELECT * FROM services ORDER BY name ASC");
            $services = $stmt->fetchAll();
            
            foreach($services as $s): 
            ?>
                <div class="glass-card overflow-hidden shadow-sm flex flex-col justify-between">
                    <!-- Imaj Sèvis la -->
                    <div class="h-48 w-full overflow-hidden bg-[#FAF7F2]">
                        <img src="uploads/<?php echo htmlspecialchars($s['image']); ?>" alt="<?php echo htmlspecialchars($s['name']); ?>" class="w-full h-full object-cover">
                    </div>

                    <!-- Detay -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-bold font-serif-custom text-[#4A2E2B]"><?php echo htmlspecialchars($s['name']); ?></h3>
                            <p class="text-xs text-[#8C6D68] mt-1"><?php echo htmlspecialchars($s['description']); ?></p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-[#F0E8E1] flex items-center justify-between">
                            <div>
                                <span class="text-sm font-black text-[#4A2E2B]"><?php echo number_format($s['price'], 2); ?> HTG</span>
                                <span class="block text-[10px] text-[#8C6D68]"><i class="far fa-clock"></i> <?php echo $s['duration_minutes']; ?> min</span>
                            </div>

                            <!-- L ap voye uuid sèvis la lè kliyan an chwazi l -->
                            <a href="confirmer_rendezvous.php?service_uuid=<?php echo urlencode($s['uuid']); ?>" class="px-4 py-2 rounded-xl bg-[#9C413D] text-white text-xs font-bold hover:bg-[#823430] transition">
                                Chwazi
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>