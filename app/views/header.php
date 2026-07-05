<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream Spa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#FAF7F2] min-h-screen flex flex-col font-sans antialiased">

    <!-- BARRE DE NAVIGATION MODIFIÉE AUX COULEURS DU SPA -->
    <nav class="bg-[#FAF7F2]/90 backdrop-blur-md shadow-sm border-b border-[#FCD7CC]/60 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Logo / Nom du Spa -->
            <div class="flex items-center gap-2">
                <span class="text-2xl font-serif font-black tracking-wide bg-gradient-to-r from-[#C87A65] to-[#4A2E30] bg-clip-text text-transparent">
                    Dream Spa
                </span>
            </div>
            
            <!-- Liens de navigation -->
            <div class="flex items-center gap-6 sm:gap-8 text-sm font-medium text-[#5C3A3C]">
    <!-- Lien vers l'Accueil -->
    <a href="index.php?url=home" class="hover:text-[#C87A65] transition-colors duration-200">Home</a>
    
    <!-- Lien vers le Contact (il passera par ton routeur) -->
    <a href="index.php?url=contact" class="hover:text-[#C87A65] transition-colors duration-200">Contact</a>
    
    <!-- Lien vers la Connexion via le Contrôleur -->
    <a href="index.php?url=login" class="hover:text-[#C87A65] transition-colors duration-200">Login</a>
    
    <!-- Bouton Register Terracotta via le Contrôleur -->
    <a href="index.php?url=register" class="bg-[#C87A65] hover:bg-[#A3523D] text-white text-xs sm:text-sm px-5 py-2 rounded-full shadow-sm shadow-[#C87A65]/10 transition-all duration-300 font-semibold tracking-wide hover:-translate-y-0.5 transform no-underline">
        Register
    </a>
</div>

                

        </div>
    </nav>