<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// 🎯 CORRIGÉ : Utilisation de l'inclusion simple pour le routeur MVC
include 'header.php'; 
?>

<div class="bg-[#FDFBF9] min-h-screen py-12 px-6">
    <div class="max-w-6xl mx-auto text-center mt-10">
        <span class="text-xs uppercase tracking-widest text-[#C4A484] font-semibold bg-[#F5EFEB] px-3 py-1 rounded-full">Regard Sublimé</span>
        <h1 class="text-4xl md:text-5xl font-serif text-[#4A3E3D] mt-4 mb-6">Extension de Cils</h1>
        <p class="text-base text-[#7A6E67] max-w-2xl mx-auto font-light leading-relaxed">
            Offrez de l'intensité et de la profondeur à votre regard grâce à nos poses d'extensions sur-mesure. Des cils plus longs, plus denses et parfaitement courbés pour un résultat naturel ou sophistiqué.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 text-left">
            
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-[#F5EFEB] hover:shadow-md transition duration-300 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-serif text-[#4A3E3D] mb-2">Pose Naturelle (Cil à Cil)</h3>
                    <p class="text-sm text-[#7A6E67] font-light mb-6">Idéal pour un effet mascara quotidien, subtil et élégant sans abîmer vos cils naturels.</p>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-[#F5EFEB]">
                    <span class="text-xl font-medium text-[#4A3E3D]">60 €</span>
                    <a href="index.php?url=reservation" class="text-xs uppercase tracking-wider text-[#C4A484] font-semibold hover:text-[#4A3E3D] transition">Réserver</a>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-[#F5EFEB] hover:shadow-md transition duration-300 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-serif text-[#4A3E3D] mb-2">Volume Russe</h3>
                    <p class="text-sm text-[#7A6E67] font-light mb-6">Pour un regard intense, glamour et volumineux grâce à l'application de bouquets de cils ultra-légers.</p>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-[#F5EFEB]">
                    <span class="text-xl font-medium text-[#4A3E3D]">85 €</span>
                    <a href="index.php?url=reservation" class="text-xs uppercase tracking-wider text-[#C4A484] font-semibold hover:text-[#4A3E3D] transition">Réserver</a>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-[#F5EFEB] hover:shadow-md transition duration-300 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-serif text-[#4A3E3D] mb-2">Remplissage (3 semaines)</h3>
                    <p class="text-sm text-[#7A6E67] font-light mb-6">Entretien nécessaire pour combler les chutes naturelles et redonner toute la fraîcheur à votre pose.</p>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-[#F5EFEB]">
                    <span class="text-xl font-medium text-[#4A3E3D]">45 €</span>
                    <a href="index.php?url=reservation" class="text-xs uppercase tracking-wider text-[#C4A484] font-semibold hover:text-[#4A3E3D] transition">Réserver</a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php 
// 🎯 CORRIGÉ : Utilisation de l'inclusion simple pour le routeur MVC
include 'footer.php'; 
?>