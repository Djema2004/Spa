<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$erreur = "";

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

if (isset($_POST['btn_login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            
            if (password_verify($password, $user['password'])) {
                
                // Stockage des données de l'utilisateur en session
                $_SESSION['user_uuid'] = $user['id']; 
                $_SESSION['firstname'] = $user['firstname']; 
                $_SESSION['lastname']  = $user['lastname'];
                $_SESSION['email']     = $user['email'];
                $_SESSION['user_role'] = isset($user['role']) ? strtolower(trim($user['role'])) : 'client'; // Stockage du rôle
                $_SESSION['logged_in'] = true; 

                // REDIRECTION DYNAMIQUE SELON LE RÔLE
                if ($_SESSION['user_role'] === 'admin') {
                    // Si c'est un administrateur -> Redirection vers le dashboard admin
                    header("Location: dashboard.php");
                } else {
                    // Si c'est un client -> Redirection vers la page de réservation
                    header("Location: reservation.php");
                }
                exit(); 
            } else {
                $erreur = "Adresse e-mail ou mot de passe incorrect.";
            }
        } else {
            $erreur = "Adresse e-mail ou mot de passe incorrect.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}

include __DIR__ . '/header.php'; 
?>

<main class="flex-1 flex items-center justify-center p-4 my-16 bg-[#FAF7F2] text-[#5C3A3C]">
    
    <div id="login" class="w-full max-w-md bg-white p-8 sm:p-10 rounded-[2rem] shadow-xl shadow-[#FCD7CC]/20 border border-[#FCD7CC]/40 relative overflow-hidden">
        
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#FCECE7] rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#FCECE7] rounded-full blur-2xl pointer-events-none"></div>

        <div class="mb-8 text-center relative z-10">
            <h2 class="text-3xl font-serif font-black tracking-tight text-[#4A2E30]">Ravi de vous revoir</h2>
            <p class="text-sm text-[#5C3A3C]/80 mt-2 font-light">Connectez-vous à votre compte Spa pour réserver.</p>
        </div>

        <?php if (!empty($erreur)): ?>
            <div class="mb-4 p-3 bg-[#BA4A43]/10 text-[#BA4A43] rounded-xl text-xs font-medium border border-[#BA4A43]/20 relative z-10">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> <?php echo $erreur; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-5 relative z-10">
            
            <div>
                <label for="email" class="block text-sm font-semibold text-[#4A2E30] mb-1.5">Adresse e-mail</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#C87A65]/70">
                        <i class="fa-regular fa-envelope text-sm"></i>
                    </span>
                    <input type="email" id="email" name="email" placeholder="nom@exemple.com" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#FCD7CC] bg-[#FAF7F2]/50 text-[#5C3A3C] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87A65]/20 focus:border-[#C87A65] transition-all placeholder:text-[#5C3A3C]/40 text-sm shadow-sm" required>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="password" class="block text-sm font-semibold text-[#4A2E30]">Mot de passe</label>
                    <a href="#" class="text-xs font-medium text-[#C87A65] hover:text-[#A3523D] hover:underline">Oublié ?</a>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#C87A65]/70">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <input type="password" id="password" name="password" placeholder="••••••••" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#FCD7CC] bg-[#FAF7F2]/50 text-[#5C3A3C] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87A65]/20 focus:border-[#C87A65] transition-all placeholder:text-[#5C3A3C]/40 text-sm shadow-sm" required>
                </div>
            </div>

            <div class="pt-4 text-center">
                <button type="submit" name="btn_login" class="w-full bg-[#C87A65] hover:bg-[#A3523D] text-white font-semibold py-3 rounded-xl transition-all duration-300 text-sm shadow-md shadow-[#C87A65]/20 tracking-wider hover:-translate-y-0.5 transform cursor-pointer border-0">
                    Se connecter
                </button>
            </div>

            <p class="text-xs text-center text-[#5C3A3C]/80 pt-2 font-light">
                Nouveau sur notre plateforme ? <a href="register.php" class="text-[#4A2E30] font-bold hover:underline">Créer un compte</a>
            </p>
        </form>
    </div>
</main>

<?php 
include __DIR__ . '/footer.php'; 
?>