<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Ajouter une nouvelle prestation</h2>
        
        <form action="/spa/admin/prestations" method="POST" class="space-y-4">
            <input type="hidden" name="action" value="add_prestation">

            <div>
                <label class="block text-sm font-medium text-gray-700">Nom du service</label>
                <input type="text" name="nom_prestation" required class="w-full mt-1 p-2 border rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" class="w-full mt-1 p-2 border rounded-md"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Durée (minutes)</label>
                    <input type="number" name="duree" value="30" class="w-full mt-1 p-2 border rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Prix (HTG)</label>
                    <input type="number" step="0.01" name="prix" required class="w-full mt-1 p-2 border rounded-md">
                </div>
            </div>

            <button type="submit" class="w-full bg-amber-600 text-white py-2 rounded-md hover:bg-amber-700">
                Enregistrer le Service
            </button>
        </form>
    </div>
</body>
</html>